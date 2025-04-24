<div class="row">
    <div class="col-md-6 mb-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Leave empty for auto-generation">
    </div>

    <div class="col-md-6 mb-3">
        <label for="posting[office_id]">Office</label>
        <select class="form-select" id="office_id" name="posting[office_id]">
            <option value="">Select Office</option>
            @foreach($data['offices'] as $office)
                <option value="{{ $office->id }}">{{ $office->name }}</option>
            @endforeach
            <option value="new">+ Add New Office</option>
        </select>
        <div id="new_office_container" class="mt-3 mb-3 d-none border rounded p-3 bg-light shadow-sm">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Add New Office</h6>
            <div class="mb-3">
                <label for="new_office">Office Name</label>
                <input type="text" class="form-control" id="new_office" name="new_office" placeholder="Enter office name">
            </div>
            <div class="mb-3">
                <label for="new_office_type">Office Type</label>
                <select class="form-select" id="new_office_type" name="new_office_type">
                    <option value="">Select Office Type</option>
                    <option value="Secretariat">Secretariat</option>
                    <option value="Provincial">Provincial</option>
                    <option value="Regional">Regional</option>
                    <option value="Divisional">Divisional</option>
                    <option value="District">District</option>
                    <option value="Tehsil">Tehsil</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="new_office_parent_id">Parent Office (Optional)</label>
                <select class="form-select" id="new_office_parent_id" name="new_office_parent_id">
                    <option value="">Select Parent Office</option>
                    @foreach($data['offices'] as $office)
                        <option value="{{ $office->id }}">{{ $office->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="new_office_contact_number">Office Contact Number</label>
                <input type="text" class="form-control" id="new_office_contact_number" name="new_office_contact_number" placeholder="Enter office contact number">
            </div>
            <div class="mb-3">
                <label for="new_district_id">District</label>
                <select class="form-select" id="new_district_id" name="new_district_id">
                    <option value="">Select District</option>
                    @foreach($data['districts'] as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                    <option value="new">+ Add New District</option>
                </select>
            </div>
            <div id="new_district_container" class="mt-3 d-none border rounded p-3 bg-white">
                <h6 class="fw-bold mb-3 border-bottom pb-2">Add New District</h6>
                <div class="mb-3">
                    <label for="new_district">District Name</label>
                    <input type="text" class="form-control" id="new_district" name="new_district" placeholder="Enter district name">
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="posting[designation_id]">Designation</label>
        <select class="form-select" id="designation_id" name="posting[designation_id]">
            <option value="">Select Designation</option>
            @foreach($data['designations'] as $designation)
                <option value="{{ $designation->id }}" data-bps="{{ $designation->bps }}">{{ $designation->name }}</option>
            @endforeach
            <option value="new">+ Add New Designation</option>
        </select>
        <div id="new_designation_container" class="mt-3 mb-3 d-none border rounded p-3 bg-light shadow-sm">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Add New Designation</h6>
            <div class="mb-3">
                <label for="new_designation">Designation Name</label>
                <input type="text" class="form-control" id="new_designation" name="new_designation" placeholder="Enter designation name">
            </div>
            <div class="mb-3">
                <label for="new_designation_bps">BPS</label>
                <select class="form-select" id="new_designation_bps" name="new_designation_bps">
                    <option value="">Select BPS</option>
                    @for($i = 1; $i <= 22; $i++)
                        <option value="BPS-{{ sprintf('%02d', $i) }}">BPS-{{ sprintf('%02d', $i) }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="posting[start_date]">Posting Date</label>
        <input type="date" class="form-control" id="start_date" name="posting[start_date]" value="{{ date('Y-m-d') }}">
    </div>
</div>