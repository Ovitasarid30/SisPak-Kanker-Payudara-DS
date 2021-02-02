<html>
<head>
<style type="text/css">
p {text-indent:0pt;}
</style>
<script type="text/javascript">
function konfirmasi(id_rule){
	var kd_hapus=id_rule;
	var url_str;
	url_str="hapus_relasi.php?id_rule="+kd_hapus;
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
<h2>Data Nilai | Basis Pengetahuan</h2><hr>
<div class="konten">
<?php
include "../koneksi.php";
$kd_gejala=$_GET['kd_gejala'];
?>
<form id="form1" name="form1" method="post" action="update_mbmd.php?kd_gejala=<?php echo $kd_gejala;?>" enctype="multipart/form-data"><div>
  
  </div>

<table width="700" border="0" cellpadding="4" cellspacing="1" bordercolor="#F0F0F0" >
  <tr style="background:linear-gradient(to top, #9C0, #CF0);">
    <td width="61"><strong>KD Gejala</strong></td>
    <td width="725"><strong>Nama Gejala</strong><span style="float:right; margin-right:25px;"><strong></strong></span></td>
    <?php $query_p=mysql_query("SELECT kd_penyakit FROM tbrule GROUP BY kd_penyakit");
	while($data_p=mysql_fetch_array($query_p)){
	?>
    <td width="88" ><?php echo $data_p['kd_penyakit'];?><br></td><?php }?>
    <td width="88" align="center">Nilai<br>Belief</td>
    <td width="88" align="center">Nilai<br>Plausability</td>
    <td width="88" align="center">Action</td>
    </tr>
    <?php
    $query=mysql_query("SELECT tbgejala.kd_gejala, tbgejala.gejala, tbrule.id_rule, tbrule.kd_gejala,tbrule.kd_penyakit, tbrule.mb, tbrule.md, tbpenyakit.kd_penyakit, tbpenyakit.nama_penyakit AS penyakit FROM tbrule,tbpenyakit,tbgejala WHERE tbpenyakit.kd_penyakit=tbrule.kd_penyakit AND tbrule.kd_gejala='$kd_gejala' GROUP BY tbrule.kd_gejala")or die(mysql_error());
	$no=0;
	while($row=mysql_fetch_array($query)){
	$idpenyakit=$row['kd_penyakit'];
	$no++;
	?>
  <tr bgcolor="#FFFFFF" bordercolor="#333333">
    <td valign="top"><?php echo $row['kd_gejala'];?></td>
    <td><?php echo $row['gejala'];?></td><?php $query_pb=mysql_query("SELECT kd_penyakit FROM tbrule GROUP BY kd_penyakit");
	while($data_pb=mysql_fetch_array($query_pb)){
	?>
    <td><?php $kd_penyakit_B=$data_pb['kd_penyakit'];
	$kd_gejala_B=$row['kd_gejala'];
	$query_CG=mysql_query("SELECT * FROM tbrule WHERE kd_penyakit='$kd_penyakit_B' AND kd_gejala='$kd_gejala' ");
	while($data_GB=mysql_fetch_array($query_CG)){ echo "&#8730;"; }
	?></td><?php }?>
    <td style="background:linear-gradient(to top, #9C0, #CF0);"><input name="txtMB" type="text" size="2" value="<?php echo $row['mb'];?>"></td>
    <td style="background:linear-gradient(to top, #9C0, #CF0);"><input name="txtMD" type="text" size="2" value="<?php echo $row['md'];?>"></td>
    <td style="background:linear-gradient(to top, #9C0, #CF0);"><input type="submit" value="Update Nilai"></td>
    </tr>
  <?php } ?>
</table></form>
</div>
</body>
</html>