<x-app-layout title="Dashboard" :showAside="false">
    @push('style')
    <style>
        .wrapper {
            margin: 0 auto;
            max-width: 900px;
            width: 100%;
            text-align: center
        }

        #searchBar {
            width: 80%;
            padding: .7rem 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #ccc;
            border-radius: 50px;
            font-size: 1em;
        }

        .app-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 20px;
            align-items: center;
        }

        .app-tile {
            background-color: #00000005;
            padding: .7rem 0;
            border-radius: 8px;
            box-shadow: 1px 3px 5px inset rgba(0, 0, 0, 0.1), 1px 3px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.1s;
            cursor: pointer
        }

        .app-tile:hover {
            transform: translateY(-5px);
        }

        .app-tile p {
            font-size: 1em;
            color: #555;
            margin-bottom: 0px
        }

        .app-tile i {
            font-size: 2.5rem
        }

    </style>
    @endpush
    <div class="wrapper">
        <input type="text" id="searchBar" placeholder="Search apps by name..." oninput="filterApps()">
        <div class="app-grid" id="appGrid">
            <div class="app-tile">
                <i class="bi bi-clipboard" style="color: #00a4e4"></i>
                <p>Registration</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-shield-lock" style="color: #49c0b6"></i>
                <p>Standardization</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-credit-card" style="color: #a4c649"></i>
                <p>Service Card</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-journal" style="color: #1cc7d0"></i>
                <p>News</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-file-earmark-post" style="color: #ffc168"></i>
                <p>Pages</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-images" style="color: #146eb4"></i>
                <p>Slider</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-app" style="color: #0389ff"></i>
                <p>Stories</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-download" style="color: #fb8a2e"></i>
                <p>Downloads</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-card-image" style="color: #11862f"></i>
                <p>Gallery</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-kanban" style="color: #a71930"></i>
                <p>Projects</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-file" style="color: #5ecc62"></i>
                <p>Project Files</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-envelope" style="color: #505050"></i>
                <p>Newsletter</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-chat-left" style="color: #00aee6"></i>
                <p>Public Queries</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-gear" style="color: #f1632a"></i>
                <p>Settings</p>
            </div>
            <div class="app-tile">
                <i class="bi bi-activity" style="color: #ce1126"></i>
                <p>Activity Log</p>
            </div>
        </div>
    </div>

    @push('script')
    <script>
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
