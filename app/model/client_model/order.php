<?php
class order_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function insert_order($name, $phone, $address,$tokenKey, $totalBill) {
		$queryStr = "INSERT INTO `$this->tbl`(name,phone,address,tokenKey,totalValue) VALUES(:cname, :cphone, :caddress, :ctokenKey, :totalBill)";
		$this->db->query($queryStr);
		$this->db->bind(":cname",$name);
		$this->db->bind(":cphone",$phone);
		$this->db->bind(":caddress",$address);
		$this->db->bind(":ctokenKey",$tokenKey);
		$this->db->bind(":totalBill",$totalBill);
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
		if ($qd["sort"]) $queryStr .= " ORDER BY ".$qd["sort"][0]." ".$qd["sort"][1];
		if ($qd["mere"]) $queryStr .= " LIMIT ".$qd["mere"][0]." OFFSET ".$qd["mere"][1];
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
	public function edit_display($dpl_v,$ord_id) {
		$ord_id = filter_var($ord_id);
		$queryStr = "UPDATE `$this->tbl` SET display = '$dpl_v' WHERE id = $ord_id";
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
		if (@$c[1]) $queryStr .= " AND ".$c[1][0]." = '".$c[1][1]."'";
		$this->db->query($queryStr);
		return $this->db->single();
	}
}