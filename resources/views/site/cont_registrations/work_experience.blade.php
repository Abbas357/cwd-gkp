<x-main-layout>
    @include('site.cont_registrations.partials.header')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Add Work Experience</h2>
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

        <form id="workExperienceForm" action="{{ route('registrations.work_experience.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="experienceDocs" class="form-label">Upload Work Experience Documents</label>
                <input type="file" class="form-control" id="experienceDocs" name="experience_docs">
            </div>

            <div id="experienceRows" class="position-relative">
                <div class="experience-row mb-5 p-4 border rounded position-relative" style="box-shadow: 0 0 7px #cdcdcd">
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                        <button type="button" class="btn btn-danger btn-sm delete-row" style="display: none;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">ADP Number *</label>
                            <input type="text" class="form-control" name="experiences[0][adp_number]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Project Name *</label>
                            <input type="text" class="form-control" name="experiences[0][project_name]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Project Cost *</label>
                            <input type="text" step="0.01" class="form-control" name="experiences[0][project_cost]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Commencement Date *</label>
                            <input type="date" class="form-control" name="experiences[0][commencement_date]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Completion Date *</label>
                            <input type="date" class="form-control" name="experiences[0][completion_date]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="experiences[0][status]">
                                <option value="completed">Completed</option>
                                <option value="ongoing">Ongoing</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mb-3" style="margin-top: -2rem;">
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
            const experienceRows = document.getElementById('experienceRows');
            const addRowBtn = document.getElementById('addRow');
            let rowIndex = 0;

            function createInputGroup(label, name, type = 'text', required = false, options = null) {
                if (type === 'select') {
                    return `
                        <div class="col-md-2">
                            <label class="form-label">${label}</label>
                            <select class="form-select" name="experiences[${rowIndex}][${name}]">
                                <option value="completed">Completed</option>
                                <option value="ongoing">Ongoing</option>
                            </select>
                        </div>
                    `;
                }
                
                return `
                    <div class="col-md-${name === 'status' ? '2' : '3'}">
                        <label class="form-label">${label}${required ? ' *' : ''}</label>
                        <input type="${type}" ${type === 'number' ? 'step="0.01"' : ''} class="form-control" name="experiences[${rowIndex}][${name}]" ${required ? 'required' : ''}>
                    </div>
                `;
            }

            addRowBtn.addEventListener('click', function() {
                rowIndex++;
                const newRow = document.createElement('div');
                newRow.className = 'experience-row mb-5 p-3 border rounded position-relative';
                
                const inputs = `
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="row g-3">
                        ${createInputGroup('Project Name', 'project_name', 'text', true)}
                        ${createInputGroup('Client Name', 'client_name', 'text', true)}
                        ${createInputGroup('Project Value', 'project_value', 'number', true)}
                        ${createInputGroup('Completion Date', 'completion_date', 'date', true)}
                        ${createInputGroup('Status', 'status', 'select')}
                    </div>
                `;
                
                newRow.innerHTML = inputs;
                experienceRows.appendChild(newRow);
            });

            // Handle row deletion
            experienceRows.addEventListener('click', function(e) {
                if (e.target.closest('.delete-row')) {
                    const row = e.target.closest('.experience-row');
                    row.remove();
                }
            });
        });
    </script>
    @endpush
</x-main-layout>