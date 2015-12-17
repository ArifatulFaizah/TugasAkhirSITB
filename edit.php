
<?php

    if (isset($_POST['id_book']) )
    {
        
            $id_book = $_POST['id_book'];
            require_once('nusoap/lib/nusoap.php');
           $client = new nusoap_client('http://localhost/buku/server.php');
            $result = $client->call('books',array('id_book' => $id_book));
            if (is_array($result))
            {

                foreach($result as $data)
                {
                    $id_book = $data['id_book'];
                    $author = $data['author'];
                    $title = $data['title'];
                    $genre = $data['genre'];
                    $price = $data['price'];
                    $publish_date = $data['publish_date'];
                    $description = $data['description'];
                }
              

            } 
            else {

                   
        
                echo "<p>Data tidak ditemukan</p>";
            }

            //}
    } 
   

?>

<?php

    require_once('nusoap/lib/nusoap.php');
    $client = new nusoap_client('http://localhost/buku/server.php');
    // proses call method 'search' dengan parameter key di script server.php yang ada di server A
    if (isset($_POST['submit']))
    {
       $id_book = $_POST['id_book'];
        $author = $_POST['author'];
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $price = $_POST['price'];
        $publish_date = date("Y-m-d H:i:s");
        $description = $_POST['description'];

         $result = $client->call('edit_buku', array('id_book' => $id_book, 'author' => $author, 'title' => $title, 'genre' => $genre, 'price' => $price, 'publish_date' => $publish_date, 'description' => $description));

        if ($result == true){
            echo '<script> alert("Berhasil Edit Data."); window.location.replace("index.php");</script>';
        } else {

            mysql_error($result);
    

        }

    
    } 
	?>
	
<html>
<head>
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="asset/css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">	
	<title> Edit Data Buku </title>
</head>
<body>
			<div class="col-md-9 col-sm-9">
                            <div class="panel panel-default">
                                <div class="panel-heading">
									    <center><h2>Edit Data Buku</h2></center>
										<center><a href="index.php">Kembali (Lihat Data Buku)</a></center>
										
                                </div>
		
		<form name="contactform" id="contactform" action="" method="post">

	<br><table class="table table-hover" align="center">
		<tr class="success">
			<td><b>Id Book</b></td>
			<td><input type="text" required="required" value="<?php echo $id_book; ?>" name="id_book" id="id_book"></td>
		</tr>
		<tr class="success">
			<td><b>Author</b></td>
			<td><input type="text" required="required" value="<?php echo $author; ?>" name="author" id="author"></td>
		</tr>
		<tr class="success">
			<td><b>Title</b></td>
			<td><input type="text" required="required" value="<?php echo $title; ?>" name="title" id="title"></td>
		</tr>
		<tr class="success">
			<td><b>Genre</b></td>
			<td><input type="text" required="required" value="<?php echo $genre; ?>" name="genre" id="genre"></td>
		</tr>
		<tr class="success">
            <td><b>Price</b></td>
            <td><input type="text" required="required" value="<?php echo $price; ?>" name="price" id="price"></td>
		</tr>
        <tr class="success">
            <td><b>Publish Date</b></td>
            <td><input type="text" name="publish_date" id="date" value="<?php echo $publish_date; ?>"></td>
        </tr>
        <tr class="success">
            <td><b>Description</b></td>
            <td><input type="text"  value="<?php echo $description; ?>" name="description" id="description"></td>
        </tr>
		
	</table>
	<div class="panel-footer">
        <div class="row">
            <div class="col-sm-offset-3 col-sm-9" align = "center">
                <button type="submit" name="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save</button>
                <button name="cancel" class="btn btn-danger"><i class="fa fa-close"></i> Cancel</button>
            </div>
        </div>
    </div>
</form>                  
</body>
</html>

