<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript">
function validasi(form){
	if(form.idsolusi.value==""){
		alert("Masukkan kode gejala..!");
		form.idsolusi.focus(); return false;
		}else if(form.gejala.value==""){
		alert("Masukkan gejala..!");
		form.gejala.focus(); return false;	
		}
		form.submit();
	}
function konfirmasi(idsolusi){
	var kd_hapus=idsolusi;
	var url_str;
	url_str="hpssolusi.php?kdhapus="+kd_hapus;
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
<h2>Data Solusi</h2>
<form name="form3" onSubmit="return validasi(this);" method="post" action="simpansolusi.php">
<table class="tab" width="477" border="0" align="center">
  <tr>
    <td colspan="3"><div align="center"></div></td>
  </tr>
  <tr>
    <td width="95">ID Solusi</td>
    <td width="8">:</td>
    <td width="224">
      <input name="idsolusi" type="text" id="idsolusi" size="4" maxlength="4">
    </td>
  </tr>
  <tr>
    <td> Solusi</td>
    <td>:</td>
    <td>
      <textarea name="solusi" rows="2" cols="40" id="solusi"></textarea>
    </td>
  </tr>
  <tr>
    <td>Penyakit</td>
    <td>:</td>
    <td><select name="TxtKdPenyakit" id="TxtKdPenyakit">
      <option value="NULL">[ Daftar Penyakit ]</option>
      <?php 
	$sqlp = "SELECT * FROM tbpenyakit ORDER BY kd_penyakit";
	$qryp = mysql_query($sqlp, $koneksi) 
		    or die ("SQL Error: ".mysql_error());
	while ($datap=mysql_fetch_array($qryp)) {
		if ($datap['kd_penyakit']==$kdsakit) {
			$cek ="selected";
		}
		else {
			$cek ="";
		}
		echo "<option value='$datap[kd_penyakit]' $cek>$datap[kd_penyakit]&nbsp;|&nbsp;$datap[nama_penyakit]</option>";
	}
  ?>
    </select></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
      <input name="simpan" type="submit" id="simpan" value="Simpan">
      <input type="reset" name="reset" value="Reset">
    </td>
  </tr>
</table>
</form>
<div class="CSSTableGenerator">          
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr bgcolor="#CCCC99" align="center">
    <td width="85"><strong>ID Solusi</strong></td>
    <td width="505"><strong>Solusi</strong></td>
    <td width="505"><strong>Penyakit</strong></td>
    <td width="50"><strong>Edit</strong></td>
    <td width="50"><strong>Hapus</strong></td>
  </tr>
  <tr>
    <?php
	//include("inc.connect/connect.php");
	include "../koneksi.php";
	$sql = "SELECT * FROM tbsolusi, tbpenyakit WHERE tbsolusi.kd_penyakit=tbpenyakit.kd_penyakit";
	$qry = mysql_query($sql,$koneksi) or die ("SQL Error".mysql_error());
	$no=0;
	while ($data = mysql_fetch_array ($qry)) {
	$no++;
   ?>

  <tr>
    <td><?php echo $data['idsolusi']; ?></td>
    <td><?php echo $data['solusi']; ?></td>
    <td><?php echo $data['nama_penyakit']; ?></td>
    <td><a title="Edit solusi" href="edsolusi.php?kdubah=<?php echo $data['idsolusi'];?>"><img src="image/edit.jpeg" width="16" height="16" border="0"></a></td>
    <td><a title="Hapus solusi" style="cursor:pointer;" onclick="return konfirmasi('<?php echo $data['idsolusi'];?>');"><img src="image/hapus.jpeg" width="16" height="16" ></a></td>
  </tr>
  <?php
  } ?>
</table></div>
<p>&nbsp; </p>
</body>
</html>