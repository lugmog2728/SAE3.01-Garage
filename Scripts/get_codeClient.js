/**
 * Retourne le code client correspondant au nom et prénom saisis si existant
 * @returns {void}
 */
function rechercherCodeClient() {

    var nomClient = document.getElementById('nom_client').value;
    var prenomClient = document.getElementById('prenom_client').value;
  
    if (!nomClient || !prenomClient) {
      return;
    }
  
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          document.getElementById('code_client').value = xhr.responseText;
        } else {
          console.error('Erreur lors de la récupération du code client');
        }
      }
    };
    xhr.open('GET', './../Scripts/rechercher-code-client.php?nom=' + nomClient + '&prenom=' + prenomClient, true);
    xhr.send();
  }
  
  document.getElementById('nom_client').addEventListener('change', rechercherCodeClient);
  document.getElementById('prenom_client').addEventListener('change', rechercherCodeClient);
  