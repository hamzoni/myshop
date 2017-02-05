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
	public function countRecord() {
		$queryStr = "SELECT COUNT(*) FROM `$this->tbl`";
		$this->db->query($queryStr);
		return reset($this->db->resultset()[0]);
	}
	public function chkClientData($tokenKey) {
		if ($this->countRecord() == 0) return false;
		$r = $this->getClientData($tokenKey);
		if (count($r) != 0) {
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
			'tokenKey' => ':ctkey'
		];
		$setStr = ""; $c = 0;
		foreach ($bindStr as $k => $v) {
			if ($k != 'tokenKey') {
				$setStr .= " `$k` = $v ".($c++ < 3 ? "," : "");
			}
		}
		$queryStr = "UPDATE `$this->tbl`
			SET $setStr
			WHERE `tokenKey` = :ctkey";
		$this->db->query($queryStr);
		foreach ($cData as $k => $v) {
			$this->db->bind($bindStr[$k],$v);
		}
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function insert_clientInfo($cData) {
		$qrtr["col"] = ""; $qrtr["val"] = ""; $c = 0;
		foreach ($cData as $k => $v) {
			$qrtr["col"] .= "$k".($c < 4 ? "," : ""); 
			$qrtr["val"] .= ":$k".($c < 4 ? "," : "");
			$c++;
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
}