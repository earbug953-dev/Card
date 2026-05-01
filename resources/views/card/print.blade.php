<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP Membership Card - {{ $transaction->user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f8f8f8;
            padding: 20px;
        }

        .print-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            width: 100%;
            aspect-ratio: 16/9;
            background: linear-gradient(135deg, #FCD34D 0%, #FBBF24 50%, #F59E0B 100%);
            border-radius: 24px;
            padding: 40px 50px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            page-break-inside: avoid;
            color: white;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.2) 0%, transparent 50%);
            pointer-events: none;
        }

        .card-content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .vip-badge {
            text-align: center;
        }

        .vip-badge svg {
            width: 60px;
            height: 60px;
            fill: white;
            filter: drop-shadow(0 3px 5px rgba(0,0,0,0.2));
            margin-bottom: 8px;
        }

        .vip-text {
            font-size: 36px;
            font-weight: 900;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.25);
            letter-spacing: 1px;
        }

        .vip-subtitle {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255,255,255,0.95);
            letter-spacing: 2px;
            margin-top: 4px;
        }

        .plan-info {
            text-align: right;
        }

        .plan-label {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255,255,255,0.9);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .plan-name {
            font-size: 28px;
            font-weight: 900;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.25);
            margin-top: 4px;
        }

        .card-middle {
            display: flex;
            align-items: center;
            gap: 35px;
            flex: 1;
            justify-content: center;
        }

        .member-photo {
            width: 110px;
            height: 130px;
            border-radius: 12px;
            background: rgba(255,255,255,0.25);
            border: 3px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            font-size: 42px;
        }

        .member-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .member-info {
            flex: 1;
            text-align: center;
        }

        .member-label {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255,255,255,0.9);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .member-name {
            font-size: 32px;
            font-weight: 900;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.25);
            margin: 8px 0;
            letter-spacing: 0.5px;
        }

        .member-dates {
            display: flex;
            gap: 50px;
            justify-content: center;
            margin-top: 8px;
            font-size: 11px;
        }

        .date-label {
            font-size: 9px;
            font-weight: 700;
            color: rgba(255,255,255,0.85);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .date-value {
            font-weight: 800;
            margin-top: 3px;
            font-size: 14px;
        }

        .celebrity-photo {
            width: 110px;
            height: 130px;
            border-radius: 12px;
            background: rgba(255,255,255,0.25);
            border: 3px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            font-size: 42px;
        }

        .celebrity-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 10px;
        }

        .card-id {
            flex: 1;
        }

        .card-id-label {
            font-size: 10px;
            color: rgba(255,255,255,0.9);
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: 1px;
        }

        .card-id-value {
            font-family: 'Courier New', monospace;
            font-size: 20px;
            font-weight: 900;
            letter-spacing: 4px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .access-code-box {
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.6);
            border-radius: 8px;
            padding: 8px 12px;
            font-family: 'Courier New', monospace;
            font-size: 11px;
            font-weight: 700;
            text-align: center;
            margin-top: 6px;
            letter-spacing: 1px;
        }

        .security-badge {
            text-align: center;
        }

        .security-icon {
            font-size: 40px;
            margin-bottom: 6px;
        }

        .security-text {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255,255,255,0.9);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .details-section {
            background: white;
            border-radius: 16px;
            padding: 35px 40px;
            margin-top: 50px;
            color: #1f2937;
            page-break-inside: avoid;
        }

        .section-title {
            color: #D97706;
            font-size: 18px;
            font-weight: 900;
            margin-bottom: 25px;
            padding-bottom: 12px;
            border-bottom: 3px solid #FCD34D;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 10px;
            color: #6B7280;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 800;
            color: #1f2937;
        }

        .benefits-section {
            margin-top: 28px;
            padding-top: 28px;
            border-top: 3px solid #FCD34D;
        }

        .benefits-title {
            color: #D97706;
            font-size: 16px;
            font-weight: 900;
            margin-bottom: 18px;
            letter-spacing: 0.5px;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 12px;
            color: #374151;
        }

        .benefit-icon {
            color: #F59E0B;
            font-weight: 900;
            font-size: 14px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .footer-note {
            background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%);
            border-left: 5px solid #0284C7;
            padding: 16px 18px;
            margin-top: 25px;
            border-radius: 8px;
            font-size: 11px;
            color: #0C4A6E;
            font-weight: 600;
            line-height: 1.6;
        }

        .print-button {
            text-align: center;
            margin-bottom: 30px;
        }

        .print-button button {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: white;
            border: none;
            padding: 14px 35px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            letter-spacing: 0.5px;
        }

        .print-button button:hover {
            background: linear-gradient(135deg, #D97706 0%, #B45309 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .print-container {
                max-width: 100%;
            }

            .print-button {
                display: none;
            }

            .card {
                box-shadow: none;
                margin: 0;
            }

            .details-section {
                box-shadow: none;
            }
        }

        @media (max-width: 1024px) {
            .card {
                padding: 30px 35px;
            }

            .details-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .vip-text {
                font-size: 28px;
            }

            .member-name {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <div class="print-button">
            <button onclick="window.print()">🖨️ Print This Card</button>
        </div>

        <!-- Premium Card -->
        <div class="card">
            <div class="card-content">
                <div class="card-header">
                    <div class="vip-badge">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L15 10H23L17 15L19 23L12 18L5 23L7 15L1 10H9L12 2Z"/>
                        </svg>
                        <div class="vip-text">VIP</div>
                        <div class="vip-subtitle">PREMIUM MEMBER</div>
                    </div>

                    <div class="plan-info">
                        <div class="plan-label">Plan</div>
                        <div class="plan-name">{{ $card->plan->name }}</div>
                    </div>
                </div>

                <div class="card-middle">
                    <div class="member-photo">
                        @if($transaction->user_photo)
                            <img src="{{ asset('storage/' . $transaction->user_photo) }}" alt="Member">
                        @else
                            👤
                        @endif
                    </div>

                    <div class="member-info">
                        <div class="member-label">Cardholder</div>
                        <div class="member-name">{{ $transaction->user->name }}</div>
                        <div class="member-dates">
                            <div>
                                <div class="date-label">Issue Date</div>
                                <div class="date-value">{{ $card->issue_date->format('m/d/Y') }}</div>
                            </div>
                            <div>
                                <div class="date-label">Expires</div>
                                <div class="date-value">{{ $card->expiry_date->format('m/d/Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="celebrity-photo">
                        @if($card->celebrity_image)
                            <img src="{{ asset('storage/' . $card->celebrity_image) }}" alt="Elite">
                        @else
                            ⭐
                        @endif
                    </div>
                </div>

                <div class="card-footer">
                    <div class="card-id">
                        <div class="card-id-label">Card ID</div>
                        <div class="card-id-value">{{ $card->formatted_number }}</div>
                        <div class="access-code-box">Access: {{ $transaction->access_code }}</div>
                    </div>
                    <div class="security-badge">
                        <div class="security-icon">🔐</div>
                        <div class="security-text">SECURE</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Details -->
        <div class="details-section">
            <h2 class="section-title">📋 Card Information</h2>

            <div class="details-grid">
                <div class="detail-item">
                    <div class="detail-label">Cardholder</div>
                    <div class="detail-value">{{ $transaction->user->name }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value" style="font-size: 12px;">{{ $transaction->user->email }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Plan Type</div>
                    <div class="detail-value">{{ $card->plan->name }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Valid For</div>
                    <div class="detail-value">{{ $card->plan->duration_months }} months</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Card Number</div>
                    <div class="detail-value" style="font-family: 'Courier New', monospace; font-size: 11px;">{{ $card->formatted_number }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Access Code</div>
                    <div class="detail-value" style="font-family: 'Courier New', monospace; font-size: 11px; color: #D97706;">{{ $transaction->access_code }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Issue Date</div>
                    <div class="detail-value">{{ $card->issue_date->format('M d, Y') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Expiry Date</div>
                    <div class="detail-value">{{ $card->expiry_date->format('M d, Y') }}</div>
                </div>
            </div>

            @if($card->plan->features_list)
                <div class="benefits-section">
                    <h3 class="benefits-title">✨ Your Benefits</h3>
                    <div class="benefits-grid">
                        @foreach($card->plan->features_list as $feature)
                            <div class="benefit-item">
                                <span class="benefit-icon">✓</span>
                                <span>{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="footer-note">
                <strong>💡 Important:</strong> Keep your access code <strong>({{ $transaction->access_code }})</strong> safe. This card is valid until <strong>{{ $card->expiry_date->format('F d, Y') }}</strong>. For support, contact our admin team.
            </div>
        </div>
    </div>
</body>
</html>

