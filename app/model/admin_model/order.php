<?php
class order_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function select_orderAjax($lim, $offs, $sortby = null, $sort_order = null, $whereAt = null) {
		$queryStr = "SELECT * FROM `$this->tbl` ";
		if (!is_null($whereAt) && $whereAt != "") {
			$queryStr .= "WHERE $sortby <= (SELECT `$sortby` FROM `$this->tbl` WHERE id = $whereAt) ";
			$queryStr .= "AND id <= $whereAt ";
		} 
		if (!is_null($sortby) && !is_null($sort_order)) {
			$queryStr .= "ORDER BY $sortby $sort_order, `id` $sort_order ";
		}
		$queryStr .= "LIMIT :lim OFFSET :offs";
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
	public function rq_new_ord($c) {
		$c_str = "";
		$c['d'] = filter_var($c['d']);
		$td = date('Y-m-d H:i:s');
		$yd = date('Y-m-d H:i:s', strtotime('-'.$c['d'].' days'));

		foreach ($c['b']  as $k => $v) $c['b'][$k] = filter_var($v);
		for ($i = 0; $i < count($c['c']); $i++) {
			$c_str .= filter_var($c['c'][$i]).($i == count($c['c']) - 1 ? "" : ",");
		}
		$queryStr = "SELECT ".$c_str." FROM `$this->tbl` WHERE ";
		$queryStr .= "`time_order` <= '".$td."' AND `time_order` >= '".$yd."' ORDER BY time_order DESC ";
		$queryStr .= "LIMIT ".$c['b']["lmt"]." OFFSET ".$c['b']["ofs"];
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
	public function rq_new_ord_2($c) {
		$c_str = "";
		$c['d'] = filter_var($c['d']);
		foreach ($c['b']  as $k => $v) $c['b'][$k] = filter_var($v);
		for ($i = 0; $i < count($c['c']); $i++) {
			$c_str .= filter_var($c['c'][$i]).($i == count($c['c']) - 1 ? "" : ",");
		}
		$queryStr = "SELECT ".$c_str." FROM `$this->tbl` WHERE ";
		$queryStr .= "DATE(`time_order`) > (NOW() - INTERVAL ".$c['d']." DAY) ORDER BY time_order ASC ";
		$queryStr .= "LIMIT ".$c['b']["lmt"]." OFFSET ".$c['b']["ofs"];
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
	public function get_maxNew_ord() {
		$queryStr = "SELECT COUNT(*) FROM `$this->tbl` WHERE view = '0'";
		$this->db->query($queryStr);
		return $this->db->single();
	}
	public function seen_order_ntf() {
		$queryStr = "UPDATE `$this->tbl` SET `view` = '1' WHERE `view` = '0'";
		$this->db->query($queryStr);
		try {
			$this->db->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		return $this->db->rowCount();
	}
	public function count_all_order() {
		$queryStr = "SELECT COUNT(*) FROM `$this->tbl`";
		$this->db->query($queryStr);
		return $this->db->single();
	}
	public function check_new_order($id) {
		$queryStr = "SELECT * FROM `$this->tbl` WHERE view = '0' AND id >= :id";
		$queryStr .= " ORDER BY time_order DESC";
		$this->db->query($queryStr);
		$this->db->bind(":id",$id);
		return $this->db->resultset();
	}
}