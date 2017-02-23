<?php
class store_c extends general_c{
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function get_store_data($cols = "*", $cnd = null) {
		$c = "";
		if (is_array($cols)) {
			for ($i = 0; $i < count($cols); $i++) {
				$cols[$i] = filter_var($cols[$i]);
				$c .= $cols[$i].($i == count($cols) - 1 ? "" : ",");
			}
		} else {
			$c = $cols;
		}
		$queryStr = "SELECT ".$c." FROM `$this->tbl`";
		if (null !== $cnd) $queryStr .= " WHERE ".$cnd[0]."=".$cnd[1];
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
}