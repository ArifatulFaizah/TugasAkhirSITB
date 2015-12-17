
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
	<body>
						
			<?php require_once 'client.php' ?>
			<?php if($id_book=='') { 
			
			/* $link=mysql_connect('localhost','root','');
			if (!$link)
			{
				die("Koneksi dengan MySQL gagal");
			}
			$result=mysql_query('USE books ');
			if (!$result)
			{
				die("Database books gagal digunakan");
			} */
			include ('koneksi.php');
			$result=mysql_query('SELECT * FROM books');
		?>
		<div class="row">
			<div class="span1"></div>
			<div class="span11">
				<div class="navbar">
				<h3><center>Selamat Datang di Catalog Books</center></h3>
				<h3><center>Kurs BCA</center></h4>
				
				</div>
				<!-- form pencarian data -->
				<form method="post" align="center" action="index.php?op=search" class="input input-block-level">
					<input type="text" name="key"> <input type="submit" name="submit" value="Search" class="btn btn-warning">
				</form>
				<?php
					$no=1;
					$sqlCount = "select count(id_book) from books";
					$query = mysql_query($sqlCount) or die(mysql_error());
					$rsCount = mysql_fetch_array($query);
					$banyakData = $rsCount[0];
					$page = isset($_GET['page']) ? $_GET['page'] : 1;
					$limit = 5;
					$mulai_dari = $limit * ($page - 1);
					$sql_limit = "select * from books order by id_book limit $mulai_dari, $limit";
					$hasil = mysql_query($sql_limit) or die(mysql_error());
					if(mysql_num_rows($hasil)==0){
						echo "<p class='message'>Data tidak ditemukan!</p>";
					}
				?>
				
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

if (isset($_POST['hapus_id_book'])) {

    $id_book = $_POST['hapus_id_book'];

    require_once('nusoap/lib/nusoap.php');
    $client = new nusoap_client('http://localhost/buku/server.php');
    $result = $client->call('hapus_buku', array('id_book' => $id_book));

    if ($result == true)
    {

        echo '<script> alert("Record has been successfully deleted"); window.location.replace("");</script>';

    } else {
        mysql_error($result);
        echo '<script> alert("Failed, record has not been deleted"); window.location.replace("");</script>';

    }

/*header("Location: {$_SERVER['HTTP_REFERER']}");*/

}

?>
				
				<?php
				
					if (isset($_GET['op']))
					{
						if ($_GET['op'] == 'search')
					{
						$key = $_POST['key'];
					
						$query = "SELECT * FROM books WHERE id_book = '$key' OR author LIKE '%$key%' OR title LIKE '%$key%'";
						$result = mysql_query($query);
				
							echo "<center><table class='table table-hover'></center>";
							echo "<tr class='success'><th>Id Buku</th><th>Penulis</th><th>Judul Buku</th><th>Action</th></tr>";
							
							while($data = mysql_fetch_array($result))
							{
							echo "<tr class='success'> ";?>
									<td><a href="?id_book=<?= $data['id_book'] ?>"><?php echo $data['id_book'];?></a></td>
							<?php
							echo "
								<td>".$data['author']."</td>
								<td>".$data['title']."</td>";?>
								<td>
									<div class="row">
										<center>
										<div class="col-xs-12">
											<form action="edit.php" method="post">
												<button id='submit' type='submit' name="id_book" value="<?php echo $data['id_book']; ?>" class="btn btn-warning">Edit</button>
											</form>
											<form action='hapus.php' method='post'>
												<button id='submit' type='submit' name="hapus_id_book" value="<?php echo $data['id_book']; ?>" class="btn btn-danger" onclick="return confirm('Hapus Data Buku  <?php echo $data['id_book']; ?>?')">Delete</button>
											</form>
										</div>
										</center>
									</div>
								</td>
								<?php
								echo "</tr>";
							}
							echo "</table>";
							// menampilkan jumlah data hasil pencarian
							echo "<center><br><p>Ditemukan ".count($result)." data terkait kata kunci '".$key."'</p></br></center>";
						
					}}
					?>
					
				<input type="button"  value="Tambah Buku" onClick=top.location="tambah.php" class="btn btn-warning pagination">
				<input type="button"  value="Kurs BCA" onClick=top.location="kursbca.php" class="btn btn-warning"><br><br>	
					
				<table class="table table-hover">
					<thead>
						<tr class="success">
							<td><b>No</b></td>
							<td><b>Id Buku</b></td>
							<td><b>Penulis</b></td>
							<td><b>Judul Buku</b></td>
							<td><b>Action</b></td>
						</tr>
					</thead>
					<tbody>
						<?php $no=$no+(($page-1)*$limit);
							//Buang field ke dalam array
							while ($data=mysql_fetch_array($hasil)){
						?>
						<tr class="success">
							<td><?php echo $no;?></td>
							<td><a href="?id_book=<?= $data[0] ?>"><?php echo $data[0];?></td>
							<td><?php echo $data[1]; ?></td>
							<td><?php echo $data[2]; ?></td>
							<td>
                                <div class="row">
                                    <center>
                                    <div class="col-xs-12">
                                        <form action="edit.php" method="post">
                                            <button id='submit' type='submit' name="id_book" value="<?php echo $data['id_book']; ?>" class="btn btn-warning">Edit</button>
                                        </form>
                                        <form action='hapus.php' method='post'>
                                            <button id='submit' type='submit' name="hapus_id_book" value="<?php echo $data['id_book']; ?>" class="btn btn-danger" onclick="return confirm('Hapus Data Buku  <?php echo $data['id_book']; ?>?')">Delete</button>
                                        </form>
                                     </div>
                                    </center>
                                </div>
							</td>
						</tr>
						<?php $no++;
							}?>
					</tbody>
						
				</table>
						
				<?php {}?>
			
				<center><div class="pagination pagination-right">
					<?php
						$banyakHalaman = ceil($banyakData / $limit);
						echo 'Page ';
						for($i = 1; $i <= $banyakHalaman; $i++){
							if($page != $i){
								echo '<a href="index.php?page='.$i.'">'.$i.' </a> ';
							}else{
								echo "$i ";
							}
						}
					?>
				</div></center>
				
			</div>
		</div>
				
	<?php }else{ ?>
		<center><h3>Selamat Datang di Catalog Books </h3></center>
		<center><h3>Detail Buku </h3></center><br><br>	
		
<!--<table border="1" align="center" cellpadding="4" cellspacing="0" >-->
  <?php foreach ($data as $key => $books) { ?>

  <table class="table table-hover">
	 <tr class="success">
      <td align="center"><b>ID Book</b></td>
      <td><?php echo $books->id_book?></td>
    </tr>
    <tr class="success">
      <td align="center"><b>Author</b></td>
      <td><?php echo $books->author?></td>
    </tr>
    <tr class="success">
      <td align="center"><b>Title Book</b></td>
      <td><?php echo $books->title?></td>
    </tr>
    <tr class="success">
      <td align="center"><b>Genre</b></td>
      <td><?php echo $books->genre?></td>
    </tr>
    <tr class="success">
      <td align="center"><b>Price</b></td>
      <td><?php echo $books->price?></td>
    </tr>
	<tr class="success">
      <td align="center"><b>Publish Date</b></td>
      <td><?php echo $books->publish_date?></td>
    </tr>
	<tr class="success">
      <td align="center"><b>Description</b></td>
      <td><?php echo $books->description?></td>
    </tr>
	<tr class="success">
      <td align="center"><b>Action</b></td>
      <td>
		<form action="index.php">
			<button class="btn btn-warning label-warning"><font>Kembali</font></button>                                                    
		</form>
		
		<form action="edit.php" method="post">
		 <button id='submit' type='submit' name="id_book" value="<?php echo $id_book; ?>" class="btn btn-warning">><a href="?id_book=<?= $data['id_book'] ?>"><?php echo $data['id_book'];?></a><font>Edit</font></button>                                                    
		</form>
		<form action='hapus.php' method='post'>
            <button id='submit' type='submit' name="hapus_id_book" value="<?php echo $id_book; ?>" class="btn btn-danger" onclick="return confirm('Hapus Data Buku <?php echo $id_book; ?> ?')"><font>Delete</font></button>
        </form>
    </tr>
	</table>
 <?php } ?>

<?php }?>
	</body>
</html>