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
}