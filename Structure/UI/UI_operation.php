<?php
include "UI_header.php";

$tarifDAO = new TarifDAO(MaBD::getInstance());
$operationDAO = new OperationDAO(MaBD::getInstance());

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $operation = $operationDAO->getOne($_GET['id']);
    $libelle = $operation->libelle_op;
    $duree = $operation->duree_op;
    $cout = ($tarifDAO->getOne($operation->code_tarif))->cout_horaire_actuel_ht;
}else {
    $libelle = "";
    $duree="";
    $cout="";
}

if (sizeof($_POST)==3) {
    $tempTarif = $tarifDAO->getOneByCout($_POST['cout_horaire_actuel_ht']);
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        //update

        if ($tempTarif == null){
            $tarifID= $tarifDAO->getID();
            $tarif = new Tarif(
                array(
                    "code_tarif" => $tarifID,
                    "cout_horaire_actuel_ht" => $_POST['cout_horaire_actuel_ht']
                )
            );

            $tarifDAO->insert($tarif);

        }else{
            $tarifID = $tempTarif->code_tarif;
        }
        $operation->libelle_op =$_POST['libelle_op'];
        $operation->duree_op = $_POST['duree_op'];
        $operation->code_tarif= $tarifID;
        $operationDAO->update($operation);
        header("Location: ../afficher_data.php?data=operation");

    }else{
        //insert
        if($tempTarif == null){
            $tarifID = $tarifDAO->getID();
            $tarif = new Tarif(
                array(
                    "code_tarif" => $tarifID,
                    "cout_horaire_actuel_ht"=>$_POST['cout_horaire_actuel_ht']
                )
            );
            $tarifDAO->insert($tarif);
        }else{
            $tarifID = $tempTarif->code_tarif;
        }
        $operation = new Operation(
            array(
                "code_op" => $operationDAO->getNewID(),
                "libelle_op"=>$_POST['libelle_op'],
                "duree_op"=>$_POST['duree_op'],
                "code_tarif"=>$tarifID
            )
        );
        $operationDAO->insert($operation);
        header("Location: ../afficher_data.php?data=operation");
    }
}
?>
<body>
    <main>
        <form action="" method="post">
        <div class="form-group">
                <label for="libelle_op">Libelle de l'operation</label>
                <input type="text" class="form-control" id="libelle_op" name="libelle_op" placeholder="Libelle de l'operation" value="<?php echo $libelle; ?>">
            </div>
            <div class="form-group">
                <label for="duree_op">Durée de l'operation</label>
                <input type="text" class="form-control" id="duree_op" name="duree_op" placeholder="Durée de l'operation" value = "<?php echo $duree ?>">
            </div>
            <div class="form-group">
                <label for="cout_horaire_actuel_ht">Coût horaire de l'operation</label>
                <input type="number" class="form-control" id="cout_horaire_actuel_ht" name="cout_horaire_actuel_ht" placeholder="Coût horaire de l'operation" value = "<?php echo $cout;?>">
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </main>
</body>