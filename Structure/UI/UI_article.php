<?php
include "UI_header.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    $articleDAO = new ArticleDAO(MaBD::getInstance());
    $article = $articleDAO->getOne($id);

    if ($article) {
        $typeArticle = $article->type_article;
        $prixUnit = $article->prix_unit_actuel_ht;
        $libelleArticle = $article->libelle_article;
    }
} else {
    $id = 0;
    $typeArticle = '';
    $prixUnit = '';
    $libelleArticle = '';
}

if (sizeof($_POST) != 0) {
    $typeArticle = $_POST['type_article'];
    $prixUnit = $_POST['prix_unit'];
    $libelleArticle = $_POST['libelle_article'];

    $articleDAO = new ArticleDAO(MaBD::getInstance());
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = intval($_GET['id']);

        $article = new Article(
            array(
                "code_article" => $id,
                "type_article" => $typeArticle,
                "prix_unit_actuel_ht" => $prixUnit,
                "libelle_article" => $libelleArticle
            )
        );

        $articleDAO->update($article);
        header("Location: ../afficher_data.php?data=article");
    } else {
        $article = new Article(
            array(
                "code_article" => $articleDAO->getNewId(),
                "type_article" => $typeArticle,
                "prix_unit_actuel_ht" => $prixUnit,
                "libelle_article" => $libelleArticle
            )
        );

        $articleDAO->insert($article);

        header("Location: ../afficher_data.php?data=article");
        exit;
    }
}
?>
<head>

</head>

<form action="" method="post">
    <div class="form-group">
        <label for="type_article">Type de l'article</label>
        <input type="text" class="form-control" id="type_article" name="type_article" value="<?= $typeArticle ?>" placeholder="type article" required>
    </div>
    <div class="form-group">
        <label for="prix_unit">Prix unitaire de l'article</label>
        <input type="number" class="form-control" id="prix_unit" name="prix_unit" value="<?= $prixUnit ?>" placeholder="prix unitaire de l'article" required>
    </div>
    <div class="form-group">
        <label for="libelle_article">Libelle de l'article</label>
        <input type="text" class="form-control" id="libelle_article" name="libelle_article" value="<?= $libelleArticle ?>" placeholder="libelle de l'article" required>
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
</form>

