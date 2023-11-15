<x-guest-layout>
    <div>
        <div class="px-6 py-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

{{--                <!-- Address -->--}}
{{--                <div class="mt-4">--}}
{{--                    <x-input-label for="address" :value="'Address'" />--}}
{{--                    <x-text-area id="address" class="block mt-1 w-full" type="text" name="address"--}}
{{--                        :value="old('address')" required autofocus autocomplete="address" />--}}
{{--                    <x-input-error :messages="$errors->get('address')" class="mt-2" />--}}
{{--                </div>--}}

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="flex items-center justify-center py-4 text-center bg-gray-50">
            <span class="text-sm text-gray-600">Already have an account? </span>

            <a href="{{ route('login') }}"
                class="mx-2 text-sm font-bold text-blue-500 hover:underline">Login</a>
        </div>
    </div>
</x-guest-layout>
