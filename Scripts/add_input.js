document.querySelector("#ajout_opperation").addEventListener('click',buttonClickedOperation)
document.querySelector('#ajout_article').addEventListener('click', buttonClickedArticle)
document.querySelector('#ajout_operateur').addEventListener('click', buttonClickedOperateur)



/**
 * Ajoute un input pour une nouvelle operation
 */
function buttonClickedOperation() {
    let articleInterv = document.querySelector('#block_descript_interv');
    let lastInput = articleInterv.lastElementChild;
    let nbOpers = articleInterv.childElementCount;
    let inputToAdd = document.createElement('input');
    inputToAdd.classList = ["operation"];
    inputToAdd.type = "text";
    inputToAdd.setAttribute('list', "alloperation");
    inputToAdd.name = "opperation" + nbOpers;
    inputToAdd.placeholder = "Operation";
    inputToAdd.setAttribute('required','');
    articleInterv.insertBefore(inputToAdd, lastInput.nextSibling);
}

/**
 * Ajoute un input pour un nouvel article
 */
function buttonClickedArticle() {

    let article =document.querySelector('#block_descript_article');
    let lastArticle = article.lastElementChild;
    let nbArt = article.childElementCount;

    let articleOnceArticle = document.createElement('article');
    articleOnceArticle.classList = ["onceArticle"];

    let inputlibelleArt = document.createElement('input'); 
    inputlibelleArt.type = "text"; 
    inputlibelleArt.classList =["libelleArt"]; 
    inputlibelleArt.name = "Article" + nbArt; 
    inputlibelleArt.placeholder = "Article"; 
    inputlibelleArt.setAttribute('list', "allArticle"); 
    inputlibelleArt.setAttribute('required', '');

    let inputQte = document.createElement('input');
    inputQte.type = "number"; 
    inputQte.classList = ["qte"]; 
    inputQte.name = "qteArticle" + nbArt; 
    inputQte.placeholder = "Qte";
    inputQte.setAttribute('min', "1");
    inputQte.setAttribute('required', '');
    inputQte.setAttribute('min', '1');
	inputQte.defaultValue = "1";
    
    articleOnceArticle.insertBefore(inputlibelleArt,lastArticle.nextElementSibling);
    articleOnceArticle.insertBefore(inputQte, lastArticle.nextElementSibling); 

    article.insertBefore(articleOnceArticle, lastArticle.nextElementSibling);
}

/**
 * Ajoute un input pour un nouvel operateur
 */
function buttonClickedOperateur(){
    let articleOperateur = document.querySelector('#block_liste_operateur');
    let lastInput = articleOperateur.lastElementChild;
    let inputToAdd = document.createElement('input');
    inputToAdd.classList = ["operateur"];
    inputToAdd.type = "text";
    inputToAdd.name = "operateur";
    inputToAdd.setAttribute('list', "alloperateur");
    inputToAdd.placeholder = "Operateur";
    inputToAdd.setAttribute('required','');
    articleOperateur.insertBefore(inputToAdd, lastInput.nextSibling);

    document.getElementById('ajout_operateur').style.visibility = "hidden";
}

let addbuttonoperateur = document.querySelector('#block_liste_operateur')
if (addbuttonoperateur.childElementCount == 2){
    document.getElementById('ajout_operateur').style.visibility =" hidden";
}

function lessInputOp(){
    var article = document.querySelector('#block_descript_inter');
    if(article.childElementCount != 1){
      article.removeChild(article.lastChild);
    }
}