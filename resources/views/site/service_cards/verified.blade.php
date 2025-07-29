<x-main-layout title="Service Card Verification">
    @push('style')
        <style>
            .verification-container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }

            .card-header-custom {
                background: linear-gradient(135deg, #85a8e9 0%, #4c86eb 100%);
                color: white;
                padding: 30px;
                border-radius: 15px 15px 0 0;
                text-align: center;
                position: relative;
                overflow: hidden;
            }

            .card-header-custom::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
                animation: pulse 3s ease-in-out infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                    opacity: 0.5;
                }

                50% {
                    transform: scale(1.1);
                    opacity: 0.3;
                }
            }

            .status-badge {
                display: inline-block;
                padding: 12px 30px;
                font-size: 18px;
                font-weight: bold;
                border-radius: 50px;
                margin: 20px 0;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                animation: slideIn 0.5s ease-out;
            }

            @keyframes slideIn {
                from {
                    transform: translateY(-20px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .status-verified {
                background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                color: white;
            }

            .status-expired {
                background: linear-gradient(135deg, #ffc107 0%, #ff6b6b 100%);
                color: white;
            }

            .status-invalid {
                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                color: white;
            }

            .status-not-found {
                background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
                color: white;
            }

            .profile-section {
                text-align: center;
                margin-top: -50px;
                position: relative;
                z-index: 10;
            }

            .profile-image {
                width: 150px;
                height: 180px;
                border-radius: 10px;
                border: 5px solid white;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                object-fit: cover;
                background: #f0f0f0;
            }

            .info-card {
                background: white;
                border-radius: 0 0 15px 15px;
                padding: 80px 30px 30px 30px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                margin-top: -60px;
            }

            .info-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                margin-top: 30px;
            }

            .info-item {
                padding: 15px;
                background: #f8f9fa;
                border-radius: 10px;
                transition: all 0.3s ease;
                border-left: 4px solid transparent;
            }

            .info-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                border-left-color: #2a5298;
            }

            .info-label {
                font-size: 12px;
                color: #6c757d;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-bottom: 5px;
            }

            .info-value {
                font-size: 16px;
                color: #2c3e50;
                font-weight: 600;
            }

            .validity-section {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border-radius: 10px;
                padding: 20px;
                margin: 20px 0;
                text-align: center;
            }

            .validity-dates {
                display: flex;
                justify-content: space-around;
                flex-wrap: wrap;
                gap: 20px;
                margin-top: 15px;
            }

            .date-box {
                background: white;
                padding: 15px 25px;
                border-radius: 10px;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            }

            .qr-verification {
                text-align: center;
                margin-top: 30px;
                padding: 20px;
                background: #f8f9fa;
                border-radius: 10px;
            }

            .print-button {
                position: fixed;
                bottom: 30px;
                right: 30px;
                background: #2a5298;
                color: white;
                border: none;
                padding: 15px 30px;
                border-radius: 50px;
                box-shadow: 0 5px 20px rgba(42, 82, 152, 0.3);
                cursor: pointer;
                transition: all 0.3s ease;
                font-weight: bold;
                display: flex;
                align-items: center;
                gap: 10px;
                z-index: 1000;
            }

            .print-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(42, 82, 152, 0.4);
            }

            @media print {

                .print-button,
                .no-print {
                    display: none !important;
                }

                .verification-container {
                    max-width: 100%;
                }

                .card-header-custom::before {
                    display: none;
                }
            }

            .office-name {
                font-size: 14px;
                line-height: 1.4;
            }

            .loading-skeleton {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: loading 1.5s infinite;
            }

            @keyframes loading {
                0% {
                    background-position: 200% 0;
                }

                100% {
                    background-position: -200% 0;
                }
            }
        </style>
    @endpush

    @php
        $isValid = false;
        $status = 'not-found';
        $statusText = 'Card Not Found';
        $statusClass = 'status-not-found';

        if ($serviceCard ?? null) {
            if ($serviceCard->status !== 'active') {
                $status = 'invalid';
                $statusText = 'Card Not Verified';
                $statusClass = 'status-invalid';
            } elseif ($serviceCard->isExpired()) {
                $status = 'expired';
                $statusText = 'Card Expired';
                $statusClass = 'status-expired';
            } else {
                $isValid = true;
                $status = 'verified';
                $statusText = 'Valid Service Card';
                $statusClass = 'status-verified';
            }
        }

        $user = $serviceCard->user ?? null;
        $profile = $user->profile ?? null;
    @endphp

    <div class="verification-container">
        <div class="card-header-custom">
            <img src="{{ asset('admin/images/logo-square.png') }}" alt="Logo"
                style="width: 80px; margin-bottom: 20px;">
            <h2 class="mb-3">Government of Khyber Pakhtunkhwa</h2>
            <h4>Communication and Works Department</h4>
            <h5 class="mt-3">Service Card Verification System</h5>
        </div>

        @if ($serviceCard ?? null)
            <div class="profile-section">
                <img src="{{ $user->getFirstMediaUrl('profile_pictures') ?: asset('admin/images/default-avatar.png') }}"
                    alt="{{ $user->name ?? 'Profile' }}" class="profile-image">
            </div>

            <div class="info-card">
                <div class="text-center">
                    <h3 class="mb-2">{{ $user->name ?? 'N/A' }}</h3>
                    <p class="text-muted mb-0">{{ $user->currentDesignation ? $user->currentDesignation->name : 'N/A' }}</p>
                    <p class="text-muted mb-0">Office: {{ $user->currentOffice ? $user->currentOffice->name : 'N/A' }}</p>
                    <div class="status-badge {{ $statusClass }}">
                        <i
                            class="bi bi-{{ $isValid ? 'check-circle' : ($status == 'expired' ? 'clock-history' : 'x-circle') }}"></i>
                        {{ $statusText }}
                    </div>
                </div>

                @if ($isValid || $status == 'expired')
                    <div class="validity-section">
                        <h5 class="mb-3">Card Validity Information</h5>
                        <div class="validity-dates">
                            @if ($serviceCard->issued_at)
                                <div class="date-box">
                                    <div class="info-label">Issue Date</div>
                                    <div class="info-value">{{ $serviceCard->issued_at->format('d M, Y') }}</div>
                                    <small class="text-muted">{{ $serviceCard->issued_at->diffForHumans() }}</small>
                                </div>
                            @endif
                            @if ($serviceCard->expired_at)
                                <div class="date-box">
                                    <div class="info-label">Expiry Date</div>
                                    <div class="info-value">{{ $serviceCard->expired_at->format('d M, Y') }}</div>
                                    <small
                                        class="text-muted {{ $serviceCard->isExpired() ? 'text-danger' : 'text-success' }}">
                                        {{ $serviceCard->expired_at->diffForHumans() }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Personnel Number</div>
                            <div class="info-value">{{ $profile->personnel_number ?? 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">CNIC</div>
                            <div class="info-value">{{ $profile->cnic ?? 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Father Name</div>
                            <div class="info-value">{{ $profile->father_name ?? 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Date of Birth</div>
                            <div class="info-value">
                                {{ $profile->date_of_birth ? $profile->date_of_birth->format('d M, Y') : 'N/A' }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $user->email ?? 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Mobile Number</div>
                            <div class="info-value">{{ $profile->mobile_number ?? 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Blood Group</div>
                            <div class="info-value">{{ $profile->blood_group ?? 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Emergency Contact</div>
                            <div class="info-value">{{ $profile->emergency_contact ?? 'N/A' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Designation</div>
                            <div class="info-value office-name">
                                {{ $user->currentDesignation ? $user->currentDesignation->name : 'N/A' }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Office</div>
                            <div class="info-value office-name">
                                {{ $user->currentOffice ? $user->currentOffice->name : 'N/A' }}</div>
                        </div>

                        <div class="info-item" style="grid-column: 1 / -1;">
                            <div class="info-label">Present Address</div>
                            <div class="info-value">{{ $profile->present_address ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="qr-verification">
                        <i class="bi bi-shield-check" style="font-size: 48px; color: #28a745;"></i>
                        <h5 class="mt-3">Verification Complete</h5>
                        <p class="text-muted mb-0">Card ID: {{format_card_id($serviceCard->id) }}</p>
                        <small class="text-muted">Verified on {{ now()->format('d M, Y \a\t h:i A') }}</small>
                    </div>
                @else
                    <div class="text-center mt-5">
                        <i class="bi bi-exclamation-triangle" style="font-size: 64px; color: #dc3545;"></i>
                        <h4 class="mt-3">Verification Failed</h4>
                        <p class="text-muted">
                            @if ($status == 'invalid')
                                This service card is not in active status.
                            @elseif($serviceCard->status !== 'verified')
                                This service card has not been verified by the issuing authority.
                            @else
                                This service card cannot be verified at this time.
                            @endif
                        </p>
                        <p class="mt-4">
                            <small>For assistance, please contact IT Cell (9214039), C&W Department</small>
                        </p>
                    </div>
                @endif
            </div>
        @else
            <div class="info-card">
                <div class="text-center">
                    <i class="bi bi-x-octagon" style="font-size: 64px; color: #6c757d;"></i>
                    <h3 class="mt-4">Service Card Not Found</h3>
                    <p class="text-muted">The QR code or link you followed does not correspond to a valid service card.
                    </p>
                    <p class="mt-4">
                        <small>For assistance, please contact IT Cell (9214039), C&W Department</small>
                    </p>
                </div>
            </div>
        @endif

        <button type="button" class="print-button no-print">
            <i class="bi bi-printer"></i>
            Print Verification
        </button>
    </div>

    @push('script')
        <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
        <script>
            // Add smooth scroll effect
            document.addEventListener('DOMContentLoaded', function() {
                const infoItems = document.querySelectorAll('.info-item');

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.animation = 'slideIn 0.5s ease-out';
                        }
                    });
                }, {
                    threshold: 0.1
                });

                infoItems.forEach(item => {
                    observer.observe(item);
                });
            });

            $('.print-button').on('click', () => {
                $(".verification-container").printThis({
                    pageTitle: "Card details of {{ $user->name }}",
                    beforePrint() {
                        if (window.Pace && Pace.restart) {
                            Pace.restart();
                        }
                    },
                    afterPrint() {
                        if (window.Pace && Pace.stop) {
                            Pace.stop();
                        }
                    }
                });
            });
        </script>
    @endpush
</x-main-layout>
