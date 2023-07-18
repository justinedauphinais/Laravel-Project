<x-guest-layout>
    <h1 class="text-2xl text-center font-fjalla mb-4 font-bold">Changer de mot de passe</h1>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $token }}">
        <x-input-error class="font-fjalla" :messages="$errors->get('error')" class="mt-2" />

        <!-- Email Address -->
        <div>
            <x-input-label class="font-fjalla" for="email" :value="__('Courriel')" />
            <x-text-input class="font-fjalla" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $email)" autofocus autocomplete="username" />
            <x-input-error class="font-fjalla" :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label class="font-fjalla" for="password" :value="__('Nouveau mot de passe')" />
            <x-text-input class="font-fjalla" id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
            <x-input-error class="font-fjalla" :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label class="font-fjalla" for="password_confirmation" :value="__('Confirmer nouveau mot de passe')" />

            <x-text-input class="font-fjalla" id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" autocomplete="new-password" />

            <x-input-error class="font-fjalla" :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="bg-dark-yellow px-6 py-1 rounded-md border border-gray-900" type="submit">
                {{ __('Changer de mot de passe') }}
            </button>
        </div>
    </form>
</x-guest-layout>
