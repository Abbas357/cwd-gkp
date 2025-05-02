@php
    $level = strtolower($level);
    $levelClass = 'log-' . $level;
    
    $levelIcons = [
        'emergency' => 'bi-exclamation-octagon-fill',
        'alert' => 'bi-exclamation-triangle-fill',
        'critical' => 'bi-exclamation-diamond-fill',
        'error' => 'bi-x-circle-fill',
        'warning' => 'bi-exclamation-circle',
        'notice' => 'bi-info-circle',
        'info' => 'bi-info-square',
        'debug' => 'bi-bug'
    ];
    
    $icon = $levelIcons[$level] ?? 'bi-info-circle';
@endphp

<span class="log-badge {{ $levelClass }}">
    <i class="bi {{ $icon }} me-1"></i>
    {{ strtoupper($level) }}
</span>