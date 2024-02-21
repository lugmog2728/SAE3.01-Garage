/**
 * Supprime une ligne de la table
 * @param {*} table Nom de la table BD
 * @param {*} col Colonne de la table 
 * @param {*} value Valeur à supprimer
 */
function supprimer(table, col, value) {  

    console.log(table+ " " + col + " " + value)  
    if (confirm("Vous allez supprimer la table n° " + value)) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './../Scripts/deleteData.php?table='+table+'&col='+col+'&value='+value , false);
        console.log("hey")
       
        console.log("coucou");
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert(table+" belle et bien supprimé");
            } else {
              alert('impossible de suprimé');
            }
          }
          xhr.send();
        

    }
}