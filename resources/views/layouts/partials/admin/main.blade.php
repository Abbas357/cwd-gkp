<main class="main-wrapper" style="{{ !$showAside ? 'margin-left: 0;' : '' }}">
    <div class="main-content">
        @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification("{{ session('success') }}");
            });

        </script>
        @endif

        @if (session('danger'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification("{{ session('danger') }}", 'error');
            });

        </script>
        @endif

        {{ $slot }}
        <br /><br />
    </div>
</main>