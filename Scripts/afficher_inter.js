/**
 * Annule une intervention
 * @param {int, string} id id de l'intervention
 * @param {string} elem 
 */
function annuler(elem, id) {
    console.log(elem.parentElement.parentElement.children[0])
    id2 = elem.parentElement.parentElement.children[0].innerText
    if (confirm("Vous allez annuler l'intervention n° " + id)) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './../Scripts/DA_afficher_intervention.php?sql=annule&num_dde=' + id, true);
        xhr.send();
    }
    alert("intervention belle et bien annulée")
}

/**
 * Supprime une intervention
 * @param {int, string} id id de l'intervention
 * @param {string} elem 
 */
function supprimer(elem, id) {
    console.log(elem.parentElement.parentElement.children[0])
    id2 = elem.parentElement.parentElement.children[0].innerText
    if (confirm("Vous allez supprimer l'intervention n° " + id)) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './../Scripts/DA_afficher_intervention.php?sql=delete&num_dde=' + id, false);
        xhr.send();


        alert("Intervention belle et bien supprimé")
        reload();
    }
}

/**
 * Ouvre la page de modification d'une intervention
 * @param {*} elem 
 * @param {*} id id de l'intervention
 */
function modifier(elem, id) {
    id2 = elem.parentElement.parentElement.children[1].children[0].getAttribute('value')
    alert("Vous allez modifier" + id)
    location.assign("../Structure/completer_RDV.php?id=" + id)


}