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
		$this->mdl_str = $this->model("admin_model/store","stores");
		$this->mdl_clt = $this->model("admin_model/user","clients");
	}
	public function index() {
		if (!$this->check_is_ajax()) {
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
			$this->page_data["header"]["lib"]["css"][0] = "font-perxis/style.css";
			$this->page_data["store"]["info"] = $this->mdl_str->get_store_data(["id","store_name","owner","phone","facebook"],["status","'1'"]);
			$this->page_data["store"]["order"] = $this->seller_orders();
			$this->view('admin/main',$this->page_data);
		}
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
	public function seller_orders() {
		$pkg = [];
		$pkg[0] = $this->mdl_pkg->get_records(['product_id','order_id','seller_id','qty'],['view',"'0'"]);
		$pkg[1] = $this->mdl_pkg->get_records(['product_id','order_id','seller_id','qty'],['view',"'1'"]);
		$sID = $this->mdl_str->get_records(['id']);
		$rsl = [];
		for ($i = 0; $i < count($sID); $i++) $rsl[reset($sID[$i])] = [];
		for ($j = 0; $j < count($pkg); $j++) {
			for ($i = 0, $z; $i < count($pkg[$j]); $i++) {
				$x = $pkg[$j][$i];
				if (@!is_array($rsl[$x['seller_id']][0])) $rsl[$x['seller_id']][0] = [];
				if (@!is_array($rsl[$x['seller_id']][1])) $rsl[$x['seller_id']][1] = [];

				$ord = $this->mdl_order->get_records(['time_order','address'],['id',$x['order_id']])[0];
				$prd = $this->mdl_prd->get_records(['name'],['id',$x['product_id']])[0];
				
				$z['time_order'] = $ord['time_order'];
				$z['time_stamp'] = strtotime($ord['time_order']);
				$z['product_name'] = $prd['name'];
				$z['address'] = $ord['address'];
				$z['qty'] = $x['qty'];
				array_push($rsl[$x['seller_id']][$j], $z);
			}
		}    
		foreach ($rsl as $x => $y) {
		 	if (@count($rsl[$x][0]) > 0) $rsl[$x][0] = $this->quickSort_ts($rsl[$x][0],0,count($rsl[$x][0]) - 1);
		 	if (@count($rsl[$x][1]) > 0) $rsl[$x][1] = $this->quickSort_ts($rsl[$x][1],0,count($rsl[$x][1]) - 1);
		}     
		return $rsl;
	}
	public function get_vendor_ajax() {
		$r = json_decode($_GET['r'],true);
		$pkg = $this->mdl_pkg->get_records(['product_id','order_id','qty'],[['view',"'".$r['get_type']."'"],['seller_id',$r['store_id']]]);
		if (count($pkg) > 0) {
			for ($i = 0, $j = 0; $i < count($pkg); $i++) {
				$ord = $this->mdl_order->get_records(['time_order','address'],['id',$pkg[$i]['order_id']]);
				$prd = $this->mdl_prd->get_records(['name'],['id',$pkg[$i]['product_id']]);
				$ord = reset($ord); $prd = reset($prd);
				$pkg[$i]['time_order'] = $ord['time_order'];
				$pkg[$i]['time_stamp'] = strtotime($ord['time_order']);
				$pkg[$i]['product_name'] = $prd['name'];
				$pkg[$i]['address'] = $ord['address'];
			}
			$pkg = $this->quickSort_ts($pkg,0,count($pkg) - 1);
			$pkg_x = [];
			for ($i = 0; $i < count($pkg); $i++) {
				$pkg_x[$i]['address'] = $pkg[$i]['address'];
				$pkg_x[$i]['product_name'] = $pkg[$i]['product_name'];
				$pkg_x[$i]['qty'] = $pkg[$i]['qty'];
				$pkg_x[$i]['time_order'] = $pkg[$i]['time_order'];
			}
			$pkg_x = json_encode($pkg_x);
			print_r($pkg_x);
		}
	}
	public function set_vendor_view() { // update package view
		$r = json_decode($_GET['r'],true);
		$r = $this->mdl_pkg->update_records('view',"'".$r['type']."'",['seller_id',$r['store_id']]);
		print_r($r);
	}
	public function quickSort_ts($arr, $l, $r) {
		$i = $l; $j = $r;
		$tmp;
		$pivot = $arr[($l + $r) / 2]['time_stamp'];
		while ($i <= $j) {
			while ($arr[$i]['time_stamp'] > $pivot) $i++;
			while ($arr[$j]['time_stamp'] < $pivot) $j--;
			if ($i <= $j) {
			      $tmp = $arr[$i];
			      $arr[$i] = $arr[$j];
			      $arr[$j] = $tmp;
			      $i++; $j--;
			}
		};
		if ($l < $j) $this->quickSort_ts($arr, $l, $j);
		if ($i < $r) $this->quickSort_ts($arr, $i, $r);
		return $arr;
	}
}

?>