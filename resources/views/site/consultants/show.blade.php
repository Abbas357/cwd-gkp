<x-main-layout>
    @push('style')
    <style>
        .consultant-hero {
            background: linear-gradient(135deg, #ffffff 0%, #f5ebff 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .consultant-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.15"/><circle cx="20" cy="60" r="0.5" fill="white" opacity="0.15"/><circle cx="80" cy="40" r="0.5" fill="white" opacity="0.15"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }

        .consultant-hero .container {
            position: relative;
            z-index: 2;
        }

        .consultant-avatar {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            margin: 0 auto 2rem;
            border: 6px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: avatarPulse 3s ease-in-out infinite;
        }

        @keyframes avatarPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .consultant-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .detail-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .detail-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .detail-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }

        .detail-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .card-content {
            color: #64748b;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid #4f46e5;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
        }

        .info-value {
            font-size: 1.1rem;
            color: #1e293b;
            font-weight: 600;
        }

        .sector-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sector-road {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .sector-building {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .sector-bridge {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
        }

        .btn-outline {
            background: transparent;
            color: #4f46e5;
            border: 2px solid #4f46e5;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .stats-bar {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #4f46e5;
            display: block;
        }

        .stat-label {
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .consultant-title {
                font-size: 2rem;
            }
            
            .consultant-subtitle {
                font-size: 1.1rem;
            }
            
            .detail-cards {
                grid-template-columns: 1fr;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .consultant-avatar {
                width: 120px;
                height: 120px;
                font-size: 3rem;
            }
        }
    </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        Consultant Detail
    </x-slot>

    <div class="consultant-hero">
        <div class="container">
            <div class="consultant-avatar">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <h1 class="consultant-title">{{ $consultant->name }}</h1>
        </div>
    </div>

    <div class="container">

        <div class="detail-cards">
            <div class="detail-card">
                <div class="card-icon">
                    <i class="bi bi-card-text"></i>
                </div>
                <h3 class="card-title">Professional Information</h3>
                <div class="card-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-award-fill"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">PEC Number</div>
                                <div class="info-value">{{ $consultant->pec_number }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-diagram-3-fill"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Sector</div>
                                <div class="info-value">
                                    <span class="sector-badge sector-{{ strtolower($consultant->sector) }}">
                                        <i class="bi bi-{{ $consultant->sector === 'Road' ? 'signpost-2' : ($consultant->sector === 'Building' ? 'building' : 'bridge') }}"></i>
                                        {{ $consultant->sector }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-card">
                <div class="card-icon">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <h3 class="card-title">Contact Information</h3>
                <div class="card-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Email Address</div>
                                <div class="info-value">{{ $consultant->email }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Contact Number</div>
                                <div class="info-value">{{ $consultant->contact_number }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-card">
                <div class="card-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                <h3 class="card-title">Location & Address</h3>
                <div class="card-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">District</div>
                                <div class="info-value">{{ $consultant->district ? $consultant->district->name : 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-house-fill"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Address</div>
                                <div class="info-value">{{ $consultant->address ?: 'Not specified' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="mailto:{{ $consultant->email }}" class="action-btn btn-primary">
                <i class="bi bi-envelope-fill"></i>
                Send Email
            </a>
            <a href="tel:{{ $consultant->contact_number }}" class="action-btn btn-outline">
                <i class="bi bi-telephone-fill"></i>
                Call Now
            </a>
            <a href="{{ route('consultants.view') }}" class="action-btn btn-outline">
                <i class="bi bi-arrow-left"></i>
                Back to List
            </a>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add smooth entrance animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.detail-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });

            // Add hover effects to info items
            const infoItems = document.querySelectorAll('.info-item');
            infoItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                    this.style.transition = 'transform 0.3s ease';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
        });

        // Copy to clipboard functionality
        function copyToClipboard(text, element) {
            navigator.clipboard.writeText(text).then(function() {
                const originalText = element.textContent;
                element.textContent = 'Copied!';
                element.style.color = '#10b981';
                setTimeout(() => {
                    element.textContent = originalText;
                    element.style.color = '';
                }, 2000);
            });
        }

        // Add click-to-copy functionality
        document.querySelectorAll('.info-value').forEach(element => {
            if (element.textContent.includes('@') || element.textContent.match(/[\d\-\+]/)) {
                element.style.cursor = 'pointer';
                element.title = 'Click to copy';
                element.addEventListener('click', function() {
                    copyToClipboard(this.textContent, this);
                });
            }
        });
    </script>
    @endpush
</x-main-layout>