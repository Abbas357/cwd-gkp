<div class="container-md">
    <div class="position-relative rounded w-100 mx-auto p-3" style="background: #34bf4966; overflow-x: auto; white-space: nowrap; border-radius: 50px; border: 1px solid #34bf4966; box-shadow:  10px 10px 30px #34bf4966">
        <div class="d-flex justify-content-evenly text-center gap-2 menu-container">
            <div class="col-6 col-md-3 col-lg-2 action-container">
                <a href="{{ route('registrations.create') }}" class="action-link">
                    <div class="action-button">
                        <i class="bi bi-bank action-icon"></i>
                        <div class="action-label">E-Registration</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 action-container">
                <a href="{{ route('standardizations.create') }}" class="action-link">
                    <div class="action-button">
                        <i class="bi bi-diagram-3 action-icon"></i>
                        <div class="action-label">E-Standardization</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 action-container">
                <a href="http://eprocurement.cwd.gkp.pk" class="action-link">
                    <div class="action-button">
                        <i class="bi bi-people action-icon"></i>
                        <div class="action-label">E-bidding</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 action-container">
                <a href="http://etenders.cwd.gkp.pk/" class="action-link">
                    <div class="action-button">
                        <i class="bi bi-journal action-icon"></i>
                        <div class="action-label">Contractor Login</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 action-container">
                <a href="http://103.240.220.71:8080/index.php" class="action-link">
                    <div class="action-button">
                        <i class="bi bi-pie-chart action-icon"></i>
                        <div class="action-label">GIS Portal</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2 action-container">
                <a href="http://175.107.63.223:8889/forms/frmservlet?config=mb" class="action-link">
                    <div class="action-button">
                        <i class="bi bi-cloud-download action-icon"></i>
                        <div class="action-label">E-Billing</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fixed size for larger screens */
    .action-container {
        flex: 0 0 150px;
        max-width: 150px;
    }

    /* Responsive size adjustment for smaller screens */
    @media (max-width: 768px) {
        .action-container {
            flex: 0 0 100px; /* Adjust to smaller size on small screens */
            max-width: 100px;
        }
        .action-label {
            font-size: 0.8em; /* Optional: make text smaller */
        }
        .action-icon {
            font-size: 1.2em; /* Optional: reduce icon size */
        }
    }
</style>
