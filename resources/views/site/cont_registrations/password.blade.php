<x-main-layout>
    @include('site.cont_registrations.partials.header')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Change Password</h2>
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

        <form action="{{ route('registrations.password.update') }}" method="POST">
            @csrf

            <div class="card p-3">
                <div class="card-body">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Old Password</label>
                            <input type="text" class="form-control" name="old_password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="text" class="form-control" name="new_password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="text" class="form-control" name="new_password_confirmation">
                        </div>
                    </div>
                </div>
                <div class="">
                    <a href="{{ route('registrations.dashboard') }}" class="btn btn-light me-2">Cancel</a>
                    <x-button type="submit" text="Update Registration" />
                </div>
            </div>
        </form>
    </div>
</x-main-layout>