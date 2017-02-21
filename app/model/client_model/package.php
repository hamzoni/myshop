<?php
class package_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function insert_package($p_id, $o_id, $qty, $t_p) {
		$queryStr = "INSERT INTO `$this->tbl`(product_id, order_id, qty, prcTotal) VALUES (:p_id, :o_id, :qty, :prcT)";
		$this->db->query($queryStr);
		$this->db->bind('p_id',$p_id);
		$this->db->bind('o_id',$o_id);
		$this->db->bind('qty',$qty);
		$this->db->bind('prcT',$t_p);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->lastInsertId();
	}
	public function slc_spec($cols, $cnd, $val) {
		$cols = filter_var(join(",",$cols));
		$cnd = filter_var($cnd);
		$val = filter_var($val);
		$queryStr = "SELECT $cols FROM `$this->tbl` WHERE $cnd = $val";
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
}