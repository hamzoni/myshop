<?php
class product extends controller {
	public $page; // set default page
	public $page_data = array();
	public function __construct() {
		$this->page = "product";
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];

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
		// CURRENT DIRECTORY
		$crr_folder = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 

		// IMAGE STORAGE DIRECTORY
		$shrc_uplF = $_SERVER['DOCUMENT_ROOT'].$crr_folder.'img/client/';
		$upl_folder_ava = $shrc_uplF."ava/";
		$upl_folder_ntr = $shrc_uplF."ntr/"; 
		// LOCATION OF UPLOAD FORM
		$upl_f = 'http://'.$_SERVER['HTTP_HOST'].$crr_folder.'admin/product'; ;
		// SUCCESS PAGE
		$upl_f_scc = 'http://'.$_SERVER['HTTP_HOST'].$crr_folder.'admin/product/upload_success';
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
		    or $this->error('the upload form is needed', $upl_f); 

		// CHECK PHP's BUILT-IN ERROR
		($_FILES[$fld_n_ntr]['error'] == 0) 
		    or $this->error($errors[$_FILES[$fld_n_ntr]['error']], $upl_f); 
		($_FILES[$fld_n_ava]['error'] == 0) 
		    or $this->error($errors[$_FILES[$fld_n_ava]['error']], $upl_f); 
		     
		// CHECK IF HTTP'S SUBJECT UPLOAD
		@is_uploaded_file($_FILES[$fld_n_ntr]['tmp_name']) 
		    or $this->error('Invalid HTTP upload', $upl_f); 
		@is_uploaded_file($_FILES[$fld_n_ava]['tmp_name']) 
		    or $this->error('Invalid HTTP upload', $upl_f); 
		     
		// VALIDATION: CHECK IF THIS IMAGE
		@getimagesize($_FILES[$fld_n_ntr]['tmp_name']) 
		    or $this->error('Only image is allowed', $upl_f); 
		@getimagesize($_FILES[$fld_n_ava]['tmp_name']) 
		    or $this->error('Only image is allowed', $upl_f); 
		// CREATE A UNIQUE FILE NAME
		$now = time();
		while(file_exists($upl_fn_ava = $upl_folder_ava.$now)) { $now++; };
		while(file_exists($upl_fn_ntr = $upl_folder_ntr.$now)) { $now++; };

		// MOVE FILE TO TARGET LOCATION && ALLOCATE NEW FILE NAME
		print_r($_FILES[$fld_n_ntr]['tmp_name']);
		return;
		@move_uploaded_file($_FILES[$fld_n_ntr]['tmp_name'], $upl_fn_ntr) 
		    or $this->error('Receiving directory insuffiecient permission', $upl_f); 
		@move_uploaded_file($_FILES[$fld_n_ava]['tmp_name'], $upl_fn_ava) 
		    or $this->error('Receiving directory insuffiecient permission', $upl_f); 
		// DIRECT CLIENT TO SUCCESS PAGE
		header('Location: '.$upl_f_scc);
	}
	public function upload_success() {
		echo "Upload file successful";
	}
	function error($error, $location, $seconds = 99) { 
	    header("Refresh: $seconds; URL='$location'"); 
	    echo "Error found:".$error;
	    exit; 
	}
}

?>