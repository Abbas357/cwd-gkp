<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }

    .vehicle-info {
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .delete-allotment {
        background: #dc3545;
        color: white;
        border: none;
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        cursor: pointer;
    }

    .delete-allotment:hover {
        background: #c82333;
    }

    .slideshow {
        position: relative;
        height: 300px;
        overflow: hidden;
        border-radius: 0.5rem;
        background: #f8f9fa;
        margin-bottom: 1rem;
    }

    .slideshow img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }

    .slideshow img.active {
        display: block;
    }

    .slide-nav {
        position: absolute;
        bottom: 1rem;
        left: 0;
        right: 0;
        text-align: center;
        z-index: 10;
    }

    .slide-nav button {
        background: rgba(255, 255, 255, 0.5);
        border: none;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin: 0 5px;
        padding: 0;
        cursor: pointer;
    }

    .slide-nav button.active {
        background: white;
    }

</style>

<div class="row vehicle-details">
    <!-- Vehicle Information Column -->
    <div class="col-md-6">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span>Vehicle Type:</span>
                <span>{{ $vehicle->type }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Registration Number:</span>
                <span>{{ $vehicle->registration_number }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Model:</span>
                <span>{{ $vehicle->model }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Year:</span>
                <span>{{ $vehicle->model_year }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Functional Status:</span>
                <span>{{ $vehicle->functional_status }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Fuel Type:</span>
                <span>{{ $vehicle->fuel_type }}</span>
            </li>
            @if($vehicle->allotment)
            <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Alloted to:</span>
                    <div class="d-flex align-items-center gap-2">
                        <span>{{ $vehicle->allotment->allottedUser->name }}
                            ({{ $vehicle->allotment->allottedUser->designation }})</span>
                        <form action="{{ route('admin.vehicles.allotment.delete', $vehicle->allotment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-allotment" onclick="return confirm('Are you sure you want to delete this allotment?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </li>
            @endif
        </ul>
    </div>

    <!-- Vehicle Images Column -->
    <div class="col-md-6">
        <div class="slideshow">
            @forelse($vehicle->getMedia('vehicle_pictures') as $index => $image)
            <img src="{{ $image->getUrl() }}" class="slide {{ $index === 0 ? 'active' : '' }}" alt="Vehicle Image {{ $index + 1 }}">
            @empty
            <div class="d-flex align-items-center justify-content-center h-100">
                <p class="text-muted">No images available</p>
            </div>
            @endforelse
            @if($vehicle->getMedia('vehicle_pictures')->count() > 1)
            <div class="slide-nav">
                @foreach($vehicle->getMedia('vehicle_pictures') as $index => $image)
                <button onclick="showSlide({{ $index }})" class="{{ $index === 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<div class="row allot-vehicle mt-4">
    @if(!$vehicle->allotment)
        <div class="col-md-4 mb-3">
            <label for="type">Allotment Type</label>
            <select class="form-select" id="type" name="type" required>
                <option value="">Choose...</option>
                @foreach ($cat['allotment_type'] as $type)
                <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
            @error('type')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

        <div class="col-md-4 mb-3">
            <label for="date">Allotment Date</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" required>
            @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-4">
            <label for="load-users">Allot to </label>
            <select class="form-select form-select-md" data-placeholder="Choose" id="load-users" name="alloted_to">
            </select>
        </div>
    @endif
</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const navButtons = document.querySelectorAll('.slide-nav button');

    $('#load-users').select2({
        theme: "bootstrap-5"
        , dropdownParent: $('#load-users').parent()
        , ajax: {
            url: '{{ route("admin.users.api") }}'
            , dataType: 'json'
            , data: function(params) {
                return {
                    q: params.term
                    , page: params.page || 1
                };
            }
            , processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items
                    , pagination: {
                        more: data.pagination.more
                    }
                };
            }
            , cache: true
        }
        , minimumInputLength: 0
        , templateResult(user) {
            return user.position;
        }
        , templateSelection(user) {
            return user.position;
        }
    });

    function showSlide(index) {
        if (slides.length === 0) return;

        slides.forEach(slide => slide.classList.remove('active'));
        navButtons.forEach(button => button.classList.remove('active'));

        slides[index].classList.add('active');
        navButtons[index].classList.add('active');
        currentSlide = index;
    }

    if (slides.length > 1) {
        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }, 5000);
    }

</script>
