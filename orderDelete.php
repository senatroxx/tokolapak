<?php require("config.php");
$transCode = $_GET['id'];
$def = new lashopak();
$add = $def->deleteOrder($transCode);
if ($add == "Sukses") {
    header("location:order.php");
}
?>