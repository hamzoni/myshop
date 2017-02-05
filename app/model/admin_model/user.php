<?php
class user_c extends order_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function update_client_status($id, $val) {
		$queryStr = "UPDATE `$this->tbl` SET status = :val WHERE id = :id";
		$this->db->query($queryStr);
		$this->db->bind(":id",$id);
		$this->db->bind(":val",$val,PDO::PARAM_STR);
		try {
		   $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->rowCount();
	}
}