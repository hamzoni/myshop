<?php
class order extends controller {
	public $page; // set default page
	public function __construct() {
		$this->page = "order";

	}
	public function index($param = null) {
		$this->view('admin/main',["page"=>$this->page]);
	}
}

?>