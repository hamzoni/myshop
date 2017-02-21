<?php
class center extends general {
	public $AUTHc;
	public $user;
	public $cBaseURL;
	public function __construct() {
		$this->AUTHc = new AUTH("admin");
		$this->AUTHc->check_login();
	}
}


?>