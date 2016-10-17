<?php
class product_c {
	private $db;
	public function __construct() {
		$this->db = new Database();
	}
	public function insert_record($name,$price,$sale,$ava,$ntr,$type,$dp,$dc) {
		$this->db->query("INSERT INTO `products`(name,price,sale,avatar_img,nutrition_img,type,display) 
			VALUES (:nm,:prc,:sl,:av,:nr,:tp,:dp)");
		$this->db->bind(':nm',$name);
		$this->db->bind(':prc',$price);
		$this->db->bind(':sl',$sale);
		$this->db->bind(':av',$ava);
		$this->db->bind(':nr',$ntr);
		$this->db->bind(':tp',$type);
		$this->db->bind(':dp',$dp);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->lastInsertId();
	}
}