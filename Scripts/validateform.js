/**
 * Empêche l'envoi du formulaire si les champs Marque et Modele ne sont pas remplis
 */
function validateForm() {
    var marque = document.getElementById("marque").value;
    var modele = document.getElementById("modele").value;
    var submitButton = document.getElementById("submit");
    if (marque == "0" || modele == "0") {
        submitButton.disabled = true;
    } else {
        submitButton.disabled = false;
    }
}

window.onload = validateForm;
