<div {{ $attributes->merge(['class' => 'table-skeleton-wrapper']) }}>
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

        .skeleton-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
        }

        .skeleton-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 1rem;
            font-weight: 600;
            text-align: center;
        }

        .skeleton-row {
            padding: .8rem 1.3rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .skeleton-row:last-child {
            border-bottom: none;
        }

        .skeleton-header-row {
            background: #f9fafb;
            font-weight: 600;
            border-bottom: 2px solid #e5e7eb;
        }

        .skeleton-cell {
            height: 1.5rem;
            border-radius: 4px;
            flex: 1;
            max-width: 200px;
        }

        .skeleton-cell:first-child {
            max-width: 120px;
        }

        .skeleton-cell:last-child {
            max-width: 80px;
        }

        .loading-text {
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 1rem;
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
            
            .skeleton-table {
                background: #1f2937;
                border-color: #374151;
            }
            
            .skeleton-row {
                border-color: #374151;
            }
            
            .skeleton-header-row {
                background: #374151;
            }
        }
    </style>
    
    <!-- Loading Text -->
    <div class="loading-text">
        <svg class="loading-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 12a9 9 0 11-6.219-8.56"/>
        </svg>
        {{ $loadingText }}
    </div>

    <!-- Skeleton Table -->
    <div class="skeleton-table">
        @if($title)
        <div class="skeleton-header">
            {{ $title }}
        </div>
        @endif

        <div>
            @if($showHeader)
            <!-- Header Row -->
            <div class="skeleton-row skeleton-header-row">
                @for($i = 0; $i < $columns; $i++)
                    <div class="skeleton-loader skeleton-cell"></div>
                @endfor
            </div>
            @endif

            <!-- Data Rows -->
            @for($row = 0; $row < $rows; $row++)
                <div class="skeleton-row">
                    @for($col = 0; $col < $columns; $col++)
                        <div class="skeleton-loader skeleton-cell"></div>
                    @endfor
                </div>
            @endfor
        </div>
    </div>
</div>