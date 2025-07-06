<div {{ $attributes->merge(['class' => 'form-skeleton-wrapper']) }}>
    <style>
        .skeleton-loader {
            animation: skeleton-shimmer 1.5s infinite ease-in-out;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            border-radius: 4px;
            display: block;
        }

        @keyframes skeleton-shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .skeleton-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            width: 100%;
        }

        .skeleton-container.no-border {
            border: none;
            box-shadow: none;
            background: transparent;
        }

        .skeleton-header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .skeleton-title {
            height: 1.5rem;
            width: 200px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .skeleton-close-btn {
            height: 1.5rem;
            width: 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
        }

        .skeleton-body {
            padding: 2rem;
        }

        .skeleton-body.no-padding {
            padding: 0;
        }

        .skeleton-tabs {
            display: flex;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .skeleton-tab {
            height: 2.5rem;
            border-radius: 6px 6px 0 0;
            flex: 1;
            max-width: 120px;
        }

        .skeleton-tab:first-child {
            background: linear-gradient(90deg, #3b82f6 25%, #2563eb 50%, #3b82f6 75%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 1.5s infinite ease-in-out;
        }

        .skeleton-form-grid {
            display: grid;
            grid-template-columns: repeat(var(--columns), 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .skeleton-form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .skeleton-label {
            height: 1rem;
            width: 80px;
            border-radius: 4px;
        }

        .skeleton-input {
            height: 2.5rem;
            border-radius: 6px;
        }

        .skeleton-textarea-group {
            grid-column: 1 / -1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .skeleton-textarea {
            height: 6rem;
            border-radius: 6px;
        }

        .skeleton-footer {
            background: #f9fafb;
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .skeleton-btn {
            height: 2.5rem;
            border-radius: 6px;
        }

        .skeleton-btn-cancel {
            width: 80px;
        }

        .skeleton-btn-primary {
            width: 100px;
            background: linear-gradient(90deg, #3b82f6 25%, #2563eb 50%, #3b82f6 75%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 1.5s infinite ease-in-out;
        }

        .loading-text {
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 1.5rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .loading-icon {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .skeleton-loader {
                background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
            }
            
            .skeleton-container {
                background: #1f2937;
                border-color: #374151;
            }
            
            .skeleton-tabs {
                border-color: #374151;
            }
            
            .skeleton-footer {
                background: #374151;
                border-color: #4b5563;
            }

            .skeleton-title,
            .skeleton-close-btn {
                background: rgba(255, 255, 255, 0.1);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .skeleton-form-grid {
                grid-template-columns: 1fr !important;
            }
            
            .skeleton-tabs {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            
            .skeleton-tab {
                max-width: none;
                min-width: 80px;
            }
        }
    </style>
    
    @if($showLoadingText)
    <!-- Loading Text -->
    <div class="loading-text">
        <svg class="loading-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 12a9 9 0 11-6.219-8.56"/>
        </svg>
        {{ $loadingText }}
    </div>
    @endif

    <!-- Skeleton Container -->
    <div class="skeleton-container {{ $noBorder ? 'no-border' : '' }}">
        @if($showHeader)
        <!-- Header -->
        <div class="skeleton-header">
            <div class="skeleton-title"></div>
            @if($showCloseBtn)
            <div class="skeleton-close-btn"></div>
            @endif
        </div>
        @endif

        <!-- Body -->
        <div class="skeleton-body {{ $noPadding ? 'no-padding' : '' }}">
            @if($tabs > 0)
            <!-- Tabs -->
            <div class="skeleton-tabs">
                @for($i = 0; $i < $tabs; $i++)
                    <div class="skeleton-loader skeleton-tab"></div>
                @endfor
            </div>
            @endif

            <!-- Form Grid -->
            <div class="skeleton-form-grid" style="--columns: {{ $inputColumns }};">
                @for($row = 0; $row < $inputRows; $row++)
                    @for($col = 0; $col < $inputColumns; $col++)
                        <div class="skeleton-form-group">
                            <div class="skeleton-loader skeleton-label"></div>
                            <div class="skeleton-loader skeleton-input"></div>
                        </div>
                    @endfor
                @endfor

                <!-- Textareas spanning full width -->
                @for($i = 0; $i < $textareas; $i++)
                    <div class="skeleton-textarea-group">
                        <div class="skeleton-loader skeleton-label"></div>
                        <div class="skeleton-loader skeleton-textarea"></div>
                    </div>
                @endfor
            </div>
        </div>

        @if($showFooter)
        <!-- Footer -->
        <div class="skeleton-footer">
            <div class="skeleton-loader skeleton-btn skeleton-btn-cancel"></div>
            <div class="skeleton-btn-primary skeleton-btn"></div>
        </div>
        @endif
    </div>
</div>