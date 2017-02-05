<?php
class statistic extends controller {
	public $page; // set default page
	public $page_data = array();
	private $mdl_gnr; // general model
	private $mdl_order;
	private $mdl_pkg;
	private $mdl_prd;
	public function __construct() {
		$this->AUTHc = new AUTH("admin");
		$this->AUTHc->check_login();
		$this->check_pageData();
		
		$this->page = "statistic";
		$this->mdl_gnr = $this->model("general","orders");
		$this->mdl_order = $this->model("admin_model/order","orders");
		$this->mdl_pkg = $this->model("admin_model/package","packages");
		$this->mdl_prd = $this->model("admin_model/product","products");
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];

		$this->page_data["page"] = $this->page;
		$this->page_data["preface_pgc"] = "Statistic";
		$this->page_data["base_url"] = $crr_url; 
		
		$this->page_data["header"]["user"] = "admin"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "stats";
		$this->page_data["header"]["js"][0] = "graph.min";
		$this->page_data["header"]["js"][1] = "stats";

		$this->page_data["stats"] = json_encode($this->get_pageData());
		$this->view('admin/main',$this->page_data);

	}
}

?>