<?php
include "koneksi.php";

$query = "SELECT * FROM tbl_kontak_perangkat";
$hasil = mysqli_query($conn, $query);

?>

	<h1>Perangkat Desa</h1>
	<legend></legend>
	
	<div class="sand-content">
		<p>
			<table class="fancytable" style="width:100%;">
			<tr>
				<th style="width:15%"><center>FOTO</center></th><th style="width:15%"><center>NAMA</center></th><th style="width:15%"><center>JABATAN</center></th><th style="width:15%"><center>NO.HP</center></th><th style="width:40%"><center>ALAMAT</center></th>
			</tr>
			<?php
				while ($data = mysqli_fetch_array($hasil)) {
					$url=base_url().$data['foto_perangkat'];
					echo '
					<tr style="text-align:center;">
					<td style="width:15%"><a href="'.$url.'" target="_blank"><img src="'.$url.'" style="height:150px; width:130px; padding-bottom:10px"></a></td><td style="width:15%">'.$data["nama_perangkat"].'</td><td style="width:15%">'.$data["jabatan_perangkat"].'</td><td style="width:15%">'.$data["nohp_perangkat"].'</td><td style="width:40%">'.$data["alamat_perangkat"].'</td>
					</br>
					</br>
					</tr>
					';
				}
				echo '</table>';
			?>
		</p>
	</div>
	
<script type="text/javascript" charset="utf-8">			
	function nav_active(){
	var r = document.getElementById("nav-home");
	r.className = "";

	var d = document.getElementById("nav-kontak");
	d.className = d.className + " active";
	}
	
	$(document).ready(function(){  
	//document.getElementById("displayPhoto").src = <?php echo site_url($sejarah);?>;
	}); 
</script>

	