<style>
    .remarks-timeline-container {
        max-height: 600px;
        overflow-y: auto;
    }

    .remarks-timeline-container::-webkit-scrollbar {
        width: 6px;
    }

    .remarks-timeline-container::-webkit-scrollbar-track {
        background:
            border-radius: 3px;
    }

    .remarks-timeline-container::-webkit-scrollbar-thumb {
        background:
            border-radius: 3px;
    }

    .remarks-timeline-container::-webkit-scrollbar-thumb:hover {
        background:
    }

    .timeline-item:hover .card {
        transform: translateY(-2px);
        transition: transform 0.2s ease-in-out;
    }

    .timeline-marker {
        z-index: 2;
    }
</style>
@php
    $parsedRemarks = [];
    if (!empty($remarks)) {
        $lines = explode("\n", $remarks);
        foreach ($lines as $line) {
            $line = trim($line);
            if (preg_match('/^(\d+)\.\s*(.+)/', $line, $matches)) {
                $number = $matches[1];
                $content = $matches[2];

                if (
                    preg_match(
                        '/^(.+?)\s*Remarks:\s*<strong>(.+?)<\/strong>\s*-\s*<span[^>]*>(.+?)<\/span>/',
                        $content,
                        $remarkMatches,
                    )
                ) {
                    $parsedRemarks[] = [
                        'number' => $number,
                        'type' => trim($remarkMatches[1]),
                        'message' => trim($remarkMatches[2]),
                        'metadata' => trim($remarkMatches[3]),
                        'raw_content' => $content,
                    ];
                } else {
                    $parsedRemarks[] = [
                        'number' => $number,
                        'type' => 'General',
                        'message' => $content,
                        'metadata' => '',
                        'raw_content' => $content,
                    ];
                }
            }
        }
    }

    $typeColors = [
        'Verification' => [
            'bg' => 'bg-success-subtle',
            'border' => 'border-success',
            'text' => 'text-success',
            'dot' => 'bg-success',
        ],
        'Rejection' => [
            'bg' => 'bg-danger-subtle',
            'border' => 'border-danger',
            'text' => 'text-danger',
            'dot' => 'bg-danger',
        ],
        'Restoration' => [
            'bg' => 'bg-primary-subtle',
            'border' => 'border-primary',
            'text' => 'text-primary',
            'dot' => 'bg-primary',
        ],
        'Printing' => [
            'bg' => 'bg-secondary-subtle',
            'border' => 'border-secondary',
            'text' => 'text-secondary',
            'dot' => 'bg-secondary',
        ],
        'Renewal' => [
            'bg' => 'bg-warning-subtle',
            'border' => 'border-warning',
            'text' => 'text-warning',
            'dot' => 'bg-warning',
        ],
        'Status Update' => [
            'bg' => 'bg-info-subtle',
            'border' => 'border-info',
            'text' => 'text-info',
            'dot' => 'bg-info',
        ],
        'Duplication' => [
            'bg' => 'bg-dark-subtle',
            'border' => 'border-dark',
            'text' => 'text-dark',
            'dot' => 'bg-dark',
        ],
        'Creation' => [
            'bg' => 'bg-success-subtle',
            'border' => 'border-success',
            'text' => 'text-success',
            'dot' => 'bg-success',
        ],
        'General' => [
            'bg' => 'bg-light',
            'border' => 'border-secondary',
            'text' => 'text-muted',
            'dot' => 'bg-secondary',
        ],
    ];

    function getRemarkIcon($type)
    {
        $icons = [
            'Verification' => 'bi-check-circle-fill',
            'Rejection' => 'bi-x-circle-fill',
            'Restoration' => 'bi-arrow-clockwise',
            'Printing' => 'bi-printer-fill',
            'Renewal' => 'bi-arrow-repeat',
            'Status Update' => 'bi-info-circle-fill',
            'Duplication' => 'bi-files',
            'Creation' => 'bi-plus-circle-fill',
            'General' => 'bi-chat-text-fill',
        ];
        return $icons[$type] ?? $icons['General'];
    }
@endphp

<div class="remarks-timeline-container">
    @if (empty($parsedRemarks))
        <div class="d-flex align-items-center justify-content-center py-5">
            <div class="text-center">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                    style="width: 64px; height: 64px;">
                    <i class="bi bi-journal-text fs-1 text-muted"></i>
                </div>
                <p class="text-muted small">No remarks available</p>
            </div>
        </div>
    @else
        <div class="timeline">
            @foreach ($parsedRemarks as $index => $remark)
                @php
                    $colors = $typeColors[$remark['type']] ?? $typeColors['General'];
                    $isLast = $index === count($parsedRemarks) - 1;
                @endphp

                <div class="timeline-item mb-4 position-relative">
                    @if (!$isLast)
                        <div class="timeline-line position-absolute bg-secondary opacity-25"
                            style="left: 23px; top: 48px; width: 2px; bottom: -16px;"></div>
                    @endif

                    <div class="d-flex align-items-start">
                        <div class="timeline-marker position-relative flex-shrink-0 me-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm border border-2 border-white {{ $colors['dot'] }}"
                                style="width: 48px; height: 48px;">
                                <i class="{{ getRemarkIcon($remark['type']) }} text-white"></i>
                            </div>
                            <div class="position-absolute bg-white border {{ $colors['border'] }} rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 24px; height: 24px; top: -8px; right: -8px;">
                                <span class="small fw-bold {{ $colors['text'] }}">{{ $remark['number'] }}</span>
                            </div>
                        </div>

                        <div class="flex-fill">
                            <div
                                class="card border-start border-4 {{ $colors['border'] }} {{ $colors['bg'] }} shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span
                                            class="badge {{ $colors['bg'] }} {{ $colors['text'] }} border {{ $colors['border'] }}">
                                            <i class="{{ getRemarkIcon($remark['type']) }} me-1"></i>
                                            {{ $remark['type'] }}
                                        </span>
                                    </div>

                                    <div class="mb-2">
                                        <p class="mb-0 fw-medium text-dark">{{ $remark['message'] }}</p>
                                    </div>

                                    @if (!empty($remark['metadata']))
                                        <div
                                            class="d-flex align-items-center small text-muted bg-white bg-opacity-75 rounded px-2 py-1">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $remark['metadata'] }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>