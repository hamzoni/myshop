<?php
class profile extends controller {
	public $page;
	public $page_data = array();
	public $profile_ad;
	public $profile_fn;
	public function __construct() {
		$this->AUTHc = new AUTH("admin");
		$this->AUTHc->check_login();
		
		$this->page = "profile";
		$this->profile_ad = getcwd()."/data/";
		$this->profile_fn = "profile.txt";
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];

		$this->page_data["page"] = $this->page;
		$this->page_data["preface_pgc"] = "Admin profile";
		$this->page_data["base_url"] = $crr_url; 
		
		$this->page_data["header"]["user"] = "admin"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "profile";
		$this->page_data["header"]["js"][0] = "profile";

		$this->view('admin/main',$this->page_data);
	}
	public function store_profile() {
		$content = json_encode($_GET["r"]);
		echo $content;
		$file_path = $this->profile_ad.$this->profile_fn;
		if (!is_dir($this->profile_ad)) mkdir($this->profile_ad);
		$fp = fopen($file_path, "w+");
		fwrite($fp, $content);
		fclose($fp);
		if($this->encrypt_file($file_path,$file_path)) {
			// echo "Upload successful";
		} else {
			// echo "Unable to upload file.";
		}
	}
	public function load_profile($ajax = true) {
		if(!$fp = $this->decrypt_file($this->profile_ad.$this->profile_fn)) {
			if ($ajax) {
				echo 0;
			}
			return false;
		}
		$contents = stream_get_contents($fp);
		if ($ajax) {
			print_r($contents);
		} else {
			return $contents;
		}
	}
	public function upl_admin_avatar() {
		$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 
		$specific_folder = 'img/admin/profile/avatar/';
		$uploadsDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self; 
		$fieldname = 'upl_avaCtner'; 
		// remove file available in folder 
		$files = glob($uploadsDirectory.$specific_folder."*"); 
		foreach($files as $file){ 
			if(is_file($file)) unlink($file);
		}
		// validation 
		$errors = array(1 => 'php.ini max file size exceeded', 
		                2 => 'html form max file size exceeded', 
		                3 => 'file upload was only partial', 
		                4 => 'no file was attached'); 
		if (!$_FILES[$fieldname]['error'] == 0) {
			echo json_encode(["error"=>$errors[$_FILES[$fieldname]['error']]]);
			return;
		}
		if (!is_uploaded_file($_FILES[$fieldname]['tmp_name'])) {
			echo json_encode(["error"=>'not an HTTP upload']);
			return;
		}
		if (!getimagesize($_FILES[$fieldname]['tmp_name'])) {
			echo json_encode(["error"=>'only image uploads are allowed']);
			return;
		}
		$uploadFilestore = $specific_folder.md5(time());
		$uploadFilename = $uploadsDirectory.$uploadFilestore;
		if(!move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadFilename)) {
			echo json_encode(["error"=>'receiving directory insuffiecient permission']); 
		} else {
			echo json_encode(["file_name"=>$uploadFilestore]);
		}
	}
}