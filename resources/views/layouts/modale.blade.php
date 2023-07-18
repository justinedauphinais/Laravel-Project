<?php
    $modaleTitle = "Êtes-vous certain de vouloir suspendre cet administrateur?"
?>

<div id="modale" class="hide relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black bg-opacity-30 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="border-2 border-dark-red relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h1 id="modaleTitre" class="text-2xl font-bold text-center font-fjalla"></h1>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center gap-x-3 mt-3 mb-5">
                    <button id="modaleAnnuler" class="font-fjalla font-bold bg-pale-yellow uppercase w-4/12 py-2 rounded-md border border-black">
                        {{__('Annuler')}}
                    </button>
                    <button id="modaleConfirmer" class="font-fjalla font-bold bg-dark-yellow uppercase w-4/12 py-2 rounded-md border border-black">
                        {{__('Suspendre')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
