<div class="row">
    <div class="col-md-6 mb-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="Designation name" name="name" required>
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="bps">BPS</label>
        <select class="form-select" id="bps" name="bps" required>
            <option value="">Choose...</option>
            @foreach ($bps as $bs)
            <option value="{{ $bs }}">{{ $bs}}</option>
            @endforeach
        </select>
        @error('bps')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

