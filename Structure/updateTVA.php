<?php
include "header.php";
$parametresDAO = new ParametresDAO(MaBD::getInstance());
if (sizeof($_POST)==1) {
    $TVA = new Parametres(
        array(
            "id" => 1,
            "taux_tva_actuel" => $_POST['taux_tva_actuel']/100
        )
    );
    $parametresDAO->update($TVA);
    header("Location: gestion_donnee.php");
}

$TVA = $parametresDAO->getOne(1);
$TVA = $TVA->taux_tva_actuel * 100;
?>

<html>
    <head>
        <title>Modifier TVA</title>
    </head>
    <body>
        <main> 
            <form action="" method="post">
                <div class="form-group">
                    <label for="taux_tva_actuel">Taux de TVA (en %)</label>
                    <?php 
                        echo("<input type='number' min='0' max='100' class='form-control' id='taux_tva_actuel' name='taux_tva_actuel' placeholder='pourcentage de TVA' value ='$TVA' required>");                
                    ?>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </main>
    </body>
</html>
<!-- Same on all pages -->
<?php
    require "footer.php";
    createFooter();
?>