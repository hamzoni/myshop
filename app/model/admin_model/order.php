<?php
class order_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function select_orderAjax($lim, $offs, $sortby = null, $sort_order = null, $whereAt = null) {
		$queryStr = "SELECT * FROM `$this->tbl` ";
	
		if (!is_null($whereAt) && $whereAt != "") $queryStr .= "WHERE id <= $whereAt";
		if (!is_null($sortby) && !is_null($sort_order)) {
			$queryStr .= " ORDER BY $sortby $sort_order";
		}
		$queryStr .= " LIMIT :lim OFFSET :offs";

		$this->db->query($queryStr);
		$this->db->bind(":lim",$lim);
		$this->db->bind(":offs",$offs);
		$row = $this->db->resultset();
		return $row;
	}
	public function edit_specific_field($id, $fn, $val) {
		$queryStr = "UPDATE `$this->tbl` SET $fn = :val WHERE id = :id";
		$this->db->query($queryStr);
		$this->db->bind(":val",$val);
		$this->db->bind(":id",$id);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->rowCount();
	}
	public function remove_record($id) {
		$queryStr = "DELETE FROM `$this->tbl` WHERE id = :id";

		$this->db->query($queryStr);
		$this->db->bind(":id",$id);
		try {
			$this->db->execute();
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return $this->db->rowCount();
	}
	public function edit_order($n, $p, $a, $id) {
		$queryStr = "UPDATE `$this->tbl` SET name = :n , phone = :p, address = :a WHERE id = :id";
		$this->db->query($queryStr);
		$this->db->bind(":n",$n);
		$this->db->bind(":p",$p);
		$this->db->bind(":a",$a);
		$this->db->bind(":id",$id);
		try {
			$this->db->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		return $this->db->rowCount();
	}
}