/*****************************************************************************
 Fichier : indexUtilisateurs.js
 Auteur : Justine Dauphinais
 Fonctionnalité : Script pour s'occuper de suspendre et supprimer les utilisateurs
                  + requêtes AJAX
 Date : 28 avril 2023
*****************************************************************************/

// Boutons de l'index
var boutonsSuspendre = document.querySelectorAll('.suspendre');
var boutonsSupprimer = document.querySelectorAll('.supprimer');

// Modale
var modale = document.getElementById("modale");
var modaleAnnuler = document.getElementById("modaleAnnuler");
var modaleConfirmer = document.getElementById("modaleConfirmer");
var modaleTitre = document.getElementById('modaleTitre');

// Élément à supprimer
var idASupprimer = "";
var divASupprimer = "";
var boutonSuspendre = "";

// Confirmations et erreur div
var confirmationSuppression = document.getElementById("confirmationSuppression");
var confirmationSuspension = document.getElementById("confirmationSuspension");
var confirmationReactivation = document.getElementById("confirmationReactivation");
var erreur = document.getElementById("erreurAJAX");

// Boutons suspendre
boutonsSuspendre.forEach(bouton => {
    bouton.addEventListener("click", (element) => {
        element = element.srcElement;
        boutonSuspendre = element;
        idASupprimer = element.id;
        divASupprimer = document.getElementById("div-" + idASupprimer);

        modaleTitre.innerHTML = "Êtes-vous certain de vouloir suspendre cet administrateur?";

        if (boutonSuspendre.innerHTML.includes("Suspendre le compte"))
            modaleConfirmer.innerHTML = "Suspendre";
        else
            modaleConfirmer.innerHTML = "Réactiver";

        modale.classList.remove("hide");
    });
});

// Boutons supprimer
boutonsSupprimer.forEach(bouton => {
    bouton.addEventListener("click", (element) => {
        element = element.srcElement;
        idASupprimer = element.id;
        divASupprimer = document.getElementById("div-" + idASupprimer);

        modaleTitre.innerHTML = "Êtes-vous certain de vouloir supprimer cet administrateur?";
        modaleConfirmer.innerHTML = "Supprimer";

        modale.classList.remove("hide");
    });
});

modaleAnnuler.addEventListener("click", () => {
    modale.classList.add("hide");
});

modaleConfirmer.addEventListener("click", () => {
    modale.classList.add("hide");

    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    console.log(csrf);

    if (modaleConfirmer.innerHTML == "Supprimer") {
        var xhttp = new XMLHttpRequest();
        var link = "/supprimer?utilisateur=" + idASupprimer;

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                hideConfirmations();

                if (this.status === 200) {
                    divASupprimer.remove();

                    confirmationSuppression.classList.remove("hide");
                }
                else if (this.status === 500)
                    erreur.classList.remove("hide");
            }
        };

        xhttp.open("post", link, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-CSRF-TOKEN", csrf);
        xhttp.send();
    }
    else if (modaleConfirmer.innerHTML == "Suspendre" || modaleConfirmer.innerHTML == "Réactiver") {
        var xhttp = new XMLHttpRequest();
        var link = "/suspendre?utilisateur=" + idASupprimer;

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                hideConfirmations();

                if (this.status === 200) {
                    if (boutonSuspendre.innerHTML.includes("Suspendre")) {
                        boutonSuspendre.innerHTML = "Réactiver le compte";

                        divASupprimer.classList.remove("bg-white");
                        divASupprimer.classList.remove("hover:bg-gray-100");
                        divASupprimer.classList.add("bg-red-200");
                        divASupprimer.classList.add("hover:bg-red-300");

                        confirmationSuspension.classList.remove("hide");
                    }
                    else if (boutonSuspendre.innerHTML.includes("Réactiver")) {
                        boutonSuspendre.innerHTML = "Suspendre le compte";

                        divASupprimer.classList.add("bg-white");
                        divASupprimer.classList.add("hover:bg-gray-100");
                        divASupprimer.classList.remove("bg-red-200");
                        divASupprimer.classList.remove("hover:bg-red-300");

                        confirmationReactivation.classList.remove("hide");
                    }
                }
                else if (this.status === 500)
                    erreur.classList.remove("hide");
            }
        };

        xhttp.open("post", link, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-CSRF-TOKEN", csrf);
        xhttp.send();
    }
});

function hideConfirmations() {
    confirmationReactivation.classList.add("hide");
    confirmationSuppression.classList.add("hide");
    confirmationSuspension.classList.add("hide");
    erreur.classList.add("hide");
}
