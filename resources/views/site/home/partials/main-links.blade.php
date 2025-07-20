<div class="macos-dock">
    <div class="w-100 mx-auto p-4">
        <div class="d-flex text-center gap-2 menu-container">
            <div class="col action-container">
                <a href="https://old.cwd.gkp.pk/applyOnline.php" class="action-link">
                    <div class="action-button">
                        <img src="{{ asset('site/images/icons/home-links/contractor-registration.png') }}" alt="Registration">
                        <div class="action-label">E-Registration</div>
                        <small class="explanation-text">(Contractor Registration)</small>
                    </div>
                </a>
            </div>
            <div class="col action-container">
                <a href="{{ route('standardizations.login.get') }}" class="action-link">
                    <div class="action-button">
                        <img src="{{ asset('site/images/icons/home-links/standardization.png') }}" alt="Standardization">
                        <div class="action-label">E-Standardization</div>
                        <small class="explanation-text">(Engineering Products)</small>
                    </div>
                </a>
            </div>
            {{-- <div class="col action-container">
                <a href="http://eprocurement.cwd.gkp.pk" class="action-link">
                    <div class="action-button">
                        <img src="{{ asset('site/images/icons/home-links/ebidding.png') }}" alt="E-Bidding">
                        <div class="action-label">E-bidding</div>
                        <small class="explanation-text">(Online Bidding System)</small>
                    </div>
                </a>
            </div>
            <div class="col action-container">
                <a href="http://etenders.cwd.gkp.pk/" class="action-link">
                    <div class="action-button">
                        <img src="{{ asset('site/images/icons/home-links/contractor-login.png') }}" alt="Contractor Login">
                        <div class="action-label">Contractor Login</div>
                        <small class="explanation-text">(Contractor Dashboard)</small>
                    </div>
                </a>
            </div> --}}
            <div class="col action-container">
                <a href="https://kp.eprocure.gov.pk" class="action-link">
                    <div class="action-button">
                        <img src="{{ asset('site/images/icons/home-links/ebidding.png') }}" alt="E-Bidding">
                        <div class="action-label">E-PADS</div>
                        <small class="explanation-text">(Online Bidding System)</small>
                    </div>
                </a>
            </div>
            <div class="col action-container">
                <a href="http://103.240.220.71:8080/index.php" class="action-link">
                    <div class="action-button">
                        <img src="{{ asset('site/images/icons/home-links/gis-portal.png') }}" alt="GIS Portal">
                        <div class="action-label">GIS Portal</div>
                        <small class="explanation-text">(Geospatial Insights)</small>
                    </div>
                </a>
            </div>
            <div class="col action-container">
                <a href="http://175.107.63.223:8889/forms/frmservlet?config=mb" class="action-link">
                    <div class="action-button">
                        <img src="{{ asset('site/images/icons/home-links/billing-icon.png') }}" alt="e-billing">
                        <div class="action-label">E-Billing</div>
                        <small class="explanation-text">(Billing Portal)</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.macos-dock {
    position: relative;
    width: 100%;
    max-width: 1300px;
    margin: 0 auto;
    background-color: #FFFFFF88;
    z-index: 10;
}

.macos-dock > div {
    overflow-x: auto;
    white-space: nowrap;
    box-shadow: 10px 10px 30px #00000055;
}

.action-container a {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 10rem;
}

.action-container .action-button {
    border: 1px solid #999;
    transition: all 0.3s ease;
}

.action-container .action-link img {
    width: 60px;
    height: 60px;
    filter: grayscale(.4);
    opacity: 0.7;
}

.action-container .action-link:hover img {
    width: 60px;
    height: 60px;
    filter: grayscale(0) brightness(1.5) saturate(1.5);
    transform: scale(1.1);
    transition: all 0.3s ease;
    opacity: 1;
}

.macos-dock .action-container {
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform-origin: center center;
    display: inline-block;
}

.macos-dock .action-button {
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.macos-dock .action-icon {
    transition: all 0.3s ease;
}

@keyframes dockBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const actionContainers = document.querySelectorAll('.macos-dock .action-container');
    const dockContainer = document.querySelector('.macos-dock .menu-container');
    
    function applyDockEffect(e) {
        const mouseX = e.clientX - dockContainer.getBoundingClientRect().left;
        
        actionContainers.forEach(item => {
            const itemRect = item.getBoundingClientRect();
            const itemCenterX = itemRect.left + (itemRect.width / 2) - dockContainer.getBoundingClientRect().left;
            
            const distance = Math.abs(mouseX - itemCenterX);
            
            const maxScale = 1.3;
            
            const effectDistance = 150;
            
            let scale = 1;
            
            if (distance < effectDistance) {
                const scaleFactor = 1 - (distance / effectDistance);
                
                if (distance < 50) {
                    scale = 1 + (scaleFactor * (maxScale - 1));
                } else {
                    scale = 1 + (scaleFactor * (maxScale - 1) * .9);
                }
            }
            
            item.style.transform = `scale(${scale})`;
            
            const actionButton = item.querySelector('.action-button');
            if (distance < effectDistance) {
                const intensity = 1 - (distance / effectDistance);
                actionButton.style.boxShadow = `0 ${5 + (intensity * 5)}px ${10 + (intensity * 10)}px rgba(0, 0, 0, ${0.1 + (intensity * 0.1)})`;
                
                actionButton.style.transform = `translateY(-${intensity * 5}px)`;
                
                const actionIcon = item.querySelector('.action-icon');
                if (actionIcon) {
                    actionIcon.style.transform = `scale(${1 + (intensity * 0.2)})`;
                }
            } else {
                actionButton.style.boxShadow = '0 3px 7px rgba(0, 0, 0, 0.1)';
                actionButton.style.transform = 'translateY(0)';
                
                const actionIcon = item.querySelector('.action-icon');
                if (actionIcon) {
                    actionIcon.style.transform = 'scale(1)';
                }
            }
        });
    }
    
    function resetDockEffect() {
        actionContainers.forEach(item => {
            item.style.transform = 'scale(1)';
            
            const actionButton = item.querySelector('.action-button');
            actionButton.style.boxShadow = '0 3px 7px rgba(0, 0, 0, 0.1)';
            actionButton.style.transform = 'translateY(0)';
            
            const actionIcon = item.querySelector('.action-icon');
            if (actionIcon) {
                actionIcon.style.transform = 'scale(1)';
            }
        });
    }
    
    if (dockContainer) {
        dockContainer.addEventListener('mousemove', applyDockEffect);
        dockContainer.addEventListener('mouseleave', resetDockEffect);
        
        actionContainers.forEach(item => {
            item.addEventListener('click', function() {
                const actionButton = this.querySelector('.action-button');
                actionButton.style.animation = 'dockBounce 0.3s ease';
                
                setTimeout(() => {
                    actionButton.style.animation = '';
                }, 300);
            });
        });
    }
});
</script>