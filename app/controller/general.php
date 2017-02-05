<?php
class general {
	public $AUTHc;
	public $user;
	public $cBaseURL;
	public function is_contain_char($str) {
		return preg_match('/[^\d]+/', $str) > 0;
	}
	function encrypt_file($source,$destination,$passphrase = SPEC_PWD,$stream=NULL) {
		if($stream) {
			$contents = $source;
		}else{
			$handle = fopen($source, "rb");
			$contents = fread($handle, filesize($source));
			fclose($handle);
		}
	 
		$iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
		$key = substr(md5("\x2D\xFC\xD8".$passphrase, true) . md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
		$opts = array('iv'=>$iv, 'key'=>$key);
		if (!@$fp = fopen($destination, 'wb')) return false;
		stream_filter_append($fp, 'mcrypt.tripledes', STREAM_FILTER_WRITE, $opts);
		if (!@fwrite($fp, $contents)) return false;
		fclose($fp);
		return true;
	}
	function decrypt_file($file,$passphrase = SPEC_PWD) {
		$iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
		$key = substr(md5("\x2D\xFC\xD8".$passphrase, true) .
		md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
		$opts = array('iv'=>$iv, 'key'=>$key);
		if(!@$fp = fopen($file, 'rb')) return false;
		stream_filter_append($fp, 'mdecrypt.tripledes', STREAM_FILTER_READ, $opts);
		return $fp;
	}
	// use already set object
	public function access_object() {
		$r = json_decode($_GET["r"], true);
		try {
			echo $this->{$r["obj"]}->{$r["func"]}();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	// use not set object
	public function request_method() {
		$r = json_decode($_GET["r"], true);
		$args = array();
		$args[count($args)] = $r["v"];
		try {
			print_r(call_user_func_array([$r["obj"],$r["func"]],$args));
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function check_pageData() {
		$dt = $this->get_pageData();
		if (@!$dt[PG_D]["VIEWS"][TODAY_DATE]) $dt[PG_D]["VIEWS"][TODAY_DATE] = 0;
		if (@!$dt[PG_D]["TRANSACTIONS"][TODAY_DATE]) $dt[PG_D]["TRANSACTIONS"][TODAY_DATE] = 0;
		if (@!$dt[PG_D]["ACCOUNTS"][TODAY_DATE]) $dt[PG_D]["ACCOUNTS"][TODAY_DATE] = 0;
		if (@!$dt[PG_D]["INCOMES"][TODAY_DATE]) $dt[PG_D]["INCOMES"][TODAY_DATE] = 0;
		$this->put_pageData($dt);
	}
	public function setup_PageData() {
		if (@filesize(PAGE_STATS) == 0 || !file_exists(PAGE_STATS)) {
			$f = fopen(PAGE_STATS, "w+");
			$page_data = [
				PG_D => [
					"VIEWS" => [],
					"TRANSACTIONS" => [],
					"ACCOUNTS" => [],
					"INCOMES" => []
				],
				PG_S => [
					"S_VIEWS" => 0,
					"S_TRANSACTIONS" => 0,
					"S_ACCOUNTS" => 0,
					"S_INCOMES" => 0
				]
			];
			$page_data = json_encode($page_data);
			fwrite($f, $page_data);
			fclose($f);
			return true;
		}
		return false;
	}
	public function get_pageData() {
		$this->setup_PageData();
		$fp = fopen(PAGE_STATS, "r");
		$dt = fread($fp, filesize(PAGE_STATS));
		fclose($fp);
		return json_decode($dt, true);
	}
	public function put_pageData($dt) {
		$dt = json_encode($dt);
		$fp = fopen(PAGE_STATS, "w+");
		fwrite($fp, $dt);
		fclose($fp);
	}
	public function search($args []) {
		print_r($args);
	}
}
