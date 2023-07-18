/*****************************************************************************
 Fichier : catgories.js
 Auteur : Jimmi Lancelot
 Fonctionnalité : fonctions qui permet d'interargir avec les boutons ajouter,supprimer, modifier
                  et suspendre avec les requetes Ajax.
 Date : 4/5/2023
*****************************************************************************/


/// Partie modification de categorie ------------------------------------------------------------------------
    var Inputnom =document.getElementById('nomup');
    var Inputdescription =document.getElementById('descriptionup');
    var btnModitfier = document.querySelectorAll('.modifier');
    var modalModifier = document.getElementById('modaleup');
    var modalAnnulerUp = document.getElementById('modaleAnnulerup');
    var modalConfirmerUp = document.getElementById('modaleConfirmerup');

    var idAmodification = "";

    btnModitfier.forEach(button => {
        button.addEventListener('click', (element) => {
            element = element.srcElement;

            var idinput = document.querySelector('input[name="id"]');
            idinput.value = element.id;

            modalModifier.classList.remove('hide');

            idAmodification = element.id;

            var nom =  document.getElementById("nom-" + element.id );
            nom = nom.innerHTML.trim().split("\n").map(line => line.trim()).join("\n");
            Inputnom.value = nom;

            var description = document.getElementById("description-" + element.id );
            description = description.innerHTML.trim().split("\n").map(line => line.trim()).join("\n");
            Inputdescription.value = description;
        });
    });

    modalAnnulerUp.addEventListener('click', ()=>{
        modalModifier.classList.add('hide');
    });

    modalConfirmerUp.addEventListener('click', (element)=> {
        if ((Inputnom.value == "" || Inputnom.value == null) || (Inputdescription.value == "" || Inputdescription.value == null)) {
            var indicationErreur = document.getElementById("errorModifier");
            indicationErreur.classList.remove("hide");
        }
        else {
            var idinput =  document.querySelector('input[name="id"]');

            var csrf = document.querySelector('meta[name="csrf-token"]').content;
            var nomup = document.getElementById("nom-" + idinput.value);

            var descup = document.getElementById("description-" + idinput.value );
            var descmodal = document.getElementById("descriptionup");
            var nommodal = document.getElementById("nomup");

            var xhttp = new XMLHttpRequest();
            var link = "/enregistrementCategorie?categorie=" + idAmodification + "&nom=" + Inputnom.value + "&description=" + Inputdescription.value;

            xhttp.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        nomup.innerHTML = nommodal.value;
                        descup.innerHTML = descmodal.value;

                        modalModifier.classList.add('hide');
                    }
                    else if (this.status === 400){
                        // Code quand ça n'a pas fonctionné
                        document.getElementById("divinfo").classList.remove("hide");
                        var information = document.getElementById('erreurs');
                        information.innerHTML = "La modification de la categorie n'a pas fonctionné.";
                    }
                };
            }

            xhttp.open("post", link, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.setRequestHeader("X-CSRF-TOKEN", csrf);
            xhttp.send();
        }
    });
/// ---------------------------------------------------------------------------------------------------------

