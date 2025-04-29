<div class="row" id="step-1">
    <div class="col-md-6 mb-3">
        <label for="ddo_code">DDO Code</label>
        <input type="text" class="form-control" id="ddo_code" name="ddo_code" required>
        @error('ddo_code')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="district_id">District</label>
        <select class="form-control" id="district_id" name="district_id" required>
            <option value="">Select District</option>
            @foreach ($cat['districts'] as $district)
            <option value="{{ $district->id }}">{{ $district->name }}</option>
            @endforeach
        </select>
        @error('district_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row" id="step-2">
    <div class="col-md-4 mb-3">
        <label for="month">Month</label>
        <input type="month" class="form-control" id="month" name="month" required>
        @error('month')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="type">Receipt Type</label>
        <select class="form-control" id="type" name="type" required>
            <option value="">Select Type</option>
            @foreach ($cat['receipt_type'] as $type)
            <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
        @error('type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="amount">Amount (In Millions)</label>
        <div class="input-group">
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            <span class="input-group-text">In Millions</span>
        </div>
        @error('amount')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row" id="step-3">
    <div class="col-md-12 mb-3">
        <label for="remarks">Remarks</label>
        <textarea class="form-control" id="remarks" name="remarks" rows="5"></textarea>
        @error('remarks')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
