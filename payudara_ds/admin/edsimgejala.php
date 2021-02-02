<?php
include "../koneksi.php";
	$kdgejala = $_REQUEST['kdgejala2'];
	$gejala = $_REQUEST['gejala'];
	$sql = "UPDATE tb_gejala SET gejala='$gejala' WHERE kdgejala='$kdgejala'";
	$result=mysql_query($sql)	or die ("SQL Error".mysql_error());
	if($result){
		echo "<center>Data Telah Berhasil Diubah</center>";
		echo "<center><a href='haladmin.php?top=gejala.php'>OK</a></center>";
		}else{
		echo"<table style='margin-top:150px;' align='center'><tr><td>";
		echo"<div style='width:500px; height:50px auto; border:1px dashed #CCC; padding:3px 3px 3px 3px;'>";
		echo "<center><font color='#ff0000'>Data tidak dapat di Update..!</strong></font></center><br>";
		echo "<center><a href='../admin/haladmin.php?top=gejala.php'>Kembali</a></center>";
		echo"</div>";
		echo"</td></tr></table>";
		}
?>