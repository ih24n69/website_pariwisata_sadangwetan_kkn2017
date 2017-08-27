<?php
	require_once "koneksi.php";
	$sql 	= "select * from tbl_kontak_perangkat";
	$query	= $connection->query($sql);
		while ($row = mysqli_fetch_assoc($query)){
			$data[] = $row;
		}
?>