<x-app-layout>
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Collections</li>
    </x-slot>

    @push('style')
    @endpush

    <div class="wrapper">
        <div class="page">
            <div class="page-inner">
                <div class="page-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Add Categories </h3>
                                    <form id="collectionForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="type" class="form-label">Type</label>
                                                <select class="form-select" id="type" name="type" required>
                                                    <option value=""> Choose... </option>
                                                    @foreach (cat_types() as $cat)
                                                    <option value="{{ $cat }}"> {{ $cat }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" placeholder="Name" required>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button class="btn btn-primary" id="submit-btn" type="submit">Add Category</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table" id="categories">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="categories-tbody">
                                            {{-- Categories is populated here --}}
                                        </tbody>
                                    </table>
                                    <div id="loading-spinner" class="loading-spinner text-center" style="display: none;">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
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
    <script src="{{ asset('plugins/sweetalert2@11.js') }}"></script>
    <script>
        $("#categories").on('click', '.delete-btn', async function() {
            const id = $(this).data("id");
            const url = "{{ route('collections.destroy', ':id') }}".replace(':id', id);

            const result = await confirmAction('Do you want to delete this user?');

            if (result.isConfirmed) {
                const success = await fetchRequest(url, 'DELETE');
                if (success) {
                    let urlParams = new URLSearchParams(window.location.search);
                    let initialType = urlParams.get('type') || '';
                    fetchAndDisplayCategories(initialType);
                }
                setButtonLoading($('#submit-btn'), false);
            }
        });

        document.getElementById('collectionForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            setButtonLoading($('#submit-btn'), true);
            const form = event.target;
            const formData = new FormData(form);

            const url = "{{ route('collections.store') }}";

            try {
                const response = await fetch(url, {
                    method: 'POST'
                    , headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                    , body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    setButtonLoading($('#submit-btn'), false);
                    let urlParams = new URLSearchParams(window.location.search);
                    let initialType = urlParams.get('type') || '';
                    fetchAndDisplayCategories(initialType);
                    showMessage("success", result.success || "Operation successful");
                    $('#name').val('');
                } else {
                    showMessage("error", result.error || "There was an error processing your request");
                }
            } catch (error) {
                showMessage("error", "There was an error processing your request");
            }
        });

        function fetchAndDisplayCategories(type = '') {
            let url = new URL(window.location.href);
            if (type) {
                url.searchParams.set('type', type);
            } else {
                url.searchParams.delete('type');
            }
            $('#loading-spinner').show();
            $('#categories-tbody').hide();

            fetch(url.href, {
                    method: 'GET'
                    , headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    , }
                , })
                .then(response => response.json())
                .then(data => {
                    var tbody = $('#categories-tbody');
                    tbody.empty();
                    $('#loading-spinner').hide();
                    $('#categories-tbody').show();
                    if (data.length > 0) {
                        data.forEach(function(category) {
                            tbody.append(`
                            <tr>
                                <td>${category.id}</td>
                                <td>${category.type}</td>
                                <td>${category.name}</td>
                                <td>
                                    <span class="delete-btn cursor-pointer text-danger border border-danger bg-light material-symbols-outlined" title="Defer" data-bs-toggle="tooltip" data-id="${category.id}">
                                        delete
                                    </span>
                                </td>
                            </tr>
                        `);
                        });
                    } else {
                        tbody.append('<tr><td colspan="4">No categories found.</td></tr>');
                    }
                    window.history.pushState({}, '', url.href);
                })
                .catch(error => console.error('Error fetching categories:', error));
        }
        $(document).ready(function() {
            let urlParams = new URLSearchParams(window.location.search);
            let initialType = urlParams.get('type') || '';
            fetchAndDisplayCategories(initialType);
            $('#type').on('change', function() {
                var selectedType = $(this).val();
                fetchAndDisplayCategories(selectedType);
            });
        });

    </script>
    @endpush
</x-app-layout>
