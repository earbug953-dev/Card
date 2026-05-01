@extends('layouts.app')
@section('title','Plans & Celebrities')
@section('breadcrumb-parent','Plans & Celebrities')
@section('content')
<div class="page-header">
  <div><div class="ph-title">Plans & Celebrities</div><div class="ph-sub">Manage membership plans, pricing and the celebrity featured on each card</div></div>
  <div class="ph-actions"><button class="btn btn-primary" onclick="openModal('createModal')"><i class="fas fa-plus"></i> New Plan</button></div>
</div>

@if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}<button class="alert-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button></div>@endif

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;margin-bottom:32px;">
  @forelse($plans as $plan)
  <div class="panel" style="border-color:{{ $plan->name==='Gold'?'var(--gold-border)':'var(--white-06)' }};">
    <div class="panel-header">
      <div class="panel-title">{{ $plan->name }}</div>
      <div style="display:flex;gap:8px;">
        <button onclick="openEdit({{ $plan->id }},'{{ addslashes($plan->name) }}',{{ $plan->price }},{{ $plan->duration_months }},'{{ addslashes($plan->description??'') }}','{{ addslashes($plan->celebrity_name??'') }}','{{ addslashes($plan->features??'') }}')" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></button>
        <form method="POST" action="{{ route('plans.destroy',$plan) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger btn-icon"><i class="fas fa-trash"></i></button></form>
      </div>
    </div>
    <div class="panel-body">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
        <div style="font-family:'Playfair Display',serif;font-size:32px;font-weight:900;color:var(--gold);">${{ number_format($plan->price,0) }}</div>
        <span class="badge badge-muted">{{ $plan->duration_months }} month{{ $plan->duration_months>1?'s':'' }}</span>
      </div>
      <div style="background:var(--ink-4);border:1px solid var(--gold-border);border-radius:12px;padding:14px;margin-bottom:16px;">
        <div style="font-size:11px;text-transform:uppercase;letter-spacing:1px;color:var(--gold);margin-bottom:10px;font-weight:700;"><i class="fas fa-star" style="margin-right:5px;"></i>Featured Celebrity</div>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
          <div style="width:60px;height:60px;border-radius:50%;border:2px solid var(--gold);overflow:hidden;background:var(--ink-3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            @if($plan->celebrity_image)<img src="{{ asset('storage/'.$plan->celebrity_image) }}" alt="" style="width:100%;height:100%;object-fit:cover;object-position:center top;">
            @else<i class="fas fa-star" style="color:var(--gold);font-size:22px;opacity:.4;"></i>@endif
          </div>
          <div>
            <div style="font-size:14px;font-weight:700;color:var(--white);">{{ $plan->celebrity_name ?? 'Not set' }}</div>
            <div style="font-size:12px;color:var(--white-40);">{{ $plan->celebrity_image ? 'Photo uploaded ✓' : 'No photo yet' }}</div>
          </div>
        </div>
        <form action="{{ route('plans.celebrity', $plan) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
            <input type="text" name="celebrity_name" value="{{ $plan->celebrity_name }}" placeholder="Celebrity name" class="form-control" style="flex:1;min-width:120px;">
            <input type="file" name="celebrity_image" accept="image/*" class="form-control" style="flex:1;min-width:120px;">
            <button type="submit" class="btn btn-sm btn-outline" style="white-space:nowrap;flex-shrink:0;"><i class="fas fa-save"></i> Save</button>
          </div>
        </form>
      </div>
      @if($plan->features)
      @foreach(array_slice(array_filter(array_map('trim',explode("\n",$plan->features))),0,4) as $f)
      <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--white-40);margin-bottom:6px;"><i class="fas fa-check" style="color:var(--gold);font-size:10px;width:14px;"></i>{{ $f }}</div>
      @endforeach
      @endif
    </div>
  </div>
  @empty
  <div style="grid-column:1/-1;"><div class="empty-state"><div class="empty-icon"><i class="fas fa-layer-group"></i></div><div class="empty-title">No Plans Yet</div><p class="empty-desc">Create your first membership plan</p><button class="btn btn-primary" onclick="openModal('createModal')"><i class="fas fa-plus"></i> Create Plan</button></div></div>
  @endforelse
