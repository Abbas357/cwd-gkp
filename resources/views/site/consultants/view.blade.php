<x-main-layout>
    @push('style')
    <style>

        .filters {
            padding: 2rem;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .sector-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .sector-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sector-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: #4f46e5;
            color: #4f46e5;
        }

        .sector-btn.active {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border-color: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
        }

        .stats {
            padding: 1.5rem 2rem;
            background: #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #475569;
            font-weight: 600;
        }

        .stat-number {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .table-container {
            padding: 2rem;
            overflow-x: auto;
        }

        .consultants-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .consultants-table thead {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
        }

        .consultants-table th {
            padding: 1.2rem 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .consultants-table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .consultants-table tbody tr {
            transition: all 0.3s ease;
        }

        .consultants-table tbody tr:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            transform: scale(1.01);
        }

        .sector-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
            display: inline-block;
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

        .consultant-name {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.1rem;
        }

        .consultant-email {
            color: #64748b;
            font-size: 0.9rem;
        }

        .consultant-contact {
            color: #475569;
            font-weight: 600;
        }

        .pec-number {
            background: #f1f5f9;
            padding: 0.3rem 0.8rem;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #475569;
        }

        .district-info {
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .no-data {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        .no-data i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #cbd5e1;
        }

        .search-box {
            position: relative;
            width: 400px;
            margin: 0 auto;
            margin-bottom: 1rem;
        }

        .search-input {
            width: 400px;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .action-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .view-link {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .email-link {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .phone-link {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .action-link:hover {
            transform: translateY(-2px) scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Pagination Styles */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: white;
            border-top: 1px solid #e2e8f0;
        }

        .pagination-info {
            color: #64748b;
            font-size: 0.9rem;
        }

        .pagination {
            margin: 0;
        }

        .pagination .page-link {
            color: #4f46e5;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: #4f46e5;
            color: white;
            border-color: #4f46e5;
            transform: translateY(-1px);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-color: #4f46e5;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #cbd5e1;
            background: #f8fafc;
            border-color: #e2e8f0;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .sector-buttons {
                justify-content: center;
            }

            .consultants-table {
                font-size: 0.9rem;
            }

            .consultants-table th,
            .consultants-table td {
                padding: 0.8rem 0.5rem;
            }

            .pagination-container {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>

    @endpush
    <x-slot name="breadcrumbTitle">
        Approved Consultants
    </x-slot>

    <div class="container">
        <div class="filters text-center">
            <div class="search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Search consultants...">
            </div>
            
            <div class="sector-buttons">
                <a href="?sector=" class="sector-btn {{ !$selectedSector ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    All Sectors
                </a>
                @foreach($sectors as $sector)
                    <a href="?sector={{ $sector }}" class="sector-btn {{ $selectedSector === $sector ? 'active' : '' }}">
                        <i class="bi bi-{{ $sector === 'Road' ? 'signpost-2' : ($sector === 'Building' ? 'building' : 'bridge') }}"></i>
                        {{ $sector }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="stats">
            <div class="stat-item">
                <i class="bi bi-bar-chart-fill"></i>
                Total Consultants: 
                <span class="stat-number" id="totalConsultants">{{ $consultants->count() }}</span>
            </div>
            @if($selectedSector)
                <div class="stat-item">
                    <i class="bi bi-funnel-fill"></i>
                    Filtered by: 
                    <span class="stat-number">{{ $selectedSector }}</span>
                </div>
            @endif
        </div>

        <div class="table-container">
            @if($consultants->count() > 0)
                <table class="consultants-table" id="consultantsTable">
                    <thead>
                        <tr>
                            <th><i class="bi bi-building"></i> Firm Name</th>
                            <th><i class="bi bi-envelope-fill"></i> Contact Info</th>
                            <th><i class="bi bi-card-text"></i> PEC Number</th>
                            <th><i class="bi bi-diagram-3-fill"></i> Sector</th>
                            <th><i class="bi bi-geo-alt-fill"></i> District</th>
                            <th><i class="bi bi-house-fill"></i> Address</th>
                            <th><i class="bi bi-gear-fill"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody id="consultantsTableBody">
                        <tr id="consultants-loader-row">
                            <td colspan="7" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </td>
                        </tr>
                        @foreach($consultants as $consultant)
                            <tr class="consultant-row">
                                <td>
                                    <div class="consultant-name">{{ $consultant->name }}</div>
                                </td>
                                <td>
                                    <div class="consultant-email">
                                        <i class="bi bi-envelope"></i> {{ $consultant->email }}
                                    </div>
                                    <div class="consultant-contact">
                                        <i class="bi bi-telephone-fill"></i> {{ $consultant->contact_number }}
                                    </div>
                                </td>
                                <td>
                                    <span class="pec-number">{{ $consultant->pec_number }}</span>
                                </td>
                                <td>
                                    <span class="sector-badge sector-{{ strtolower($consultant->sector) }}">
                                        {{ $consultant->sector }}
                                    </span>
                                </td>
                                <td>
                                    <div class="district-info">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $consultant->district->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>{{ $consultant->address ?: 'N/A' }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('consultants.show', ['uuid' => $consultant->uuid]) }}" 
                                           class="action-link view-link" 
                                           title="View Details">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="mailto:{{ $consultant->email }}" 
                                           class="action-link email-link" 
                                           title="Send Email">
                                            <i class="bi bi-envelope-fill"></i>
                                        </a>
                                        <a href="tel:{{ $consultant->contact_number }}" 
                                           class="action-link phone-link" 
                                           title="Call">
                                            <i class="bi bi-telephone-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <div class="pagination-container" id="paginationContainer" style="display: none;">
                    <div class="pagination-info" id="paginationInfo">
                        Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="showingTotal">0</span> entries
                    </div>
                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination" id="paginationNav">
                            <!-- Pagination buttons will be generated by JavaScript -->
                        </ul>
                    </nav>
                </div>
            @else
                <div class="no-data">
                    <i class="bi bi-search"></i>
                    <h3>No Consultants Found</h3>
                    <p>
                        @if($selectedSector)
                            No approved consultants found in the {{ $selectedSector }} sector.
                        @else
                            No approved consultants found in the system.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

    @push('script')
    <script>
        class ConsultantsPagination {
            constructor() {
                this.currentPage = 1;
                this.itemsPerPage = 10;
                this.allRows = [];
                this.filteredRows = [];
                this.init();
            }

            init() {
                this.allRows = Array.from(document.querySelectorAll('.consultant-row'));
                this.filteredRows = [...this.allRows];
                this.setupSearch();
                this.setupPagination();
                this.setupAnimation();
            }

            setupSearch() {
                const searchInput = document.getElementById('searchInput');
                searchInput.addEventListener('keyup', (e) => {
                    this.search(e.target.value);
                });
            }

            search(searchTerm) {
                const term = searchTerm.toLowerCase();
                
                this.filteredRows = this.allRows.filter(row => {
                    const text = row.textContent.toLowerCase();
                    return text.includes(term);
                });

                this.currentPage = 1;
                this.updateDisplay();
                this.updateStats();
            }

            setupPagination() {
                this.updateDisplay();
                this.updateStats();
            }

            updateDisplay() {
                const totalItems = this.filteredRows.length;
                const paginationContainer = document.getElementById('paginationContainer');
                
                // Show/hide pagination based on item count
                if (totalItems > this.itemsPerPage) {
                    paginationContainer.style.display = 'flex';
                    this.showPaginatedRows();
                    this.generatePagination();
                    this.updatePaginationInfo();
                } else {
                    paginationContainer.style.display = 'none';
                    this.showAllFilteredRows();
                }
            }

            showPaginatedRows() {
                const startIndex = (this.currentPage - 1) * this.itemsPerPage;
                const endIndex = startIndex + this.itemsPerPage;

                // Hide all rows first
                this.allRows.forEach(row => {
                    row.style.display = 'none';
                });

                // Show only the rows for current page
                this.filteredRows.slice(startIndex, endIndex).forEach(row => {
                    row.style.display = '';
                });
            }

            showAllFilteredRows() {
                // Hide all rows first
                this.allRows.forEach(row => {
                    row.style.display = 'none';
                });

                // Show all filtered rows
                this.filteredRows.forEach(row => {
                    row.style.display = '';
                });
            }

            generatePagination() {
                const totalItems = this.filteredRows.length;
                const totalPages = Math.ceil(totalItems / this.itemsPerPage);
                const paginationNav = document.getElementById('paginationNav');
                
                let paginationHTML = '';

                // Previous button
                paginationHTML += `
                    <li class="page-item ${this.currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${this.currentPage - 1}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                `;

                // Page numbers
                const startPage = Math.max(1, this.currentPage - 2);
                const endPage = Math.min(totalPages, this.currentPage + 2);

                if (startPage > 1) {
                    paginationHTML += `
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="1">1</a>
                        </li>
                    `;
                    if (startPage > 2) {
                        paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    paginationHTML += `
                        <li class="page-item ${i === this.currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    }
                    paginationHTML += `
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                        </li>
                    `;
                }

                // Next button
                paginationHTML += `
                    <li class="page-item ${this.currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${this.currentPage + 1}">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                `;

                paginationNav.innerHTML = paginationHTML;

                // Add event listeners
                paginationNav.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const page = parseInt(e.target.getAttribute('data-page')) || parseInt(e.target.parentElement.getAttribute('data-page'));
                        if (page && !isNaN(page) && page !== this.currentPage) {
                            this.goToPage(page);
                        }
                    });
                });
            }

            updatePaginationInfo() {
                const totalItems = this.filteredRows.length;
                const startIndex = (this.currentPage - 1) * this.itemsPerPage + 1;
                const endIndex = Math.min(this.currentPage * this.itemsPerPage, totalItems);

                document.getElementById('showingStart').textContent = startIndex;
                document.getElementById('showingEnd').textContent = endIndex;
                document.getElementById('showingTotal').textContent = totalItems;
            }

            goToPage(page) {
                const totalPages = Math.ceil(this.filteredRows.length / this.itemsPerPage);
                if (page >= 1 && page <= totalPages) {
                    this.currentPage = page;
                    this.updateDisplay();
                    this.animateRows();
                }
            }

            updateStats() {
                const totalConsultants = document.getElementById('totalConsultants');
                totalConsultants.textContent = this.filteredRows.length;
            }

            setupAnimation() {
                this.animateRows();
            }

            animateRows() {
                const visibleRows = document.querySelectorAll('.consultant-row[style=""], .consultant-row:not([style])');
                visibleRows.forEach((row, index) => {
                    if (row.style.display !== 'none') {
                        row.style.opacity = '0';
                        row.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            row.style.transition = 'all 0.5s ease';
                            row.style.opacity = '1';
                            row.style.transform = 'translateY(0)';
                        }, index * 50);
                    }
                });
            }
        }

        $('#consultantsTableBody').hide();
        document.addEventListener('DOMContentLoaded', function() {
            $('#consultantsTableBody').show();
            $('#consultants-loader-row').hide();
            new ConsultantsPagination();
        });
    </script>
    @endpush
</x-main-layout>