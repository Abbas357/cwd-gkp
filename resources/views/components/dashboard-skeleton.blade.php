<div {{ $attributes->merge(['class' => 'dashboard-skeleton-wrapper']) }}>
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

        .dashboard-skeleton {
            padding: 1.5rem;
            gap: 2rem;
        }

        .loading-text {
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 2rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 1.1rem;
        }

        .loading-icon {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Stats Boxes Section */
        .stats-section {
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid #e5e7eb;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }

        .stat-value {
            height: 2rem;
            width: 60%;
            border-radius: 6px;
        }

        .stat-label {
            height: 1rem;
            width: 80%;
            border-radius: 4px;
        }

        .stat-change {
            height: 1rem;
            width: 40%;
            border-radius: 4px;
        }

        /* Table Section */
        .table-section {
            margin-bottom: 2rem;
        }

        .table-with-chart-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            align-items: stretch;
        }

        .table-container {
            grid-column: 1;
        }

        .side-chart-container {
            grid-column: 2;
        }

        .skeleton-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid #e5e7eb;
        }

        .skeleton-header {
            background: #EEEEEE;
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .skeleton-row {
            padding: 1rem 1.5rem;
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

        /* Charts Section */
        .charts-section {
            margin-top: 2rem;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .chart-box {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid #e5e7eb;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .chart-title {
            height: 1.2rem;
            width: 70%;
            border-radius: 4px;
        }

        .chart-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
        }

        .chart-legend {
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 100%;
            margin-top: 8px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
        }

        .legend-text {
            height: 1rem;
            flex: 1;
            border-radius: 3px;
        }

        /* Bar Chart Styles */
        .bar-chart-container {
            display: flex;
            align-items: end;
            justify-content: space-between;
            height: 100px;
            width: 100%;
            gap: 8px;
            margin: 16px 0;
        }

        .bar-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .bar-chart {
            width: 100%;
            max-width: 20px;
            border-radius: 4px 4px 0 0;
            min-height: 20px;
        }

        .bar-label {
            height: 0.8rem;
            width: 100%;
            border-radius: 3px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .stats-grid, .charts-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .table-with-chart-grid {
                grid-template-columns: 1fr;
            }
            
            .table-container, .side-chart-container {
                grid-column: 1;
            }
        }

        @media (max-width: 640px) {
            .stats-grid, .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .dashboard-skeleton {
                padding: 1rem;
            }
            
            .table-with-chart-grid {
                gap: 1rem;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .skeleton-loader {
                background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
            }
            
            .stat-box, .skeleton-table, .chart-box {
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
    
    <div class="dashboard-skeleton">
        <!-- Loading Text -->
        <div class="loading-text">
            <svg class="loading-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12a9 9 0 11-6.219-8.56"/>
            </svg>
            {{ $loadingText }}
        </div>

        @if($showStatsBoxes)
        <!-- Stats Boxes Section (4 columns, 1 row) -->
        <div class="stats-section">
            <div class="stats-grid">
                @for($i = 0; $i < 4; $i++)
                    <div class="stat-box">
                        <div class="skeleton-loader stat-icon"></div>
                        <div class="skeleton-loader stat-value"></div>
                        <div class="skeleton-loader stat-label"></div>
                        <div class="skeleton-loader stat-change"></div>
                    </div>
                @endfor
            </div>
        </div>
        @endif

        @if($showTable)
        <!-- Table Section with Side Chart -->
        <div class="table-section">
            <div class="table-with-chart-grid">
                <!-- Table (8 columns) -->
                <div class="table-container">
                    <div class="skeleton-table">
                        <div class="skeleton-header">
                            <div class="skeleton-loader" style="height: 1.5rem; width: 200px; background: rgba(255,255,255,0.3);"></div>
                        </div>

                        <div>
                            <!-- Header Row -->
                            <div class="skeleton-row skeleton-header-row">
                                @for($i = 0; $i < $tableColumns; $i++)
                                    <div class="skeleton-loader skeleton-cell"></div>
                                @endfor
                            </div>

                            <!-- Data Rows -->
                            @for($row = 0; $row < $tableRows; $row++)
                                <div class="skeleton-row">
                                    @for($col = 0; $col < $tableColumns; $col++)
                                        <div class="skeleton-loader skeleton-cell"></div>
                                    @endfor
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Side Chart (4 columns) -->
                <div class="side-chart-container">
                    <div class="chart-box">
                        <div class="skeleton-loader chart-title"></div>
                        <div class="skeleton-loader chart-circle"></div>
                        <div class="chart-legend">
                            @for($j = 0; $j < 4; $j++)
                                <div class="legend-item">
                                    <div class="skeleton-loader legend-color"></div>
                                    <div class="skeleton-loader legend-text"></div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($showCharts)
        <!-- Charts Section (4 columns, 1 row) -->
        <div class="charts-section">
            <div class="charts-grid">
                @for($i = 0; $i < 4; $i++)
                    <div class="chart-box">
                        <div class="skeleton-loader chart-title"></div>
                        @if($i < 2)
                            <!-- Pie Charts (first two) -->
                            <div class="skeleton-loader chart-circle"></div>
                            <div class="chart-legend">
                                @for($j = 0; $j < 3; $j++)
                                    <div class="legend-item">
                                        <div class="skeleton-loader legend-color"></div>
                                        <div class="skeleton-loader legend-text"></div>
                                    </div>
                                @endfor
                            </div>
                        @else
                            <!-- Bar Charts (last two) -->
                            <div class="bar-chart-container">
                                @for($j = 0; $j < 5; $j++)
                                    <div class="bar-item">
                                        <div class="skeleton-loader bar-chart" style="height: {{ 30 + ($j * 15) }}px;"></div>
                                        <div class="skeleton-loader bar-label"></div>
                                    </div>
                                @endfor
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
        @endif
    </div>
</div>