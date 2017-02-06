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
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];
		$this->set_id_start();

		if (@isset($_SESSION["ntf"])) {
			$this->page_data["ntf"] = $_SESSION["ntf"];
			unset($_SESSION["ntf"]);
		}
		// clear all unknown image in folder everytime load page
		$this->clr_unuseImg();
		$this->page_data["page"] = $this->page;
		$this->page_data["preface_pgc"] = "Products list";
		$this->page_data["base_url"] = $crr_url;

		$this->page_data["header"]["user"] = "admin"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "product";
		$this->page_data["header"]["js"][0] = "product_data";
		$this->page_data["header"]["js"][1] = "product";
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
				$imgDB["fn"][] = $vtnt[0];
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
		} catch (Exception $e) {};
		// DATA VALIDATION
		$this->f_vld($f_dt, $this->crr_folder.'/admin/product');
		
		// ALLOCATE IMG TO FOLDER
		$rt_dt = $this->upload_image(false,2);
		// INSERT DATA TO DATABASE
		$insert_result = $this->mdl_obj->insert_record(
			$f_dt["p_name"],$f_dt["p_price"],$f_dt["p_sale"],
			$rt_dt['img_href']['ava'],$rt_dt['img_href']['ntr'],
			$f_dt["p_type"],$f_dt["p_dp"],$f_dt["p_dscr"]);
		if (!is_int(intval($insert_result))) {
			$this->error($insert_result, $this->upl_f_fail);
		}
		// DIRECT CLIENT TO SUCCESS PAGE
		$_SESSION["ntf"] = "Add new product successful!";
		header('Location: '.$rt_dt['scc_pg']);
	}

	public function upload_image($imgvF = false, $upl_type = 3, $prv_fn = [],$prevAvailable = ['ava'=>false,'ntr'=>false]) {
		// imgvF = false: is uploaded from a html form (ajax rather)
		// upl_type = 0 (ava) or 1 (ntr) or 2 (both) or 3 (none of those)

		// IMAGE STORAGE DIRECTORY
		$shrc_uplF = $_SERVER['DOCUMENT_ROOT'].$this->crr_folder.'img/client/';
		$src_view_base = 'img/client/';
		// SUCCESS PAGE
		$upl_f_scc = 'http://'.$_SERVER['HTTP_HOST'].$this->crr_folder.'admin/product/index';
		// UPLOAD ERROR
		$errors = array(1 => 'php.ini max file size exceeded', 
		                2 => 'html form max file size exceeded', 
		                3 => 'file upload was only partial', 
		                4 => 'no file was attached');
		// CHECK IF IMAGE IS SUMMITED THROUGH FORM 
		if (!$imgvF) {
			isset($_POST['submit_prd']) 
			or $this->error('the upload form is needed', $this->upl_f_fail);
		}
		$now = time();
		$return_data = array();
		if ($upl_type == 3) {
			return;
		}
		if ($upl_type == 0 || $upl_type == 2) {
			$upl_folder_ava = $shrc_uplF."ava/";
			$ava_href = $src_view_base."ava/";
			// NAME OF INPUT(s)
			$fld_n_ava = 'p_avatar';
			if (!$imgvF) { // different in handling error
				// CHECK PHP's BUILT-IN ERROR
				($_FILES[$fld_n_ava]['error'] == 0) 
			    or $this->error($errors[$_FILES[$fld_n_ava]['error']], $this->upl_f_fail);
			    // CHECK IF HTTP'S SUBJECT UPLOAD
				@is_uploaded_file($_FILES[$fld_n_ava]['tmp_name']) 
				or $this->error('Invalid HTTP upload', $this->upl_f_fail);
				// VALIDATION: CHECK IF THE FILE IS GENUINELY AN IMAGE
				@getimagesize($_FILES[$fld_n_ava]['tmp_name']) 
				or $this->error('Only image is allowed', $this->upl_f_fail);
				// CREATE A UNIQUE FILE NAME
				while(file_exists($upl_fn_ava = $upl_folder_ava.$now)) {$now++;};
				$return_data['img_href']['ava'] = $ava_href.$now;
				// MOVE FILE TO TARGET LOCATION && ALLOCATE NEW FILE NAME
				move_uploaded_file($_FILES[$fld_n_ava]['tmp_name'], $upl_fn_ava) 
				or $this->error('Receiving directory insuffiecient permission', $this->upl_f_fail);
			} else {
				// CHECK PHP's BUILT-IN ERROR
				if ($_FILES[$fld_n_ava]['error'] != 0) {
					$return_data['error'] = $errors[$_FILES[$fld_n_ava]['error']];
					return $return_data['error'];
				}
			    // CHECK IF HTTP'S SUBJECT UPLOAD
				if (!is_uploaded_file($_FILES[$fld_n_ava]['tmp_name'])) {
					$return_data['error'] = 'Invalid HTTP upload';
					return $return_data['error'];
				}
				// VALIDATION: CHECK IF THE FILE IS GENUINELY AN IMAGE
				if (!getimagesize($_FILES[$fld_n_ava]['tmp_name'])) {
					$return_data['error'] = 'Only image is allowed';
					return $return_data['error'];
				} 
				if ($prevAvailable['ava'] === true) {
					// USE PREVIOUS FILE NAME
					$fldd = [];
					preg_match('/\d+$/', $prv_fn['ava'], $fldd);
					$fldd = $fldd[0];
					$upl_fn_ava = $upl_folder_ava.$fldd;
					$return_data['img_href']['ava'] = $ava_href.$fldd;
				} else {
					// CREATE A UNIQUE FILE NAME
					while(file_exists($upl_fn_ava = $upl_folder_ava.$now)) {$now++;};
					$return_data['img_href']['ava'] = $ava_href.$now;
				}
				
				// MOVE FILE TO TARGET LOCATION && ALLOCATE NEW FILE NAME
				if (!move_uploaded_file($_FILES[$fld_n_ava]['tmp_name'], $upl_fn_ava) ) {
					$return_data['error'] = 'Receiving directory insuffiecient permission';
					return $return_data['error'];
				}
			}	
		} 
		if ($upl_type == 1 || $upl_type == 2) {
			$upl_folder_ntr = $shrc_uplF."ntr/";
			$ntr_href = $src_view_base."ntr/";
			// NAME OF INPUT(s)
			$fld_n_ntr = 'p_nutrition';
			if (!$imgvF) {
				// CHECK PHP's BUILT-IN ERROR
				($_FILES[$fld_n_ntr]['error'] == 0) 
			    or $this->error($errors[$_FILES[$fld_n_ntr]['error']], $this->upl_f_fail);
			    // CHECK IF HTTP'S SUBJECT UPLOAD
				@is_uploaded_file($_FILES[$fld_n_ntr]['tmp_name']) 
				or $this->error('Invalid HTTP upload', $this->upl_f_fail);
				// VALIDATION: CHECK IF THE FILE IS GENUINELY AN IMAGE
				@getimagesize($_FILES[$fld_n_ntr]['tmp_name']) 
				or $this->error('Only image is allowed', $this->upl_f_fail);
				// CREATE A UNIQUE FILE NAME
				while(file_exists($upl_fn_ntr = $upl_folder_ntr.$now)) {$now++;};
				$return_data['img_href']['ntr'] = $ntr_href.$now;
				// MOVE FILE TO TARGET LOCATION && ALLOCATE NEW FILE NAME
				move_uploaded_file($_FILES[$fld_n_ntr]['tmp_name'], $upl_fn_ntr) 
				or $this->error('Receiving directory insuffiecient permission', $this->upl_f_fail);
			} else {
				if ($_FILES[$fld_n_ntr]['error'] != 0) {
					$return_data['error'] = $errors[$_FILES[$fld_n_ntr]['error']];
					return $return_data['error'];
				}
			    // CHECK IF HTTP'S SUBJECT UPLOAD
				if (!is_uploaded_file($_FILES[$fld_n_ntr]['tmp_name'])) {
					$return_data['error'] = 'Invalid HTTP upload';
					return $return_data['error'];
				}
				// VALIDATION: CHECK IF THE FILE IS GENUINELY AN IMAGE
				if (!getimagesize($_FILES[$fld_n_ntr]['tmp_name'])) {
					$return_data['error'] = 'Only image is allowed';
					return $return_data['error'];
				} 
				if ($prevAvailable['ntr'] === true) {
					// USE PREVIOUS IMAGE
					$fldd = [];
					preg_match('/\d+$/', $prv_fn['ntr'], $fldd);
					$fldd = $fldd[0];
					$upl_fn_ntr = $upl_folder_ntr.$fldd;
					$return_data['img_href']['ntr'] = $ntr_href.$fldd;
				} else {
					// CREATE A UNIQUE FILE NAME
					while(file_exists($upl_fn_ntr = $upl_folder_ntr.$now)) {$now++;};
					$return_data['img_href']['ntr'] = $ntr_href.$now;
					}
				// MOVE FILE TO TARGET LOCATION && ALLOCATE NEW FILE NAME
				if (!move_uploaded_file($_FILES[$fld_n_ntr]['tmp_name'], $upl_fn_ntr)) {
					$return_data['error'] = 'Receiving directory insuffiecient permission';
					return $return_data['error'];
				}
			}
		}
		$return_data['scc_pg'] = $upl_f_scc;
		return $return_data;
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
			$_SESSION["ntf"] = "Invalid numberic input";
			header("Location: $l");
			return;
		}

		// CHECK IF INPUT IS EMPTY
		if($this->blank_inputChecker($f)) {
			$_SESSION["ntf"] = "Inadequate necessary information";
			header("Location: $l");
			return;
		}
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
		$isEmpty_img = [];
		$isEmpty_img['ava'] = empty($_FILES['p_avatar']['size']);
		$isEmpty_img['ntr'] = empty($_FILES['p_nutrition']['size']);

		$fileExist = ['ava'=>file_exists($upd_dtrc['ava']),'ntr'=>file_exists($upd_dtrc['ntr'])];
		$dl_r = true;
		if ($isEmpty_img['ava'] == false && $isEmpty_img['ntr'] == false) {
			// remove image from dir
			if ($upd_dtrc['ava'] != 0 && $upd_dtrc['ntr'] != 0
				&& null !== $upd_dtrc) {
				$dl_r = $this->rmImg_dir([$upd_dtrc['ava'],$upd_dtrc['ntr']]);
			}
			// upload image using prev name
			$upl_rs = $this->upload_image(true, 2,['ava'=>$upd_dtrc['ava'],'ntr'=>$upd_dtrc['ntr']],$fileExist);
			$upd_gntr['ava'] = $upl_rs['img_href']['ava'];
			$upd_gntr['ntr'] = $upl_rs['img_href']['ntr'];
		} else if ($isEmpty_img['ava'] == true && $isEmpty_img['ntr'] == false) {
			if ($upd_dtrc['ntr'] != 0 && null !== $upd_dtrc) {
				$dl_r = $this->rmImg_dir($upd_dtrc['ntr']);
			}
			$upl_rs = $this->upload_image(true, 1,['ntr'=>$upd_dtrc['ntr']],$fileExist);
			$upd_gntr['ntr'] = $upl_rs['img_href']['ntr'];
			$upd_gntr['ava'] = null;
		} else if ($isEmpty_img['ava'] == false && $isEmpty_img['ntr'] == true) {
			if ($upd_dtrc['ava'] != 0 && null !== $upd_dtrc) {
				$dl_r = $this->rmImg_dir($upd_dtrc['ava']);
			}
			$upl_rs = $this->upload_image(true, 0,['ava'=>$upd_dtrc['ava']],$fileExist);
			$upd_gntr['ava'] = $upl_rs['img_href']['ava'];
			$upd_gntr['ntr'] = null;
		} else {
			$upd_gntr['ava'] = null;
			$upd_gntr['ntr'] = null;
			$dl_r = true;
			$upl_rs = true;
		}
		if (is_array($dl_r)) {
			if (array_key_exists('error',$dl_r)) {
				print_r($dl_r['error']);
				return;
			}
		}
		if (is_array($upl_rs)) {
			if (array_key_exists('error',$upl_rs)) {
				print_r($upl_rs['error']);
				return;
			}
		}
		// update record
		$upd_db = $this->mdl_obj->update_product($upd_gntr);
		$upd_gntr['last_upd'] = date("Y-m-d h:i:s");
		$spc_tblDpl = array();
		$spc_tblDpl['sale'] = $upd_gntr['p_sale'];
		$spc_tblDpl['type'] = $upd_gntr['p_type'];
		$spc_tblDpl['display'] = $upd_gntr['p_display'];
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