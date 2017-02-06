<?php
class user extends controller {
	public $page; // set default page
	public $page_data = array();
	// private $ctrl_lbr; // controller library
	private $mdl_gnr;
	private $mdl_clt;
	private $mdl_ord; // order model - for extension
	public function __construct() {
		$this->AUTHc = new AUTH("admin");
		$this->AUTHc->check_login();
		
		$this->page = "user";
		$this->mdl_gnr = $this->model("general","orders");
		$this->mdl_ord = $this->model("admin_model/order","clients");
		$this->mdl_clt = $this->model("admin_model/user","clients"); 
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1]; 
		$this->set_id_start();

		$this->page_data["page"] = $this->page;
		$this->page_data["preface_pgc"] = "Client info";
		$this->page_data["base_url"] = $crr_url; 
		$this->page_data["input_length"] = json_encode($this->find_maxIPL());
		
		$this->page_data["header"]["user"] = "admin"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "user";
		$this->page_data["header"]["js"][0] = "user";
		$this->view('admin/main',$this->page_data);
	}
	public function find_maxIPL() {
		$arr = array();
		$arr["name"] = $this->mdl_clt->getField_maxLengthV2("name")["Type"];
		$arr["phone"] = $this->mdl_clt->getField_maxLengthV2("phone")["Type"];
		$arr["address"] = $this->mdl_clt->getField_maxLengthV2("address")["Type"];
		foreach ($arr as $key => $value) {
			$arr[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
		}
		return json_encode($arr);
	}
	public function find_maxIPL_single($fn) {
		return filter_var($this->mdl_clt->getField_maxLengthV2($fn)["Type"],FILTER_SANITIZE_NUMBER_INT);
	}
	public function load_clientData() {
		$rs = json_decode($_GET["instruction"]);
		$rs = $this->mdl_clt->select_orderAjax($rs->lim,$rs->offs, "signup_date","DESC",$rs->start_id);
		print_r(json_encode($rs));
	}
	public function count_client_records() {
		print_r($this->mdl_clt->countAll()["COUNT(*)"]);
	}
	public function ban_client() {
		$r = json_decode($_GET["c_stt"]);
		echo $this->mdl_clt->update_client_status($r->id,$r->val);
	}
	public function edit_client() {
		$r = json_decode($_GET["r"], true);
		$data_L = ["name"=>$this->find_maxIPL_single("name"),
					"phone"=>$this->find_maxIPL_single("phone"),
					"address"=>$this->find_maxIPL_single("address")];
		if (!$this->is_contain_char($r["phone"]) && !$this->is_contain_char($r["id"])) {
			foreach ($data_L as $k => $v) {
				if (intval($v) < strlen($r[$k])) {
					echo "0";
					return;
				}
			}
			print_r($this->mdl_clt->edit_order($r["name"],intval($r["phone"]),$r["address"],intval($r["id"])));
		} else {
			echo "0";
		}
	}
	public function delete_client() {
		$c_id = $_GET["r"];
		echo $this->mdl_clt->remove_record($c_id);
	}
}