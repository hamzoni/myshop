<?php
class AUTH extends general {
	public function __construct($user) {
		$this->user = $user;
		$this->cBaseURL = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
	}
	public function check_login() {
		if (@!$_SESSION[$this->user."_login"]) {
			header("Location: ".$this->cBaseURL);
			exit(0);
		}
	}
	public function create_login($data) {
		$_SESSION[$this->user."_login"] = ["time" => $data, 
											"url" => $this->cBaseURL.$this->user];
		return $_SESSION[$this->user."_login"]["url"];
	}
	public function logout() {
		unset($_SESSION[$this->user."_login"]);
	}
}