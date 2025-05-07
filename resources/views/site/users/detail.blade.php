<x-main-layout title="Details">
    @push('style')
    <style>
        .modal-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .info-row {
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            width: 150px;
            display: inline-block;
        }

        .info-value {
            display: inline-block;
        }

        .document-link {
            color: #0d6efd;
            text-decoration: none;
        }

        .document-link:hover {
            text-decoration: underline;
        }

        a i:hover {
            filter: contrast(130%) brightness(130%) drop-shadow(7px 7px 3px #ccc)
        }
        .card-container {
            perspective: 1000px;
            height: 100%;
        }
        
        .card-flip {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            min-height: 320px;
        }
        
        .card-container:hover .card-flip {
            transform: rotateY(180deg) scale(1.05);
        }
        
        .front, .back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }
        
        .front {
            z-index: 2;
        }
        
        .back {
            transform: rotateY(180deg);
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        .back-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.15; 
            transform: scaleX(-1);
            filter: blur(1px);
        }
        
        .back-content {
            position: relative;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.5);
        }

        #user-chart-container {
            height: 400px;
            overflow: auto;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            position: relative;
            text-align: center;
        }

        #user-chart-container .symbol {
            display: none;
        }

        #user-chart-container .orgchart {
            background-image: none !important;
            margin: 0 auto !important;
            transform-origin: top center !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        #user-chart-container .orgchart .node {
            width: 180px;
            transition: all 0.3s;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            border-radius: 4px;
            overflow: hidden;
        }

        #user-chart-container .orgchart .node .title {
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

        #user-chart-container .orgchart .node .content {
            width: 170px;
            height: auto;
            padding: 3px;
            font-size: 0.8rem;
            border: 2px solid #3498db;
        }

        #user-chart-container .orgchart .node .user-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin: 3px auto;
            border: 2px solid #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        #user-chart-container .orgchart .node .user-name {
            font-weight: bold;
            margin: 2px 0;
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #user-chart-container .orgchart .node .user-title {
            font-size: 0.75rem;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #user-chart-container .orgchart .node.selected-user .title {
            background-color: #e74c3c; /* Highlight the selected user */
        }

        #user-chart-container .orgchart .node.selected-user .content {
            border: 2px solid #e74c3c;
        }

        #user-chart-container .orgchart .lines:before,
        #user-chart-container .orgchart .lines:after,
        #user-chart-container .orgchart .downLine,
        #user-chart-container .orgchart .rightLine,
        #user-chart-container .orgchart .leftLine {
            border-color: #000 !important;
        }

        #user-chart-container .orgchart .lines .downLine {
            background-color: #000;
            height: 20px !important;
            width: 2px !important;
        }

        #user-chart-container .orgchart .lines .rightLine,
        #user-chart-container .orgchart .lines .leftLine {
            border-top: 2px solid #000 !important;
        }

        #user-chart-container .vacancy-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #f5f5f5;
            border: 2px dashed #ccc;
            margin: 3px auto;
        }

        #user-chart-container .vacancy-text {
            font-weight: bold;
            color: #d35400;
            font-style: italic;
        }
    </style>

    <x-slot name="breadcrumbTitle">
    Detail of {{ $user['name'] }}
    {{ (
        $office = trim($user['office'] ?? '')
    ) && $office !== '-' 
        ? ' (' . $office . ')' 
        : ''
    }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('team') }}">Team</a></li>
    </x-slot>
    
    @endpush
    <div class="container mt-3">
        <p style="text-align: right"><strong>Views:</strong> {{ $user['views_count'] }}</p>
        <div class="row">
            <div class="text-center">
                <img src="{{ $user['media']['profile_pictures'] }}" class="modal-img" alt="{{ $user['name'] }}">
                <h4 class="mt-2">{{ $user['name'] }}</h4>
                <p>{{ $user['office'] }}</p>
            </div>
            <div class="text-center">
                <a href="https://facebook.com/{{ $user['facebook'] ?? '#' }}"><i class="bi bi-facebook fs-1 me-2" style="color: #3b5998"></i></a>
                <a href="https://x.com/{{ $user['twitter'] ?? '#' }}"><i class="bi bi-twitter fs-1 me-2" style="color: #1da1f2"></i></a>
                <a href="https://wa.me/{{ $user['whatsapp'] ?? '#' }}"><i class="bi bi-whatsapp fs-1 me-2" style="color: #25d366"></i> </a>
            </div>
            <hr>
            <div class="row">
                <h1 class="fs-3 py-2 bg-light">Basic Information</h1>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label">Designation:</span>
                        <span class="info-value">{{ $user['designation'] }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $user['email'] }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Mobile Number:</span>
                        <span class="info-value">{{ $user['mobile_number'] }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Office Number:</span>
                        <span class="info-value">{{ $user['contact_number'] }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    @if($user['status'] == 'Active')
                    <div class="info-row">
                        <span class="info-label">Posting Type:</span>
                        <span class="info-value">{{ $user['posting_type'] }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Posting Date:</span>
                        <span class="info-value">{{ $user['posting_date'] }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Posting Order:</span>
                        <span class="info-value">
                            @if($user['media']['posting_orders'])
                            <a href="{{ $user['media']['posting_orders'] }}" target="_blank" class="document-link">View Posting Order</a>
                            @else
                            N/A
                            @endif
                        </span>
                    </div>
                    @else
                    <div class="info-row">
                        <span class="info-label">Relinquish Date:</span>
                        <span class="info-value">{{ $user['exit_date'] }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Relinquish Order:</span>
                        <span class="info-value">
                            @if($user['media']['exit_orders'])
                            <a href="{{ $user['media']['exit_orders'] }}" target="_blank" class="document-link">View Exit Order</a>
                            @else
                            N/A
                            @endif
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($user['job_description'])
        <div class="row mt-3">
            <h1 class="fs-3 py-2 bg-light">Job Description</h1>
            {!! $user['job_description'] !!}
        </div>
        @endif

        @auth()
        <div class="row mt-3">
            <h1 class="fs-3 py-2 bg-light">Posting History</h1>
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Office</th>
                                <th>Designation</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Duration</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user['history'] as $posting)
                                <tr>
                                    <td>{{ $posting->office?->name ?? 'N/A' }}</td>
                                    <td>{{ $posting->designation?->name ?? 'N/A' }}</td>
                                    <td>{{ $posting->start_date?->format('d M Y') ?? 'N/A' }}</td>
                                    <td>{{ $posting->end_date?->format('d M Y') ?? 'Ongoing' }}</td>
                                    <td>
                                        {{ formatDuration($posting->start_date, $posting->end_date) }}
                                    </td>
                                    <td>
                                        @if($posting->is_current)
                                            <span class="badge bg-success">Current</span>
                                        @else
                                            <span class="badge bg-secondary">Past</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <h1 class="fs-3 py-2 bg-light">Former Postings</h1>
            @foreach ($user['previous'] as $posting)
                <div class="col-sm-12 col-md-4 col-lg-3 mb-3">
                    <div class="card-container">
                        <div class="card-flip">
                            <!-- Front of Card -->
                            <div class="card front user-card shadow-sm rounded border-1 overflow-hidden border">
                                <img src="{{ getProfilePic($posting->user) }}" class="card-img-top img-fluid" style="object-fit: contain;height:230px; border-radius: 50px" alt="{{ $posting?->user?->name ?? 'No Image' }}">
                                <div class="card-body text-center p-2">
                                    <h5 class="card-title text-dark mb-2" style="white-space: nowrap; overflow: hidden; font-size: max(1rem, min(3vw, 0.9rem));">{{ $posting?->user?->name ?? "N/A"  }}</h5>
                                    @isset($posting->user->currentOffice->name)
                                    <h5 class="card-title font-weight-bold text-primary mb-2" style="white-space: nowrap; overflow: hidden; font-size: max(1rem, min(5vw, 1rem));"><span style="color: black">Currently </span> {{ $posting->user->currentOffice->name }}</h5>
                                    @endisset
                                    <div>
                                        <span class="badge text-bg-light" style="white-space: normal; word-wrap: break-word; word-break: break-word;">
                                            <span> {{ $posting->start_date?->format('d M Y') ?? '...' }} <i class="bi-arrow-right fs-6"></i> {{ $posting?->end_date?->format('d M Y') ?? '...' }} </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card back user-card shadow rounded border-1 overflow-hidden border">
                                <div class="back-bg" style="background-image: url('{{ getProfilePic($posting->user) }}');"></div>
                                
                                <div class="card-body d-flex flex-column justify-content-center p-3 back-content">
                                    <h5 class="card-title font-weight-bold text-primary mb-3">User Details</h5>
                                    <p class="mb-2"><strong>Name:</strong> {{ $posting?->user?->name ?? "N/A" }}</p>
                                    @isset($posting->user->currentOffice->name)
                                        <p class="mb-2"><strong>Present Posting:</strong> {{ $posting->user->currentOffice->name }}</p>
                                    @endisset
                                    @isset($posting->user->currentDesignation->name)
                                        <p class="mb-2"><strong>Designation:</strong> {{ $posting->user->currentDesignation->name }}</p>
                                    @endisset
                                    <p class="mb-2"><strong>Posting Date:</strong> {{ $posting?->start_date?->format('d M Y') ?? "..." }}</p>
                                    <p class="mb-2"><strong>Relieving Date:</strong> {{ $posting?->end_date?->format('d M Y') ?? "..." }}</p>
                                    <p class="mb-2"><strong>Duration:</strong> {{ formatDuration($posting->start_date, $posting->end_date) }}</p>
                                    <a class="cw-btn bg-light text-dark mt-auto mx-auto" href="{{ route('positions.details', ['uuid' => $posting->user->uuid ]) }}">
                                        <i class="bi-eye"></i> Full Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endauth
        <div class="row mt-3">
            <h1 class="fs-3 py-2 bg-light">User Organogram</h1>
            <div class="col-12">
                <div id="user-chart-container" class="position-relative" style="height: 600px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 5px;">
                    <div class="chart-loading position-absolute top-50 start-50 translate-middle text-center" id="user-chart-loading">
                        <div class="spinner-border text-primary"></div>
                        <p class="mt-3">Loading user organogram...</p>
                    </div>
        
                    <div id="user-chart-controls" style="position: absolute; bottom: 10px; right: 10px; z-index: 100; background: rgba(255, 255, 255, 0.9); padding: 8px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                        <button id="user-zoom-in" class="btn btn-sm btn-light" title="Zoom In"><i class="bi bi-plus-lg"></i></button>
                        <button id="user-zoom-out" class="btn btn-sm btn-light" title="Zoom Out"><i class="bi bi-dash-lg"></i></button>
                        <button id="user-zoom-reset" class="btn btn-sm btn-light" title="Reset Zoom"><i class="bi bi-arrow-repeat"></i></button>
                        <button id="user-center-chart" class="btn btn-sm btn-light" title="Center Chart"><i class="bi bi-arrows-move"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/3.1.1/js/jquery.orgchart.min.js"></script>
    <script>
    $(document).ready(function() {
        let userOrgChart = null;
        let userZoomLevel = 2;
        const userZoomStep = 0.03;
        
        function loadUserOrganogram() {
            $('#user-chart-loading').show();
            
            const userUuid = '{{ $user["uuid"] }}';
            
            $.ajax({
                url: "{{ route('positions.hierarchy') }}", // You'll need to create this route
                type: "GET",
                data: {
                    user_uuid: userUuid
                },
                success: function(data) {
                    initUserOrganogram(data);
                    $('#user-chart-loading').hide();
                },
                error: function(xhr, status, error) {
                    $('#user-chart-container').html('<div class="alert alert-danger">Error loading user organogram: ' + error + '</div>');
                    $('#user-chart-loading').hide();
                }
            });
        }
        
        function initUserOrganogram(data) {
            $('#user-chart-container').find('.orgchart').remove();
            
            userOrgChart = $('#user-chart-container').orgchart({
                'data': data,
                'nodeContent': 'content',
                'nodeID': 'id',
                'createNode': function($node, data) {
                    if (data.className) {
                        $node.addClass(data.className);
                    }
                    
                    let nodeContent = '';
                    
                    if (data.image) {
                        nodeContent += `<div class="user-container" data-user-id="${data.id}">`;
                        nodeContent += `<img class="user-image" src="${data.image}" alt="${data.name}">`;
                        nodeContent += `<div class="user-name">${data.name}</div>`;
                        nodeContent += `<div class="user-title">${data.title || 'No Designation'}</div>`;
                        nodeContent += `</div>`;
                    } else {
                        nodeContent += `<div class="user-container vacant-post">`;
                        nodeContent += `<div class="vacancy-placeholder"></div>`;
                        nodeContent += `<div class="user-name vacancy-text">Post Vacant</div>`;
                        nodeContent += `</div>`;
                    }
                    
                    $node.find('.content').html(nodeContent);
                    
                    // Add data attributes for interaction
                    if (data.user_id) {
                        $node.attr('data-user-id', data.user_id);
                    }
                    
                    return $node;
                },
                'direction': 't2b', // TOP TO BOTTOM direction
                'verticalLevel': 3,
                'pan': true,
                'zoom': true,
                'toggleSiblingsResp': true
            });
            
            // Center the chart within the container
            centerUserOrgChart();
            
            // Setup node click handlers
            $('#user-chart-container').on('click', '.node', function() {
                const userId = $(this).attr('data-user-id');
                if (userId) {
                    window.location.href = `/user/details/${userId}`;
                }
            });
        }
        
        function centerUserOrgChart() {
            const $chart = $('#user-chart-container .orgchart');
            
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
        
        function zoomUserOrgChart(newZoom) {
            const $chart = $('#user-chart-container .orgchart');
            if (!$chart.length) return;
            
            userZoomLevel = newZoom;
            $chart.css({
                'transform': `scale(${userZoomLevel})`,
                'transform-origin': 'top center'
            });
        }
        
        loadUserOrganogram();
        
        $('#user-zoom-in').on('click', function() {
            zoomUserOrgChart(userZoomLevel + userZoomStep);
        });
        
        $('#user-zoom-out').on('click', function() {
            zoomUserOrgChart(Math.max(0.3, userZoomLevel - userZoomStep));
        });
        
        $('#user-zoom-reset').on('click', function() {
            zoomUserOrgChart(1);
            centerUserOrgChart();
        });
        
        $('#user-center-chart').on('click', function() {
            centerUserOrgChart();
        });
        
        // Handle window resize
        let userResizeTimer;
        $(window).on('resize', function() {
            clearTimeout(userResizeTimer);
            userResizeTimer = setTimeout(function() {
                if (userOrgChart) {
                    centerUserOrgChart();
                }
            }, 250);
        });
    });
    </script>
    @endpush
</x-main-layout>
