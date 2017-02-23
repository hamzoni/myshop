<?php
class product_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function select_prdPager($limit = 12,$offset) {
		$queryStr = "SELECT * FROM `$this->tbl` LIMIT :lim OFFSET :offset";
		$this->db->query($queryStr);
		$this->db->bind(":lim" , $limit);
		$this->db->bind(":offset" , $offset);
		$rows = $this->db->resultset();
		return $rows;
	}
	public function select_byGenre($orderBy = null,$sortType = 1,$lim = null,$cond = [null,null]) {
		$queryStr = "SELECT * FROM `$this->tbl` ";
		if ($cond[0] !== null && !empty($cond[0])) {
			if ($cond[0][0] !== null && !empty($cond[0][0]) && $cond[0][1] !== null & !empty($cond[0][1])) {
				$queryStr .= "WHERE ".$cond[0][0]."='".$cond[0][1]."'";
				if ($cond[1] !== null && !empty($cond[1])) {
					if ($cond[1][0] !== null && !empty($cond[1]) && $cond[1][1] !== null & !empty($cond[1][1])) {
						$queryStr .= " AND ".$cond[1][0]."='".$cond[1][1]."'";
					}
				}
			}
		}
		if ($orderBy !== null) {
			($sortType == 1 ? $dtc = 'DESC' : $dtc = 'ASC');
			$queryStr .= " ORDER BY $orderBy $dtc";
		}
		if ($lim !== null) {
			$queryStr .= " LIMIT $lim";
		}
		$this->db->query($queryStr);
		$rows = $this->db->resultset();
		return $rows;
	}
	public function getMainDishes($lm,$ofs) {
		$queryStr = "SELECT * FROM `$this->tbl` LIMIT $lm OFFSET $ofs";
		$this->db->query($queryStr);
		$rows = $this->db->resultset();
		return $rows;
	}
	public function slc_spec_unique($cols, $cnd, $val) {
		$cols = filter_var(join(",",$cols));
		$cnd = filter_var($cnd);
		$val = filter_var($val);
		$queryStr = "SELECT $cols FROM `$this->tbl` WHERE $cnd = $val";
		$this->db->query($queryStr);
		return $this->db->single();
	}
	public function add_purchase_count($prd_id) {
		$prd_id = filter_var($prd_id);
		$queryStr = "UPDATE `$this->tbl` 
					SET purchase_count = purchase_count + 1 
					WHERE id = :prd_id";
		$this->db->query($queryStr);
		$this->db->bind(":prd_id", $prd_id);
		$this->db->execute();
	}
}