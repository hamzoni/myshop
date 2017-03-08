<?php
class user_c extends order_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	public function update_client_status($id, $val) {
		$queryStr = "UPDATE `$this->tbl` SET status = :val WHERE id = :id";
		$this->db->query($queryStr);
		$this->db->bind(":id",$id);
		$this->db->bind(":val",$val,PDO::PARAM_STR);
		try {
		   $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->rowCount();
	}
	public function ban_exist($userID) {
		$queryStr = "SELECT COUNT(*) FROM `$this->tbl` WHERE user_id = :id";
		$this->db->query($queryStr);
		$this->db->bind("id",$userID);
		return $this->db->single();
	}
	public function add_ban($userID,$startD, $endD,$periodic,$permanent) {
		$permanent = filter_var($permanent);
		$queryStr = "INSERT INTO `$this->tbl`
		(start_date,end_date,user_id,periodic,permanent) 
		VALUES(:startD,:endD,:userID,:periodic,'$permanent')";
		$this->db->query($queryStr);
		$this->db->bind("startD",$startD);
		$this->db->bind("endD",$endD);
		$this->db->bind("userID",$userID);
		$this->db->bind("periodic",$periodic);
		try {
		   $this->db->execute();
		} catch (Exception $e) {
		    return $e->getMessage();
		}
		return $this->db->rowCount();
	}
	public function update_ban($userID,$startD,$endD,$periodic,$permanent) {
		$permanent = filter_var($permanent);
		$queryStr = "UPDATE `$this->tbl`
		SET start_date=:startD,
			end_date=:endD,
			periodic=:periodic,
			permanent='$permanent' 
		WHERE user_id = :userID";
		$this->db->query($queryStr);
		$this->db->bind("startD",$startD);
		$this->db->bind("endD",$endD);
		$this->db->bind("userID",$userID);
		$this->db->bind("periodic",$periodic);
		$this->db->execute();
		return $this->db->rowCount();
	}
	public function select_ban_list() {
		$queryStr = "SELECT * FROM `$this->tbl`";
		$this->db->query($queryStr);
		return $this->db->resultset();
	}
	public function lift_ban($user_id) {
		$queryStr = "DELETE FROM `$this->tbl` WHERE user_id = :user_id";
		$this->db->query($queryStr);
		$this->db->bind('user_id',$user_id);
		$this->db->execute();
		return $this->db->rowCount();
	}
}