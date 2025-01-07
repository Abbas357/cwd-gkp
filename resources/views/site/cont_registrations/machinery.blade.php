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

            <div id="machineryRows">
                <div class="row machinery-row mb-3">
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
                    <div class="col-md-2">
                        <label class="form-label">Registration</label>
                        <input type="text" class="form-control" name="machinery[0][registration]">
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
                <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('registrations.hr_profiles.create') }}'">
                    <i class="bi bi-arrow-left"></i> Previous
                </button>
                <button type="submit" class="btn btn-primary">
                    Next <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const machineryRows = document.getElementById('machineryRows');
            const addRowBtn = document.getElementById('addRow');
            let rowIndex = 0;

            addRowBtn.addEventListener('click', function() {
                rowIndex++;
                const newRow = document.createElement('div');
                newRow.className = 'row machinery-row mb-3';
                newRow.innerHTML = `
                    <div class="col-md-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="machinery[${rowIndex}][name]" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Number *</label>
                        <input type="text" class="form-control" name="machinery[${rowIndex}][number]" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Model</label>
                        <input type="text" class="form-control" name="machinery[${rowIndex}][model]">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Registration</label>
                        <input type="text" class="form-control" name="machinery[${rowIndex}][registration]">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
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
