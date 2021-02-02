<html>
<head>
<title>Tampilan Data Penyakit</title>
<script type="text/javascript">
function konfirmasi(id_user){
	var kd_hapus=id_user;
	var url_str;
	url_str="hapus_user.php?id_user="+kd_hapus;
	var r=confirm("Yakin ingin menghapus data..?"+kd_hapus);
	if (r==true){   
		window.location=url_str;
		}else{
			//alert("no");
			}
	}
</script>
</head>
<body>
<h2>Laporan Data Pasien</h2>
<div class="CSSTableGenerator">
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#22B5DD">
  <tr bordercolor="" bgcolor="#CCCCCC"> 
    <td width="29"><div align="center"><strong>No</strong></div></td>
    <td width="147"><div align="center"><b>Nama</b></div></td>
    <td width="74"><div align="center"><strong>Jenis Kelamin</strong></div></td>
    <td width="73" align="center"><div align="center"><strong>Usia</strong></div></td>
    <td width="166" align="center"><div align="center"><strong>Domisili dan Email</strong></div></td>
    <td width="235" align="center"><div align="center"><strong>Hasil Deteksi </strong></div></td>
    <td width="150" align="center"><strong>Tanggal Deteksi</strong> </td>
  </tr>
  <?php 
  	include "../koneksi.php";
	$arrPenyakit=array();
	$queryP=mysql_query("SELECT * FROM tb_penyakit"); while($dataP=mysql_fetch_array($queryP)){ $arrPenyakit["$dataP[kdpenyakit]"]=$dataP['nama_penyakit']; }	
	$sql = "SELECT * FROM tbpasien,tb_hasil WHERE tb_hasil.idpasien=tbpasien.idpasien group by tb_hasil.idpasien  ORDER BY tb_hasil.idhasil DESC";
	//$sql="SELECT * FROM analisa_hasil";
	$qry = mysql_query($sql, $koneksi)  or die ("SQL Error".mysql_error());
	$no=0;
	while ($data=mysql_fetch_array($qry)) {
	$no++;
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td><?php echo $no; ?></td>
    <td><?php echo $data['nama']; ?></td>
    <td><?php echo $data['kelamin']; ?></td>
    <td><?php echo $data['umur']; ?></td>
    <td><?php echo $data['alamat']."<br>".$data['email'];?></td>
    <td><?php $idp=$data['idpasien'];
	$strP=mysql_query("SELECT * FROM tb_hasil WHERE idpasien='$idp' ");
	while($dataP=mysql_fetch_array($strP)){
		echo $dataP['kdpenyakit']." | "; print_r($arrPenyakit["$dataP[kdpenyakit]"]); echo " = ".$dataP['persentase']."%<br>";
		}
	 ?></td>
    <td><?php echo $data['tanggal']; ?>&nbsp;|<a title="hapus pengguna" style="cursor:pointer;" onClick="return konfirmasi('<?php echo $data['idpasien'];?>')"><img src="image/hapus.jpeg" width="16" height="16" ></a></td>
  </tr>
  <?php
  }
  ?>
</table>
</div>
</body>
</html>
