<x-guest-layout>
    <h1 class="font-fjalla text-2xl text-center mb-4 font-bold">{{__('Mot de passe oublié')}}</h1>

    <div class="font-fjalla mb-4 text-sm text-gray-600">
        {{ __('Vous avez oublié votre mot de passe? Pas de problème.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Courriel -->
        <div>
            <x-input-label for="email" class="font-fjalla" :value="__('Courriel')" />
            <x-text-input id="email" class="font-fjalla block mt-1 w-full" type="email" name="email" :value="old('email')" autofocus />
            <x-input-error :messages="$errors->get('error')" class="font-fjalla mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="font-fjalla bg-dark-yellow font-bold px-6 py-1 rounded-md border border-gray-900 block m-auto mt-4 uppercase" type="submit">
                {{ __('Envoyer un courriel') }}
            </button>
        </div>
    </form>
</x-guest-layout>
