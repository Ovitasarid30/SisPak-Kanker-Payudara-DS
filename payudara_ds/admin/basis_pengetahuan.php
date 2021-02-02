<html>
<head>
<style type="text/css">
p {text-indent:0pt;}
</style>
<script type="text/javascript">
function konfirmasi(id_problem){
	var kd_hapus=id_problem;
	var url_str;
	url_str="hapus_relasi.php?id_problem="+kd_hapus;
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
<h2>Data Rule | Basis Pengetahuan</h2><hr>
<div class="konten">
<?php
include "../koneksi.php";
?>
<form id="form1" name="form1" method="post" action="simpan_kaidah_produksi.php" enctype="multipart/form-data"><div>
  <table class="tab" width="650" border="0" align="center" cellpadding="4" cellspacing="1" bordercolor="#F0F0F0" bgcolor="#CCCC99">
      <tr bgcolor="#FFFFFF">
        <td>Kode Rule</td>
        <td>&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="2"><strong>IF</strong><ul style="list-style:none;"> <?php
	include "../koneksi.php";
	$arrPenyakit=array(); $arrGejala=array();
	$query=mysql_query("SELECT * FROM tb_gejala") or die("Query Error..!" .mysql_error);
	while ($row=mysql_fetch_array($query)){
		$arrGejala["$row[id]"]=$row['kdgejala'].",".$row['gejala'];
	?>
    	<li><input type="checkbox" name="gejala[]" id="gejala" value="<?php echo $row['id'];?>">
    	<?php echo $row['kdgejala'] ."<strong>|&nbsp;</strong>".$row['gejala'];?><strong>&nbsp;&nbsp;AND</strong></li>
		 <?php } ?></ul><strong>&nbsp;&nbsp;THEN
		 <select name="TxtKdPenyakit" id="TxtKdPenyakit">
		   <option value="NULL">[ Daftar Penyakit ]</option>
		   <?php 
	$sqlp = "SELECT * FROM tb_penyakit ORDER BY id";
	$qryp = mysql_query($sqlp, $koneksi) 
		    or die ("SQL Error: ".mysql_error());
	while ($datap=mysql_fetch_array($qryp)) {
		if ($datap['id']==$kdsakit) {
			$cek ="selected";
		}
		else {
			$cek ="";
		}
		$arrPenyakit["$datap[id]"]=$datap['nama_penyakit'];
		echo "<option value='$datap[id]' $cek>$datap[id]&nbsp;|&nbsp;$datap[nama_penyakit]</option>";
	}
  ?>
		   </select>
		 Densitas (m)<input type="text" name="cf" size="5"></strong></td>
        </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;</td>
        <td><input type="reset" name="Submit2" value="Reset" /><input type="submit" name="Submit" value="Set Rule" /></td>
      </tr>
    </table>
  </div>
</form>
<table width="100%" border="0" cellpadding="4" cellspacing="1" bordercolor="#F0F0F0" >
  <tr>
    <td width="61"><strong>KD Gejala</strong></td>
    <td width="725"><strong>Nama Gejala</strong><span style="float:right; margin-right:25px;"><strong></strong></span></td>
    <?php $query_p=mysql_query("SELECT id_problem FROM tb_rules GROUP BY id_problem");
	while($data_p=mysql_fetch_array($query_p)){
	?>
    <td width="88" ><?php $idp=$data_p['id_problem']; echo "$idp | "; print_r($arrPenyakit["$idp"]); ?><br><a href="edit_rule_base.php?kdpenyakit=<?php echo $data_p['id_problem'];?>">Edit Rule</a></td><?php }?>
    </tr>
    <?php
    $query=mysql_query("SELECT * FROM tb_rules GROUP BY id_evidence ORDER BY id_evidence ASC ")or die(mysql_error());
	$no=0;
	while($row=mysql_fetch_array($query)){
	$idpenyakit=$row['id_problem'];
	$no++;
	?>
  <tr bgcolor="#FFFFFF" bordercolor="#333333">
    <td valign="top"><?php echo $row['id_evidence'];?></td>
    <td><?php $idG=$row['id_evidence']; print_r($arrGejala["$idG"]);// echo $row['gejala'];?></td><?php $query_pb=mysql_query("SELECT id_problem FROM tb_rules GROUP BY id_problem ");
	while($data_pb=mysql_fetch_array($query_pb)){
	?>
    <td><?php $kdpenyakit_B=$data_pb['id_problem'];
	$kdgejala_B=$row['id_evidence'];
	$query_CG=mysql_query("SELECT * FROM tb_rules WHERE id_problem='$kdpenyakit_B' AND id_evidence='$kdgejala_B' ");
	while($data_GB=mysql_fetch_array($query_CG)){ echo "<center>&#8730;</center>";
	echo "<center><strong><a title='Edit Nilai Densitas Pada Tiap Gejala' href='edit_cf.php?id_problem=$kdpenyakit_B&id_evidence=$kdgejala_B&cf=$data_GB[cf]'>cf=$data_GB[cf]</a></strong></center>"; }
	?></td><?php }?>
    </tr>
  <?php } ?>
</table>
</div>
</body>
</html>