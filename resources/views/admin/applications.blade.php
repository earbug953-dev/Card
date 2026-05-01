@extends('layouts.app')
@section('title', 'Fan Applications — Live Chat')
@section('breadcrumb-parent', 'Applications')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Fan Applications</h1>
        <p>Review applications, chat with fans, approve payments and issue card ID codes</p>
    </div>
    <div class="page-header-actions">
        <span style="font-size:13px;color:var(--text-muted);">{{ $pending }} pending · {{ $total }} total</span>
    </div>
</div>

<div style="display:grid; grid-template-columns:340px 1fr; gap:20px; height:calc(100vh - 220px); min-height:500px;">

    <!-- Sidebar: Application list -->
    <div style="background:var(--bg-card);border:1px solid var(--border-subtle);border-radius:var(--radius-lg);display:flex;flex-direction:column;overflow:hidden;">
        <div style="padding:16px;border-bottom:1px solid var(--border-subtle);">
            <div style="position:relative;">
                <i class="fas fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:13px;"></i>
                <input type="text" id="appSearch" placeholder="Search applicants…" onkeyup="filterApps()"
                    style="width:100%;background:var(--bg-elevated);border:1px solid var(--border-subtle);border-radius:8px;padding:8px 12px 8px 32px;color:var(--text-primary);font-family:var(--font-body);font-size:13px;outline:none;box-sizing:border-box;">
            </div>
            <div style="display:flex;gap:6px;margin-top:10px;">
                @foreach(['all'=>'All','pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'] as $k=>$l)
                <button onclick="filterStatus('{{ $k }}')" class="filter-btn {{ $k==='all'?'active':'' }}" style="flex:1;padding:5px 8px;font-size:11px;font-weight:600;border-radius:6px;border:1px solid var(--border-subtle);background:var(--bg-elevated);color:var(--text-muted);cursor:pointer;font-family:var(--font-body);transition:var(--transition);">{{ $l }}</button>
                @endforeach
            </div>
        </div>

        <div id="appList" style="flex:1;overflow-y:auto;">
            @forelse($applications->sortByDesc('created_at') as $app)
            <div class="app-item {{ $app->status }}" onclick="loadChat('{{ $app->id }}')" data-status="{{ $app->status }}" data-name="{{ strtolower($app->first_name.' '.$app->last_name) }}"
                style="padding:14px 16px;border-bottom:1px solid var(--border-subtle);cursor:pointer;transition:var(--transition);position:relative;">
                @if($app->status === 'pending')
                <div style="position:absolute;top:14px;right:14px;width:8px;height:8px;border-radius:50%;background:var(--warning);"></div>
                @endif
                <div style="display:flex;gap:10px;align-items:flex-start;">
                    @if($app->photo_path)
                        <img src="{{ asset('storage/'.$app->photo_path) }}" alt="" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid {{ $app->status==='approved'?'var(--success)':($app->status==='pending'?'var(--warning)':'var(--border)') }};flex-shrink:0;">
                    @else
                        <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--gold-dark),var(--gold));display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:var(--bg-dark);flex-shrink:0;border:2px solid {{ $app->status==='approved'?'var(--success)':'var(--gold-dark)' }};">{{ strtoupper(substr($app->first_name,0,1)) }}</div>
                    @endif
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $app->first_name }} {{ $app->last_name }}</div>
                        <div style="font-size:12px;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $app->email }}</div>
                        <div style="display:flex;align-items:center;gap:6px;margin-top:4px;">
                            <span class="badge {{ $app->status==='pending'?'badge-warning':($app->status==='approved'?'badge-success':'badge-danger') }}" style="font-size:10px;padding:2px 7px;">
                                {{ ucfirst($app->status) }}
                            </span>
                            <span style="font-size:11px;color:var(--text-muted);">{{ $app->plan->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                @if($app->card_code)
                <div style="margin-top:6px;margin-left:50px;font-size:10.5px;font-family:monospace;color:var(--gold);letter-spacing:1px;">{{ $app->card_code }}</div>
                @endif
                <div style="font-size:11px;color:var(--text-muted);margin-top:4px;margin-left:50px;">{{ $app->created_at->diffForHumans() }}</div>
            </div>
            @empty
            <div style="padding:40px 20px;text-align:center;color:var(--text-muted);font-size:13.5px;">
                <i class="fas fa-inbox" style="font-size:32px;margin-bottom:12px;display:block;"></i>
                No applications yet. They'll appear here when fans apply.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Chat Panel -->
    <div id="chatPanelWrap" style="background:var(--bg-card);border:1px solid var(--border-subtle);border-radius:var(--radius-lg);display:flex;flex-direction:column;overflow:hidden;">

        <!-- Default state - no chat selected -->
        <div id="noChatSelected" style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;color:var(--text-muted);">
            <i class="fas fa-comments" style="font-size:48px;opacity:0.3;"></i>
            <p style="font-size:14px;">Select an application from the list to open the chat</p>
        </div>

        <!-- Dynamic chat loads here via JS / HTMX -->
        <div id="chatContent" style="display:none;flex:1;flex-direction:column;overflow:hidden;"></div>

    </div>
</div>

@push('styles')
<style>
.app-item:hover { background: var(--bg-hover); }
.app-item.active-chat { background: var(--gold-muted); border-left: 3px solid var(--gold); }
.filter-btn.active { background: var(--gold-muted) !important; color: var(--gold) !important; border-color: rgba(201,168,76,0.3) !important; }
</style>
@endpush

@push('scripts')
<script>
const allApps = @json($applications->values());

function filterApps(){
    const q=document.getElementById('appSearch').value.toLowerCase();
    document.querySelectorAll('.app-item').forEach(el=>{
        el.style.display=el.dataset.name.includes(q)?'':'none';
    });
}

function filterStatus(st){
    document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active'));
    event.target.classList.add('active');
    document.querySelectorAll('.app-item').forEach(el=>{
        el.style.display=(st==='all'||el.dataset.status===st)?'':'none';
    });
}

function loadChat(id){
    document.querySelectorAll('.app-item').forEach(el=>el.classList.remove('active-chat'));
    event.currentTarget?.classList.add('active-chat');
    const app=allApps.find(a=>a.id==id);if(!app)return;

    document.getElementById('noChatSelected').style.display='none';
    const cc=document.getElementById('chatContent');
    cc.style.display='flex';
    cc.style.flexDirection='column';
    cc.innerHTML=buildChatUI(app);
    cc.querySelector('.chat-messages')?.scrollTo(0,99999);
}

function buildChatUI(app){
    const msgs=(app.chat_messages||[]).map(m=>`
        <div style="display:flex;gap:10px;${m.sender==='admin'?'flex-direction:row-reverse;':''}">
            <div style="width:32px;height:32px;border-radius:50%;${m.sender==='admin'?'background:linear-gradient(135deg,var(--gold-dark),var(--gold));':'background:var(--bg-elevated);border:1px solid var(--border);'}display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;align-self:flex-end;font-weight:700;color:${m.sender==='admin'?'var(--bg-dark)':'var(--text-primary)'};">
                ${m.sender==='admin'?'👑':app.first_name[0].toUpperCase()}
            </div>
            <div style="max-width:75%;background:${m.sender==='admin'?'var(--gold-muted)':'var(--bg-elevated)'};border:1px solid ${m.sender==='admin'?'rgba(201,168,76,0.2)':'var(--border-subtle)'};border-radius:${m.sender==='admin'?'14px 14px 4px 14px':'14px 14px 14px 4px'};padding:10px 14px;font-size:13px;color:var(--text-primary);line-height:1.55;">
                ${m.message.replace(/\n/g,'<br>')}
                <div style="font-size:10px;opacity:0.4;margin-top:4px;text-align:right;">${new Date(m.created_at).toLocaleTimeString('en',{hour:'2-digit',minute:'2-digit'})}</div>
            </div>
        </div>
    `).join('');

    const statusColor = app.status==='pending'?'var(--warning)':app.status==='approved'?'var(--success)':'var(--danger)';
    const cardCodeEl = app.card_code ? `<div style="font-family:monospace;font-size:15px;letter-spacing:2px;color:var(--gold);background:var(--gold-muted);border:1px solid rgba(201,168,76,0.3);border-radius:8px;padding:8px 16px;text-align:center;">${app.card_code}</div>` : '';

    return `
    <div style="padding:16px 20px;background:var(--bg-elevated);border-bottom:1px solid var(--border-subtle);display:flex;align-items:center;gap:14px;flex-shrink:0;">
        <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--gold-dark),var(--gold));display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:var(--bg-dark);flex-shrink:0;">${app.photo_path?`<img src="/storage/${app.photo_path}" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">`:app.first_name[0].toUpperCase()}</div>
        <div style="flex:1;min-width:0;">
            <div style="font-size:14px;font-weight:600;color:var(--text-primary);">${app.first_name} ${app.last_name}</div>
            <div style="font-size:12px;color:var(--text-muted);">${app.email} · ${app.phone} · ${app.plan?.name || 'N/A'} — $${parseFloat(app.plan?.price||0).toFixed(2)}</div>
        </div>
        <div style="display:flex;gap:8px;flex-shrink:0;align-items:center;">
            <span style="font-size:11px;font-weight:600;color:${statusColor};background:${statusColor}22;border:1px solid ${statusColor}44;padding:4px 10px;border-radius:99px;">${app.status.toUpperCase()}</span>
            ${app.status==='pending'?`
            <button onclick="approveApp(${app.id})" style="background:var(--success-bg);color:var(--success);border:1px solid rgba(76,175,124,0.25);border-radius:8px;padding:7px 14px;font-size:12.5px;font-weight:600;cursor:pointer;font-family:var(--font-body);display:flex;align-items:center;gap:6px;"><i class="fas fa-check"></i> Approve & Issue Card</button>
            <button onclick="rejectApp(${app.id})" style="background:var(--danger-bg);color:var(--danger);border:1px solid rgba(224,82,82,0.2);border-radius:8px;padding:7px 12px;font-size:12.5px;cursor:pointer;font-family:var(--font-body);"><i class="fas fa-times"></i></button>
            `:''}
            ${cardCodeEl}
        </div>
    </div>

    <div class="chat-messages" style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:12px;background:var(--bg-dark);">
        <div style="text-align:center;margin-bottom:8px;">
            <div style="display:inline-block;background:var(--gold-muted);border:1px solid rgba(201,168,76,0.2);border-radius:99px;padding:5px 14px;font-size:11px;color:var(--gold);">Application submitted · ${new Date(app.created_at).toLocaleDateString('en',{month:'short',day:'numeric',year:'numeric'})}</div>
        </div>
        <div style="display:flex;gap:10px;">
            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--gold-dark),var(--gold));display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;align-self:flex-end;">👑</div>
            <div style="max-width:75%;background:var(--gold-muted);border:1px solid rgba(201,168,76,0.2);border-radius:14px 14px 14px 4px;padding:12px 16px;font-size:13px;color:var(--text-primary);line-height:1.6;">
                <strong>Welcome, ${app.first_name}!</strong><br><br>
                Thank you for applying for the <strong>${app.plan?.name} Membership Card</strong> ($${parseFloat(app.plan?.price||0).toFixed(2)}). We've received your application.<br><br>
                Address on file: <strong>${app.address}</strong><br>
                Reference: <strong style="font-family:monospace;color:var(--gold);">${app.reference_number}</strong><br><br>
                Please let us know your preferred payment method and we'll process it right away!
            </div>
        </div>
        ${msgs}
    </div>

    <div style="padding:12px 16px;background:var(--bg-elevated);border-top:1px solid var(--border-subtle);flex-shrink:0;">
        <div style="display:flex;gap:8px;">
            <input id="adminMsgInput" placeholder="Type a message to ${app.first_name}…" onkeydown="if(event.key==='Enter')sendAdminMsg(${app.id})"
                style="flex:1;background:var(--bg-dark);border:1px solid var(--border-subtle);border-radius:10px;padding:10px 14px;color:var(--text-primary);font-family:var(--font-body);font-size:13.5px;outline:none;">
            <button onclick="sendAdminMsg(${app.id})" style="background:linear-gradient(135deg,var(--gold-dark),var(--gold));color:var(--bg-dark);border:none;border-radius:10px;padding:10px 18px;font-size:13.5px;font-weight:700;cursor:pointer;font-family:var(--font-body);">Send</button>
        </div>
        <div style="display:flex;gap:6px;margin-top:8px;flex-wrap:wrap;">
            ${['Payment received — processing your card!','Please provide your payment reference number.','What payment method works best for you?','Your card has been approved and issued!'].map(q=>`<button onclick="quickReply('${q}')" style="font-size:11px;padding:4px 10px;border-radius:99px;border:1px solid var(--border-subtle);background:var(--bg-elevated);color:var(--text-muted);cursor:pointer;font-family:var(--font-body);">${q.substring(0,35)}…</button>`).join('')}
        </div>
    </div>
    `;
}

function quickReply(text){ const el=document.getElementById('adminMsgInput'); if(el)el.value=text; }

async function sendAdminMsg(appId){
    const el=document.getElementById('adminMsgInput');
    const msg=el?.value?.trim();if(!msg)return;
    el.value='';el.disabled=true;
    try{
        const r=await fetch(`/admin/applications/${appId}/chat`,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify({message:msg})});
        if(r.ok){location.reload();}
    }catch(e){el.disabled=false;}
}

async function approveApp(appId){
    if(!confirm('Approve this application and issue a VIP Card ID?'))return;
    const r=await fetch(`/admin/applications/${appId}/approve`,{method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}});
    if(r.ok)location.reload();
}

async function rejectApp(appId){
    if(!confirm('Reject this application?'))return;
    const r=await fetch(`/admin/applications/${appId}/reject`,{method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}});
    if(r.ok)location.reload();
}

// Auto-refresh every 15s
setInterval(()=>{ if(!document.getElementById('noChatSelected').style.display||document.getElementById('noChatSelected').style.display==='none') return; location.reload(); },15000);
</script>
@endpush
@endsection
