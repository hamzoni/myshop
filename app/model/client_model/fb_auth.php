<?php
class fb_auth_c extends general_c {
	public function __construct($tbl) {
		$this->db = new Database();
		$this->tbl = $tbl;
	}
	function check_user_exist($userData = array()) {
		if (!empty($userData)) {
			$queryStr =  "SELECT * FROM ".$this->tbl." 
				WHERE oauth_provider = '".$userData['oauth_provider']."' 
				AND oauth_uid = '".$userData['oauth_uid']."'";
			$this->db->query($queryStr);
			$this->db->resultset();
			$r = $this->db->rowCount();
			return $r != 0;
		}
	}
	function update_user_data($userData = array()) {
		if (!empty($userData)) {
			$queryStr = "UPDATE ".$this->tbl." 
				SET first_name = '".$userData['first_name'].
				"', last_name = '".$userData['last_name'].
				"', email = '".$userData['email'].
				"', gender = '".$userData['gender'].
				"', locale = '".$userData['locale'].
				"', picture = '".$userData['picture'].
				"', link = '".$userData['link'].
				"', modified = '".date("Y-m-d H:i:s").
				"' WHERE oauth_provider = '".$userData['oauth_provider'].
				"' AND oauth_uid = '".$userData['oauth_uid']."'";
			$this->db->query($queryStr);
			$this->db->execute();
		}
	}
	function insert_user_data($userData = array()) {
		if (!empty($userData)) {
			$queryStr = "INSERT INTO ".$this->tbl." 
				SET oauth_provider = '".$userData['oauth_provider'].
				"', oauth_uid = '".$userData['oauth_uid'].
				"', first_name = '".$userData['first_name'].
				"', last_name = '".$userData['last_name'].
				"', email = '".$userData['email'].
				"', gender = '".$userData['gender'].
				"', locale = '".$userData['locale'].
				"', picture = '".$userData['picture'].
				"', link = '".$userData['link'].
				"', created = '".date("Y-m-d H:i:s").
				"', modified = '".date("Y-m-d H:i:s")."'";
			$this->db->query($queryStr);
			$this->db->execute();
		}
	}
}
?>