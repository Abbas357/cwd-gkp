<x-app-layout title="Districts" :showAside="false">
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Districts</li>
    </x-slot>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"> Add Districts </h3>
                    <form class="needs-validation" action="{{ route('admin.settings.districts.store') }}" method="post" novalidate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-primary" type="submit">Add District</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-3 p-2"> List of Districts </h3>
                    <table class="table p-5 table-stripped table-bordered">
                        <thead class="">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($districts as $district)
                            <tr>
                                <td>{{ $district->id }}</td>
                                <td>{{ $district->name }}</td>
                                <td>
                                    <form id="delete-district-form-{{ $district->id }}" method="post" action="{{ route('admin.settings.districts.destroy', ['district' => $district->id]) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="bg-light border-0 delete-district-btn" style="cursor: pointer;" data-district-id="{{ $district->id }}">
                                            <i class="cursor-pointer bi-trash fs-5" title="Delete District" data-bs-toggle="tooltip" data-id="{{ $district->id }}"></i>
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
            {{ $districts->links() }}
        </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            $('.delete-district-btn').on('click', async function() {
                const result = await confirmAction('Are you sure to delete the District?');
                if (result && result.isConfirmed) {
                    var districtId = $(this).data('district-id');
                    $('#delete-district-form-' + districtId).submit();
                }
            });

        });

    </script>
    @endpush
</x-app-layout>
