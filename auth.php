<?php
require('koneksi.php');
session_start();

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $pass = ($_POST['password']);

	if(!$username) {
		$error = "Username tidak boleh kosong!";
		header('Location: login.php?error='.urlencode($error));
        return;
	}

	if(!$pass) {
		$error = "Password tidak boleh kosong!";
		header('Location: login.php?error='.urlencode($error));
        return;
	}

	$sql = "SELECT * FROM user WHERE `username`='$username' and id_level = '1'";
	$result = mysqli_query($koneksi, $sql);
	$num = mysqli_num_rows($result);

	if(!$num) {
		$error = "User tidak ditemukan!";
		header('Location: login.php?error='.urlencode($error));
        return;
	}

	while ($row = mysqli_fetch_array($result)){
		$id = $row['id_user'];
		$userVal = $row['username'];
		$passVal =$row['password'];
		$namamu = $row['nama'];
		$foto = $row['Foto'];
	};

	if($username != $userVal) {
		$error = "Username anda salah!";
		header('Location: login.php?error='.urlencode($error));
        return;
	}

	if($pass != $passVal) {
		$error = "Password anda salah!";
		header('Location: login.php?error='.urlencode($error));
        return;
	}
	$_SESSION["login"]=true;
	$_SESSION["idUser"] = $id;
	$_SESSION["namaUser"] = $namamu;
	$_SESSION["fotoUser"] = $foto;
	header('Location: dashboard.php');
}

if (!isset($_SESSION["login"])){
	$error = "Harus login terlebih dahulu!";
	header('Location: login.php?error='.urlencode($error));
	// header("Location: login.php");
	exit;
}
?>