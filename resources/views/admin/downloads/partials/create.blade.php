<div class="row mx-1">
    <div class="col-md-12 mb-3">
        <label for="file_name">File Name</label>
        <input type="text" class="form-control" id="file_name" value="{{ old('file_name') }}" placeholder="File Name" name="file_name" required>
        @error('file_name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="file_type">File Type</label>
        <select class="form-select form-select-md" id="file_type" name="file_type" required>
            <option value="">Select Option</option>
            @foreach ($cat['file_type'] as $file_type)
            <option value="{{ $file_type }}">{{ $file_type }}</option>
            @endforeach
        </select>
        @error('file_type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="category">Category</label>
        <select class="form-select form-select-md" id="category" name="category" required>
            <option value="">Select Option</option>
            @foreach (category('download_category', 'main') as $category)
            <option value="{{ $category }}">{{ $category }}</option>
            @endforeach
        </select>
        @error('category')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="file">File</label>
        <input type="file" class="form-control" id="file" name="file" required>
        @error('file')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
