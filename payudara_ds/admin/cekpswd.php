<?php
session_start();
//include "inc.connect/connect.php" ;
include "../koneksi.php";
$username = $_POST['username'];
$password = $_POST['password'];

if (trim($username)=="") {
	///include "login2.php"; 
	echo "<div align=center><b>Username belum diisi !!</b><br>";
	echo "Harap diisi terlebih dahulu</div>";
	exit;
}
elseif (trim($password)=="") {
	//include "login3.php"; 
	echo "<div align=center><b>Password belum diisi !!</b><br>";
	echo "Harap diisi terlebih dahulu</div>";
	exit;
}
$passwordhash = md5($password);  // mengenkripsikannya untuk dicocokan dengan database
$perintahnya = "select username, password from login where username = '$username' and PASSWORD = '$password'";
$jalankanperintahnya = mysql_query($perintahnya);
$ada_apa_enggak = mysql_num_rows($jalankanperintahnya);
if ($ada_apa_enggak >= 1 )
{
	$_SESSION['username'] = $username;
	$_SESSION['password']= $password;
//header("location: haladmin.php?top=home.php");
echo "<meta http-equiv='refresh' content='0; url=haladmin.php?top=home.php'>";
}
else
include "login.php";
echo "<div align=center>Username dan Password tidak sesuai</div>";      
?>