/**
 * Rempli la liste des modèles en fonction de la marque sélectionnée
 * @param {string, int} numMarque id de la marque
 * @returns {void}
 */
function remplirListeModeles(numMarque) {
  //si l'option est remise a celle par defaut
  if (numMarque == 0) {
    var selectModele = document.querySelector('#modele');

    //vide les options déjà présente
    while (selectModele.firstChild != null){
      selectModele.removeChild(selectModele.firstChild);
    }

    var option = document.createElement('option');
    option.value = 0;
    option.textContent = 'Sélectionnez un modèle';

    // Ajoute l'option en enfant de l'élément select
    selectModele.appendChild(option);

    selectModele.disabled = true;
    return;
  }
  // Envoie une requête AJAX
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Récupère le select de modèle
        var selectModele = document.getElementById('modele');
        selectModele.innerHTML = xhr.responseText;

        // Active le sélecteur de modèle
        selectModele.disabled = false;
      } else {
        // Affiche une erreur si la requête a échoué
        console.error('Erreur lors de la récupération des modèles : ' + xhr.status);
      }
    }
  };
  xhr.open('GET', './../Scripts/get_modele.php?marque=' + numMarque, true);
  xhr.send();
  
}


