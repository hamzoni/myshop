<?php
class general_c {
	protected $db;
	protected $tbl;
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function countAll($groupBy = null) {
		$this->db->query("SELECT COUNT(*) FROM `$this->tbl`"
			.(!is_null($groupBy) ? "GROUP BY $groupBy": ""));
		return $this->db->single();
	}
	public function describeTable() {
		$this->db->query("DESCRIBE  `$this->tbl`");
		return $this->db->resultset();
	}
	public function getField_maxLength($fn,$data_type) {
		$queryStr = "SELECT ".($data_type == "int" ? "NUMERIC_PRECISION" : "CHARACTER_MAXIMUM_LENGTH")." FROM INFORMATION_SCHEMA.COLUMNS 
					  WHERE table_name = '$this->tbl' AND COLUMN_NAME = '$fn';";
		$this->db->query($queryStr);
		return $this->db->single();
	}
	public function getField_maxLengthV2($fn) {
		$queryStr = "SHOW FULL COLUMNS FROM $this->tbl WHERE FIELD = '$fn'";
		$this->db->query($queryStr);
		return $this->db->single();
	}
	public function search_table($cols, $val, $lim = 10,$sort_col = null, $sort_ord = "DESC", $slcDt = "*") {
		$queryStr = "SELECT $slcDt FROM `$this->tbl` WHERE ";
		for ($i = 0; $i < count($cols); $i++) {
			$queryStr .= $cols[$i]." LIKE '%$val%' "
					  .($i == count($cols) - 1 ? "" : "OR ");
		}
		if (null !== $sort_col) $queryStr .= "ORDER BY $sort_col $sort_ord ";
		$queryStr .= "LIMIT $lim ";
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
	public function search_ID($tbl,$id,$slcDt = "*") {
		$queryStr = "SELECT $slcDt FROM $tbl WHERE id = $id";
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
	public function select_random($n, $c) {
		$queryStr = "SELECT * FROM products WHERE `".$c[0]."` = '".$c[1]."' ORDER BY RAND() LIMIT ".$n;
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
	public function get_records($cols = "*",$cnd = null) {
		if (is_array($cols)) $cols = join(",",$cols);
		$queryStr = "SELECT $cols FROM `$this->tbl` ";
		$queryStr .= $this->get_condition($cnd);
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
	public function update_records($c,$v,$cnd) {
		$ss = "";
		if (is_array($c) && is_array($v)) {
			for ($i = 0; $i < count($c); $i++) 
				$c[$i] = filter_var($c[$i]);
				$v[$i] = filter_var($v[$i]);
				$ss = $c[$i]."=".$v[$i];
				$ss .= ($i == count($c) - 1 ? "" : ",");
		} else {
			$c = filter_var($c);
			$v = filter_var($v);
			$ss = $c."=".$v;
		}
		$queryStr = "UPDATE `$this->tbl` SET ".$ss." ";
		$queryStr .= $this->get_condition($cnd);
		$this->db->query($queryStr);
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function get_condition($cnd) {
		$rsl = "";
		if ($cnd) {
			if (@!is_array($cnd[0])) {
				$rsl .= "WHERE ".$cnd[0]."=".$cnd[1];
			} else {
				$rsl .= "WHERE ".$cnd[0][0]."=".$cnd[0][1];
				if (count($cnd) > 1) {
					for ($i = 1; $i < count($cnd); $i++)
					$rsl .= " AND ".$cnd[$i][0]."=".$cnd[$i][1];
				}
			}
		}
		return $rsl;
	}
}