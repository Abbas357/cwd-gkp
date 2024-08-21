<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name">Name</label>
            <input id="name" name="name" type="text" class="my-2 form-control" value="{{ old('name', $user->name) }}" required autocomplete="name" />
            <error class="mt-2" :messages="$errors->get('name')" />
            @foreach($errors->get('name') as $error)
            <span class="mt-2 text-danger"> {{ $error }}</span>
            @endforeach
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="my-2 form-control" value="{{ old('email', $user->email) }} " required autocomplete="email" />
            @foreach($errors->get('email') as $error)
            <span class="mt-2 text-danger"> {{ $error }}</span>
            @endforeach
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="mt-2 btn btn-primary">Save</button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
