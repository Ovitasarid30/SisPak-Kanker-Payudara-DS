<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Proses Deteksi</title>
<style type="text/css">
p{ padding-left:2px; text-indent:0px;}
</style>
</head>
<body>
<div class="konten">
<?php
include "koneksi.php";
// kosongkan tabel tmp_penyakit
$kosong_tmp_penyakit=mysql_query("DELETE FROM tmp_penyakit");
echo "<h3>Hasil Deteksi</h3><hr>";
$sqlpenyakit="SELECT * FROM tbrule GROUP BY kd_penyakit ";
$querypenyakit=mysql_query($sqlpenyakit);
$Similarity=0;
echo"<div style='display:none;'>";
while($rowpenyakit=mysql_fetch_array($querypenyakit)){
// data penyakit di tabel relasi
//echo $rowpenyakit['kd_penyakit']. "<br>";
$kd_pen=$rowpenyakit['kd_penyakit'];
	//mengambil gejala di tabel relasi
	$query_gejala=mysql_query("SELECT * FROM tbrule WHERE kd_penyakit='$kd_pen'");
	$var1=0; $var2=0;
	$querySUM=mysql_query("select sum(bobot)AS jumlahbobot from tbrule where kd_penyakit='$kd_pen'");
	$resSUM=mysql_fetch_array($querySUM);
	echo $resSUM['jumlahbobot'] ."<br>";
	$SUMbobot=$resSUM['jumlahbobot'];
	while($row_gejala=mysql_fetch_array($query_gejala)){
		// kode gejala di tabel relasi
		$kode_gejala_relasi=$row_gejala['kd_gejala'];
		$bobotRelasi=$row_gejala['bobot'];
		echo "bobot relasi=". $bobotRelasi. "<br>";
		echo"<p>";
		//echo "<strong>Kode Gejala :</strong> ". $row_gejala['kd_gejala']. " <strong>Bobot Profil</strong> :". $bobotRelasi;
		// mencari data di tabel tmp_gejala dan membandingkannya
		$query_tmp_gejala=mysql_query("SELECT * FROM tmp_gejala WHERE kd_gejala='$kode_gejala_relasi'");
		$row_tmp_gejala=mysql_fetch_array($query_tmp_gejala);
		//$bobot_TMP=$row_tmp_gejala['bobot'];
		// Mengecek apakah ada data di tabel tmp_gejala
		$adadata=mysql_num_rows($query_tmp_gejala);
			if($adadata!==0){
				echo "Ada data<br>";
				//echo " Kode Gejala pada tabel tmp_gejala = ".$row_tmp_gejala['kd_gejala'] ."<br>";
				//$bobotNilai=$bobotRelasi*1; echo "Nilai bobot hasil kali 1 = ".$bobotNilai;
				$bobotNilai=$bobotRelasi*1; echo "Nilai bobot hasil kali 1 = ".$bobotNilai;
				$HasilKaliSatu;
				$var1=$bobotNilai/$SUMbobot; echo "Nilai Jika 1=". $var1;
				}else{
				echo "Tidak ada data<br>";
				$bobotNilai=$bobotRelasi*0; //echo "Nilai = ".$bobotNilai;
				$var2=$bobotNilai+$bobotNilai; echo "Nilai Jika 0=". $var2;
				}
				$Nilai_tmp_gejala=$var1+$var2; //echo "Nilai akhir".$Nilai_tmp_gejala;
				$Nilai_bawah=$Nilai_bawah + $bobotRelasi;
				$Nilai_Pembilang=$Nilai_tmp_gejala;
				$Nilai_Penyebut=$Nilai_bawah;
				// menghasilkan nilai Similarity dengan membagikan $Nilai_Pembilang/$Nilai_Penyebut
				$Similarity=$Nilai_Pembilang/$Nilai_Penyebut;
				// input data ke tabel tmp_penyakit		
		echo "</p>";	
		}
$query_tmp_penyakit=mysql_query("INSERT INTO tmp_penyakit(kd_penyakit,nilai) VALUES ('$kd_pen','$var1')");
$nilaiMin=mysql_query("SELECT kd_penyakit,MAX(nilai)  AS NilaiAkhir FROM tmp_penyakit GROUP BY nilai  ORDER BY nilai DESC ");
//$nilaiMin=mysql_query("SELECT kd_penyakit,MIN(nilai)  AS NilaiAkhir FROM tmp_penyakit");
$rowMin=mysql_fetch_array($nilaiMin);
$rendah=$rowMin['NilaiAkhir']; echo $rendah;
//echo "Gejala yang paling dominan adalah : ". $rowMin['NilaiAkhir'];
//echo "<h3>Hasil Diagnosa : </h3>";
echo $rowMin['kd_penyakit']. "<br>";
$penyakitakhir=$rowMin['kd_penyakit'];
echo "<input type='hidden' value='$rowMin[kd_penyakit]'>";
$sql_pilih_penyakit=mysql_query("SELECT * FROM tbpenyakit WHERE kd_penyakit='$penyakitakhir'");
$row_hasil=mysql_fetch_array($sql_pilih_penyakit);
$kd_penyakit=$row_hasil['kd_penyakit'];
$penyakit=$row_hasil['nama_penyakit'];
$keterangan_penyakit=$row_hasil['definisi'];
$solusi=$row_hasil['solusi'];
}
echo "</div>";
?> 
<table width="500" border="0" bgcolor="#0099FF" cellspacing="1" cellpadding="4" bordercolor="#0099FF">
  <tr bgcolor="#ffffff">
    <td height="32"  style="color:#C60;"><strong>Identitas Anda :</strong><br /><br />
    <?php
    include "koneksi.php";
	$query_pasien=mysql_query("SELECT * FROM tbpasien ORDER BY idpasien DESC ");
	$data_pasien=mysql_fetch_array($query_pasien);
	echo "Nama : ". $data_pasien['nama'] . "<br>";
	echo "Jenis Kelamin : ". $data_pasien['kelamin']. "<br>";
	echo "Umur : ". $data_pasien['umur']. "<br>";
	echo "Alamat : ". $data_pasien['alamat']. "<br>";
	echo "<label>Gejala yang diinputkan : </label><br>";
	
	$query_gejala_input=mysql_query("SELECT tbgejala.gejala AS namagejala,tmp_gejala.kd_gejala FROM tbgejala,tmp_gejala WHERE tmp_gejala.kd_gejala=tbgejala.kd_gejala");
	$nogejala=0;
	while($row_gejala_input=mysql_fetch_array($query_gejala_input)){
		$nogejala++;
		echo $nogejala. ".". $row_gejala_input['namagejala']. "<br>";
		//mencari relasi gejala ke penyakit-penyakit
		$kd_gejala_Input=$row_gejala_input['kd_gejala'];
		$query_KatagoriP=mysql_query("SELECT * FROM tbrule WHERE kd_gejala='$kd_gejala_Input' ORDER BY kd_penyakit ASC");
		//menampilkan data himpunan penyakit
		echo "m$nogejala { ";
		while($data_KatagoriP=mysql_fetch_array($query_KatagoriP)){
			echo $data_KatagoriP['kd_penyakit'] .",";
			}
		//mencari nilai belief pada tabel nilaibobot
		$query_NBelief=mysql_query("SELECT * FROM nilaibobot WHERE kd_gejala ='$kd_gejala_Input' ");
		$data_NBelief=mysql_fetch_array($query_NBelief);
		echo " } = $data_NBelief[mb]<br>";
		$DataM0=1-$data_NBelief['mb'];
		echo "m (&#920;) = 1 - $data_NBelief[mb] = $DataM0<br><hr>"; 
		}
	
	?>
    <p></p>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>Hasil Deteksi :</strong><br /> 
