<x-main-layout title="Contacts">

    @push('style')
        <style>
            /* Updated CSS for sticky positioning on both sidebar and main content */

            .nav-pills .nav-link {
                color: #495057;
                border-radius: 0;
                transition: all 0.3s ease;
            }

            .nav-pills .nav-link:hover {
                background-color: #e9ecef;
            }

            .nav-pills .nav-link.active {
                background-color: #575757;
                color: white;
            }

            .contact-tabs .nav-link {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #dee2e6;
            }

            /* Sidebar sticky positioning */
            .contact-sidebar {
                position: sticky;
                top: 4rem;
                height: fit-content;
                /* Ensures proper sticky behavior */
            }

            /* Main content sticky positioning */
            .contacts-main-content {
                position: sticky;
                top: 4rem;
                height: fit-content;
                /* Ensures proper sticky behavior */
            }

            @media (max-width: 767.98px) {
                .offcanvas-contacts {
                    z-index: 1050;
                }

                .office-toggle-btn {
                    position: fixed;
                    top: 8rem;
                    left: 0px;
                    z-index: 999;
                    border-radius: 5px;
                    width: 35px;
                    height: 35px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                }

                .office-toggle-btn::before {
                    content: '';
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 100%;
                    height: 100%;
                    border-radius: 5px;
                    animation: ripple .5s cubic-bezier(0.895, 0.03, 0.685, 0.22) infinite;
                    pointer-events: none;
                }

                @keyframes ripple {
                    0% {
                        box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.2);
                    }

                    100% {
                        box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
                    }
                }

                /* Remove sticky positioning on mobile for better UX */
                .contact-sidebar,
                .contacts-main-content {
                    position: static;
                }
            }
        </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        Contact List
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Contacts</li>
    </x-slot>

    <div class="container my-4">
        <div class="row g-4">
            <!-- Mobile Office Button (visible on small screens) -->
            <div class="d-md-none d-block">
                <button class="btn btn-light border border-secondary office-toggle-btn shadow" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#officesOffcanvas">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <!-- Sidebar with Offices (Hidden on mobile) -->
            <div class="col-md-3 d-none d-md-block">
                <div class="contact-sidebar">
                    <div class="card border-0 shadow-sm overflow-hidden">
                        <div class="card-header bg-light border p-3">
                            <h5 class="m-0 fw-bold"><i class="bi bi-building me-2"></i>Offices</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column contact-tabs" id="officeTabs" role="tablist">
                                @foreach ($contactsByOffice as $office => $contacts)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="tab-{{ Str::slug($office) }}" data-bs-toggle="tab"
                                            href="#{{ Str::slug($office) }}" role="tab"
                                            aria-controls="{{ Str::slug($office) }}" aria-selected="false">
                                            <span><i class="bi bi-telephone me-2"></i>{{ $office }}</span>
                                            <span class="badge bg-secondary rounded-pill">{{ count($contacts) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="tab-pio" data-bs-toggle="tab" href="#pio"
                                        role="tab" aria-controls="pio" aria-selected="false">
                                        <span><i class="bi bi-person-badge me-2"></i>Public Information Officer</span>
                                        <span class="badge bg-secondary rounded-pill">1</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Off-canvas Offices for mobile -->
            <div class="offcanvas offcanvas-start offcanvas-contacts" tabindex="-1" id="officesOffcanvas"
                aria-labelledby="officesOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="officesOffcanvasLabel">
                        <i class="bi bi-building me-2"></i>Office Contacts
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <ul class="nav nav-pills flex-column contact-tabs" id="mobileOfficeTabs" role="tablist">
                        @foreach ($contactsByOffice as $office => $contacts)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="mobile-tab-{{ Str::slug($office) }}" data-bs-toggle="tab"
                                    href="#{{ Str::slug($office) }}" role="tab"
                                    aria-controls="{{ Str::slug($office) }}" aria-selected="false"
                                    data-bs-dismiss="offcanvas">
                                    <span><i class="bi bi-people me-2"></i>{{ $office }}</span>
                                    <span class="badge bg-secondary rounded-pill">{{ count($contacts) }}</span>
                                </a>
                            </li>
                        @endforeach
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="mobile-tab-pio" data-bs-toggle="tab" href="#pio" role="tab"
                                aria-controls="pio" aria-selected="false" data-bs-dismiss="offcanvas">
                                <span><i class="bi bi-person-badge me-2"></i>Public Information Officer</span>
                                <span class="badge bg-secondary rounded-pill">1</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contact Content with sticky positioning -->
            <div class="col-md-9">
                <div class="contacts-main-content border border-light shadow-sm">
                    <div class="tab-content" id="officeTabContent">
                        @foreach ($contactsByOffice as $office => $contacts)
                            <div class="tab-pane fade" id="{{ Str::slug($office) }}" role="tabpanel"
                                aria-labelledby="tab-{{ Str::slug($office) }}">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light border-0 py-3">
                                        <h5 class="m-0"><i class="bi bi-building me-2"></i>{{ $office }}
                                            Contacts</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover mb-0">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th>S#</th>
                                                        <th>Office</th>
                                                        <th>Contact Number</th>
                                                        <th>Social Media</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($contacts as $contact)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $contact->office }}</td>
                                                            <td>{{ $contact->contact_number ?? 'N/A' }}</td>
                                                            <td>
                                                                <div class="d-flex">
                                                                    <a href="https://facebook.com/{{ $contact->facebook ?? '#' }}"
                                                                        class="me-2"><i class="bi bi-facebook fs-4"
                                                                            style="color: #3b5998"></i></a>
                                                                    <a href="https://twitter.com/{{ $contact->twitter ?? '#' }}"
                                                                        class="me-2"><i class="bi bi-twitter fs-4"
                                                                            style="color: #1da1f2"></i></a>
                                                                    <a href="https://wa.me/{{ $contact->whatsapp ?? '#' }}"
                                                                        class="me-2"><i class="bi bi-whatsapp fs-4"
                                                                            style="color: #25d366"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="tab-pane fade" id="pio" role="tabpanel" aria-labelledby="tab-pio">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light border-0 py-3">
                                    <h5 class="m-0 text-primary"><i class="bi bi-person-badge me-2"></i>Public
                                        Information Officer Contacts</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover mb-0">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>S#</th>
                                                    <th>Office</th>
                                                    <th>Contact Number</th>
                                                    <th>Social Media</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Deputy Secretary (Admn)</td>
                                                    <td>091-9211192</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="https://facebook.com/#" class="me-2"><i
                                                                    class="bi bi-facebook fs-4"
                                                                    style="color: #3b5998"></i></a>
                                                            <a href="https://twitter.com/#" class="me-2"><i
                                                                    class="bi bi-twitter fs-4"
                                                                    style="color: #1da1f2"></i></a>
                                                            <a href="https://wa.me/#" class="me-2"><i
                                                                    class="bi bi-whatsapp fs-4"
                                                                    style="color: #25d366"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const offcanvasElement = document.getElementById('officesOffcanvas');
                const mobileTabLinks = document.querySelectorAll('#mobileOfficeTabs .nav-link');
                const offcanvasInstance = new bootstrap.Offcanvas(offcanvasElement);

                mobileTabLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        offcanvasInstance.hide();
                    });
                });

                const tabLinks = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]');

                function activateTabFromHash() {
                    let hash = window.location.hash;

                    hash = hash.replace('#', '');

                    if (!hash) {
                        const firstTab = document.querySelector('#officeTabs .nav-link');
                        if (firstTab) {
                            hash = firstTab.getAttribute('href').replace('#', '');
                        }
                    }

                    const tabToActivate = document.querySelector(`.nav-link[href="#${hash}"]`);
                    if (tabToActivate) {
                        const tab = new bootstrap.Tab(tabToActivate);
                        tab.show();
                    }
                }

                tabLinks.forEach(tabLink => {
                    tabLink.addEventListener('click', function() {
                        const href = this.getAttribute('href');
                        history.pushState(null, null, href);
                    });
                });

                window.addEventListener('popstate', activateTabFromHash);

                activateTabFromHash();
            });
        </script>
    @endpush
</x-main-layout>
