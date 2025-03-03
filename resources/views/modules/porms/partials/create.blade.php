<div class="card-plain m-2">
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="month">Month</label>
            <input type="month" class="form-control" id="month" name="month" required>
            <span class="text-danger" id="month-error"></span>
        </div>

        <div class="col-md-4 mb-3">
            <label for="ddo_code">DDO Code</label>
            <input type="text" class="form-control" id="ddo_code" name="ddo_code" required>
            <span class="text-danger" id="ddo_code-error"></span>
        </div>

        <div class="col-md-4 mb-3">
            <label for="district_id">District</label>
            <select class="form-control" id="district_id" name="district_id" required>
                <option value="">Select District</option>
                @foreach ($cat['districts'] as $district)
                <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>
            <span class="text-danger" id="district_id-error"></span>
        </div>

        <div class="col-md-6 mb-3">
            <label for="type">Receipt Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="">Select Type</option>
                @foreach ($cat['receipt_type'] as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
                @endforeach
            </select>
            <span class="text-danger" id="type-error"></span>
        </div>

        <div class="col-md-6 mb-3">
            <label for="amount">Amount (In Millions)</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            <span class="text-danger" id="amount-error"></span>
        </div>

        <div class="col-md-12 mb-3">
            <label for="remarks">Remarks</label>
            <textarea class="form-control" id="remarks" name="remarks" rows="5"></textarea>
            <span class="text-danger" id="remarks-error"></span>
        </div>
    </div>

</div>
