<?php
class client_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function getClientData($tokenKey) {
		$queryStr = "SELECT * FROM `$this->tbl` WHERE `tokenKey` = :tokenKey";
		$this->db->query($queryStr);
		$this->db->bind(":tokenKey",$tokenKey);
		$row = $this->db->resultset();
		return $row;
	}
	public function getClientData_c($tokenKey, $col) {
		$queryStr = "SELECT $col FROM `$this->tbl` WHERE `tokenKey` = :tokenKey";
		$this->db->query($queryStr);
		$this->db->bind(":tokenKey",$tokenKey);;
		return $this->db->single();
	}
	public function countRecord() {
		$queryStr = "SELECT COUNT(*) FROM `$this->tbl`";
		$this->db->query($queryStr);
		return reset($this->db->resultset()[0]);
	}
	public function chkClientData($tokenKey) {
		if ($this->countRecord() == 0) return false;
		$r = $this->getClientData($tokenKey);
		if (count($r) > 0) {
			return true;
		}
		return false;
	}
	public function deleteClientData($tokenKey) {
		$queryStr = "DELETE FROM `$this->tbl` WHERE `tokenKey` = :tokenKey";
		$this->db->query($queryStr);
		$this->db->bind(':tokenKey', $tokenKey);
		$this->db->execute();
	}
	public function updateClientInfo($cData) {
		$bindStr = [
			'name' => ':cname',
			'phone' => ':cphone',
			'address' => ':cAddr',
			'saveData' => ':csave',
			'tokenKey' => ':ctkey',
			'last_update' => ':cLUpd'
		];
		$setStr = "";
		$last_elm = end($bindStr);
		foreach ($bindStr as $k => $v) {
			if ($k != 'tokenKey') {
				$setStr .= " `$k` = $v ".($v != $last_elm ? "," : "");
			}
		}
		$queryStr = "UPDATE `$this->tbl` SET $setStr WHERE `tokenKey` = :ctkey";
		$this->db->query($queryStr);
		foreach ($cData as $k => $v) {
			if (array_key_exists($k, $bindStr)) $this->db->bind($bindStr[$k],$v);
		}
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function insert_clientInfo($cData) {
		$qrtr["col"] = ""; $qrtr["val"] = "";
		$last_elm = end($cData);
		foreach ($cData as $k => $v) {
			$qrtr["col"] .= "$k".($v != $last_elm ? "," : ""); 
			$qrtr["val"] .= ":$k".($v != $last_elm ? "," : "");
		}
		$queryStr = "INSERT INTO `$this->tbl`(".$qrtr['col'].") VALUES(".$qrtr['val'].")";

		$this->db->query($queryStr);
		foreach ($cData as $k => $v) {
			$this->db->bind(":$k",$v);
		}
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->lastInsertId();
	}
	public function update_last_activity($token) {
		$queryStr = "UPDATE `$this->tbl` SET `last_update` = NOW() WHERE `tokenKey`=$token";
		$this->db->query($queryStr);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->rowCount();
	}
	public function upd_client_record($token, $totalBill, $crrPC, $crrPV) {
		$crrPV += intval($totalBill);
		$crrPC += 1;
		$queryStr = "UPDATE `$this->tbl` 
					 SET `purchase_count` = :crrPC , `total_purchaseVal` = :crrPV 
					 WHERE `tokenKey` = :token";
		$this->db->query($queryStr);
		$this->db->bind(':token',$token);
		$this->db->bind(':crrPC',$crrPC);
		$this->db->bind(':crrPV',$crrPV);
		try {
		    $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->rowCount();
	}
}