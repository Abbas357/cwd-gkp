<x-main-layout>
    @include('site.contractors.partials.header')

    <div class="container">
        <form class="needs-validation" action="{{ route('contractors.machinery.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card cw-shadow mb-4 rounded-0">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Machine Information
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="name">Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="eg. Name of Machine" name="name" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="number">Number <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="number" value="{{ old('number') }}" placeholder="Number" name="number" required>
                            @error('number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="model">Model <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="model" value="{{ old('model') }}" placeholder="Model" name="model" required>
                            @error('model')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="registration">Registration <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="cnic" value="{{ old('registration') }}" placeholder="Registration" name="registration" required>
                            @error('registration')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="card cw-shadow mb-4 rounded-0">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Attachments
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="machinery_docs">Upload Machinery Documents</label>
                            <input type="file" class="form-control" id="machinery_docs" name="machinery_docs[]" multiple>
                            <div class="form-text">Accepted formats: PDF, DOC, DOCX (Max: 2MB)</div>
                            @error('machinery_docs')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="machinery_pictures">Machine Pictures</label>
                            <input type="file" class="form-control" id="machinery_pictures" name="machinery_pictures[]" multiple>
                            <div class="form-text">Clear images of Machine</div>
                            @error('machinery_pictures')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-2">
                <x-button type="submit" text="Add" />
            </div>
        </form>
    </div>
</x-main-layout>
