<x-guest-layout>
    <h1 class="font-fjalla text-2xl text-center mb-4 font-bold">{{__('Bonjour') . ' ' . $user->prenom . ' ' . $user->nom}}</h1>

    <p class="block font-fjalla">{{__('Vous recevez ce courriel parce qu\'une demande de changement de mot de passe a été passée.')}}</p>

    <button class="font-fjalla mb-6 bg-dark-yellow font-bold px-6 py-1 rounded-md border border-gray-900 block m-auto mt-4 uppercase">
        <a href="{{ "http://127.0.0.1:8000/reset-password/" . $token }}">{{__('Changer votre mot de passe')}}</a>
    </button>

    <small class="block font-fjalla">{{__('Ce lien expirera dans 60 minutes.')}}</small>

    <small class="block font-fjalla">{{__('Si vous n\'avez pas fait de demande de changement de mot de passe, aucune autre action est requise.')}}</small>
</x-guest-layout>
