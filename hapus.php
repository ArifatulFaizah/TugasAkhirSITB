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

        echo '<script> alert("Record has been successfully deleted"); window.location.replace("index.php");</script>';

    } else {
        mysql_error($result);
        echo '<script> alert("Failed, record has not been deleted"); window.location.replace("");</script>';

    }

/*header("Location: {$_SERVER['HTTP_REFERER']}");*/

}

?>
