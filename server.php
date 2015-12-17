<?php
error_reporting(E_ALL);
ini_set('display_error',1);

require_once 'nusoap/lib/nusoap.php';
require_once 'adodb/adodb.inc.php';
require_once 'books.php';
$server = new nusoap_server();
$server->configureWSDL('Service Books','urn:books');
$server->wsdl->schemaTargetNamespace = 'urn:books';


$server->register('books', 
	array('input' => 'xsd:String'),
	array('output' => 'xsd:Array'),
	'urn:books',
	'urn:books#books',
	'rpc',
	'encoded',
	'menampilkan data buku'
	);

$server->register('get_book_by_id',
  array(
    'id_book' => 'xsd:string'),
    array(
      'return' => 'xsd:string'
    ),
    'urn:books',
    'urn:books#get_book_by_id',
    'rpc',
    'encoded',
    'get_book_by_id'
  );

$server->register('tambah_buku', 
	array('input' => 'xsd:Array'),
	array('output' => 'xsd:Array'),
	'urn:books',
	'urn:books#tambah_buku',
	'rpc',
	'encoded',
	'tambah_buku'
	);

$server->register('edit_buku', 
	array('input' => 'xsd:Array'),
	array('output' => 'xsd:Array'),
	'urn:books',
	'urn:books#edit_buku',
	'rpc',
	'encoded',
	'edit buku'
	);

$server->register('hapus_buku', 
	array('input' => 'xsd:String'),
	array('output' => 'xsd:Array'),
	'urn:books',
	'urn:books#hapus_buku',
	'rpc',
	'encoded',
	'menghapus data buku'
	);	
	
	function books($id_book)
{

	$query = "SELECT * FROM books where id_book = '$id_book'";
	$hasil = mysql_query($query);
	while ($data = mysql_fetch_array($hasil))
	{
		// menyimpan data hasil pencarian dalam array
		$result[] = array('id_book' => $data['id_book'], 'author' => $data['author'], 'title' => $data['title'], 'genre' => $data['genre'], 'price' => $data['price'], 'publish_date' => $data['publish_date'], 'description' => $data['description']);
	}
	// mereturn array hasil pencarian
	return $result;
}


function edit_buku($id_book, $author, $title, $genre, $price, $publish_date, $description)
{
	$query = "UPDATE books SET author='$author',  title = '$title', genre = '$genre', price = '$price', publish_date = '$publish_date', description = '$description' WHERE id_book = '$id_book'";
	$hasil = mysql_query($query);
	if ($hasil ){

		return true;

	} else{

		return false;

	}
		
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);	

include "koneksi.php";

function get_book_by_id($id_book="") {
  $books = new books();
  return $books->get_book_by_id($id_book);
}


 
/* function get_book_by_id($id_book)
{

	$query = "SELECT * FROM books where id_book = '$id_book'";
	$hasil = mysql_query($query);
	while ($data = mysql_fetch_array($hasil))
	{
		// menyimpan data hasil pencarian dalam array
		$result[] = array('id_book' => $data['id_book'], 'author' => $data['author'], 'title' => $data['title'], 'genre' => $data['genre'], 'price' => $data['price'], 'publish_date' => $data['publish_date'], 'description' => $data['description']);
	}
	// mereturn array hasil pencarian
	return $result;
}  */
function tambah_buku($id_book, $author, $title, $genre, $price, $publish_date, $description)
{
	$query = "INSERT INTO books (id_book, author, title, genre, price, publish_date, description) VALUES ('$id_book', '$author', '$title', '$genre' , '$price', '$publish_date', '$description')";
	$hasil = mysql_query($query);
	
	if ($hasil){

		return true;

	} else {

		return false;

	}
	
}



function hapus_buku($id_book)
{

	$query = "DELETE FROM books where id_book='$id_book'";
	$hasil = mysql_query($query);

	if ($hasil == true ){

		return true;

	} else {

		return false;

	}
}





?>

