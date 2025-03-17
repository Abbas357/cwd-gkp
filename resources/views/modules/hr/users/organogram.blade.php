<x-hr-layout>
    @push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/orgchart/3.1.1/css/jquery.orgchart.min.css" rel="stylesheet">
    <style>
        #chart-container {
            height: 600px;
            overflow: auto;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            position: relative;
            text-align: center;
        }
        #chart-container .symbol {
            display: none;
        }

        .orgchart {
            background-image: none !important;
            margin: 0 auto !important; /* Center the chart horizontally */
            transform-origin: top center !important; /* Ensure scaling happens from center */
            display: flex !important; /* Allow centering */
            align-items: center;
            justify-content: center;
        }

        .orgchart .node {
            width: 180px;
            transition: all 0.3s;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            border-radius: 4px;
            overflow: hidden;
        }

        .orgchart .node .title {
            width: 170px;
            height: auto;
            line-height: 20px;
            padding: 5px;
            font-size: 0.85rem;
            font-weight: bold;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .orgchart .node .content {
            width: 170px;
            height: auto;
            padding: 3px;
            font-size: 0.8rem;
            border: 3px solid #2ecc71;
        }

        .orgchart .hierarchy::before {
            border-top: 3px solid #000000;
        }

        .orgchart .hierarchy {
            cursor: move;
        }

        .orgchart .nodes.vertical::before {
            background-color: #000000;
            height: 20px;
            width: 2px;
            top: 2px;
        }

        .orgchart .nodes.vertical .hierarchy::after, .orgchart .nodes.vertical .hierarchy::before {
            border-color: #000000;
        }

        .orgchart .nodes.vertical>.hierarchy:first-child::before {
            border-color: #000000;
            border-width: 2px 0 0 2px;
        }

        .orgchart .node .office-name {
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .orgchart .node .office-type {
            font-size: 0.75rem;
            color: #666;
        }

        .orgchart .node .user-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin: 3px auto;
            border: 2px solid #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .orgchart .node .user-name {
            font-weight: bold;
            margin: 2px 0;
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .orgchart .node .user-title {
            font-size: 0.75rem;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .orgchart .node .vacant-post {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80px;
        }
        
        .orgchart .node .vacancy-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #f5f5f5;
            border: 2px dashed #ccc;
            margin: 3px auto;
        }
        
        .orgchart .node .vacancy-text {
            font-weight: bold;
            color: #d35400;
            font-style: italic;
        }

        .orgchart .lines:before,
        .orgchart .lines:after,
        .orgchart .downLine,
        .orgchart .rightLine,
        .orgchart .leftLine {
            border-color: #000 !important; /* Ensure all line parts are black */
        }
        
        /* Smoother lines with better rendering */
        .orgchart .lines .downLine {
            background-color: #000;
            height: 20px !important;
            width: 2px !important; /* Slightly thicker for better visibility */
        }

        .orgchart .lines .rightLine,
        .orgchart .lines .leftLine {
            border-top: 2px solid #000 !important; /* Solid black lines */
        }

        /* Improve spacing between siblings */
        .orgchart .nodes.horizontal {
            margin-left: 25px !important;
            margin-right: 25px !important;
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

        .orgchart .node.type-secretariat .title {
            border: 3px solid #ffcc00;
        }

        .orgchart .node.type-secretariat .content {
            border: 3px solid #ffcc00;
        }

        .orgchart .node.type-provincial .title,
        .orgchart .node.type-regional .title,
        .orgchart .node.type-divisional .title,
        .orgchart .node.type-district .title {
            border-left: 4px solid #2980b9;
        }

        /* Make selected node stand out */
        .orgchart .node.focused {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            transform: scale(1.05);
            z-index: 100;
        }

        /* Control buttons for the chart */
        #chart-controls {
            position: absolute;
            bottom: 10px;
            right: 10px;
            z-index: 100;
            background: rgba(255, 255, 255, 0.9);
            padding: 8px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        #chart-controls button {
            margin: 0 2px;
        }

        .user-info-popup {
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 250px;
            display: none;
        }
        
        .office-type-filter {
            margin-bottom: 15px;
        }
        
        .office-type-filter .btn-check:checked + .btn-outline-primary {
            background-color: #0d6efd;
            color: white;
        }
        
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
            
            .orgchart {
                transform: scale(1) !important;
                width: 100% !important;
            }
            
            #chart-controls {
                display: none;
            }
        }
    </style>
    @endpush

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
                    <div class="filter-controls mb-3">
                        <!-- Add Office Type Filter Buttons -->
                        <div class="office-type-filter mb-3">
                            <div class="btn-group" role="group" aria-label="Office Type">
                                <input type="radio" class="btn-check" name="office-type" id="both-type" value="both" checked>
                                <label class="btn btn-outline-primary" for="both-type">Both</label>
                                
                                <input type="radio" class="btn-check" name="office-type" id="secretariat-type" value="secretariat">
                                <label class="btn btn-outline-primary" for="secretariat-type">Secretariat</label>
                                
                                <input type="radio" class="btn-check" name="office-type" id="field-type" value="field">
                                <label class="btn btn-outline-primary" for="field-type">Field Formations</label>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="root-office" class="form-label">Office</label>
                                    <select id="root-office" class="form-select">
                                        @foreach($topOffices as $office)
                                        <option value="{{ $office->id }}">{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="chart-depth" class="form-label">Chart Depth</label>
                                    <select id="chart-depth" class="form-select">
                                        <option value="1">1 Level</option>
                                        <option value="2" selected>2 Levels</option>
                                        <option value="3">3 Levels</option>
                                        <option value="0">All Levels</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user-search" class="form-label">Search User</label>
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
                        <div class="chart-loading position-absolute top-50 start-50 translate-middle text-center">
                            <div class="spinner-border text-primary"></div>
                            <p class="mt-3">Loading organization chart...</p>
                        </div>

                        <div id="chart-controls">
                            <button id="zoom-in" class="btn btn-sm btn-light" title="Zoom In"><i class="bi bi-plus-lg"></i></button>
                            <button id="zoom-out" class="btn btn-sm btn-light" title="Zoom Out"><i class="bi bi-dash-lg"></i></button>
                            <button id="zoom-reset" class="btn btn-sm btn-light" title="Reset Zoom"><i class="bi bi-arrow-repeat"></i></button>
                            <button id="center-chart" class="btn btn-sm btn-light" title="Center Chart"><i class="bi bi-arrows-move"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/3.1.1/js/jquery.orgchart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        $(document).ready(function() {
            let orgChart = null;
            let zoomLevel = 1;
            const zoomStep = 0.03;
            let currentOfficeType = 'both'; 

            function initOrganogram(officeId, depth, officeType) {
                $('.chart-loading').show();
                $('#chart-container').css('min-height', '300px');

                if (orgChart) {
                    $('#chart-container').find('.orgchart').remove();
                }

                $.ajax({
                    url: "{{ route('admin.apps.hr.organogram.data') }}",
                    type: "GET",
                    data: {
                        office_id: officeId,
                        depth: depth,
                        office_type: officeType
                    },
                    success: function(data) {
                        orgChart = $('#chart-container').orgchart({
                            'data': data,
                            'nodeContent': 'content',
                            'nodeID': 'id',
                            'createNode': function($node, data) {
                                if (data.className) {
                                    $node.addClass(data.className);
                                }

                                let nodeContent = '';

                                if (data.head) {
                                    nodeContent += `<div class="user-container" data-user-id="${data.head.id}">`;
                                    nodeContent += `<img class="user-image" src="${data.head.image}" alt="${data.head.name}">`;
                                    nodeContent += `<div class="user-name">${data.head.name}</div>`;
                                    nodeContent += `</div>`;
                                } else {
                                    nodeContent += `<div class="user-container vacant-post">`;
                                    nodeContent += `<div class="vacancy-placeholder"></div>`;
                                    nodeContent += `<div class="user-name vacancy-text">Post Vacant</div>`;
                                    nodeContent += `</div>`;
                                }

                                $node.find('.content').html(nodeContent);

                                // Add data attributes for interaction
                                $node.attr('data-office-id', data.office_id);
                                $node.attr('data-office-type', data.office_type || 'unknown');
                                if (data.head) {
                                    $node.attr('data-user-id', data.head.id);
                                }

                                return $node;
                            },
                            'direction': 't2b', // TOP TO BOTTOM direction
                            'verticalLevel': 3,
                            'pan': true,
                            'zoom': true,
                            'toggleSiblingsResp': true
                        });

                        // After chart is created, center it within the container
                        centerOrgChart();

                        // Setup node click handlers
                        $('#chart-container').on('click', '.node', function() {
                            // Clear any previous focus
                            $('.orgchart .node').removeClass('focused');

                            // Add focused class to this node
                            $(this).addClass('focused');
                        });

                        $('.chart-loading').hide();
                    },
                    error: function() {
                        $('#chart-container').html('<div class="alert alert-danger">Error loading organization chart.</div>');
                        $('.chart-loading').hide();
                    }
                });
            }

            function centerOrgChart() {
                const $chart = $('#chart-container .orgchart');
                const $container = $('#chart-container');

                if (!$chart.length) return;

                $chart.css({
                    'transform': 'scale(1)',
                    'transform-origin': 'top center',
                    'margin': '20px auto',
                    'left': '0',
                    'right': '0',
                    'position': 'relative'
                });
            }

            function zoomOrgChart(newZoom) {
                const $chart = $('#chart-container .orgchart');
                if (!$chart.length) return;

                zoomLevel = newZoom;
                $chart.css({
                    'transform': `scale(${zoomLevel})`,
                    'transform-origin': 'top center'
                });
            }

            initOrganogram($('#root-office').val(), $('#chart-depth').val(), currentOfficeType);

            $('input[name="office-type"]').on('change', function() {
                currentOfficeType = $(this).val();
                initOrganogram($('#root-office').val(), $('#chart-depth').val(), currentOfficeType);
            });

            $('#root-office').on('change', function() {
                initOrganogram($(this).val(), $('#chart-depth').val(), currentOfficeType);
            });

            $('#chart-depth').on('change', function() {
                initOrganogram($('#root-office').val(), $(this).val(), currentOfficeType);
            });

            $('#search-btn').on('click', function() {
                const query = $('#user-search').val();
                if (query.trim().length < 2) {
                    alert('Please enter at least 2 characters');
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.apps.hr.users.api') }}",
                    type: "GET",
                    data: {
                        q: query
                    },
                    success: function(response) {
                        if (response.results.length > 0) {
                            const user = response.results[0];
                            const userNode = $(`.node[data-user-id="${user.id}"]`);

                            if (userNode.length) {
                                $('.orgchart .node').removeClass('focused');

                                userNode.addClass('focused');

                                $('#chart-container').animate({
                                    scrollTop: userNode.offset().top - $('#chart-container').offset().top + $('#chart-container').scrollTop() - 100
                                }, 500);
                            } else {
                                alert('User found but not visible in current chart view');
                            }
                        } else {
                            alert('No users found matching your search');
                        }
                    }
                });
            });

            $('#user-search').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#search-btn').click();
                }
            });

            $('#zoom-in').on('click', function() {
                zoomOrgChart(zoomLevel + zoomStep);
            });

            $('#zoom-out').on('click', function() {
                zoomOrgChart(Math.max(0.3, zoomLevel - zoomStep));
            });

            $('#zoom-reset').on('click', function() {
                zoomOrgChart(1);
                centerOrgChart();
            });

            $('#center-chart').on('click', function() {
                centerOrgChart();
            });

            $('#btn-export-chart').on('click', function() {
                const $exportBtn = $(this);
                $exportBtn.html('<i class="spinner-border spinner-border-sm"></i> Exporting...');
                $exportBtn.attr('disabled', true);
                
                setTimeout(function() {
                    const chartElem = document.querySelector('#chart-container');
                    
                    html2canvas(chartElem, {
                        scale: 2,
                        backgroundColor: '#f8f9fa',
                        logging: false,
                        useCORS: true,
                        allowTaint: true
                    }).then(function(canvas) {
                        const imgData = canvas.toDataURL('image/png', 1.0);
                        const link = document.createElement('a');
                        link.download = 'organogram_' + new Date().toISOString().split('T')[0] + '.png';
                        link.href = imgData;
                        link.click();
                        
                        $exportBtn.html('<i class="bi bi-download"></i> Export PNG');
                        $exportBtn.attr('disabled', false);
                    }).catch(function(error) {
                        $exportBtn.html('<i class="bi bi-download"></i> Export PNG');
                        $exportBtn.attr('disabled', false);
                    });
                }, 300);
            });

            $('#btn-print-chart').on('click', function() {
                const $chart = $('#chart-container .orgchart');
                const originalTransform = $chart.css('transform');
                const originalWidth = $chart.css('width');
                
                $chart.css({
                    'transform': 'scale(.5)',
                    'width': '100%'
                });
                
                window.print();

                setTimeout(function() {
                    $chart.css({
                        'transform': originalTransform,
                        'width': originalWidth
                    });
                }, 500);
            });

            // Handle window resize
            let resizeTimer;
            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (orgChart) {
                        centerOrgChart();
                    }
                }, 250);
            });
        });
    </script>
    @endpush
</x-hr-layout>