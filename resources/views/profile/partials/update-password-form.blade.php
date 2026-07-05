<section style="padding-right: 10px;">

    <div class="mb-6">
        <h2 class="text-xl font-semibold ">
            Update Password
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Change your password to keep your account secure.
        </p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" value="Current Password" class="text-black dark:text-black" />
            <x-text-input
                id="current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="New Password" class="text-black dark:text-black"/>
            <x-text-input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirm Password" class="text-black dark:text-black"/>
            <x-text-input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn">
                Save
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-sm text-green-600">
                    Saved successfully.
                </span>
            @endif
        </div>
    </form>

</section>
