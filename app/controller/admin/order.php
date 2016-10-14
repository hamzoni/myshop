<?php
class order extends controller {
	public $page; // set default page
	public function __construct() {
		$this->page = "order";
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];


		$this->page_data["page"] = $this->page;
		$this->page_data["base_url"] = $crr_url; 
		$this->page_data["header"]["user"] = "admin"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "order";
		$this->view('admin/main',$this->page_data);
	}
}

?>