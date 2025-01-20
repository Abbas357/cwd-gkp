<x-main-layout>
    @include('site.standardizations.partials.header')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Change Password</h2>
        </div>

        <form action="{{ route('standardizations.password.update') }}" method="POST">
            @csrf

            <div class="card p-3">
                <div class="card-body">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Old Password</label>
                            <input type="password" class="form-control" name="old_password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="new_password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="new_password_confirmation">
                        </div>
                    </div>
                </div>
                <div class="">
                    <a href="{{ route('standardizations.dashboard') }}" class="btn btn-light me-2">Cancel</a>
                    <x-button type="submit" text="Update Password" />
                </div>
            </div>
        </form>
    </div>
</x-main-layout>