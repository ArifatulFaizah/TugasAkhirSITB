<!DOCTYPE html>
<html>
	<head>
		<!-- Bootstrap -->
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="asset/css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<title>Catalog Books</title>
	</head>
<?php

    require_once('nusoap/lib/nusoap.php');
    $client = new nusoap_client('http://localhost/buku/server.php');
    if (isset($_POST['submit']))
    {
       
        $id_book = $_POST['id_book'];
        $author = $_POST['author'];
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $price = $_POST['price'];
        $publish_date = date("Y-m-d H:i:s");
        $description = $_POST['description'];
        

        //$fotokereta = $_POST['fotokereta'];
error_reporting(E_ALL ^ E_DEPRECATED);
        $result = $client->call('tambah_buku', array('id_book' => $id_book, 'author' => $author, 'title' => $title, 'genre' => $genre, 'price' => $price, 'publish_date' => $publish_date, 'description' => $description));
 
        if ($result == true){
            echo '<script> alert("Berhasil Tambah Data."); window.location.replace("index.php");</script>';
        } else {

            mysql_error($result);
    

        }

    } 

?>
<body>
	<center><h3>Tambah Data Buku</h3></center><br>	
	<center><a href="index.php">Lihat Buku</a></center>
           <div class="row">
			<div class="span11">
				<div class="navbar">     
<form name="contactform" id="contactform" action="" method="post">
	<br><table class="table table-hover" align="center">
		<tr class="success">
			<td><b>Id Book</b></td>
			<td><input type="text" name="id_book" id="id_book"></td>
		</tr>
		<tr class="success">
			<td><b>Author</b></td>
			<td><input type="text" name="author" id="author"></td>
		</tr>
		<tr class="success">
			<td><b>Title</b></td>
			<td><input type="text" name="title" id="title"></td>
		</tr>
		<tr class="success">
			<td><b>Genre</b></td>
			<td><input type="text" name="genre" id="genre"></td>
		</tr>
		<tr class="success">
            <td><b>Price</b></td>
            <td><input type="text" name="price" id="price"></td>
		</tr>
        <tr class="success">
            <td><b>Publish Date</b></td>
            <td><input type="text" name="publish_date" id="date" value="<?php echo date("Y-m-d"); ?>"></td>
        </tr>
        <tr class="success">
            <td><b>Description</b></td>
            <td><input type="text" name="description" id="description"></td>
        </tr>
		<tr>
			<td><center><input type="submit" class="btn btn-warning" id="submit" name="submit" value="Tambah Data"></center></td>
		</tr>
	</table>
</form>
</div>
</div>
</div>
</body>
</html>