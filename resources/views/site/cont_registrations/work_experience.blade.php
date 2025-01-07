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

            <div id="experienceRows">
                <div class="row experience-row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Project Name *</label>
                        <input type="text" class="form-control" name="experiences[0][project_name]" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Client Name *</label>
                        <input type="text" class="form-control" name="experiences[0][client_name]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Project Value *</label>
                        <input type="number" step="0.01" class="form-control" name="experiences[0][project_value]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Completion Date *</label>
                        <input type="date" class="form-control" name="experiences[0][completion_date]" required>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="experiences[0][status]">
                            <option value="completed">Completed</option>
                            <option value="ongoing">Ongoing</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm delete-row" style="display: none;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="button" id="addRow" class="btn btn-secondary">Add</button>
            </div>

            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('registrations.machinery.create') }}'">
                    <i class="bi bi-arrow-left"></i> Previous
                </button>
                <button type="submit" class="btn btn-primary">
                    Submit <i class="bi bi-check2"></i>
                </button>
            </div>
        </form>
    </div>
    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const experienceRows = document.getElementById('experienceRows');
            const addRowBtn = document.getElementById('addRow');
            let rowIndex = 0;

            addRowBtn.addEventListener('click', function() {
                rowIndex++;
                const newRow = document.createElement('div');
                newRow.className = 'row experience-row mb-3';
                newRow.innerHTML = `
                    <div class="col-md-3">
                        <label class="form-label">Project Name *</label>
                        <input type="text" class="form-control" name="experiences[${rowIndex}][project_name]" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Client Name *</label>
                        <input type="text" class="form-control" name="experiences[${rowIndex}][client_name]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Project Value *</label>
                        <input type="number" step="0.01" class="form-control" name="experiences[${rowIndex}][project_value]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Completion Date *</label>
                        <input type="date" class="form-control" name="experiences[${rowIndex}][completion_date]" required>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="experiences[${rowIndex}][status]">
                            <option value="completed">Completed</option>
                            <option value="ongoing">Ongoing</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
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