<?php
			
//mencari persen
$query_nilai=mysql_query("SELECT SUM(nilai) as nilaiSum FROM tmp_penyakit");
$rowSUM=mysql_fetch_array($query_nilai);
$nilaiTotal=$rowSUM['nilaiSum'];
//echo "Nilai Total ". $rowSUM['nilaiSum']. "<br>";
$query_sum_tmp=mysql_query("SELECT * FROM tmp_penyakit WHERE NOT nilai='0' ORDER BY nilai DESC LIMIT 0,2");
while($row_sumtmp=mysql_fetch_array($query_sum_tmp)){
	$nilai=$row_sumtmp['nilai'];
	$nilai_persen=$nilai/$nilaiTotal*100;
	$data_persen=$nilai_persen;
	$persen=substr($data_persen,0,5);
	//echo "Nilai persen : ".$persen. "%<br>";
	$kd_pen2=$row_sumtmp['kd_penyakit'];
	//echo $kd_pen2 ."<br>";
	//echo $kd_pen2. "<br>";
	$query_penyasol=mysql_query("SELECT * FROM tbpenyakit WHERE kd_penyakit='$kd_pen2'");
	while ($row_penyasol=mysql_fetch_array($query_penyasol)){
		// jika hasil diagnosa 100%
		if($persen==100||$persen>=70){
			echo "<strong>Anda Menderita Penyakit ". $row_penyasol['nama_penyakit'] ."</strong><br>";
			echo "<p>".$row_penyasol['definisi']."</p>";
			echo "<p>"."<strong>Solusi Pengobatan :</strong> ".$row_penyasol['solusi']."</p><hr>";
			// simpan hasil
			$query_temp=mysql_query("SELECT * FROM tbpasien ORDER BY idpasien DESC") or die(mysql_error());
			$row_pasien=mysql_fetch_array($query_temp)or die(mysql_error());
			$nama=$row_pasien['nama'];
			$kelamin=$row_pasien['kelamin'];
			$umur=$row_pasien['umur'];
			$alamat=$row_pasien['alamat'];
			$tanggal =$row_pasien['tanggal'];
			$idpasien=$row_pasien['idpasien'];
			//echo $nama ."<br>";
			//$query_tmp_hasil=mysql_query("");
			$kode_penyakit=$row_sumtmp['kd_penyakit'];
			echo $kode_penyakit ."100%";
			$query_hasil="INSERT INTO tbhasil(idpasien, kd_penyakit,tanggal_diagnosa) VALUES ('$idpasien','$kode_penyakit','$tanggal')";
			$res_hasil=mysql_query($query_hasil)or die(mysql_error());
			if($res_hasil){
				echo "";
				}else{
					echo "<font color='#FF0000'>Data tidak dapat disimpan..!</font><br>";
				}
			//#end simpan
			}else{
				echo "<strong>Anda Menderita Penyakit ". $row_penyasol['nama_penyakit']. " Sebesar ". $persen."%". "</strong><br>";
				echo "<p>".$row_penyasol['definisi']."</p>";
				echo "<p>"."<strong>Solusi Pengobatan :</strong> ".$row_penyasol['solusi']."</p><hr>";
				// simpan data
				$query_temp=mysql_query("SELECT * FROM tbpasien ORDER BY idpasien DESC") or die(mysql_error());
				$row_pasien=mysql_fetch_array($query_temp)or die(mysql_error());
				$nama=$row_pasien['nama'];
				$kelamin=$row_pasien['kelamin'];
				$umur=$row_pasien['umur'];
				$alamat=$row_pasien['alamat'];
				$tanggal=$row_pasien['tanggal'];
				$idpasien=$row_pasien['idpasien'];
				$kode_penyakit=$row_sumtmp['kd_penyakit'];
				$query_hasil2="INSERT INTO tbhasil(idpasien, kd_penyakit,tanggal_diagnosa) VALUES ('$idpasien','$kode_penyakit','$tanggal')";
				$res_hasil2=mysql_query($query_hasil2)or die(mysql_error());
				if($res_hasil2){
					echo "";
					}else{
						echo "<font color='#FF0000'>Data tidak dapat disimpan..!</font><br>";
					}
				}
		}
	}
?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>&nbsp;</strong><br />
    </td>
  </tr>
</table>
<br />
<br />
<a href="index.php?top=konsultasiFm.php">Deteksi Kembali</a><br />
<a href="index.php?top=PasienAddFm.php">Kembali</a>
</div>
</body>
</html>

