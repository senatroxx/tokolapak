<?php require("../config.php");
$id = $_GET['id'];
$def = new lashopak();
$add = $def->delProd($id);
if ($add == "Sukses") {
    header("location:prodlist.php");
}
?>