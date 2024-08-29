<section>
    <header>
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-lg font-medium">
                {{ __('Update Password') }}
            </h2>
            <h5>Password was changed <span class="text-primary"> @if (auth()->user()->password_updated_at)
                {{ auth()->user()->password_updated_at->diffForHumans() }} </span>
                @else
                    Password never updated
                @endif</h5>
        </div>



        <p class="mt-1 text-sm">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" class="needs-validation" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" class="my-2 form-control" autocomplete="current-password" />
            @foreach($errors->updatePassword->get('current_password') as $error)
            <span class="mt-2 text-danger"> {{ $error }}</span>
            @endforeach
        </div>

        <div>
            <label for="update_password_password">New Password</label>
            <input id="update_password_password" name="password" type="password" class="my-2 form-control" autocomplete="new-password" />
            @foreach($errors->updatePassword->get('password') as $error)
            <span class="mt-2 text-danger"> {{ $error }}</span>
            @endforeach
        </div>

        <div>
            <label for="update_password_password_confirmation" class="label">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="my-2 form-control" autocomplete="new-password" />
            @foreach($errors->updatePassword->get('password_confirmation') as $error)
            <span class="mt-2 text-danger"> {{ $error }}</span>
            @endforeach
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="mt-2 btn btn-primary">Change Password</button>
        </div>
    </form>
</section>
