<?php
class order extends controller {
	public $page; // set default page
	public $page_data = array();
	private $mdl_gnr; // general model
	private $mdl_order;
	private $mdl_pkg;
	private $mdl_prd;
	public function __construct() {
		$this->AUTHc = new AUTH("admin");
		$this->AUTHc->check_login();
		
		$this->page = "order";
		$this->mdl_gnr = $this->model("general","orders");
		$this->mdl_order = $this->model("admin_model/order","orders");
		$this->mdl_pkg = $this->model("admin_model/package","packages");
		$this->mdl_prd = $this->model("admin_model/product","products");
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];
		$this->set_id_start();

		$this->page_data["page"] = $this->page;
		$this->page_data["preface_pgc"] = "Order list";
		$this->page_data["base_url"] = $crr_url; 
		
		$this->page_data["header"]["user"] = "admin"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "order";
		$this->page_data["header"]["js"][0] = "order";

		$this->view('admin/main',$this->page_data);

	}
	public function count_order_records() {
		if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) return;
		$r = $this->mdl_order->countAll();
		print_r(reset($r));
	}
	public function load_order() {
		if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) return;
		$rqIns = json_decode($_GET["instruction"]);
		$sortBy = "time_order";
		$inOrder = "DESC";
		$records = $this->mdl_order->select_orderAjax($rqIns->limit,
			$rqIns->offset, 
			$sortBy, 
			$inOrder,
			empty($rqIns->start_id) ? null : $rqIns->start_id);
		print_r(json_encode($records));
	}
	public function load_package() {
		if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) return;
		$rqIns = json_decode($_GET["order_id"]);
		$package = $this->mdl_pkg->select_packageAjax($rqIns);
		$p_price = array();
		$p_name = array();
		for ($i = 0; $i < count($package); $i++) {
			$prd_id = $package[$i]["product_id"];
			$package[$i]["p_price"] = $this->mdl_prd->select_specificRow("price",$prd_id)["price"];
			$package[$i]["p_name"] = $this->mdl_prd->select_specificRow("name",$prd_id)["name"];
		}
		print_r(json_encode($package));
	}
	public function edit_ship_status() {
		if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) return;
		$r = json_decode($_GET["r"]);
		echo $this->mdl_order->edit_specific_field($r->order_id,"ship_status",$r->ship_bool);
	}
	public function remove_order() {
		if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) return;
		$r = filter_var($_GET["order_id"]);
		$this->mdl_pkg->delete_package("order_id",$r);
		echo $this->mdl_order->remove_record($r);
	}
	public function edit_order() {
		if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) return;
		$data_l = ["phone"=>"int","name"=>"char","address"=>"char"];
		$r = json_decode(filter_var($_GET["r"]),true);
		foreach ($data_l as $k => $v) {
			$data_l[$k] = $this->mdl_order->getField_maxLength($k,$v);
			if (strlen($r[$k]) > reset($data_l[$k])) {
				echo 0;
				return;
			}
		}
		echo $this->mdl_order->edit_order($r["name"], $r["phone"], $r["address"], $r["ord_id"]);
	}
}

?>
