<?php
require_once 'adodb/adodb.inc.php';

/**
* Books
*/
class Books
{

	function __construct()
	{
		$this->db = NewADOConnection('mysqli');
		$this->db->Connect('localhost','root','','books');
	}

	function get_book_by_id($id_book="")
	{
		$books  = $this->db->Execute("SELECT * FROM books WHERE id_book LIKE ?","%$id_book%");
		return json_encode($books->GetAssoc());
		 
	}
	
	
}


?>