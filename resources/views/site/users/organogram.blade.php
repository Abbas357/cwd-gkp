<x-main-layout>
    @push('style')
        <link href="{{ asset('site/lib/orgchart/jquery.orgchart.min.css') }}" rel="stylesheet">
        <style>
            #chart-container {
                height: auto;
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
                margin: 0 auto !important;
                /* Center the chart horizontally */
                transform-origin: top center !important;
                /* Ensure scaling happens from center */
                display: flex !important;
                /* Allow centering */
                align-items: center;
                justify-content: center;
            }

            .orgchart .node {
                width: 180px;
                transition: all 0.3s;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
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

            .orgchart .nodes.vertical .hierarchy::after,
            .orgchart .nodes.vertical .hierarchy::before {
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
                border-color: #000 !important;
                /* Ensure all line parts are black */
            }

            /* Smoother lines with better rendering */
            .orgchart .lines .downLine {
                background-color: #000;
                height: 20px !important;
                width: 2px !important;
                /* Slightly thicker for better visibility */
            }

            .orgchart .lines .rightLine,
            .orgchart .lines .leftLine {
                border-top: 2px solid #000 !important;
                /* Solid black lines */
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

            /* Beautiful tab styling */
            .office-type-tabs {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 20px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .office-type-tabs .nav-pills {
                background: rgba(255, 255, 255, 0.1);
                padding: 5px;
                border-radius: 8px;
                backdrop-filter: blur(10px);
            }

            .office-type-tabs .nav-link {
                color: #fff;
                font-weight: 500;
                padding: 10px 25px;
                border-radius: 6px;
                transition: all 0.3s ease;
                margin: 0 5px;
                background: transparent;
                border: 2px solid transparent;
            }

            .office-type-tabs .nav-link:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-2px);
            }

            .office-type-tabs .nav-link.active {
                background: white;
                color: #667eea;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                border: 2px solid white;
            }

            .office-type-tabs .nav-link i {
                margin-right: 8px;
                font-size: 1.1rem;
            }

            /* Better filter controls */
            .filter-controls {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 20px;
            }

            .form-label {
                font-weight: 600;
                color: #495057;
                margin-bottom: 8px;
            }

            .form-select {
                border: 2px solid #e0e0e0;
                border-radius: 8px;
                padding: 10px 15px;
                transition: all 0.3s;
            }

            .form-select:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            }

            @media print {
                body * {
                    visibility: hidden;
                }

                #chart-container,
                #chart-container * {
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
    <x-slot name="breadcrumbTitle">
        Organogram of C&W Department
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Team</li>
    </x-slot>
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div></div>
                    <div>
                        <button id="btn-export-chart" class="cw-btn bg-primary">
                            <i class="bi bi-download"></i> Export PNG
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="office-type-tabs">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="both-tab" data-bs-toggle="pill" 
                                    data-office-type="both" type="button" role="tab">
                                    <i class="bi bi-building"></i> Both
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="secretariat-tab" data-bs-toggle="pill" 
                                    data-office-type="secretariat" type="button" role="tab">
                                    <i class="bi bi-briefcase"></i> Secretariat
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="field-tab" data-bs-toggle="pill" 
                                    data-office-type="field" type="button" role="tab">
                                    <i class="bi bi-geo-alt"></i> Field Formations
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="filter-controls">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="root-office" class="form-label">
                                        <i class="bi bi-building-fill"></i> Select Office
                                    </label>
                                    <select id="root-office" class="form-select">
                                        @foreach ($topOffices as $office)
                                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chart-depth" class="form-label">
                                        <i class="bi bi-diagram-3"></i> Chart Depth
                                    </label>
                                    <select id="chart-depth" class="form-select">
                                        <option value="1">1 Level</option>
                                        <option value="2">2 Levels</option>
                                        <option value="3">3 Levels</option>
                                        <option value="0">All Levels</option>
                                    </select>
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
                            <button id="zoom-in" class="btn btn-sm btn-light" title="Zoom In"><i
                                    class="bi bi-plus-lg"></i></button>
                            <button id="zoom-out" class="btn btn-sm btn-light" title="Zoom Out"><i
                                    class="bi bi-dash-lg"></i></button>
                            <button id="zoom-reset" class="btn btn-sm btn-light" title="Reset Zoom"><i
                                    class="bi bi-arrow-repeat"></i></button>
                            <button id="center-chart" class="btn btn-sm btn-light" title="Center Chart"><i
                                    class="bi bi-arrows-move"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('site/lib/orgchart/jquery.orgchart.min.js') }}"></script>
        <script src="{{ asset('site/lib/html2canvas/html2canvas.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                let orgChart = null;
                let zoomLevel = 1;
                const zoomStep = 0.03;
                let currentOfficeType = 'both';
                let allOffices = @json($topOffices);

                function filterOfficeOptions(officeType) {
                    const $select = $('#root-office');
                    const currentValue = $select.val();
                    $select.empty();

                    let filteredOffices = allOffices;
                    
                    if (officeType === 'secretariat') {
                        filteredOffices = allOffices.filter(office => 
                            office.type && office.type.toLowerCase() === 'secretariat'
                        );
                    } else if (officeType === 'field') {
                        filteredOffices = allOffices.filter(office => 
                            office.type && office.type.toLowerCase() !== 'secretariat'
                        );
                    }

                    if (filteredOffices.length === 0) {
                        filteredOffices = allOffices;
                    }

                    filteredOffices.forEach(office => {
                        $select.append(`<option value="${office.id}">
                            ${office.name}
                        </option>`);
                    });

                    // Try to maintain the previous selection if it exists in the filtered list
                    if ($select.find(`option[value="${currentValue}"]`).length > 0) {
                        $select.val(currentValue);
                    } else {
                        $select.val($select.find('option:first').val());
                    }
                }

                function setDefaultDepth(officeType) {
                    const $depthSelect = $('#chart-depth');

                    if (officeType === 'secretariat') {
                        $depthSelect.val('0');
                    } else if (officeType === 'field') {
                        $depthSelect.val('1');
                    } else {
                        $depthSelect.val('0');
                    }
                }

                function initOrganogram(officeId, depth, officeType) {
                    $('.chart-loading').show();
                    $('#chart-container').css('min-height', '300px');

                    if (orgChart) {
                        $('#chart-container').find('.orgchart').remove();
                    }

                    $.ajax({
                        url: "{{ route('organogram.data') }}",
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
                                        nodeContent +=
                                            `<div class="user-container" data-user-id="${data.head.id}">`;
                                        nodeContent +=
                                            `<img class="user-image" src="${data.head.image}" alt="${data.head.name}">`;
                                        nodeContent +=
                                            `<div class="user-name">${data.head.name}</div>`;
                                        nodeContent += `</div>`;
                                    } else {
                                        nodeContent +=
                                            `<div class="user-container vacant-post">`;
                                        nodeContent +=
                                            `<div class="vacancy-placeholder"></div>`;
                                        nodeContent +=
                                            `<div class="user-name vacancy-text">Post Vacant</div>`;
                                        nodeContent += `</div>`;
                                    }

                                    $node.find('.content').html(nodeContent);

                                    // Add data attributes for interaction
                                    $node.attr('data-office-id', data.office_id);
                                    $node.attr('data-office-type', data.office_type ||
                                        'unknown');
                                    if (data.head) {
                                        $node.attr('data-user-id', data.head.id);
                                    }

                                    return $node;
                                },
                                'direction': 't2b',
                                'verticalLevel': 3,
                                'pan': true,
                                'zoom': true,
                                'toggleSiblingsResp': true
                            });

                            centerOrgChart();

                            $('#chart-container').on('click', '.node', function() {
                                $('.orgchart .node').removeClass('focused');
                                $(this).addClass('focused');
                            });

                            $('.chart-loading').hide();
                        },
                        error: function() {
                            $('#chart-container').html(
                                '<div class="alert alert-danger">Error loading organization chart.</div>'
                            );
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

                filterOfficeOptions(currentOfficeType);
                setDefaultDepth(currentOfficeType);
                initOrganogram($('#root-office').val(), $('#chart-depth').val(), currentOfficeType);

                // Tab click handler
                $('.nav-link[data-office-type]').on('click', function() {
                    $('.nav-link').removeClass('active');
                    $(this).addClass('active');
                    
                    currentOfficeType = $(this).data('office-type');
                    filterOfficeOptions(currentOfficeType);
                    setDefaultDepth(currentOfficeType);
                    initOrganogram($('#root-office').val(), $('#chart-depth').val(), currentOfficeType);
                });

                $('#root-office').on('change', function() {
                    initOrganogram($(this).val(), $('#chart-depth').val(), currentOfficeType);
                });

                $('#chart-depth').on('change', function() {
                    initOrganogram($('#root-office').val(), $(this).val(), currentOfficeType);
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
                            link.download = 'organogram_' + new Date().toISOString().split('T')[
                                0] + '.png';
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
</x-main-layout>