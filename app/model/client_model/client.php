<?php
class client_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function chkClientData($tokenKey) {
		$queryStr = "SELECT * FROM `$this->tbl` WHERE `tokenKey` = :tokenKey";
		$this->db->query($queryStr);
		$this->db->bind(":tokenKey",$tokenKey);
		$row = $this->db->resultset();
		return $row;
	}
}