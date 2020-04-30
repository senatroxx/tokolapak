<?php require ("config.php");
$def = new lashopak();
if (isset($_POST['username'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $add = $def->login($username, $password);
    if (isset($_SESSION['user'])) {
        if (isset($_GET['pId'])) {
            $memberID = $_SESSION['user']['id'];
            $productId = $_GET['pId'];
            $getProd = $def->detProd($productId);
            $data = $getProd->fetch(PDO::FETCH_OBJ);
            $nama = $data->namaprod;
            $harga = $data->hargabrg;
            $jumlah = 1;
            $note = "";
            $total = ((int)$harga * (int)$jumlah);
            $add = $def->addCart($memberID, $productId, $nama, $harga, $jumlah, $total, $note);
        }
        header ('location: index.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
<div class="containerlog">
    <div class="login-box">
    <h2>Login</h2>
    <form action="" method="post">
        <div class="user-box">
        <input type="text" required="" name="username" autocomplete="off">
        <label>Username or Email</label>
        </div>
        <div class="user-box">
        <input type="password" required="" name="password" autocomplete="off">
        <label>Password</label>
        </div>
        <input type="submit" value="Login" class="login" name="masuk"><br><br>
        <span>Don't have an Account? <a href="register.php">Register</a></span>
    </form>
    </div>
</div>
</body>
</html>