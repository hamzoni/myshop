<?php
class search {
	public function __construct() {
		$_SESSION["search_id"] = $_POST["sr_tId"];
	}
	public function index() {
		$args = func_get_args();
		header("Location: ".$_POST["sr_tPg"]);
	}
}
class SEARCH_ADMIM {
	public function searching($keys) {
		$DB = new dataB_admin();
		$ID_P = strtoupper(substr($keys,0,2)); // ID prefix
		if (array_key_exists($ID_P, $DB->VA_idPattern)) {
			$ID_V = substr($keys,2,4); // ID value
			if (is_numeric($ID_V) && !preg_match('/\s/',$ID_V)) {
				if (strlen($ID_V) >= 4) {
					return $DB->cData->search_exact_ID($DB->VA_idPattern[$ID_P] ,intval($ID_V));
				} else {
					return $DB->cData->search_by_ID($DB->VA_idPattern[$ID_P] ,intval($ID_V));
				}
			} else {
				$dt2s = trim(substr($keys,2,strlen($keys)));
				return $DB->cData->search_by_VAL(
					$DB->VA_idPattern[$ID_P],
					$dt2s,
					$DB->VA_valFields[$DB->VA_idPattern[$ID_P]]
				);
			}
		} else {
			return $DB->cData->search_tbl_ALL($keys, $DB->VA_valFields);
		}
	}
	public function get_suggestion($keys) {
		$rt_Dt = SEARCH_ADMIM::searching($keys);
		$page_target = ["orders"=>"order","clients"=>"user","products"=>"product"];
		foreach ($rt_Dt as $k => $v) {
			for ($i = 0; $i < count($v); $i++) {
				$rt_Dt[$k][$i]["href"] = BASE_URL."hybrid/search";
				$rt_Dt[$k][$i]["page"] = BASE_URL."admin/".$page_target[$k];
				$rt_Dt[$k][$i]["id"] = $rt_Dt[$k][$i]["id"];
			}
		}
		return json_encode($rt_Dt);
	}
	public function execute_search($keys) {

	}
}
class SEARCH_CLIENT {

}
class dataB_admin {
	public $cData;
	public $VA_idPattern;
	public $VA_valFields;
	public function __construct() {
		$this->cData = new dataB();
		$this->VA_idPattern = ["OD" => "orders","KH" => "clients","SP" => "products"];
		$this->VA_valFields = [
			"orders" => ["name","phone","address"],
			"products" => ["name","price","sale"],
			"clients" => ["name","phone","address"],
		];
	}
}
class dataB extends controller {
	private $mdl;
	private $sort_dpt;
	private $slc_cols;
	public function __construct() {
		$this->mdl = [];
		$this->mdl["orders"] = $this->model("general","orders");
		$this->mdl["clients"] = $this->model("general","clients");
		$this->mdl["products"] = $this->model("general","products");
		$this->sort_dpt = ["orders"=>"time_order","clients"=>"signup_date","products"=>"post_date"];
		$this->slc_cols = ["orders"=>"id,name,phone,address","clients"=>"id,name,phone,address","products"=>"id,name,price,sale"];
	}
	public function search_exact_ID($tbl, $id) {
		$r = [];
		$r[$tbl] = $this->mdl[$tbl]->search_ID($tbl, $id, $this->slc_cols[$tbl]);
		return $r;
	}
	public function search_by_ID($tbl, $id) {
		$r[$tbl] = $this->mdl[$tbl]->search_table(["id"], $id, 10,$this->sort_dpt[$tbl],"DESC",$this->slc_cols[$tbl]);
		return ($r);
	}
	public function search_by_VAL($tbl, $ctn, $fd) {
		$r = [];
		$r[$tbl] = $this->mdl[$tbl]->search_table($fd, $ctn, 10,$this->sort_dpt[$tbl],"DESC",$this->slc_cols[$tbl]);
		return ($r);
	}
	public function search_tbl_ALL($ctn, $tpe) {
		$r = [];
		$max_dpl = 10;
		foreach ($tpe as $k => $v) {
			$r[$k] = $this->mdl[$k]->search_table($v, $ctn, $max_dpl, $this->sort_dpt[$k],"DESC",$this->slc_cols[$k]);
			$max_dpl -= count($r[$k]);
			if ($max_dpl < 0) break;
		}
		return ($r);
	}
}