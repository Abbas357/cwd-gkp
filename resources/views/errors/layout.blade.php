<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Error' }} - {{ $subtitle ?? 'Something went wrong' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #0f0f23;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated background */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0) scale(1);
            }
            33% {
                transform: translateY(-100px) translateX(100px) scale(1.2);
            }
            66% {
                transform: translateY(100px) translateX(-100px) scale(0.8);
            }
        }

        /* Grid pattern overlay */
        .grid-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 1;
        }

        /* Stars (for 404 page) */
        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkle 3s infinite;
        }

        @keyframes twinkle {
            0%, 100% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }

        /* Main container */
        .error-container {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 600px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Error code */
        .error-code {
            font-size: 120px;
            font-weight: 900;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            margin-bottom: 20px;
            line-height: 1;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        /* Title */
        h1 {
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 700;
            color: #ffffff;
        }

        /* Description */
        .description {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Icon containers */
        .icon-container {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            position: relative;
        }

        /* Server icon (for 500 error) */
        .server-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            position: relative;
        }

        .server {
            width: 60px;
            height: 50px;
            background: #2d2d44;
            border-radius: 5px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .server::before {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: #ff6b6b;
            top: 10px;
            left: 10px;
            border-radius: 2px;
            animation: blink 1s infinite;
        }

        .server::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: #4ecdc4;
            top: 20px;
            left: 10px;
            border-radius: 2px;
            animation: blink 1s infinite 0.5s;
        }

        @keyframes blink {
            0%, 50% {
                opacity: 1;
            }
            51%, 100% {
                opacity: 0.3;
            }
        }

        /* Astronaut icon (for 404 error) */
        .astronaut-container {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            position: relative;
        }

        .astronaut {
            width: 60px;
            height: 60px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: float-astronaut 4s ease-in-out infinite;
        }

        @keyframes float-astronaut {
            0%, 100% {
                transform: translate(-50%, -50%) rotate(0deg);
            }
            25% {
                transform: translate(-45%, -55%) rotate(-5deg);
            }
            50% {
                transform: translate(-55%, -45%) rotate(0deg);
            }
            75% {
                transform: translate(-45%, -50%) rotate(5deg);
            }
        }

        .astronaut-body {
            width: 40px;
            height: 45px;
            background: #f0f0f0;
            border-radius: 20px 20px 15px 15px;
            position: relative;
            margin: 0 auto;
        }

        .astronaut-head {
            width: 35px;
            height: 35px;
            background: #e0e0e0;
            border-radius: 50%;
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            overflow: hidden;
        }

        .astronaut-visor {
            width: 30px;
            height: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            opacity: 0.7;
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 15px;
        }

        /* Search box (for 404 page) */
        .search-box {
            margin: 30px 0;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 15px 20px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: white;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        /* Buttons */
        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .btn-primary {
            color: white;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        /* Contact info */
        .contact-info {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-info p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            margin-bottom: 10px;
        }

        .contact-info a {
            color: #4ecdc4;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .contact-info a:hover {
            color: #ff6b6b;
        }

        /* Popular pages (for 404) */
        .popular-pages {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .popular-pages h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.8);
        }

        .page-links {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .page-link {
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        /* Request info */
        .request-info {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
            font-family: monospace;
            max-width: 80%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .error-container {
                margin: 20px;
                padding: 30px 20px;
            }

            .error-code {
                font-size: 80px;
            }

            h1 {
                font-size: 24px;
            }

            .description {
                font-size: 16px;
            }

            .buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .page-links {
                flex-direction: column;
            }

            .page-link {
                width: 100%;
                text-align: center;
            }
        }

        /* Dynamic styles based on props */
        .particle {
            background: {{ $particleGradient ?? 'linear-gradient(45deg, #ff6b6b, #4ecdc4)' }};
        }

        .error-code {
            background: {{ $errorGradient ?? 'linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 100%)' }};
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: {{ $buttonGradient ?? 'linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 100%)' }};
        }

        .btn-primary:hover {
            box-shadow: 0 10px 25px {{ $buttonShadow ?? 'rgba(255, 107, 107, 0.3)' }};
        }

        {{ $customStyles ?? '' }}
    </style>
    
</head>
<body>
    <!-- Animated background particles -->
    <div class="bg-animation">
        @for ($i = 0; $i < 15; $i++)
            <div class="particle" style="
                width: {{ rand(10, 50) }}px;
                height: {{ rand(10, 50) }}px;
                left: {{ rand(0, 100) }}%;
                top: {{ rand(0, 100) }}%;
                animation-delay: {{ rand(0, 20) }}s;
                animation-duration: {{ rand(15, 30) }}s;
            "></div>
        @endfor
    </div>

    <!-- Grid overlay -->
    <div class="grid-overlay"></div>

    {{ $backgroundElements ?? '' }}

    <!-- Main error container -->
    <div class="error-container">
        {{ $icon ?? '' }}

        <!-- Error code -->
        <div class="error-code">
            {{ $errorCode ?? '500' }}
        </div>

        <!-- Title -->
        <h1>{{ $title ?? 'Error' }}</h1>

        <!-- Description -->
        <div class="description">
            {{ $description ?? 'Something went wrong.' }}
        </div>

        {{ $customContent ?? '' }}

        <!-- Action buttons -->
        <div class="buttons">
            {{ $buttons ?? '' }}
        </div>

        {{ $additionalContent ?? '' }}

        {{ $bottomInfo ?? '' }}
    </div>

    <!-- JavaScript for enhanced interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Parallax effect on mouse move
            document.addEventListener('mousemove', function(e) {
                const particles = document.querySelectorAll('.particle');
                const astronaut = document.querySelector('.astronaut');
                const stars = document.querySelectorAll('.star');
                
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;

                // Move particles
                particles.forEach((particle, index) => {
                    const speed = (index + 1) * 0.5;
                    particle.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
                });

                // Move astronaut slightly (for 404 page)
                if (astronaut) {
                    astronaut.style.transform = `translate(-50%, -50%) translate(${x * 10 - 5}px, ${y * 10 - 5}px)`;
                }

                // Move stars (for 404 page)
                stars.forEach((star, index) => {
                    const speed = (index + 1) * 0.3;
                    star.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
                });
            });

            {{ $customScripts ?? '' }}
        });
    </script>
</body>
</html>