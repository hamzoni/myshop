<?php
class contact extends controller {
	public $page;
	public $page_data = array();
	public $fp_s;
	public $fp_n;
	public function __construct() {
		$this->AUTHc = new AUTH("admin");
		$this->AUTHc->check_login();
		
		$this->page = "contact";
		$this->fp_s = getcwd()."/data/";
		$this->fp_n = "contact.txt";
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];

		$this->page_data["page"] = $this->page;
		$this->page_data["preface_pgc"] = "Website Contact Data";
		$this->page_data["base_url"] = $crr_url; 
		
		$this->page_data["header"]["user"] = "admin"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "contact";
		$this->page_data["header"]["js"][0] = "contact";

		$this->view('admin/main',$this->page_data);
	}
	public function store_pageInfo() {
		$r = $_GET["r"];
		$r = json_encode($r);
		$file_path = $this->fp_s.$this->fp_n;
		if (!is_dir($this->fp_s)) mkdir($this->fp_s);
		$fp = fopen($file_path, "w+");
		fwrite($fp, $r);
		fclose($fp);
		$this->encrypt_file($file_path,$file_path); // return bool
	}
	public function load_pageInfo($ajax = true) {
		if(!$fp = $this->decrypt_file($this->fp_s.$this->fp_n)) {
			if ($ajax) echo 0;
			return false;
		}
		$contents = stream_get_contents($fp);
		if ($ajax) {
			print_r($contents);
		} else {
			return $contents;
		}
	}
	public function upl_trademark() {
		$dir_s = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 
		$dir_s = $_SERVER['DOCUMENT_ROOT'].$dir_s; 

		// STORE PAGE LOGO
		$fd = ['img/hybrid/','img/'];
		$fn = ['logo_imgFile','favi_ic'];

		for ($i = 0; $i < 2; $i++) {
			if (!empty($_FILES[$fn[$i]]['tmp_name'])) {
				$fs = glob($dir_s.$fd[$i]."*"); 
				foreach($fs as $f){ 
					if(is_file($f)) unlink($f);
				}
				if ($i == 0) {
					$upl_fs = $fd[$i].md5(time());
					$this->store_page_logo($upl_fs);
				} else {
					$upl_fs = $fd[$i].'favicon.ico';
				}
				$upl_fn = $dir_s.$upl_fs;
				echo json_encode(["file_name"=>$upl_fs]);
				move_uploaded_file($_FILES[$fn[$i]]['tmp_name'], $upl_fn);
			}
		}
	}
	public function file_check_err($f) {
		$errors = array(1 => 'php.ini max file size exceeded', 
		                2 => 'html form max file size exceeded', 
		                3 => 'file upload was only partial', 
		                4 => 'no file was attached'); 
		if (!$f['error'] == 0) {
			return json_encode(["error"=>$errors[$f['error']]]);
		}
		if (!is_uploaded_file($f['tmp_name'])) {
			return json_encode(["error"=>'not an HTTP upload']);
		}
		if (!getimagesize($f['tmp_name'])) {
			return json_encode(["error"=>'only image uploads are allowed']);
		}
		return false;
	}
	protected function store_page_logo($x) {
		$f_src = realpath(__DIR__ . '/../../view/admin/main.php');
		$f_ctn = file_get_contents($f_src);
		$rp_st = "<img id=\"company_logo\" src=\"".$x."\">";
		$regex = "/\<img id=\"company_logo\".*?\>/";
		$f_ctn = preg_replace($regex, $rp_st, $f_ctn);
		file_put_contents($f_src, $f_ctn);
		// $doc = new DOMDocument();
		// libxml_use_internal_errors(true);
		// $doc->loadHTMLFile($f_src);
		// libxml_clear_errors();
		// $dom = $doc->getElementById("company_logo");
		// $dom->setAttribute('src',$x);
		// $doc->saveHTMLFile($f_src);
	}
}