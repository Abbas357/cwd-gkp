<x-app-layout>
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Offices</li>
    </x-slot>

    @push('style')
    @endpush

    <div class="wrapper">
        <div class="page">
            <div class="page-inner">
                <div class="page-section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"> Add Offices </h3>
                                    <form class="needs-validation" action="{{ route('admin.offices.store') }}" method="post" novalidate>
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" placeholder="Name" required>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button class="btn btn-primary" type="submit">Add Office</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title mb-3 p-2"> List of Offices </h3>
                                    <table class="table p-5 table-stripped table-bordered">
                                        <thead class="">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($offices as $office)
                                            <tr>
                                                <td>{{ $office->id }}</td>
                                                <td>{{ $office->name }}</td>
                                                <td>
                                                    <form id="delete-office-form-{{ $office->id }}" method="post" action="{{ route('admin.offices.destroy', ['office' => $office->id]) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="bg-light border-0 delete-office-btn" style="cursor: pointer;" data-office-id="{{ $office->id }}">
                                                            <i class="cursor-pointer bi-trash fs-5" title="Delete Office" data-bs-toggle="tooltip" data-id="{{ $office->id }}"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination links -->
                            {{ $offices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            $('.delete-office-btn').on('click', async function() {
                const result = await confirmAction('Are you sure to delete the Office?');
                if (result && result.isConfirmed) {
                    var officeId = $(this).data('office-id');
                    $('#delete-office-form-' + officeId).submit();
                }
            });

        });

    </script>
    @endpush
</x-app-layout>