/// Partie Suppression d'une categorie ----------------------------------------------------------------------
    var btnSupprimerCategorie = document.querySelectorAll('.supprimerCategorie');

    var modaleSupr = document.getElementById("modaleSupr");
    var modaleAnnulerSupr = document.getElementById("modaleAnnulerSupr");
    var modaleConfirmerSupr = document.getElementById("modaleConfirmerSupr");
    var modaleTitreSupr = document.getElementById('modaleTitreSupr');

    var idASupprimer = "";
    var divASupprimer = "";

    btnSupprimerCategorie.forEach(bouton => {
        bouton.addEventListener("click", (element) => {
            element = element.srcElement;
            idASupprimer = element.id;
            divASupprimer = bouton.parentElement.parentElement;

            modaleTitreSupr.innerHTML = "Êtes-vous certain de vouloir supprimer cette categorie ?";
            modaleConfirmerSupr.innerHTML = "Supprimer";
            modaleSupr.classList.remove("hide");
        });
    });

    modaleAnnulerSupr.addEventListener("click", () => {
        modaleSupr.classList.add("hide");
    });

    modaleConfirmerSupr.addEventListener("click", () => {
        modaleSupr.classList.add("hide");

        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        var xhttp = new XMLHttpRequest();
        var link = "/suppression/categorie?categorie=" + idASupprimer;

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    //Code quand ça a fonctionné
                    divASupprimer.remove();
                    document.getElementById("divinfo").classList.remove("hide");
                    var information = document.getElementById("erreurs");
                    information.innerHTML = "La suppression de la catégorie a fonctionné.";

                }
                else if (this.status === 400){
                    // Code quand ça n'a pas fonctionné
                    document.getElementById("divinfo").classList.remove("hide");
                    var erreur = document.getElementById("erreurs");
                    erreur.innerHTML = "vous ne pouvais pas supprimer cette catégorie car il y a des évènements associés";
                }
            };
        }

        xhttp.open("post", link, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-CSRF-TOKEN", csrf);
        xhttp.send();

    });
///------------------------------------------------------------------------------------------------------------------------

/// Partie Suspendre une categorie ------------------------------------------------------------------------------------------
    var btnSuspendreCategorie = document.querySelectorAll('.suspendreCategorie');
    var btnSupprimerCategorie = document.querySelectorAll('.supprimerCategorie');

    // Modale
    var modaleSusp = document.getElementById("modaleSuspension");
    var modaleAnnulerSusp = document.getElementById("modaleAnnulerSuspension");
    var modaleConfirmerSusp = document.getElementById("modaleConfirmerSuspension");
    var modaleTitreSuspension = document.getElementById('modaleTitreSuspension');
    var id = document.getElementById('idCategorie');

    var idASuspendre = "";
    var divASuspendre = "";
    var boutonSuspendreCategorie = "";

    btnSuspendreCategorie.forEach(bouton => {
        bouton.addEventListener("click", (element) => {
            element = element.srcElement;
            boutonSuspendreCategorie = element;
            idASuspendre = element.id;
            divASuspendre = bouton.parentElement.parentElement;

            modaleTitreSuspension.innerHTML = "Êtes-vous certain de vouloir suspendre cette catégorie ?";

            if (boutonSuspendreCategorie.innerHTML.includes("Suspendre"))
                modaleConfirmerSusp.innerHTML = "Suspendre";
            else
                modaleConfirmerSusp.innerHTML = "Réactiver";

            modaleSusp.classList.remove("hide");
        });
    });

    modaleAnnulerSusp.addEventListener("click", ()=>{
        modaleSusp.classList.add("hide");
    });

    modaleConfirmerSusp.addEventListener("click", () => {
        modaleSusp.classList.add("hide");
        var csrf = document.querySelector('meta[name="csrf-token"]').content;
        var xhttp = new XMLHttpRequest();
        var link = "/suspension/categorie?categorie=" + idASuspendre;

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    if (boutonSuspendreCategorie.innerHTML.includes("Suspendre")) {
                        boutonSuspendreCategorie.innerHTML = "Réactiver";

                        divASuspendre.classList.remove("bg-white");
                        divASuspendre.classList.remove("hover:bg-gray-100");
                        divASuspendre.classList.add("bg-red-200");
                        divASuspendre.classList.add("hover:bg-red-300");
                    }
                    else if (boutonSuspendreCategorie.innerHTML.includes("Réactiver")) {
                        boutonSuspendreCategorie.innerHTML = "Suspendre";

                        divASuspendre.classList.add("bg-white");
                        divASuspendre.classList.add("hover:bg-gray-100");
                        divASuspendre.classList.remove("bg-red-200");
                        divASuspendre.classList.remove("hover:bg-red-300");
                    }
                }
                else if (this.status === 400)
                    alert(this.responseText);
            }
        };

        xhttp.open("post", link, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-CSRF-TOKEN", csrf);
        xhttp.send();
    });
///-------------------------------------------------------------------------------------------------------------------------

