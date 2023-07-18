/*****************************************************************************
 Fichier : commentaire.js
 Auteur : Louis-Philippe Racette
 Fonctionnalité : gestion des commentaires
 Date : 7 mai 2023
*****************************************************************************/

let btn_masquer = document.getElementsByClassName("masquer");
let btn_supprimer = document.getElementsByClassName("supprimer_comm");

// évite les erreurs s'il n'y en a pas
if (btn_masquer) {
    for (let i = 0; i < btn_masquer.length; i++) {
        btn_masquer[i].addEventListener("click", masquer);
        btn_supprimer[i].addEventListener("click", supprimer);
    }
}

function masquer(event) {
    console.log(event.target);
    let csrf = document.querySelector('meta[name="csrf-token"]').content;
    console.log(csrf);

    let valeur_actif = event.target.value == 0 ? 1 : 0;
    console.log(valeur_actif);
    console.log(event.target.previousElementSibling.value);
    let obj = {
        id_commentaire: event.target.previousElementSibling.value,
        activer: valeur_actif,
    };

    let xhttp = new XMLHttpRequest();
    let link = "http://localhost:8000/api/commentaire/activer";

    let post = JSON.stringify(obj);
    console.log(post);

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (this.status === 200) {
                event.target.value = valeur_actif;
                if (valeur_actif == 1) {
                    event.target.classList.add("bg-pale-yellow");
                    event.target.classList.remove("bg-red-400");
                } else {
                    event.target.classList.add("bg-red-400");
                    event.target.classList.remove("bg-pale-yellow");
                }
                console.log("succès");
            } else if (this.status === 400) alert(this.responseText);
        }
    };

    xhttp.open("post", link, true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.setRequestHeader("X-CSRF-TOKEN", csrf);
    xhttp.send(post);
}

function supprimer(event) {
    console.log(event.target);
    let csrf = document.querySelector('meta[name="csrf-token"]').content;
    console.log(csrf);

    let valeur_actif = event.target.value == 0 ? 1 : 0;
    console.log(valeur_actif);
    console.log(event.target.parentElement.parentElement);

    let obj = {
        id_commentaire: event.target.value,
    };

    let xhttp = new XMLHttpRequest();
    let link = "http://localhost:8000/api/commentaire/supprimer";

    let post = JSON.stringify(obj);
    console.log(post);

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (this.status === 200) {
                event.target.parentElement.parentElement.remove();
                console.log("succès");
            } else if (this.status === 400) alert(this.responseText);
        }
    };

    xhttp.open("post", link, true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.setRequestHeader("X-CSRF-TOKEN", csrf);
    xhttp.send(post);
}
