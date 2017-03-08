<?php
class package_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function get_packages($cols = "*") {
		if (is_array($cols)) $cols = join(",",$cols);
		$queryStr = "SELECT $cols FROM `$this->tbl`";
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
	public function select_packageAjax($order_id) {
		$queryStr = "SELECT * FROM `$this->tbl` WHERE order_id = :d";
		$this->db->query($queryStr);
		$this->db->bind(":d",$order_id);
		return $this->db->resultset();
	}
	public function delete_package($fn, $val) {
		$queryStr = "DELETE FROM `$this->tbl` WHERE $fn = :val";
		$this->db->query($queryStr);
		$this->db->bind(":val",$val);
		try {
			$this->db->execute();
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return $this->db->rowCount();
	}
}