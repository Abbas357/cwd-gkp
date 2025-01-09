<x-main-layout>
    @include('site.contractors.partials.header')

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

        <form id="hrProfileForm" action="{{ route('contractors.hr_profiles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="profileRows" class="my-3 position-relative">
                <div class="profile-row mb-5 p-4 border rounded position-relative" style="box-shadow: 0 0 7px #cdcdcd">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control" name="profiles[0][name]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">CNIC Number *</label>
                            <input type="text" class="form-control" name="profiles[0][cnic_number]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">PEC Number *</label>
                            <input type="text" class="form-control" name="profiles[0][pec_number]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Designation</label>
                            <input type="text" class="form-control" name="profiles[0][designation]">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="profiles[0][start_date]">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="profiles[0][end_date]">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Salary</label>
                            <input type="number" step="0.01" class="form-control" name="profiles[0][salary]">
                        </div>
                        <div class="col-md-3">
                            <label for="hrProfile" class="form-label">Résumé (CV)</label>
                            <input type="file" class="form-control" id="hrProfile" name="hr_profile">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mb-3 position-relative" style="margin-top: -2rem;">
                <button type="button" id="addRow" class="border border-2 border-secondary rounded-circle shadow-sm" style="display:flex; align-items: center; justify-content: center; width:3rem; height:3rem;  font-size: 2rem; z-index: 1; background-color: #fff;">
                    <i class="bi bi-plus"></i>
                </button>
            </div>

            <div class="mb-3">
                <x-button type="submit" text="Submit" />
            </div>
        </form>
    </div>

    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileRows = document.getElementById('profileRows');
            const addRowBtn = document.getElementById('addRow');
            let rowIndex = 0;

            function createInputGroup(label, name, type = 'text', required = false) {
                return `
                    <div class="col-md-3">
                        <label class="form-label">${label}${required ? ' *' : ''}</label>
                        <input type="${type}" class="form-control" name="profiles[${rowIndex}][${name}]" ${required ? 'required' : ''}>
                    </div>
                `;
            }

            addRowBtn.addEventListener('click', function() {
                rowIndex++;
                const newRow = document.createElement('div');
                newRow.className = 'profile-row mb-5 p-3 border rounded position-relative';
                newRow.style.cssText =  'box-shadow: 0 0 7px #cdcdcd';
                
                const inputs = `
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="row g-3">
                        ${createInputGroup('Name', 'name', 'text', true)}
                        ${createInputGroup('CNIC Number', 'cnic_number', 'text', true)}
                        ${createInputGroup('PEC Number', 'pec_number', 'text', true)}
                        ${createInputGroup('Designation', 'designation')}
                        ${createInputGroup('Start Date', 'start_date', 'date')} 
                        ${createInputGroup('End Date', 'end_date', 'date')} 
                        ${createInputGroup('Salary', 'salary', 'text')}
                        ${createInputGroup('Résumé (CV)', 'resume', 'file')}
                    </div>
                `;
                
                newRow.innerHTML = inputs;
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