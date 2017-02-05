<?php
class order_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function insert_order($name, $phone, $address) {
		$queryStr = "INSERT INTO `$this->tbl`(name,phone,address) VALUES(:cname, :cphone, :caddress)";
		$this->db->query($queryStr);
		$this->db->bind(":cname",$name);
		$this->db->bind(":cphone",$phone);
		$this->db->bind(":caddress",$address);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->lastInsertId();
	}
}