</div>

<div class="modal-backdrop" id="createModal">
  <div class="modal">
    <div class="modal-header"><div class="modal-title">Create New Plan</div><button class="modal-close" onclick="closeModal('createModal')"><i class="fas fa-times"></i></button></div>
    <form method="POST" action="{{ route('plans.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
        <div class="form-grid-2">
          <div class="form-group"><label class="form-label">Plan Name *</label><input class="form-control" name="name" placeholder="Gold" required></div>
          <div class="form-group"><label class="form-label">Price ($) *</label><input class="form-control" type="number" name="price" step="0.01" placeholder="200" required></div>
          <div class="form-group"><label class="form-label">Duration (months) *</label><input class="form-control" type="number" name="duration_months" min="1" placeholder="12" required></div>
          <div class="form-group"><label class="form-label">Color</label><select class="form-control" name="color"><option value="gold">Gold</option><option value="silver">Silver</option><option value="bronze">Bronze</option><option value="platinum">Platinum</option></select></div>
        </div>
        <div class="form-group"><label class="form-label">Description</label><input class="form-control" name="description" placeholder="Brief plan description"></div>
        <div class="form-group"><label class="form-label"><i class="fas fa-star" style="color:var(--gold);margin-right:5px;"></i>Celebrity Name</label><input class="form-control" name="celebrity_name" placeholder="e.g. MORGAN WALLEN"></div>
        <div class="form-group"><label class="form-label">Celebrity Photo</label><input type="file" class="form-control" name="celebrity_image" accept="image/*"><div class="form-hint">Photo appears on every card for this plan</div></div>
        <div class="form-group"><label class="form-label">Features (one per line)</label><textarea class="form-control" name="features" rows="5" placeholder="Official VIP Membership Card&#10;12-Month Access&#10;Priority Support"></textarea></div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-secondary" onclick="closeModal('createModal')">Cancel</button><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Plan</button></div>
    </form>
  </div>
</div>

<div class="modal-backdrop" id="editModal">
  <div class="modal">
    <div class="modal-header"><div class="modal-title">Edit Plan</div><button class="modal-close" onclick="closeModal('editModal')"><i class="fas fa-times"></i></button></div>
    <form method="POST" id="editForm" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-grid-2">
          <div class="form-group"><label class="form-label">Plan Name *</label><input class="form-control" name="name" id="eName" required></div>
          <div class="form-group"><label class="form-label">Price ($) *</label><input class="form-control" type="number" name="price" id="ePrice" required></div>
          <div class="form-group"><label class="form-label">Duration (months) *</label><input class="form-control" type="number" name="duration_months" id="eDur" required></div>
        </div>
        <div class="form-group"><label class="form-label">Description</label><input class="form-control" name="description" id="eDesc"></div>
        <div class="form-group"><label class="form-label">Celebrity Name</label><input class="form-control" name="celebrity_name" id="eCeleb"></div>
        <div class="form-group"><label class="form-label">Celebrity Photo (leave blank to keep current)</label><input type="file" class="form-control" name="celebrity_image" accept="image/*"></div>
        <div class="form-group"><label class="form-label">Features</label><textarea class="form-control" name="features" id="eFeats" rows="5"></textarea></div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button></div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function openModal(id){document.getElementById(id).classList.add('open');}
function closeModal(id){document.getElementById(id).classList.remove('open');}
function openEdit(id,n,p,d,desc,celeb,feats){
  document.getElementById('editForm').action='/plans/'+id;
  document.getElementById('eName').value=n;document.getElementById('ePrice').value=p;
  document.getElementById('eDur').value=d;document.getElementById('eDesc').value=desc;
  document.getElementById('eCeleb').value=celeb;document.getElementById('eFeats').value=feats;
  openModal('editModal');
}
document.querySelectorAll('.modal-backdrop').forEach(el=>el.addEventListener('click',function(e){if(e.target===this)this.classList.remove('open');}));
</script>
@endpush
@endsection