/// Partie Ajouter une categorie --------------------------------------------------------------------------------------------
    var btnAjouter = document.getElementById("btn-add-category");

    var modaleAjouter = document.getElementById("modaleadd");
    var modaleAnnulerAjouter = document.getElementById("modaleAnnuleradd");
    var modaleConfirmerAjouter = document.getElementById("modaleConfirmeradd");

    btnAjouter.addEventListener("click", (element) => {
        element = element.srcElement;
        modaleConfirmerAjouter.innerHTML = "Ajouter";
        modaleAjouter.classList.remove("hide");
    });

    modaleAnnulerAjouter.addEventListener("click", () => {
        modaleAjouter.classList.add("hide");
    });

    modaleConfirmerAjouter.addEventListener("click", () => {
        var nomadd = document.getElementById("nomadd") ;
        var descriptionadd = document.getElementById("descriptionadd");

        if (nomadd.value.trim()==="" && descriptionadd.value.trim()==="") {
            document.getElementById("nomaddError").innerHTML = "Veuillez saisir un nom";
            document.getElementById("descriptionaddError").innerHTML = "Veuillez saisir une description";
        }
        else if (nomadd.value.trim() === "") {
            document.getElementById("nomaddError").innerHTML = "Veuillez saisir un nom";
        }
        else if (descriptionadd.value.trim()=== "") {
            document.getElementById("descriptionaddError").innerHTML = "Veuillez saisir une description";
        }
        else {
            document.getElementById("descriptionaddError").innerHTML = "";
            document.getElementById("nomaddError").innerHTML = "";

            modaleAjouter.classList.add("hide");
        }

        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        var xhttp = new XMLHttpRequest();
        var link = "/categorie?nom=" + nomadd.value+ "&description=" + descriptionadd.value;

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    // Code quand ça a fonctionné
                    let categorie = JSON.parse(this.responseText);

                    const categorieDiv = document.createElement("div");
                    categorieDiv.id = "categorie-" + categorie.id;
                    categorieDiv.className = "container relative flex mx-auto mt-8 bg-white border-2 border-red-800 rounded-lg shadow-lg p-9 drop-shadow-boite";

                    const idParagraph = document.createElement("p");
                    idParagraph.className = "absolute left-0 ml-2 mr-4 text-lg font-bold font-fjalla top-4";
                    idParagraph.innerText = "ID: ";

                    const idSpan = document.createElement("span");
                    idSpan.id = "idCategorie";
                    idSpan.className = "px-2 py-1 rounded-xl bg-dark-yellow font-fjalla";
                    idSpan.innerText = categorie.id;
                    idParagraph.appendChild(idSpan);

                    const nomParagraph = document.createElement("p");
                    nomParagraph.className = "absolute pl-2 pr-20 text-base font-bold border-r border-red-800 font-fjalla top-4 w-80 left-28";
                    nomParagraph.innerText = "NOM: ";

                    const nomSpan = document.createElement("span");
                    nomSpan.id = "nom-" + categorie.id;
                    nomSpan.className = "text-gray-500 font-fjalla";
                    nomSpan.innerText = categorie.nom;
                    nomParagraph.appendChild(nomSpan);

                    const descriptionParagraph = document.createElement("p");
                    descriptionParagraph.className = "absolute w-5/12 pr-20 text-base font-bold border-r border-red-800 font-fjalla top-4 left-1/3";
                    descriptionParagraph.innerText = "DESCRIPTION: ";

                    const descriptionSpan = document.createElement("span");
                    descriptionSpan.id = "description-" + categorie.id;
                    descriptionSpan.className = "text-gray-500 font-fjalla";
                    descriptionSpan.innerText = categorie.description;
                    descriptionParagraph.appendChild(descriptionSpan);

                    const actionsDiv = document.createElement("div");
                    actionsDiv.className = "absolute right-0 flex items-center top-3";

                    const actionLabel = document.createElement("p");
                    actionLabel.className = "mr-2 text-base font-bold font-fjalla";
                    actionLabel.innerText = "ACTION:";
                    actionsDiv.appendChild(actionLabel);

                    const modifierButton = document.createElement("button");
                    modifierButton.type = "submit";
                    modifierButton.className = "px-1 py-1 mr-1 font-bold text-black border border-gray-400 rounded-lg modifier font-fjalla hover:bg-amber-100 bg-pale-yellow";
                    modifierButton.name = "id";
                    modifierButton.id = categorie.id;
                    modifierButton.innerText = "Modifier";

                    actionsDiv.appendChild(modifierButton);

                    modifierButton.addEventListener("click", (element) => {
                        element = element.srcElement;

                        var idinput = document.querySelector('input[name="id"]');
                        idinput.value = element.id;

                        modalModifier.classList.remove('hide');

                        idAmodification = element.id;

                        var nom = document.getElementById("nom-"+element.id );
                        nom = nom.innerHTML.trim().split("\n").map(line => line.trim()).join("\n");
                        Inputnom.value = nom;

                        var description =document.getElementById("description-"+element.id );
                        description = description.innerHTML.trim().split("\n").map(line => line.trim()).join("\n");
                        Inputdescription.value = description;
                    });

                    const suspendreButton = document.createElement("button");
                    suspendreButton.className = "px-1 py-1 mr-1 font-bold text-black border border-gray-400 rounded-lg font-fjalla hover:bg-amber-100 bg-pale-yellow disable-category suspendreCategorie";
                    suspendreButton.id = categorie.id;

                    if (categorie.est_actif == 1)
                        suspendreButton.innerText = "Suspendre";
                    else
                        suspendreButton.innerText = "Réactiver";

                    actionsDiv.appendChild(suspendreButton);

                    suspendreButton.addEventListener("click", (element) => {
                        element = element.srcElement;

                        boutonSuspendreCategorie = element;
                        idASuspendre = element.id;
                        divASuspendre = element.parentElement.parentElement;

                        modaleTitreSuspension.innerHTML = "Êtes-vous certain de vouloir suspendre cette catégorie ?";

                        if (boutonSuspendreCategorie.innerHTML.includes("Suspendre"))
                            modaleConfirmerSusp.innerHTML = "Suspendre";
                        else
                            modaleConfirmerSusp.innerHTML = "Réactiver";

                        modaleSusp.classList.remove("hide");
                    });

                    const supprimerButton = document.createElement("button");
                    supprimerButton.className = "px-1 py-1 mr-4 font-bold text-black border border-gray-400 rounded-lg supprimerCategorie font-fjalla hover:bg-amber-400 bg-dark-yellow";
                    supprimerButton.name = "id";
                    supprimerButton.id = categorie.id;
                    supprimerButton.innerText = "Supprimer";
                    actionsDiv.appendChild(supprimerButton);

                    categorieDiv.appendChild(idParagraph);
                    categorieDiv.appendChild(nomParagraph);
                    categorieDiv.appendChild(descriptionParagraph);
                    categorieDiv.appendChild(actionsDiv);

                    document.querySelector("#btn-add-category").parentNode.before(categorieDiv);

                    supprimerButton.addEventListener("click", (element) => {
                        element = element.srcElement;
                        idASupprimer = element.id;
                        divASupprimer = element.parentElement.parentElement;
                        console.log(divASupprimer);

                        modaleTitreSupr.innerHTML = "Êtes-vous certain de vouloir supprimer cette categorie ?";
                        modaleConfirmerSupr.innerHTML = "Supprimer";

                        modaleSupr.classList.remove("hide");
                    });

                    document.getElementById("divinfo").classList.remove("hide");
                    var information = document.getElementById("erreurs");
                    information.innerHTML = "L'ajout de la catégorie a fonctionné.";
                }
                else if (this.status === 400){
                    // Code quand ça n'a pas fonctionné
                    document.getElementById("divinfo").classList.remove("hide");
                    var erreur = document.getElementById("erreurs");
                    erreur.innerHTML = "L'ajout de la categorie n'a pas fonctionné";
                }
            };
        }

        xhttp.open("post", link, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-CSRF-TOKEN", csrf);
        xhttp.send();

        descriptionadd.value = "";
        nomadd.value = "";
    });
