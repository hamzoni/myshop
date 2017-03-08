<?php
class order_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function insert_order($x) {
		$c = ["field"=>[],"bindv"=>[],"value"=>[]];
		$i = 0;
		foreach ($x as $k => $v) {
			$c["field"][$i] = $k;
			$c["value"][$i] = $v;
			$c["bindv"][$i] = ":".$k;
			$i++;
		}
		$f_s = join(",",$c["field"]);
		$b_s = join(",",$c["bindv"]);
		$queryStr = "INSERT INTO `$this->tbl`(".$f_s.") VALUES(".$b_s.")";
		$this->db->query($queryStr);
		for ($i = 0; $i < count($c["bindv"]); $i++) 
			$this->db->bind($c["bindv"][$i],$c["value"][$i]);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->lastInsertId();
	}
	public function select_order($qd, $cols = "*") {
		foreach ($qd as $k => $v) {
			$qd[$k][0] = filter_var($qd[$k][0]);
			$qd[$k][1] = filter_var($qd[$k][1]);
		}
		$cols_str = "";
		if ($cols && gettype($cols) == "array") {
			for ($i = 0; $i < count($cols); $i++) {
				$cols_str .= filter_var($cols[$i]).($i == count($cols) - 1 ? "" : ",");
			}
		}
		$queryStr = "SELECT ".$cols_str." FROM `$this->tbl` WHERE ".$qd["cnd1"][0]." = '".$qd["cnd1"][1]."'";
		if ($qd["cnd2"]) $queryStr .= " AND ".$qd["cnd2"][0]." = '".$qd["cnd2"][1]."'";
		if ($qd["cnd3"]) $queryStr .= " AND ".$qd["cnd3"][0]." = '".$qd["cnd3"][1]."'";
		if ($qd["sort"]) $queryStr .= " ORDER BY ".$qd["sort"][0]." ".$qd["sort"][1];
		if ($qd["mere"]) $queryStr .= " LIMIT ".$qd["mere"][0]." OFFSET ".$qd["mere"][1];
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
	public function edit_display($dpl_v,$ord_id) {
		if (is_array($ord_id)) {
			for ($i = 0; $i < count($i); $i++) $ord_id[$i] = filter_var($ord_id[$i]);
		} else {
			$ord_id = filter_var($ord_id);
		}
		
		$queryStr = "UPDATE `$this->tbl` SET display = '$dpl_v' WHERE id ";
		if (is_array($ord_id)) {
			$queryStr .= "IN (".join(",",$ord_id).")";
		} else {
			$queryStr .= "=".$ord_id;
		}
		$this->db->query($queryStr);
		try {
			$this->db->execute();
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return $this->db->rowCount();
	}
	public function count_orders_wCnds($c) {
		for ($i = 0; $i < count($c); $i++) {
			$c[$i][0] = filter_var($c[$i][0]);
			$c[$i][1] = filter_var($c[$i][1]);
		}
		$queryStr = "SELECT COUNT(*) FROM `$this->tbl` WHERE ".$c[0][0]." = '".$c[0][1]."'";
		for ($i = 1; $i < count($c); $i++) {
			if (@$c[1]) $queryStr .= " AND ".$c[$i][0]." = '".$c[$i][1]."'";
		}
		$this->db->query($queryStr);
		return $this->db->single();
	}
	public function getlast_ord_ID() {
		$queryStr = "SELECT id FROM `orders` ORDER BY id DESC LIMIT 1 OFFSET 0";
		$this->db->query($queryStr);
		$rsl = $this->db->single();
		return reset($rsl);
	}
}