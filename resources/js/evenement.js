// Boutons de l'événement
var boutonSuppEvent = document.getElementById("supprimerEvent");
var boutonConfirmSuppEvent = document.getElementById("confirmerSupprimerEvent");

boutonSuppEvent.addEventListener("click", (element) => {
    boutonSuppEvent.classList.add("hide");
    boutonConfirmSuppEvent.classList.remove("hide");
});
