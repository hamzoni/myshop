<?php
class admin_product extends controller {
	public $page; // set default page
	public $page_data = array();
	public $df_fallback_pg;
	public function __construct() {
		$this->df_fallback_pg = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
		$this->df_fallback_pg = 'http://'.$_SERVER['HTTP_HOST'].$this->df_fallback_pg.'admin/product';
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];
		if (!isset($_SESSION["err"])) {
			header("Location: $this->df_fallback_pg");
		}
		if (@isset($_SESSION["err"])) {
			$this->page_data["err"] = $_SESSION["err"];
			unset($_SESSION["err"]);
		}
		if (@isset($_SESSION["rewind_pg"])) {
			$this->page_data["rewind_pg"] = $_SESSION["rewind_pg"];
			unset($_SESSION["rewind_pg"]);
		}
		$this->page_data["rewind_pg"] == '' 
			? $this->page_data["rewind_pg"] = $this->df_fallback_pg
			: null;
		if (@isset($_SESSION["rewind_pg_time"])) {
			$this->page_data["rewind_pg_time"] = $_SESSION["rewind_pg_time"];
			unset($_SESSION["rewind_pg_time"]);
		}

		$this->page_data["page"] = $this->page;
		$this->page_data["base_url"] = $crr_url; 
		// $this->page_data["header"]["user"] = ""; 
		// $this->page_data["header"]["css"][0] = "";
		// $this->page_data["header"]["css"][1] = "";
		
		$this->view('error/admin',$this->page_data);
		header("Refresh:".$this->page_data["rewind_pg_time"]."; URL='".$this->page_data["rewind_pg"]."'");
	}
}

?>