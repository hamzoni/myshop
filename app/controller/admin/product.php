<?php
class product extends controller {
	public $page; // set default page
	public $crr_folder;
	public $upl_f_fail;
	public $page_data = array();
	public function __construct() {
		$this->page = "product";
		// CURRENT DIRECTORY
		$this->crr_folder = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
		// ERROR PAGE
		$this->upl_f_fail = 'http://'.$_SERVER['HTTP_HOST'].$this->crr_folder.'error/admin_product';
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];

		if (@isset($_SESSION["ntf"])) {
			$this->page_data["ntf"] = $_SESSION["ntf"];
			unset($_SESSION["ntf"]);
		}
		$this->page_data["page"] = $this->page;
		$this->page_data["base_url"] = $crr_url;
		$this->page_data["header"]["user"] = "admin"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "product";
		$this->page_data["header"]["js"][0] = "product";
		// set add_product form data
		$this->page_data["upload_form"]["handler"] = $this->page_data["base_url"]."/add_product";
		$this->page_data["upload_form"]["file_size"] = 1000*1000; //Bytes

		// call view
		$this->view('admin/main',$this->page_data);

	}
	public function add_product() {
		$mdl_obj = $this->model("admin_model/product");
		// LOCATION OF UPLOAD FORM
		$upl_f = 'http://'.$_SERVER['HTTP_HOST'].$this->crr_folder.'admin/product';
		$f_dt = array();
		try {
			$f_dt["p_name"] = $_POST["p_name"];
			$f_dt["p_price"] = intval($_POST["p_price"]);
			$f_dt["p_sale"] = intval($_POST["p_sale"]) / 100;
			$f_dt["p_type"] = $_POST["p_type"];
			$f_dt["p_dp"] = $_POST["p_display"];
			$f_dt["p_dscr"] = $_POST["f_dscrp"];
		} catch (Exception $e) {};

		// CHECK IF NUMBERIC INPUT IS IN VALID DATA
		if ($f_dt["p_price"] <= 0 
			|| $f_dt["p_sale"] < 0 
			|| $f_dt["p_sale"] >= 1
			|| !is_int($f_dt["p_price"]) 
			|| !is_double($f_dt["p_sale"])) {
			$_SESSION["ntf"] = "Invalid numberic input";
			header("Location: $upl_f");
			return;
		}
		// CHECK IF INPUT IS EMPTY
		if($this->blank_inputChecker($f_dt)) {
			$_SESSION["ntf"] = "Inadequate necessary information";
			header("Location: $upl_f");
			return;
		}
		
		// ALLOCATE IMG TO FOLDER
		$rt_dt = $this->upload_image(); 
		$insert_result = $mdl_obj->insert_record(
			$f_dt["p_name"],$f_dt["p_price"],$f_dt["p_sale"],
			$rt_dt['img_href']['ava'],$rt_dt['img_href']['ntr'],
			$f_dt["p_type"],$f_dt["p_dp"],$f_dt["p_dscr"]);
		if ($insert_result != 1) {
			$this->error($insert_result, $this->upl_f_fail);
		}
		// DIRECT CLIENT TO SUCCESS PAGE
		$_SESSION["ntf"] = "Add new product successful!";
		header('Location: '.$rt_dt['scc_pg']);
	}
	function upload_image() {
		

		// IMAGE STORAGE DIRECTORY
		$shrc_uplF = $_SERVER['DOCUMENT_ROOT'].$this->crr_folder.'img/client/';
		$upl_folder_ava = $shrc_uplF."ava/";
		$upl_folder_ntr = $shrc_uplF."ntr/"; 
		// SUCCESS PAGE
		$upl_f_scc = 'http://'.$_SERVER['HTTP_HOST'].$this->crr_folder.'admin/product/index';
		
		// NAME OF INPUT(s)
		$fld_n_ntr = 'p_nutrition';
		$fld_n_ava = 'p_avatar';
		// UPLOAD ERROR
		$errors = array(1 => 'php.ini max file size exceeded', 
		                2 => 'html form max file size exceeded', 
		                3 => 'file upload was only partial', 
		                4 => 'no file was attached'); 

		// CHECK IF AVAILABLE
		isset($_POST['submit_prd']) 
		    or $this->error('the upload form is needed', $this->upl_f_fail);

		// CHECK PHP's BUILT-IN ERROR
		($_FILES[$fld_n_ntr]['error'] == 0) 
		    or $this->error($errors[$_FILES[$fld_n_ntr]['error']], $this->upl_f_fail);
		($_FILES[$fld_n_ava]['error'] == 0) 
		    or $this->error($errors[$_FILES[$fld_n_ava]['error']], $this->upl_f_fail);
		     
		// CHECK IF HTTP'S SUBJECT UPLOAD
		@is_uploaded_file($_FILES[$fld_n_ntr]['tmp_name']) 
		    or $this->error('Invalid HTTP upload', $this->upl_f_fail);
		@is_uploaded_file($_FILES[$fld_n_ava]['tmp_name']) 
		    or $this->error('Invalid HTTP upload', $this->upl_f_fail);
		     
		// VALIDATION: CHECK IF THIS IMAGE
		@getimagesize($_FILES[$fld_n_ntr]['tmp_name']) 
		    or $this->error('Only image is allowed', $this->upl_f_fail);
		@getimagesize($_FILES[$fld_n_ava]['tmp_name']) 
		    or $this->error('Only image is allowed', $this->upl_f_fail);
		// CREATE A UNIQUE FILE NAME
		$now = time();
		while(file_exists($upl_fn_ava = $upl_folder_ava.$now)) { $now++; };
		while(file_exists($upl_fn_ntr = $upl_folder_ntr.$now)) { $now++; };

		// MOVE FILE TO TARGET LOCATION && ALLOCATE NEW FILE NAME
		// print_r($_FILES[$fld_n_ntr]['tmp_name']);
		// return;
		move_uploaded_file($_FILES[$fld_n_ntr]['tmp_name'], $upl_fn_ntr) 
		    or $this->error('Receiving directory insuffiecient permission', $this->upl_f_fail);
		move_uploaded_file($_FILES[$fld_n_ava]['tmp_name'], $upl_fn_ava) 
		    or $this->error('Receiving directory insuffiecient permission', $this->upl_f_fail);
		$return_data = array();
		$return_data['scc_pg'] = $upl_f_scc;
		$return_data['img_href']['ntr'] = $upl_fn_ntr;
		$return_data['img_href']['ava'] = $upl_fn_ava;
		return $return_data;
	}
	function blank_inputChecker($dt) {
		foreach ($dt as $k => $v) {
			if ($dt[$k] == "" || !isset($dt[$k])) {
				return true;
			}
		}
		return false;
	}
	function error($error, $err_page, $rewind_page = '', $seconds = 10) {
	    header("Location: $err_page");
	    $_SESSION["err"] = $error;
	    $_SESSION["rewind_pg"] = $rewind_page;
	    $_SESSION["rewind_pg_time"]= $seconds;
	    exit; 
	}
}

?>