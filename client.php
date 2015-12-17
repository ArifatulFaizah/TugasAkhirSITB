<?php
error_reporting(E_ALL);
ini_set('display_error',1);

require_once('nusoap/lib/nusoap.php');
$url = 'http://localhost/buku/server.php?wsdl';
$client = new nusoap_client($url, 'WSDL');
$id_book =  isset($_GET["id_book"]) ? $_GET["id_book"] : '' ;

$result = $client->call('get_book_by_id', array('id_book'=>$id_book));
$data = json_decode($result);



?>

