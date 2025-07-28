<x-error-layout 
    title="Server Error"
    subtitle="We're on it!"
    error-code="500"
    error-gradient="linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 100%)"
    particle-gradient="linear-gradient(45deg, #ff6b6b, #4ecdc4)"
    button-gradient="linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 100%)"
    button-shadow="rgba(255, 107, 107, 0.3)"
    description="Don't worry, we're already on it! Our team has been notified and is working to fix this issue as quickly as possible."
>
    <x-slot name="icon">
        
        <div class="server-icon">
            <div class="server"></div>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <a href="{{ url('/') }}" class="btn btn-primary">Go to Homepage</a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Go Back</a>
    </x-slot>

    <x-slot name="additionalContent">
        
        <div class="contact-info">
            <p>Need immediate assistance?</p>
            <p>
                Email us at <a href="mailto:abbaskhan357@gmail.com">abbaskhan357@gmail.com</a> or 
                call or WhatsApp <a href="tel:+923130535333">0313-0535333</a>
            </p>
        </div>
    </x-slot>

    <x-slot name="bottomInfo">
        
        @if(app()->bound('sentry') && app('sentry')->getLastEventId())
            <div class="request-info">
                Error ID: {{ app('sentry')->getLastEventId() }}
            </div>
        @elseif(isset($exception) && method_exists($exception, 'getMessage'))
            <div class="request-info">
                @if(config('app.debug'))
                    Debug: {{ Str::limit($exception->getMessage(), 50) }}
                @else
                    Error ID: {{ substr(md5(time() . rand()), 0, 8) }}
                @endif
            </div>
        @endif
    </x-slot>

    <x-slot name="customScripts">
        
        @if(config('app.env') === 'production')
            setTimeout(function() {
                window.location.reload();
            }, 30000);
        @endif
    </x-slot>
</x-error-layout>