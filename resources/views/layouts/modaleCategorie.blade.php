{{--Modal ajouter categorie--}}
<div id="modaleadd" class="relative z-10 hide" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 transition-opacity bg-black bg-opacity-30"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative overflow-hidden text-left transition-all transform bg-white border-2 rounded-lg shadow-xl border-dark-red sm:my-8 sm:w-full sm:max-w-lg">
                <div class="flex flex-col items-center px-4 pt-5 pb-4 text-center bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h1 id="modaleTitreadd" class="text-2xl font-bold text-center font-fjalla">{{__('Ajouter une
                                catégorie')}}</h1>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center form-group row">
                    <div class="col-md-6">
                        <input id="nomadd" type="text"
                            class="px-3 py-2 mr-4 border border-gray-300 rounded-lg w-96 font-fjalla" name="nom"
                            value="{{ old('nom') }}" required placeholder="Saisir un nom de catégorie...">
                        <div id="nomaddError" class="mt-1 text-sm text-red-500"></div>
                    </div>
                </div>
                <div class="flex justify-center mt-4 mb-5 form-group row">
                    <div class="col-md-6">
                        <textarea id="descriptionadd"
                            class="px-3 py-4 mr-4 border border-gray-300 rounded-lg w-96 font-fjalla" name="description"
                            required placeholder="Saisir une description de catégorie..."></textarea>
                        <div id="descriptionaddError" class="mt-1 text-sm text-red-500"></div>
                    </div>
                </div>
                <div class="flex justify-center mt-3 mb-5 gap-x-3">
                    <button id="modaleAnnuleradd"
                        class="w-4/12 py-2 font-bold uppercase border border-black rounded-md font-fjalla bg-pale-yellow">
                        {{__('Annuler')}}
                    </button>
                    <button id="modaleConfirmeradd"
                        class="w-4/12 py-2 font-bold uppercase border border-black rounded-md font-fjalla bg-dark-yellow">
                        {{__('Ajouter')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{----}}

{{--Modal modification categorie--}}
<div id="modaleup" class="relative z-10 hide" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 transition-opacity bg-black bg-opacity-30"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <div class="relative overflow-hidden text-left transition-all transform bg-white border-2 rounded-lg shadow-xl border-dark-red sm:my-8 sm:w-full sm:max-w-lg">
                <div class="flex flex-col items-center px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h1 id="modaleTitreup" class="text-2xl font-bold text-center font-fjalla">
                                {{__('Modifier une catégorie')}}
                            </h1>
                        </div>
                    </div>
                </div>
                <p id="errorModifier" class="text-red-600 text-sm font-fjalla text-center hide">{{ __('Les champs sont requis et doivent être moins de 255 caractères.') }}</p>
                <div class="flex justify-center form-group row">
                    <div class="col-md-6">
                        <input id="nomup" type="text"
                            class="px-3 py-2 mr-4 text-center border border-gray-300 rounded-lg w-96 font-fjalla"
                            name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>
                    </div>
                </div>
                <div class="flex justify-center mt-4 mb-5 form-group row">
                    <div class="col-md-6">
                        <textarea id="descriptionup"
                            class="px-3 py-4 mr-4 text-center border border-gray-300 rounded-lg w-96 font-fjalla"
                            name="description" required autocomplete="description">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-center mt-3 mb-5 gap-x-3">
                    <button id="modaleAnnulerup"
                        class="w-4/12 py-2 font-bold uppercase border border-black rounded-md font-fjalla bg-pale-yellow">
                        {{__('Annuler')}}
                    </button>
                    <input type="hidden" name="id" value="">
                    <button id="modaleConfirmerup"
                        class="w-4/12 py-2 font-bold uppercase border border-black rounded-md font-fjalla bg-dark-yellow">
                        {{__('moditifer')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{----}}

{{--Modal Suspension categorie--}}
<div id="modaleSuspension" class="relative z-10 hide" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 transition-opacity bg-black bg-opacity-30"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative overflow-hidden text-left transition-all transform bg-white border-2 rounded-lg shadow-xl border-dark-red sm:my-8 sm:w-full sm:max-w-lg">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h1 id="modaleTitreSuspension" class="text-2xl font-bold text-center font-fjalla"></h1>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-3 mb-5 gap-x-3">
                    <button id="modaleAnnulerSuspension"
                        class="w-4/12 py-2 font-bold uppercase border border-black rounded-md font-fjalla bg-pale-yellow">
                        {{__('Annuler')}}
                    </button>
                    <button id="modaleConfirmerSuspension"
                        class="w-4/12 py-2 font-bold uppercase border border-black rounded-md font-fjalla bg-dark-yellow">
                        {{__('Suspendre')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{----}}

{{--Modal Suppression categorie--}}
<div id="modaleSupr" class="relative z-10 hide" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 transition-opacity bg-black bg-opacity-30"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative overflow-hidden text-left transition-all transform bg-white border-2 rounded-lg shadow-xl border-dark-red sm:my-8 sm:w-full sm:max-w-lg">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h1 id="modaleTitreSupr" class="text-2xl font-bold text-center font-fjalla"></h1>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-3 mb-5 gap-x-3">
                    <button id="modaleAnnulerSupr"
                        class="w-4/12 py-2 font-bold uppercase border border-black rounded-md font-fjalla bg-pale-yellow">
                        {{__('Annuler')}}
                    </button>
                    <button id="modaleConfirmerSupr"
                        class="w-4/12 py-2 font-bold uppercase border border-black rounded-md font-fjalla bg-dark-yellow">
                        {{__('Supprimer')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{----}}
