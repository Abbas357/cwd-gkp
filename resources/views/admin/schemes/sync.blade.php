<x-app-layout title="Sync Schemes">

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Sync Schemes</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.schemes.sync') }}" method="post" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Sync Schemes</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.schemes.index') }}">All Schemes</a>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="year">Year</label>
                                    <select name="year" id="year" class="form-select form-select-md" required>
                                        <option value="">Select Year</option>
                                        @foreach (getYears() as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    @error('year')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="scheme_code">Scheme Code</label>
                                    <input type="text" class="form-control" id="scheme_code" value="{{ old('scheme_code') }}" placeholder="eg. 23774389" name="scheme_code">
                                    @error('scheme_code')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-actions mb-3 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Sync Schemes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
