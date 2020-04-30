<?php require ("config.php");
$def = new lashopak();
if (isset($_POST['regis'])) {
	$name = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	$telp = filter_input(INPUT_POST, 'telp', FILTER_SANITIZE_STRING);
	$alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
	if (isset($_FILES['profile'])) {
		$profil = $_FILES['profil'];
	}else{
		$profil = (string) NULL;
	}
	$hashed = password_hash($password, PASSWORD_DEFAULT);
	$add = $def->register($name, $username, $hashed, $email, $telp, $alamat, $profil);
	header('location:login.php');
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
<!-- <div class="menu">
    <h1>Lashopak</h1>
    <p>Terinspirasi dari secangkir kopi, bahwa dia tak pernah dusta atas nama rasa.<br> Kopi punya cerita, hitam tak selalu kotor, pahit tak harus sedih.</p>
    <p id="regis">Sudah Memiliki akun? <a href="login.php">Login.</a></p>
    <a class="kembali" href="javascript:history.back()">Kembali</a>
</div> -->
<div class="login">
	<div class="login-box">
    <h2>Register</h2>
    <form action="" method="post">
        <div class="user-box">
			<input class="nginput" type="text" name="nama" autocomplete="off" required>
			<label>Name</label>
		</div>
		<div class="user-box">
			<input class="nginput" type="text" name="username" autocomplete="off" required>
			<label>Username</label>
		</div>
		<div class="user-box">
			<input class="nginput" type="email" name="email" autocomplete="off" required>
			<label>Email</label>
		</div>
		<div class="user-box">
			<input class="nginput" type="number" name="telp" autocomplete="off" required>
			<label>Telp.</label>
		</div>
		<div class="user-box">
			<input name="alamat" type="text" class="alamat" autocomplete="off" required>
			<label>Address</label>
		</div>
        <div class="user-box">
			<input type="password" required="" name="password" autocomplete="off">
			<label>Password</label>
		</div>
		<label for="">Profile Picture</label>
		<input type="file" name="profil" class="nginput"><br><br>
		
        <input type="submit" value="Register" class="login" name="regis"><br><br>
        <span>Have an Account? <a href="login.php">Login</a></span>
    </form>
    </div>
</div>
</div>
</body>
</html>