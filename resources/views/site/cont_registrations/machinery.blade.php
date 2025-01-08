<x-main-layout>
    @include('site.cont_registrations.partials.header')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Add Machinery</h2>
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

        <form id="machineryForm" action="{{ route('registrations.machinery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="machineryDocs" class="form-label">Upload Machinery Detail(s)</label>
                <input type="file" class="form-control" id="machineryDocs" name="machinery_docs">
            </div>

            <div id="machineryRows" class="position-relative">
                <div class="machinery-row mb-5 p-4 border rounded position-relative" style="box-shadow: 0 0 7px #cdcdcd">
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                        <button type="button" class="btn btn-danger btn-sm delete-row" style="display: none;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control" name="machinery[0][name]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Number *</label>
                            <input type="text" class="form-control" name="machinery[0][number]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Model</label>
                            <input type="text" class="form-control" name="machinery[0][model]">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Registration</label>
                            <input type="text" class="form-control" name="machinery[0][registration]">
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
            const machineryRows = document.getElementById('machineryRows');
            const addRowBtn = document.getElementById('addRow');
            let rowIndex = 0;

            function createInputGroup(label, name, type = 'text', required = false) {
                return `
                    <div class="col-md-3">
                        <label class="form-label">${label}${required ? ' *' : ''}</label>
                        <input type="${type}" class="form-control" name="machinery[${rowIndex}][${name}]" ${required ? 'required' : ''}>
                    </div>
                `;
            }

            addRowBtn.addEventListener('click', function() {
                rowIndex++;
                const newRow = document.createElement('div');
                newRow.className = 'machinery-row mb-5 p-3 border rounded position-relative';
                
                const inputs = `
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="row g-3">
                        ${createInputGroup('Name', 'name', 'text', true)}
                        ${createInputGroup('Number', 'number', 'text', true)}
                        ${createInputGroup('Model', 'model')}
                        ${createInputGroup('Registration', 'registration')}
                    </div>
                `;
                
                newRow.innerHTML = inputs;
                machineryRows.appendChild(newRow);
            });

            // Handle row deletion
            machineryRows.addEventListener('click', function(e) {
                if (e.target.closest('.delete-row')) {
                    const row = e.target.closest('.machinery-row');
                    row.remove();
                }
            });
        });
    </script>
    @endpush
</x-main-layout>