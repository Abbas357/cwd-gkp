<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
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

            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
