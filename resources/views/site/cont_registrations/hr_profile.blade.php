<x-main-layout>
    @include('site.cont_registrations.partials.header')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">HR Profiles</h2>
        </div>

        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="hrProfileForm" action="{{ route('registrations.hr_profiles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="hrProfile" class="form-label">Upload HR Profile</label>
                <input type="file" class="form-control" id="hrProfile" name="hr_profile">
            </div>

            <div id="profileRows">
                <div class="row profile-row mb-3">
                    <div class="col-md-2">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="profiles[0][name]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">CNIC *</label>
                        <input type="text" class="form-control" name="profiles[0][cnic]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">PEC *</label>
                        <input type="text" class="form-control" name="profiles[0][pec]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Designation</label>
                        <input type="text" class="form-control" name="profiles[0][designation]">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="profiles[0][date]">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Salary</label>
                        <input type="number" class="form-control" name="profiles[0][salary]">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm delete-row" style="display: none;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="button" id="addRow" class="btn btn-secondary">Add Row</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileRows = document.getElementById('profileRows');
            const addRowBtn = document.getElementById('addRow');
            let rowIndex = 0;

            addRowBtn.addEventListener('click', function() {
                rowIndex++;
                const newRow = document.createElement('div');
                newRow.className = 'row profile-row mb-3';
                newRow.innerHTML = `
                    <div class="col-md-2">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="profiles[${rowIndex}][name]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">CNIC *</label>
                        <input type="text" class="form-control" name="profiles[${rowIndex}][cnic]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">PEC *</label>
                        <input type="text" class="form-control" name="profiles[${rowIndex}][pec]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Designation</label>
                        <input type="text" class="form-control" name="profiles[${rowIndex}][designation]">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="profiles[${rowIndex}][date]">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Salary</label>
                        <input type="number" class="form-control" name="profiles[${rowIndex}][salary]">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                profileRows.appendChild(newRow);
            });

            // Handle row deletion
            profileRows.addEventListener('click', function(e) {
                if (e.target.closest('.delete-row')) {
                    const row = e.target.closest('.profile-row');
                    row.remove();
                }
            });
        });
    </script>
    @endpush
</x-main-layout>
