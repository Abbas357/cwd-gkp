<x-main-layout>
    @include('site.consultants.partials.header')

    <div class="container">
        <form class="needs-validation" action="{{ route('consultants.machinery.store') }}" method="post" enctype="multipart/form-data" novalidate>
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

        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-3 p-2"> List of Machinery </h3>
                <table class="table p-5 table-stripped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Model</th>
                            <th>Registration</th>
                            <th>Status</th>
                            <th>Machinery Documents</th>
                            <th>Machinery Pictures</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($machinery as $machine)
                        <tr>
                            <td> {{ $machine->name }} </td>
                            <td> {{ $machine->number }} </td>
                            <td> {{ $machine->model }} </td>
                            <td> {{ $machine->registration }} </td>
                            <td>
                                <span class="badge 
                                    @switch($machine->status)
                                        @case('draft') bg-secondary @break
                                        @case('rejected') bg-danger @break
                                        @case('approved') bg-success @break
                                        @default bg-light text-dark
                                    @endswitch">
                                    {{ ucfirst($machine->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    @if($machine->getMedia('consultant_machinery_docs'))
                                        @foreach($machine->getMedia('consultant_machinery_docs') as $index => $doc)
                                        <div class="mt-2 files">
                                            <a href="{{ $doc->getUrl() }}" target="_blank" class="m-1 badge bg-primary">
                                                Document {{ $index + 1 }}
                                            </a>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    @if($machine->getMedia('consultant_machinery_pics'))
                                        @foreach($machine->getMedia('consultant_machinery_pics') as $index => $pic)
                                        <div class="mt-2 files">
                                            <a href="{{ $pic->getUrl() }}" target="_blank" class="m-1 badge bg-primary">
                                                Image {{ $index + 1 }}
                                            </a>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center">No records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $machinery->links() }}
        </div>

    </div>
</x-main-layout>
