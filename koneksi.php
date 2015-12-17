<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "books";

error_reporting(E_ALL ^ E_DEPRECATED);
mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");
?>