<?php
class general {
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
		// if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) return;
		$r = json_decode($_GET["r"], true);
		try {
			echo $this->{$r["obj"]}->{$r["func"]}();
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	// use not set object
	public function request_method() {
		// if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) return;
		$r = json_decode($_GET["r"], true);
		$args = array();
		$args[count($args)] = $r["v"];
		try {
			print_r(call_user_func_array([$r["obj"],$r["func"]],$args));
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function set_pageData() {
		clearstatcache();
		if (@filesize(PAGE_STATS) == 0 || !file_exists(PAGE_STATS)) {
			$fp = fopen(PAGE_STATS, "w+");
			$dt = array();
			$dt[PG_D] = array();
			$dt[PG_S] = array();	
			$dt[PG_D]["VIEWS"] = array();
			$dt[PG_D]["TRANSACTIONS"] = array();
			$dt[PG_D]["ACCOUNTS"] = array();
			$dt[PG_D]["INCOMES"] = array();

			$dt[PG_S]["S_VIEWS"] = 0;
			$dt[PG_S]["S_TRANSACTIONS"] = 0;
			$dt[PG_S]["S_ACCOUNTS"] = 0;
			$dt[PG_S]["S_INCOMES"] = 0;
			$dt = json_encode($dt);
			fwrite($fp, $dt);
			fclose($fp);
		} 
	}
	public function open_pageData() {
		clearstatcache();
		$fp = fopen(PAGE_STATS, "r");
		$dt = fread($fp, filesize(PAGE_STATS));
		fclose($fp);
		return json_decode($dt, true);
	}
	public function put_pageData($dt) {
		$dt = json_encode($dt);
		$fp = fopen(PAGE_STATS, "w");
		fwrite($fp, $dt);
		fclose($fp);
	}
	public function page_not_found() {
		echo "Page not found";
		// header("Location: ".$this->page_data["base_url"]);
	}
	public function set_id_start() {
		$this->page_data["id_start"] = "";
		if (@$_SESSION["search_id"]) {
			$this->page_data["id_start"] = $_SESSION["search_id"];
			unset($_SESSION["search_id"]);
		}
	}
	// start order notification
	public function request_new_order() {
		$r = json_decode($_GET["r"],true);
		$m = $this->model("admin_model/order","orders");
		$r = $m->rq_new_ord($r);
		$r = json_encode($r);
		print_r($r);
	}
	public function count_new_order() {
		$m = $this->model("admin_model/order","orders");
		$r = $m->get_maxNew_ord();
		$r = reset($r);
		print_r($r);
	}
	public function have_seen_order_ntf() {
		$m = $this->model("admin_model/order","orders");
		$r = $m->seen_order_ntf();
		print_r($r);
	}
	public function count_all_order() {
		$m = $this->model("admin_model/order","orders");
		$r = $m->count_all_order();
		$r = reset($r);
		print_r($r);
	}
	public function check_new_order() {
		$r = $_GET["r"];
		$m = $this->model("admin_model/order","orders");
		$r = $m->check_new_order($r);
		$r = json_encode($r);
		print_r($r);
	}
}
