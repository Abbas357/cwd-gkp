<x-app-layout title="Homepage" id="particles-js">
    @push('style')
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            position: relative;
            z-index: 1;
        }
        
        .dashboard-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .dashboard-header h1 {
            font-size: 2.8rem;
            font-weight: 700;
            background: linear-gradient(90deg, #3a7bd5, #00d2ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }
        
        .dashboard-header p {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }
        
        [data-bs-theme=dark] .dashboard-header p {
            color: #aaa;
        }
        
        .search-container {
            max-width: 600px;
            margin: 0 auto 3rem;
            position: relative;
        }
        
        .search-container i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 1.2rem;
        }
        
        #searchBar {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            font-size: 1.1rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }
        
        #searchBar:focus {
            outline: none;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }
        
        [data-bs-theme=dark] #searchBar {
            background: rgba(40, 40, 40, 0.9);
            color: #fff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
        
        .app-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1.5rem;
            justify-content: center;
        }
        
        .app-tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 150px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(5px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        
        [data-bs-theme=dark] .app-tile {
            background: rgba(30, 30, 30, 0.8);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .app-tile::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--accent-color, #3a7bd5), var(--accent-color-secondary, #00d2ff));
            opacity: 0.8;
        }
        
        .app-tile:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
        }
        
        [data-bs-theme=dark] .app-tile:hover {
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.2);
        }
        
        .app-tile i {
            font-size: 3rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .app-tile:hover i {
            transform: scale(1.1);
        }
        
        .app-tile p {
            font-size: 1.1rem;
            font-weight: 600;
            color: #444;
            margin: 0;
            transition: all 0.3s ease;
        }
        
        [data-bs-theme=dark] .app-tile p {
            color: #eee;
        }
        
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
        }
        
        .app-section {
            margin-bottom: 2rem;
        }
        
        .app-section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
            position: relative;
            display: inline-block;
            padding-bottom: 0.5rem;
        }
        
        [data-bs-theme=dark] .app-section-title {
            color: #eee;
        }
        
        .app-section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50%;
            height: 3px;
            background: linear-gradient(90deg, #3a7bd5, #00d2ff);
        }
    </style>
    @endpush
    <div id="particles-js"></div>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Website Portal</h1>
            <p>Access all your Website components in one place</p>
        </div>
        
        <div class="search-container">
            <i class="bi bi-search"></i>
            <input type="text" id="searchBar" placeholder="Search for applications..." oninput="filterApps()">
        </div>
        
        <div class="app-grid" id="appGrid">
            @can('view any user')
            <a href="{{ route('admin.users.index') }}" class="app-tile" style="--accent-color: #8d0fe0; --accent-color-secondary: #bf5ae0;">
                <i class="bi bi-person-circle" style="color: #8d0fe0"></i>
                <p>Users</p>
            </a>
            @endcan

            @can('view any tender')
            <a href="{{ route('admin.tenders.index') }}" class="app-tile" style="--accent-color: #ff000d; --accent-color-secondary: #ff6b6b;">
                <i class="bi bi-briefcase" style="color: #ff000d"></i>
                <p>Tenders</p>
            </a>
            @endcan

            @can('view any event')
            <a href="{{ route('admin.events.index') }}" class="app-tile" style="--accent-color: #96bb05; --accent-color-secondary: #c5e200;">
                <i class="bi bi-calendar2-event" style="color: #96bb05"></i>
                <p>Events</p>
            </a>
            @endcan

            @can('view any news')
            <a href="{{ route('admin.news.index') }}" class="app-tile" style="--accent-color: #1cc7d0; --accent-color-secondary: #7fdbff;">
                <i class="bi bi-journal" style="color: #1cc7d0"></i>
                <p>News</p>
            </a>
            @endcan

            @can('view any slider')
            <a href="{{ route('admin.sliders.index') }}" class="app-tile" style="--accent-color: #146eb4; --accent-color-secondary: #36a2eb;">
                <i class="bi bi-images" style="color: #146eb4"></i>
                <p>Slider</p>
            </a>
            @endcan

            @can('create download')
            <a href="{{ route('admin.downloads.index') }}" class="app-tile" style="--accent-color: #fb8a2e; --accent-color-secondary: #ffce56;">
                <i class="bi bi-download" style="color: #fb8a2e"></i>
                <p>Downloads</p>
            </a>
            @endcan

            @can('view any gallery')
            <a href="{{ route('admin.gallery.index') }}" class="app-tile" style="--accent-color: #11862f; --accent-color-secondary: #4bc0c0;">
                <i class="bi bi-card-image" style="color: #11862f"></i>
                <p>Gallery</p>
            </a>
            @endcan

            @can('view any page')
            <a href="{{ route('admin.pages.index') }}" class="app-tile" style="--accent-color: #ffc168; --accent-color-secondary: #ffce56;">
                <i class="bi bi-file-earmark-post" style="color: #ffc168"></i>
                <p>Pages</p>
            </a>
            @endcan

            @can('view any story')
            <a href="{{ route('admin.stories.index') }}" class="app-tile" style="--accent-color: #0389ff; --accent-color-secondary: #36a2eb;">
                <i class="bi bi-app" style="color: #0389ff"></i>
                <p>Stories</p>
            </a>
            @endcan

            @can('view any project')
            <a href="{{ route('admin.projects.index') }}" class="app-tile" style="--accent-color: #a71930; --accent-color-secondary: #ff6384;">
                <i class="bi bi-kanban" style="color: #a71930"></i>
                <p>Projects</p>
            </a>
            @endcan

            @can('view project file')
            <a href="{{ route('admin.project_files.index') }}" class="app-tile" style="--accent-color: #5ecc62; --accent-color-secondary: #97dc88;">
                <i class="bi bi-file" style="color: #5ecc62"></i>
                <p>Project Files</p>
            </a>
            @endcan

            @can('view any newsletter')
            <a href="{{ route('admin.newsletter.index') }}" class="app-tile" style="--accent-color: #505050; --accent-color-secondary: #9e9e9e;">
                <i class="bi bi-envelope" style="color: #505050"></i>
                <p>Newsletter</p>
            </a>
            @endcan

            @can('view any public contact')
            <a href="{{ route('admin.public_contact.index') }}" class="app-tile" style="--accent-color: #00aee6; --accent-color-secondary: #36a2eb;">
                <i class="bi bi-chat-left" style="color: #00aee6"></i>
                <p>Public Queries</p>
            </a>
            @endcan

            @can('view any user')
            <a href="{{ route('admin.settings.index') }}" class="app-tile" style="--accent-color: #f1632a; --accent-color-secondary: #ff9f40;">
                <i class="bi bi-gear" style="color: #f1632a"></i>
                <p>Settings</p>
            </a>
            @endcan

            @can('view any user')
            <a href="{{ route('admin.logs') }}" class="app-tile" style="--accent-color: #ce1126; --accent-color-secondary: #ff6384;">
                <i class="bi bi-activity" style="color: #ce1126"></i>
                <p>Activity Log</p>
            </a>
            @endcan

            @can('view any seniority')
            <a href="{{ route('admin.seniority.index') }}" class="app-tile" style="--accent-color: #790bdf; --accent-color-secondary: #9966ff;">
                <i class="bi bi-graph-up-arrow" style="color: #790bdf"></i>
                <p>Seniority List</p>
            </a>
            @endcan

            @can('create development project')
            <a href="{{ route('admin.development_projects.index') }}" class="app-tile" style="--accent-color: #0096a0; --accent-color-secondary: #00d2ff;">
                <i class="bi bi-buildings" style="color: #0096a0"></i>
                <p>Dev. Projects</p>
            </a>
            @endcan

            @can('update comment')
            <a href="{{ route('admin.comments.index') }}" class="app-tile" style="--accent-color: #000000; --accent-color-secondary: #505050;">
                <i class="bi bi-chat" style="color: #000000"></i>
                <p>Comments</p>
            </a>
            @endcan

            @can('view any project')
            <a href="{{ route('admin.schemes.index') }}" class="app-tile" style="--accent-color: #028be1; --accent-color-secondary: #36a2eb;">
                <i class="bi bi-building" style="color: #028be1"></i>
                <p>Schemes</p>
            </a>
            @endcan

            @can('view any achievement')
            <a href="{{ route('admin.achievements.index') }}" class="app-tile" style="--accent-color: #2ef782; --accent-color-secondary: #97dc88;">
                <i class="bi bi-award" style="color: #2ef782"></i>
                <p>Achievements</p>
            </a>
            @endcan
        </div>
    </div>

    @push('script')
    <script>
        $('a.app-tile').on('click', () => {
            document.querySelector('.page-loader').classList.remove('hidden');
        });

        function filterApps() {
            const searchInput = document.getElementById("searchBar").value.toLowerCase();
            const appTiles = document.querySelectorAll(".app-tile");

            appTiles.forEach((tile) => {
                const appName = tile.querySelector("p").textContent.toLowerCase();
                if (appName.includes(searchInput)) {
                    tile.style.display = "";
                } else {
                    tile.style.display = "none";
                }
            });
        }
    </script>
    @endpush
</x-app-layout>