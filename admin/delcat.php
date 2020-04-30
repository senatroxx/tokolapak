<?php require("../config.php");
$id = $_GET['id'];
$def = new lashopak();
$add = $def->delCat($id);
if ($add == "Sukses") {
    header("location:category.php");
}
?>