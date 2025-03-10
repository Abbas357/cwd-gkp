<x-hr-layout>
    @push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/orgchart/3.1.1/css/jquery.orgchart.min.css" rel="stylesheet">
    <style>
        #chart-container {
            height: 700px;
            overflow: auto;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .orgchart {
            background-image: none !important;
        }
        
        .orgchart .node {
            width: 220px;
        }
        
        .orgchart .node .title {
            width: 220px;
            height: auto;
            line-height: 20px;
            padding: 5px;
        }
        
        .orgchart .node .content {
            width: 220px;
            height: auto;
            padding: 5px;
        }
        
        .orgchart .node .office-name {
            font-weight: bold;
        }
        
        .orgchart .node .office-type {
            font-size: 0.8rem;
            color: #666;
        }
        
        .orgchart .node .user-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin: 5px auto;
            border: 2px solid #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        
        .orgchart .node .user-name {
            font-weight: bold;
            margin: 3px 0;
        }
        
        .orgchart .node .user-title {
            font-size: 0.8rem;
            color: #666;
        }
        
        .orgchart .node .users-count {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            margin-top: 5px;
        }
        
        .orgchart .node.level-0 .title {
            background-color: #9b59b6;
        }
        
        .orgchart .node.level-1 .title {
            background-color: #3498db;
        }
        
        .orgchart .node.level-2 .title {
            background-color: #2ecc71;
        }
        
        .orgchart .node.level-3 .title {
            background-color: #e67e22;
        }
        
        /* Lines connector color */
        .orgchart .lines {
            color: rgba(68, 157, 68, 0.75);
        }
        
        .orgchart .lines:before, .orgchart .lines:after {
            border-color: rgba(68, 157, 68, 0.75);
        }
        
        #user-chart-container {
            height: 350px;
            overflow: auto;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .user-info-popup {
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            width: 250px;
            display: none;
        }
        
        .filter-controls {
            margin-bottom: 20px;
        }
        
        /* Make selected node stand out */
        .orgchart .node.focused {
            background-color: rgba(238, 217, 54, 0.25);
        }
        
        /* Additional classes for supervisor/subordinate nodes */
        .orgchart .node.supervisor-node .title {
            background-color: #2980b9;
        }
        
        .orgchart .node.subordinate-node .title {
            background-color: #27ae60;
        }
        
        .orgchart .node.selected-user .title {
            background-color: #e74c3c;
        }
        
        /* Loading indicator */
        .chart-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 100;
        }
        
        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }
            #chart-container, #chart-container * {
                visibility: visible;
            }
            #chart-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: auto;
                overflow: visible;
            }
        }
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Organogram</li>
    </x-slot>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Organization Chart</h5>
                    <div>
                        <button id="btn-print-chart" class="btn btn-sm btn-secondary me-2">
                            <i class="bi bi-printer"></i> Print
                        </button>
                        <button id="btn-export-chart" class="btn btn-sm btn-primary">
                            <i class="bi bi-download"></i> Export PNG
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="filter-controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="root-office">Root Office</label>
                                    <select id="root-office" class="form-control">
                                        @foreach($topOffices as $office)
                                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chart-depth">Chart Depth</label>
                                    <select id="chart-depth" class="form-control">
                                        <option value="1">1 Level</option>
                                        <option value="2" selected>2 Levels</option>
                                        <option value="3">3 Levels</option>
                                        <option value="4">4 Levels</option>
                                        <option value="0">All Levels</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user-search">Search User</label>
                                    <div class="input-group">
                                        <input type="text" id="user-search" class="form-control" placeholder="Search by name...">
                                        <button class="btn btn-primary" id="search-btn" type="button">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="chart-container" class="position-relative">
                        <div class="chart-loading">
                            <div class="spinner-border text-primary"></div>
                            <p class="mt-3">Loading organization chart...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">User Hierarchy</h5>
                </div>
                <div class="card-body">
                    <div id="user-chart-container" class="position-relative">
                        <div class="text-center p-5">
                            <i class="bi bi-people fs-1 text-muted"></i>
                            <p class="mt-3">Select a user from the organogram above to view their reporting structure.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="user-info-popup" class="user-info-popup"></div>

    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/3.1.1/js/jquery.orgchart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script>
        $(document).ready(function() {
            let orgChart = null;
            let userOrgChart = null;
            
            // Function to generate org chart
            function initOrganogram(officeId, depth) {
                $('.chart-loading').show();
                $('#chart-container').css('min-height', '300px');
                
                if (orgChart) {
                    // Remove existing chart before creating a new one
                    $('#chart-container').find('.orgchart').remove();
                }
                
                $.ajax({
                    url: "{{ route('admin.apps.hr.organogram.data') }}",
                    type: "GET",
                    data: { 
                        office_id: officeId,
                        depth: depth
                    },
                    success: function(data) {
                        // Create the org chart with TOP-DOWN direction
                        orgChart = $('#chart-container').orgchart({
                            'data': data,
                            'nodeContent': 'content',
                            'nodeID': 'id',
                            'createNode': function($node, data) {
                                // Add custom classes
                                if (data.className) {
                                    $node.addClass(data.className);
                                }
                                
                                // Create custom node content
                                let nodeContent = '';
                                
                                // Add office details
                                nodeContent += `<div class="office-name">${data.name}</div>`;
                                nodeContent += `<div class="office-type">${data.title}</div>`;
                                
                                // Add head user if available
                                if (data.head) {
                                    nodeContent += `<div class="user-container" data-user-id="${data.head.id}">`;
                                    nodeContent += `<img class="user-image" src="${data.head.image}" alt="${data.head.name}">`;
                                    nodeContent += `<div class="user-name">${data.head.name}</div>`;
                                    nodeContent += `<div class="user-title">${data.head.title}</div>`;
                                    nodeContent += `</div>`;
                                }
                                
                                // Add users count if available
                                if (data.users_count && data.users_count > 0) {
                                    nodeContent += `<div class="users-count">${data.users_count} staff</div>`;
                                }
                                
                                $node.find('.content').html(nodeContent);
                                
                                // Add data attributes for interaction
                                $node.attr('data-office-id', data.office_id);
                                if (data.head) {
                                    $node.attr('data-user-id', data.head.id);
                                }
                                
                                return $node;
                            },
                            'direction': 't2b', // TOP TO BOTTOM direction
                            'pan': true,
                            'zoom': true,
                            'toggleSiblingsResp': true
                        });
                        
                        // Setup node click handlers
                        $('#chart-container').on('click', '.node', function() {
                            // Clear any previous focus
                            $('.orgchart .node').removeClass('focused');
                            
                            // Add focused class to this node
                            $(this).addClass('focused');
                            
                            const officeId = $(this).data('office-id');
                            const userId = $(this).data('user-id');
                            
                            if (userId) {
                                loadUserHierarchy(userId);
                            }
                        });
                        
                        // Setup user click handlers
                        $('#chart-container').on('click', '.user-container', function(e) {
                            e.stopPropagation();
                            const userId = $(this).data('user-id');
                            
                            // Find the parent node and add focused class
                            $(this).closest('.node').addClass('focused');
                            
                            loadUserHierarchy(userId);
                        });
                        
                        $('.chart-loading').hide();
                    },
                    error: function() {
                        $('#chart-container').html('<div class="alert alert-danger">Error loading organization chart.</div>');
                        $('.chart-loading').hide();
                    }
                });
            }
            
            // Function to load user hierarchy
            function loadUserHierarchy(userId) {
                $('#user-chart-container').html('<div class="text-center p-5"><div class="spinner-border text-primary"></div><p class="mt-3">Loading user hierarchy...</p></div>');
                
                $.ajax({
                    url: "{{ route('admin.apps.hr.organogram.user-hierarchy') }}",
                    type: "GET",
                    data: { user_id: userId },
                    success: function(data) {
                        $('#user-chart-container').empty();
                        
                        if (userOrgChart) {
                            // Remove previous chart
                            $('#user-chart-container').find('.orgchart').remove();
                        }
                        
                        // Create the user org chart
                        userOrgChart = $('#user-chart-container').orgchart({
                            'data': data,
                            'nodeContent': 'content',
                            'nodeID': 'id',
                            'createNode': function($node, data) {
                                // Add custom classes
                                if (data.className) {
                                    $node.addClass(data.className);
                                }
                                
                                // Create custom node content
                                let nodeContent = '';
                                
                                // Add user details
                                nodeContent += `<div class="user-container" data-user-id="${data.id}">`;
                                nodeContent += `<img class="user-image" src="${data.image}" alt="${data.name}">`;
                                nodeContent += `<div class="user-name">${data.name}</div>`;
                                nodeContent += `<div class="user-title">${data.title}</div>`;
                                if (data.office) {
                                    nodeContent += `<div class="user-title">${data.office}</div>`;
                                }
                                nodeContent += `</div>`;
                                
                                $node.find('.content').html(nodeContent);
                                $node.attr('data-user-id', data.id);
                                
                                return $node;
                            },
                            'direction': 't2b', // TOP TO BOTTOM direction
                            'verticalLevel': 2,
                            'toggleSiblingsResp': false,
                            'pan': true,
                            'zoom': true
                        });
                        
                        // Setup node click handlers
                        $('#user-chart-container').find('.node').on('click', function() {
                            const userId = $(this).data('user-id');
                            loadUserHierarchy(userId);
                        });
                    },
                    error: function() {
                        $('#user-chart-container').html('<div class="alert alert-danger">Error loading user hierarchy.</div>');
                    }
                });
            }
            
            // Initialize with default office
            initOrganogram($('#root-office').val(), $('#chart-depth').val());
            
            // Handle office change
            $('#root-office').on('change', function() {
                initOrganogram($(this).val(), $('#chart-depth').val());
            });
            
            // Handle depth change
            $('#chart-depth').on('change', function() {
                initOrganogram($('#root-office').val(), $(this).val());
            });
            
            // Handle user search
            $('#search-btn').on('click', function() {
                const query = $('#user-search').val();
                if (query.trim().length < 2) {
                    alert('Please enter at least 2 characters');
                    return;
                }
                
                $.ajax({
                    url: "{{ route('admin.apps.hr.users.api') }}",
                    type: "GET",
                    data: { q: query },
                    success: function(response) {
                        if (response.results.length > 0) {
                            const user = response.results[0];
                            loadUserHierarchy(user.id);
                        } else {
                            alert('No users found matching your search');
                        }
                    }
                });
            });
            
            // Handle search on enter press
            $('#user-search').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#search-btn').click();
                }
            });
            
            // Export chart functionality
            $('#btn-export-chart').on('click', function() {
                html2canvas($('#chart-container .orgchart'), {
                    onrendered: function(canvas) {
                        const imgData = canvas.toDataURL('image/png');
                        const link = document.createElement('a');
                        link.download = 'organogram.png';
                        link.href = imgData;
                        link.click();
                    }
                });
            });
            
            // Print chart functionality
            $('#btn-print-chart').on('click', function() {
                window.print();
            });
        });
    </script>
    @endpush
</x-hr-layout>