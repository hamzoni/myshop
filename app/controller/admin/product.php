<?php
class product extends controller {
	public $page; // set default page
	public $crr_folder;
	public $upl_f_fail;
	private $mdl_obj; // model object
	private $mdl_gnr; // general model
	public $page_data = array();
	public function __construct() {
		$this->AUTHc = new AUTH("admin");
		$this->AUTHc->check_login();
		
		$this->page = "product";
		// CURRENT DIRECTORY
		$this->crr_folder = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
		// ERROR PAGE
		$this->upl_f_fail = 'http://'.$_SERVER['HTTP_HOST'].$this->crr_folder.'error/admin_product';
		// SET MODEL 
		$this->mdl_gnr = $this->model("general","products");
		$this->mdl_obj = $this->model("admin_model/product","products");
		$this->mdl_str = $this->model("admin_model/store","stores");
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];
		$this->set_id_start();

		// clear all unknown image in folder everytime load page
		$this->clr_unuseImg();
		$this->page_data["page"] = $this->page;
		$this->page_data["preface_pgc"] = "Products list";
		$this->page_data["base_url"] = $crr_url;

		$this->page_data["header"]["user"] = "admin"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "product";
		$this->page_data["header"]["js"][0] = "product";
		// set add_product form data
		$this->page_data["upload_form"]["handler"] = $this->page_data["base_url"]."/add_product";
		$this->page_data["upload_form"]["file_size"] = 200000*1000; //Bytes
		// total records in view products table
		$this->page_data["total_records"] = $this->mdl_obj->countAll()["COUNT(*)"];
		// set data for view products
		$this->page_data["slc_lm"] = 15;
			// set session to be used for ajax
			$_SESSION["slc_lm"] = $this->page_data["slc_lm"];
		$this->page_data["crr_offset"] = 0;
		$this->page_data["products_tray"] = array();
		$this->page_data["products_original"] = $this->mdl_obj->select_record($this->page_data["slc_lm"],$this->page_data["crr_offset"], $this->page_data["id_start"]);
		$this->page_data["products_tray"] = $this->dataModification($this->page_data["products_original"]);
		$this->page_data["crr_offset"] = $this->page_data["slc_lm"];
		// get seller data 
		$this->page_data["seller"] = $this->mdl_str->get_store_data(["id","store_name"]);
		// call view
		$this->view('admin/main',$this->page_data);

	}
	public function clr_unuseImg() {
		$imgType = ["ntr"=>"nutrition_img","ava"=>"avatar_img"];
		$rootFolder = "img/client/";
		$vtnt;
		foreach ($imgType as $t => $f) {
			$usImgArr = [];
			$imgDB = ["fn"=>[],"cpl"=>[]]; 
			$imgFD = [];
			// get all img href from database
			$imgDB["cpl"] = $this->mdl_obj->get_all_imgUrl($f);
			// get all filename from folder
			$imgFD = scandir($rootFolder.$t);
			// strip all href to get filename from database
			for ($i = 0; $i < count($imgDB["cpl"]); $i++) {
				preg_match('/\d+$/', $imgDB["cpl"][$i][$f], $vtnt);
				if ($vtnt) $imgDB["fn"][] = $vtnt[0];
			}
			// find discrepancy of between DataBase and FolDer
			for ($i = 0; $i < count($imgFD); $i++) {
				if ($this->indexOf($imgFD[$i] ,$imgDB["fn"]) == -1) {
					$fntrm = $rootFolder.$t."/".$imgFD[$i];
					// remove all differentiation
					if (file_exists($fntrm) && intval($imgFD[$i]) != 0) {
						unlink($fntrm);
					}
				}
			}
		}
		
	}
	public function indexOf($trg, $arr) {
		for ($j = 0 ; $j < count($arr); $j++) {
			if ($trg == $arr[$j]) {
				return $j;
			}
		}
		return -1;	
	}
	public function add_product() {
		$f_dt = array();
		try {
			$f_dt["p_name"] = $_POST["p_name"];
			$f_dt["p_price"] = intval($_POST["p_price"]);
			$f_dt["p_sale"] = intval($_POST["p_sale"]) / 100;
			$f_dt["p_type"] = $_POST["p_type"];
			$f_dt["p_dp"] = $_POST["p_display"];
			$f_dt["p_dscr"] = $_POST["f_dscrp"];
			$f_dt["p_seller"] = $_POST["p_store"];
		} catch (Exception $e) {};
		// DATA VALIDATION
		$err = $this->f_vld($f_dt, $this->crr_folder.'/admin/product');
		if ($err != 0) echo $err;
		
		// ALLOCATE IMG TO FOLDER
		$rt_dt = $this->upload_image();
		if (empty(@$rt_dt['ava'])) {
			echo "Main image is required";
			return;
		}
		// INSERT DATA TO DATABASE
		$prepare_dd = [
			"name" => $f_dt["p_name"],
			"price" => $f_dt["p_price"],
			"sale" => $f_dt["p_sale"],
			"avatar_img" => $rt_dt["ava"],
			"nutrition_img" => $rt_dt["ntr"],
			"type" => $f_dt["p_type"],
			"display" => $f_dt["p_dp"],
			"description" => $f_dt["p_dscr"],
			"store_id" => $f_dt["p_seller"]
		];
		$rsl = $this->mdl_obj->insert_record($prepare_dd);
		if ($rsl == 1) {
			echo "Add new product successful!";
		} else {
			echo "Error: duplicated item name.";
		}
	}
	public function upload_image() {
		$img_chk = ['p_avatar','p_nutrition'];
		$img_str = ['ava','ntr'];
		$img_rtc = [];
		$lc = "img/client/";
		$allow_f = ["jpg","png","jpeg","gif","bmp","ico"];
		for ($i = 0; $i < count($img_chk); $i++) {
			$f = $img_chk[$i];
			$n = explode(".", $_FILES[$f]["name"]);
			$k = $img_str[$i];
			$img_rtc[$k] = "";
			if (!empty($_FILES[$f]['tmp_name']) &&
				getimagesize($_FILES[$f]['tmp_name']) &&
				$_FILES[$f]["size"] < 200*1000 &&
				in_array(end($n),$allow_f)) {

				$s = $lc.$k."/";
				$now = time();
				while(file_exists($x = $s.$now)) {$now++;};
				$img_rtc[$k] = $s.$now;
				move_uploaded_file($_FILES[$f]['tmp_name'], $img_rtc[$k]);
			}
		}
		return $img_rtc;
	}
	public function f_vld($f,$l) {
		// LOCATION OF UPLOAD FORM
		$l = 'http://'.$_SERVER['HTTP_HOST'].$this->crr_folder.'admin/product';
		// CHECK IF NUMBERIC INPUT IS IN VALID DATA
		if ($f["p_price"] <= 0 
			|| $f["p_sale"] < 0 
			|| $f["p_sale"] >= 1
			|| !is_int($f["p_price"])
			|| ($f["p_sale"] != 0 ? !is_double($f["p_sale"]) : false)) {
			return "Invalid numberic input";
		}

		// CHECK IF INPUT IS EMPTY
		if($this->blank_inputChecker($f)) return "Inadequate necessary information";
		return 0;
	}
	public function blank_inputChecker($dt) {
		foreach ($dt as $k => $v) {
			if (($dt[$k] != 0 ? $dt[$k] == "" : false) || !isset($dt[$k])) {
				return true;
			}
		}
		return false;
	}
	public function error($error, $err_page, $rewind_page = '', $seconds = 10) {
	    header("Location: $err_page");
	    $_SESSION["err"] = $error;
	    $_SESSION["rewind_pg"] = $rewind_page;
	    $_SESSION["rewind_pg_time"]= $seconds;
	    exit; 
	}
	public function dataModification($dt_arr) {
		for ($i = 0; $i < count($dt_arr); $i++) {
			foreach ($dt_arr[$i] as $k => $v) {
				switch ($k) {
					case 'id':
						switch (strlen(strval($dt_arr[$i][$k]))) {
							case 4:
								$dt_arr[$i][$k] = "SP".$dt_arr[$i][$k];
								break;
							case 3:
								$dt_arr[$i][$k] = "SP0".$dt_arr[$i][$k];
								break;
							case 2:
								$dt_arr[$i][$k] = "SP00".$dt_arr[$i][$k];
								break;
							case 1:
								$dt_arr[$i][$k] = "SP000".$dt_arr[$i][$k];
								break;
						}
						break;
					case 'sale':
						$dt_arr[$i][$k] = ($dt_arr[$i][$k]*100)."%";
						break;
					case 'type':
						switch ($dt_arr[$i][$k]) {
							case 0:
								$dt_arr[$i][$k] = 'NONE';
								break;
							case 1:
								$dt_arr[$i][$k] = 'SPECIAL';
								break;
							case 2:
								$dt_arr[$i][$k] = 'SALE';
								break;
						}
					break;
					case 'display':
						if ($dt_arr[$i][$k] == 0) {
							$dt_arr[$i][$k] = '-thin';
						} else if ($dt_arr[$i][$k] == 1) {
							$dt_arr[$i][$k] = '';
						}
						break;
					default:
						break;
				}
				
			}
		}
		return $dt_arr;
	}
	public function adding_dataTbl() {
		$r = json_decode($_GET["r"]);
		$ogd = $this->mdl_obj->select_record($_SESSION["slc_lm"],$r->offset,$r->start_id);
		$rdt = $this->dataModification($ogd);
		print_r(json_encode([$ogd,$rdt]));
	}
	public function upd_prdDpl() {
		$updDpl = json_decode($_POST['UpdateDisplay']);
		$result = $this->mdl_obj->update_display($updDpl->prdId,$updDpl->prdnVal);
		print_r($result);
	}
	public function del_prdRcrd() {
		$updDpl = json_decode($_POST['DeleteRecords']);
		$result = $this->mdl_obj->delete_record($updDpl->prdId,$this->crr_folder);
		// remove image from directories
		for ($i = 0; $i < count($updDpl->prdImg); $i++) {
			for ($j = 0; $j < count($updDpl->prdImg[$i]); $j++) {
				unlink($updDpl->prdImg[$i][$j]);
			}
		}
		print_r($result);
	}
	public function upd_prdc() {
		$upd_dtrc = json_decode($_POST['previous_pData'],true);
		$upd_gntr = $_POST;
		$upd_gntr['id'] = $upd_dtrc['id'];
		$upd_gntr['p_store'] = $upd_gntr['p_store'] == 0 ? null : $upd_gntr['p_store'];
		$img_chk = ['p_avatar','p_nutrition'];
		$img_typ = ['ava','ntr'];
		$allow_f = ["jpg","png","jpeg","gif","bmp","ico"];
		for ($i = 0; $i < count($img_chk); $i++) {
			$f = $img_chk[$i];
			$g = $img_typ[$i];
			$upd_gntr[$g] = $upd_dtrc[$g];
			$n = explode(".", $_FILES[$f]["name"]);
			if (!empty($_FILES[$f]['tmp_name']) &&
				getimagesize($_FILES[$f]['tmp_name']) &&
				$_FILES[$f]["size"] < 200*1000 &&
				in_array(end($n),$allow_f)) {
				if (file_exists($upd_dtrc[$g])) unlink($upd_dtrc[$g]);
				$lc = str_replace(basename($upd_dtrc[$g]), '', $upd_dtrc[$g]);
				$now = time();
				while(file_exists($x = $lc.$now)) {$now++;};
				$upd_gntr[$g] = $lc.$now;
				move_uploaded_file($_FILES[$f]['tmp_name'], $upd_gntr[$g]);
			}
		}
		$upd_db = $this->mdl_obj->update_product($upd_gntr); 
		$upd_gntr['last_upd'] = date("Y-m-d h:i:s");
		$spc_tblDpl = array();
		$spc_tblDpl['sale'] = $upd_gntr['p_sale'];
		$spc_tblDpl['type'] = $upd_gntr['p_type'];
		$spc_tblDpl['display'] = $upd_gntr['p_display'];
		$spc_tblDpl['store_name'] = "";
		if ($upd_gntr['p_store'] != 0) {
			$stn = $this->mdl_str->get_store_data("store_name",["id",$upd_gntr["p_store"]]);
			$spc_tblDpl['store_name'] = reset($stn[0]);
		}
		$spc_tblDpl = $this->dataModification([$spc_tblDpl]);
		print_r(json_encode([$upd_gntr,$spc_tblDpl]));
	}
	public function rmImg_dir($img_src) {
		if (is_array($img_src)) {
			for ($i = 0; $i < count($img_src); $i++) {
				if (file_exists($img_src[$i])) {
					if (!unlink($img_src[$i])) {
						return ['error'=>'Unable to delete image'];
					};
				}
			}
			return true;
		}
		if (file_exists($img_src)) {
			if (!unlink($img_src)) {
				return ['error'=>'Unable to delete image'];
			}
		}
		return true;
	}
}

?>