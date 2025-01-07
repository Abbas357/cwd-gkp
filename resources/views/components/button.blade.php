<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => 'cw-btn']) }}>
    <svg class="loader" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
    </svg>
    <span>&nbsp;{{ $text }}&nbsp;</span>
</button>