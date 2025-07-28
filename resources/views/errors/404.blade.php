<x-error-layout 
    title="Oops! Lost in Space"
    subtitle="Let's Find Your Way"
    error-code="404"
    error-gradient="linear-gradient(135deg, #667eea 0%, #764ba2 100%)"
    particle-gradient="linear-gradient(45deg, #667eea, #764ba2)"
    button-gradient="linear-gradient(135deg, #667eea 0%, #764ba2 100%)"
    button-shadow="rgba(102, 126, 234, 0.3)"
    description="The page you're looking for seems to have drifted into the void. Don't worry, we'll help you navigate back to safety."
>
    <x-slot name="backgroundElements">
        <!-- Stars -->
        <div class="stars">
            @for ($i = 0; $i < 30; $i++)
                <div class="star" style="
                    left: {{ rand(0, 100) }}%;
                    top: {{ rand(0, 100) }}%;
                    animation-delay: {{ rand(0, 3) }}s;
                "></div>
            @endfor
        </div>
    </x-slot>

    <x-slot name="icon">
        <!-- Lost astronaut icon -->
        <div class="astronaut-container">
            <div class="astronaut">
                <div class="astronaut-head">
                    <div class="astronaut-visor"></div>
                </div>
                <div class="astronaut-body"></div>
            </div>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <a href="{{ url('/') }}" class="btn btn-primary">Return Home</a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Go Back</a>
    </x-slot>

    <x-slot name="additionalContent">
        <!-- Popular pages -->
        <div class="popular-pages">
            <h3>Popular destinations:</h3>
            <div class="page-links">
                <a href="{{ route('site') }}" class="page-link">Home</a>
                <a href="{{ route('pages.show', 'about_us') }}" class="page-link">About</a>
                <a href="{{ route('contacts.index') }}" class="page-link">Contact</a>
            </div>
        </div>
    </x-slot>

    <x-slot name="bottomInfo">
        <!-- Request URL -->
        <div class="request-info">
            Requested: {{ request()->fullUrl() }}
        </div>
    </x-slot>

    <x-slot name="customScripts">
        // Random star twinkle
        const stars = document.querySelectorAll('.star');
        stars.forEach(star => {
            setInterval(() => {
                star.style.animationDelay = Math.random() * 3 + 's';
            }, 3000);
        });
    </x-slot>
</x-error-layout>