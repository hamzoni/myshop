<?php
class package_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function insert_package($p_id, $o_id, $qty, $t_p, $cNote,$s_id) {
		$queryStr = "INSERT INTO `$this->tbl`(product_id, order_id, qty, prcTotal, client_note,seller_id) 
					VALUES (:p_id, :o_id, :qty, :prcT, :cNote,:s_id)";
		$this->db->query($queryStr);
		$this->db->bind('p_id',$p_id);
		$this->db->bind('o_id',$o_id);
		$this->db->bind('qty',$qty);
		$this->db->bind('prcT',$t_p);
		$this->db->bind('cNote',$cNote);
		$this->db->bind('s_id',$s_id);
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