<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance in Progress | Be Right Back!</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #a855f7;
            --accent: #ec4899;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #f8fafc;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
            text-align: center;
        }

        .astronaut {
            width: 300px;
            height: 300px;
            margin-bottom: 2rem;
            animation: float 6s ease-in-out infinite;
        }

        h1 {
            font-size: 5rem;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            text-shadow: 0 0 30px rgba(99, 102, 241, 0.3);
        }

        .message {
            font-size: 1.5rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.6;
            color: #94a3b8;
        }

        .progress-bar {
            width: 300px;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            margin: 2rem 0;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            width: 65%;
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 4px;
            animation: progress 3s ease-in-out infinite;
        }

        .button {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes progress {
            0%, 100% { width: 30%; }
            50% { width: 70%; }
        }

        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            h1 { font-size: 3rem; }
            .astronaut { width: 200px; height: 200px; }
            .message { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>
    
    <div class="container">
        <svg version="1.1" width="200px" height="200px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
        <path style="fill:#53626F;" d="M297.875,404.473c0-27.115,0-38.318,0-38.318h-68.597c0,0,0,11.203,0,38.318
            c0,38.439-52.984,53.837-52.984,53.837h174.564C350.859,458.31,297.875,442.912,297.875,404.473z"/>
        <path style="fill:#6E8193;" d="M512,379.648c0,5.054-4.098,9.152-9.152,9.152H9.152C4.098,388.8,0,384.702,0,379.648V42.188
            c0-5.054,4.098-9.152,9.152-9.152h493.693c5.054,0,9.152,4.098,9.152,9.152v337.46H512z"/>
        <rect x="30.306" y="62.065" style="fill:#FBF5E2;" width="451.382" height="272.541"/>
        <g>
            <circle style="fill:#596977;" cx="263.589" cy="47.571" r="4.755"/>
            <circle style="fill:#596977;" cx="263.589" cy="363.128" r="13.698"/>
        </g>
        <g>
            <path style="fill:#89A1BA;" d="M236.74,363.134c0,2.163-1.754,3.914-3.914,3.914h-19.411c-2.163,0-3.914-1.751-3.914-3.914l0,0
                c0-2.163,1.751-3.914,3.914-3.914h19.411C234.986,359.22,236.74,360.971,236.74,363.134L236.74,363.134z"/>
            <path style="fill:#89A1BA;" d="M197.164,363.134c0,2.163-1.751,3.914-3.914,3.914h-19.411c-2.16,0-3.914-1.751-3.914-3.914l0,0
                c0-2.163,1.754-3.914,3.914-3.914h19.411C195.409,359.22,197.164,360.971,197.164,363.134L197.164,363.134z"/>
            <path style="fill:#89A1BA;" d="M357.228,363.134c0,2.163-1.751,3.914-3.914,3.914h-19.411c-2.163,0-3.914-1.751-3.914-3.914l0,0
                c0-2.163,1.754-3.914,3.914-3.914h19.411C355.477,359.22,357.228,360.971,357.228,363.134L357.228,363.134z"/>
            <path style="fill:#89A1BA;" d="M317.652,363.134c0,2.163-1.754,3.914-3.914,3.914h-19.411c-2.163,0-3.914-1.751-3.914-3.914l0,0
                c0-2.163,1.751-3.914,3.914-3.914h19.411C315.901,359.22,317.652,360.971,317.652,363.134L317.652,363.134z"/>
        </g>
        <path style="fill:#6E8193;" d="M373.606,455.285H153.547c-13.078,0-23.679,10.601-23.679,23.679h267.415
            C397.285,465.886,386.684,455.285,373.606,455.285z"/>
        <path style="fill:#D2314B;" d="M140.959,134.672c-23.25,7.452-40.081,29.235-40.081,54.959c0,4.34,0.496,8.562,1.403,12.627
            l56.311-12.627L140.959,134.672z"/>
        <path style="fill:#4A7CF0;" d="M158.592,189.631l40.496-41.107c-10.417-10.265-24.714-16.608-40.496-16.608
            c-7.561,0-14.772,1.467-21.387,4.11L158.592,189.631z"/>
        <path style="fill:#E1A932;" d="M189.639,140.993l-31.047,48.638l53.468,21.725c2.728-6.708,4.243-14.037,4.243-21.725
            C216.303,169.191,205.669,151.25,189.639,140.993z"/>
        <path style="fill:#6CBB48;" d="M102.281,202.258c5.762,25.796,28.775,45.084,56.311,45.084c24.184,0,44.884-14.884,53.468-35.986
            l-53.468-21.725L102.281,202.258z"/>
        <g style="opacity:0.2;">
            <path d="M204.078,269.79c0,1.703-1.382,3.085-3.085,3.085h-84.808c-1.703,0-3.085-1.379-3.085-3.085l0,0
                c0-1.703,1.382-3.085,2.653-3.085h84.808C202.699,266.708,204.078,268.088,204.078,269.79L204.078,269.79z"/>
        </g>
        <g style="opacity:0.2;">
            <path d="M203.645,287.387c0,1.703-1.382,3.088-3.085,3.088h-84.808c-1.703,0-3.085-1.382-3.085-3.088l0,0
                c0-1.703,1.382-3.085,3.085-3.085h84.808C202.266,284.302,203.645,285.684,203.645,287.387L203.645,287.387z"/>
        </g>
        <g style="opacity:0.2;">
            <path d="M204.078,304.984c0,1.703-1.382,3.085-3.085,3.085h-84.808c-1.703,0-3.085-1.379-3.085-3.085l0,0
                c0-1.703,1.382-3.085,3.085-3.085h84.808C202.699,301.899,204.078,303.278,204.078,304.984L204.078,304.984z"/>
        </g>
        <g style="opacity:0.2;">
            <path d="M402.968,269.79c0,1.703-1.382,3.085-3.085,3.085h-132.06c-1.703,0-3.085-1.379-3.085-3.085l0,0
                c0-1.703,1.382-3.085,2.653-3.085h132.06C401.586,266.708,402.968,268.088,402.968,269.79L402.968,269.79z"/>
        </g>
        <g style="opacity:0.2;">
            <path d="M402.533,287.387c0,1.703-1.379,3.088-3.085,3.088H267.39c-1.703,0-3.085-1.382-3.085-3.088l0,0
                c0-1.703,1.382-3.085,3.085-3.085h132.06C401.154,284.302,402.533,285.684,402.533,287.387L402.533,287.387z"/>
        </g>
        <g style="opacity:0.2;">
            <path d="M402.968,304.984c0,1.703-1.382,3.085-3.085,3.085h-132.06c-1.703,0-3.085-1.379-3.085-3.085l0,0
                c0-1.703,1.382-3.085,3.085-3.085h132.06C401.586,301.899,402.968,303.278,402.968,304.984L402.968,304.984z"/>
        </g>
        <rect x="273.842" y="145.845" style="fill:#4A7CF0;" width="19.393" height="95.675"/>
        <rect x="307.233" y="193.693" style="fill:#D2314B;" width="19.393" height="47.836"/>
        <rect x="340.624" y="131.92" style="fill:#E1A932;" width="19.396" height="109.609"/>
        <rect x="374.045" y="156.836" style="fill:#6CBB48;" width="19.393" height="84.684"/>
        <path style="fill:#808080;" d="M411.123,243.788H256.151c-1.252,0-2.268-1.016-2.268-2.268s1.016-2.268,2.268-2.268H411.12
            c1.252,0,2.268,1.016,2.268,2.268S412.375,243.788,411.123,243.788z"/>
        <g style="opacity:0.4;">
            <path style="fill:#515763;" d="M389.158,95.498c0,4.706-3.817,8.523-8.523,8.523H131.362c-4.706,0-8.523-3.817-8.523-8.523l0,0
                c0-4.706,3.817-8.523,8.523-8.523h249.273C385.344,86.975,389.158,90.792,389.158,95.498L389.158,95.498z"/>
        </g>
        </svg>
        <h1>503</h1>
        
        <p class="message">
            Service Unavailable – We are currently experiencing technical difficulties.
            Please try again later. We apologize for any inconvenience caused.
        </p>

        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>

        <a href="/" class="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            Return to Homebase
        </a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        // Particle animation
        function initParticles() {
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            
            renderer.setSize(window.innerWidth, window.innerHeight);
            document.getElementById('particles').appendChild(renderer.domElement);

            const particles = new THREE.BufferGeometry();
            const particleCount = 1000;
            const posArray = new Float32Array(particleCount * 3);

            for(let i = 0; i < particleCount * 3; i++) {
                posArray[i] = (Math.random() - 0.5) * 5;
            }

            particles.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
            const material = new THREE.PointsMaterial({
                size: 0.005,
                color: '#6366f1',
                transparent: true,
                opacity: 0.6
            });

            const particleMesh = new THREE.Points(particles, material);
            scene.add(particleMesh);

            camera.position.z = 2;

            function animate() {
                particleMesh.rotation.y += 0.001;
                particleMesh.rotation.x += 0.001;
                renderer.render(scene, camera);
                requestAnimationFrame(animate);
            }

            animate();
        }

        window.addEventListener('load', initParticles);
    </script>
</body>
</html>