<html>
	<head>
		<title>Kurs BCA</title>
		<link rel="stylesheet" href="asset/css/navbar-fixed-top.css">
		<script src="asset/js/jquery-1.9.0.min.js"></script>
		<script src="asset/js/bootstrap.js"></script>
		<style>
			.table-wrap2{max-height: 200px;width:30%;overflow-y:auto;overflow-x:hidden;}
		</style>
	</head>	
	<body >
		<center><h3>Kurs Mata Uang BCA </h3></center>	
	</body>
	
<?php
	function bacaHTML($url){
		$data = curl_init();
		curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($data, CURLOPT_URL, $url);
		$hasil = curl_exec($data);
		curl_close($data);
		return $hasil;
	}
	$kodeHTML =  bacaHTML('http://www.klikbca.com/');
	$pecah = explode('<table width="139" border="0" cellspacing="0" cellpadding="0">', $kodeHTML);
	$pecahLagi = explode('</table>', $pecah[2]);

	echo "<div align='center'> <h3>Kurs BCA</h3></div>";
	echo "<table  border='1' align='center' cellpadding='4' cellspacing='0' class='table-wrap2'>";
	echo "<tr><td>KURS</td><td>JUAL</td><td>BELI</td></tr>";
	echo $pecahLagi[0];
	echo "</table>";
	
?>
<br><center><input type="button" value="Lihat Data Buku" onClick=top.location="index.php"></center>

