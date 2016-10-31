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
	public function select_byGenre($orderBy,$sortType = 1,$lim = 10,$condition = null) {
		$queryStr = "SELECT * FROM `$this->tbl` ";
		null !== $condition ? $queryStr .= $queryStr."WHERE :cond=:cval " : $queryStr .= "";
		$queryStr .= "ORDER BY :orderBy ".($sortType == 1 ? 'DESC' : 'ASC');
		$queryStr .= " LIMIT :lim";
		$this->db->query($queryStr);
		$this->db->bind(":lim", $lim);
		$this->db->bind(":orderBy", $orderBy);
		if (null !== $condition) {
			$this->db->bind(":cond",$condition[0]);
			$this->db->bind(":cval",$condition[1]);
		}
		$rows = $this->db->resultset();
		return $rows;
	}
}