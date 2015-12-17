<?php
	header('Content-Type: text/xml; charset=ISO-8859-1');
	include "koneksi.php";
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$path = $_SERVER[PATH_INFO];
	if ($path != null) {
		$path_params = preg_spliti('/[/]/', $path);
	}
 
// METODE REQUEST untuk POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents("php://input");
    $xml = simplexml_load_string($input);
    foreach ($xml->book as $book) {
        $querycek = "SELECT * FROM books WHERE id_book ='$book->id_book'";
        $num_rows = mysql_num_rows($querycek);
 
        if ($num_rows == 0)
        {
            $query = "INSERT INTO books (
                id_book,
                author,
                title,
                genre,
                price,
                publish_date,
                description)
                VALUES (                
                '$book->id_book',
                '$book->author',
                '$book->title',
                '$book->genre',
                '$book->price',
                '$book->publish_date',               
                '$book->description')";
 
        }
        else if ($num_rows == 1)
        {
            $query = "UPDATE books SET
 
                author = '$book->author',
                title = '$book->title',
                genre = '$book->genre',
                price = '$book->price',
                publish_date = '$book->publish_date',
                description = '$book->description'
                WHERE id_book = '$book->id_book'";
 
        }
        $result = mysql_query($query) or die('Query failed: ' . mysql_error());
    }
 
// METODE REQUEST untuk DELETE
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $input = file_get_contents("php://input");
    $xml = simplexml_load_string($input);
    foreach ($xml->book as $book) {
        $query = "DELETE FROM books WHERE id_book='$book->id_book'";
        $result = mysql_query($query) or die('Query failed: ' . mysql_error());
 
    }
 
// METODE REQUEST untuk GET
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($path_params[1] != null) {
            $query = "SELECT 
                id_book,
                author,
                title,
                genre,
                price,
                publish_date,
                description
                FROM books WHERE id_book = $path_params[1]";
    } else {  
        $query = "SELECT 
                id_book,
                author,
                title,
                genre,
                price,
                publish_date,
                description
                FROM books ";
    }
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());
 
    echo "<data>";
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        echo "<book>";
        foreach ($line as $key => $col_value) {
            echo "<$key>$col_value</$key>";
        }
        echo "</book>";
    }
    echo "</data>";
 
    mysql_free_result($result);
}
 
mysql_close($link);
 
?>
