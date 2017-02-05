<?php
class home extends controller {
	private $mdl_prd; // model of tbl: products
	private $mdl_clt; // model of tbl: clients
	private $mdl_ord;
	private $mdl_pkg;
	private $mdl_gnr_p; // general model of tbl: products
	private $mdl_gnr_c; // general model of tbl: clients
	public $profile_ad;
	public $profile_fn;
	public function __construct() {
		$this->mdl_gnr_p = $this->model("general","products");
		$this->mdl_gnr_c = $this->model("general","clients");
		$this->mdl_prd = $this->model("client_model/product","products");
		$this->mdl_clt = $this->model("client_model/client","clients");
		$this->mdl_ord = $this->model("client_model/order","orders");
		$this->mdl_pkg = $this->model("client_model/package","packages");

		$this->profile_ad = getcwd()."/data/";
		$this->profile_fn = "profile.txt";
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];
		$this->add_page_view();
		$this->check_pageData();
		
		if (@isset($_SESSION["ntf"])) {
			$this->page_data["ntf"] = $_SESSION["ntf"];
			unset($_SESSION["ntf"]);
		}
		$this->page_data["header"]["user"] = "client"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "home";
		$this->page_data["header"]["css"][2] = "color";
		$this->page_data["header"]["js"][0] = "home_data";
		$this->page_data["header"]["js"][1] = "home";
		$this->page_data["header"]["js"][2] = "auth_admin";
		$this->page_data["base_url"] = $crr_url;

		// total records in view products table
		$_SESSION["total_records"] = $this->mdl_gnr_p->countAll()["COUNT(*)"];
		$this->page_data["total_records"] = $_SESSION["total_records"];
		// set data for view products
		$_SESSION["crr_offset"] = 0;
		$_SESSION["slc_lm"] = 12;
		$this->page_data["slc_lm"] = $_SESSION["slc_lm"];
		$this->page_data["crr_offset"] = $_SESSION["crr_offset"];
		// ITEMS DATA
		// POPULAR ITEMS
		$this->page_data["items"]["popular"] = $this->mdl_prd->select_byGenre("purchase_count",1,10,[["display","1"],null]); // Sort 1 == DESC, Limit 10 == Display 10 rows
		// SALE ITEMS
		$this->page_data["items"]["saleOff"] = $this->mdl_prd->select_byGenre("sale",1,null,[["display","1"],["type","2"]]);
		// SPECIAL ITEMS
		$this->page_data["items"]["special"] = $this->mdl_prd->select_byGenre("post_date",1,null,[["display","1"],["type","1"]]);
		// SUGGESTED ITEMS
		$suggestFd = $this->mdl_prd->select_byGenre("post_date",1,null,[["display","1"],["type","3"]]);
		if (count($suggestFd) > 3) {
			$nbOfDiv = ceil(count($suggestFd)/3);
			for ($i = 0, $n = 0; $i < $nbOfDiv, $n < count($suggestFd); $i++) {
				while ($n < 3*($i + 1)) {
					$this->page_data["items"]["suggest"][$i][] = $suggestFd[$n];
					$n++;
					if ($n == count($suggestFd)) {
						break;
					}
				}
			}
		} else {
			$this->page_data["items"]["suggest"][0] = $suggestFd;
		}
		// select offset 12 items
		$this->page_data["items"]["menu"] = $this->mdl_prd->select_prdPager($this->page_data["slc_lm"], $_SESSION["crr_offset"]);
		// call view
		$this->view('client/home',$this->page_data);
	}
	public function add_page_view() {
		$dt = $this->get_pageData();

		
		$dt[PG_D]["VIEWS"][TODAY_DATE] += 1;
		$dt[PG_S]["S_VIEWS"] += 1;

		$this->put_pageData($dt);

		// $dt = $this->get_pageData();
		// for ($i = 0; $i < 700; $i++) {
			
		// 	$rand = ceil(rand() * 20000);
		// 	if (@!$dt[PG_D]["VIEWS"][TODAY_DATE - 86400 * ($i + 1)]) $dt[PG_D]["VIEWS"][TODAY_DATE - 86400 * ($i + 1)] = 0;
		// 	$dt[PG_D]["VIEWS"][TODAY_DATE - 86400 * ($i + 1)] += $rand;
		// 	$dt[PG_S]["S_VIEWS"] += $rand;

		// 	$rand = ceil(rand() * 1000);
		// 	if (@!$dt[PG_D]["TRANSACTIONS"][TODAY_DATE - 86400 * ($i + 1)]) $dt[PG_D]["TRANSACTIONS"][TODAY_DATE - 86400 * ($i + 1)] = 0;
		// 	$dt[PG_D]["TRANSACTIONS"][TODAY_DATE - 86400 * ($i + 1)] += $rand;
		// 	$dt[PG_S]["S_TRANSACTIONS"] += $rand;

		// 	$rand = ceil(rand() * 300);
		// 	if (@!$dt[PG_D]["ACCOUNTS"][TODAY_DATE - 86400 * ($i + 1)]) $dt[PG_D]["ACCOUNTS"][TODAY_DATE - 86400 * ($i + 1)] = 0;
		// 	$dt[PG_D]["ACCOUNTS"][TODAY_DATE - 86400 * ($i + 1)] += $rand;
		// 	$dt[PG_S]["S_ACCOUNTS"] += $rand;

		// 	$rand = rand(500000,50000000);
		// 	if (@!$dt[PG_D]["INCOMES"][TODAY_DATE - 86400 * ($i + 1)]) $dt[PG_D]["INCOMES"][TODAY_DATE - 86400 * ($i + 1)] = 0;
		// 	$dt[PG_D]["INCOMES"][TODAY_DATE - 86400 * ($i + 1)] += $rand;
		// 	$dt[PG_S]["S_INCOMES"] += $rand;

		// 	$this->put_pageData($dt);
		// }

	}
	public function add_transactions() {
		$dt = $this->get_pageData();

		$dt[PG_D]["TRANSACTIONS"][TODAY_DATE] += 1;
		$dt[PG_S]["S_TRANSACTIONS"] += 1;
		
		$this->put_pageData($dt);
	}
	public function add_accounts() {
		$dt = $this->get_pageData();

		$dt[PG_D]["ACCOUNTS"][TODAY_DATE] += 1;
		$dt[PG_S]["S_ACCOUNTS"] += 1;
		
		$this->put_pageData($dt);
	}
	public function add_incomes() {
		$r = $_GET["r"];
		$dt = $this->get_pageData();

		$dt[PG_D]["INCOMES"][TODAY_DATE] += $r;
		$dt[PG_S]["S_INCOMES"] += $r;

		$this->put_pageData($dt);
	}
	public function load_Adprofile() {
		if(!$fp = $this->decrypt_file($this->profile_ad.$this->profile_fn)) {
			echo 0;
			return false;
		}
		$contents = stream_get_contents($fp);
		print_r($contents);
	}
	public function create_AdSession() {
		$last_login = $_GET["r"];
		$AUTH = new AUTH("admin");
		print_r($AUTH->create_login($last_login));
	}
	public function chgPag() {
		$_SESSION["crr_offset"] = $_SESSION["slc_lm"]*($_POST["pg_selector"] - 1);
		$chgPgResult = $this->mdl_prd->getMainDishes($_SESSION["slc_lm"],$_SESSION["crr_offset"]);
		print_r(json_encode($chgPgResult));
	}
	public function chkckk_ajx() {
		$_SESSION["user_ip"] = $this->encrypt_decrypt('encrypt', $this->get_client_ip());
		$inDB = $this->mdl_clt->chkClientData($_SESSION["user_ip"]);
		$inCK = $this->check_cookie($_SESSION["user_ip"]);
		if ($inDB && $inCK) {
			$c_info = $this->mdl_clt->getClientData($_SESSION["user_ip"]);
			foreach ($c_info as $k => $v) {
				$_SESSION["client_data"][$k] = $v;
			}
			$_SESSION["client_data"]['tokenKey'] = $_SESSION["user_ip"];
			print_r(json_encode($_SESSION["client_data"][0]));
		} else {
			$_SESSION["client_data"] = null;
			$this->unset_cookie($_SESSION["user_ip"]);
			$this->mdl_clt->deleteClientData($_SESSION["user_ip"]);
		}
	}
	public function check_cookie($cookie_name) {
		if (isset($_COOKIE[$cookie_name])) {
			return true;
		}
		return false;
	}
	public function unset_cookie($cookie_name) {
		if (isset($_COOKIE[$cookie_name])) {
		    unset($_COOKIE[$cookie_name]);
		    setcookie($cookie_name, null, -1, '/');
		    return true;
		} else {
		    return false;
		}
	}
	public function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
	public function setCookie($cn,$cv,$exd) {
		setcookie($cn, $cv, time() + (86400 * $exd), '/');
	}
	public function encrypt_decrypt($action, $string) {
	    $output = false;

	    $encrypt_method = "AES-256-CBC";
	    $secret_key = md5($string);
	    $secret_iv = md5($secret_key);

	    // hash
	    $key = hash('sha256', $secret_key);
	    
	    // iv - encrypt method AES-256-CBC expects 16 bytes 
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);

	    if( $action == 'encrypt' ) {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    }
	    else if( $action == 'decrypt' ){
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
	    return $output;
	}
	public function shipInfo() {
		$shipIfd = json_decode($_GET["clt_spI"]);
		$shipIfd->tokenKey = $_SESSION["user_ip"];
		if (@(!is_null($_SESSION["client_data"]) && isset($_SESSION["client_data"]))) {
			if ($this->checkDiff($_SESSION["client_data"], $shipIfd)) {
				$this->mdl_clt->updateClientInfo($shipIfd);
				if ($shipIfd->saveData != 0) {
					$exd_ck = intval(round(microtime(true) * 1000) + 86400);
					setcookie($_SESSION["user_ip"],time(),$exd_ck, '/');
				} else {
					$this->unset_cookie($_SESSION["user_ip"]);
				}
			}
		} else {
			if ($shipIfd->saveData != 0) {
				$exd_ck = intval(round(microtime(true) * 1000) + 86400);
				setcookie($_SESSION["user_ip"],time(),$exd_ck, '/');
				$this->mdl_clt->insert_clientInfo($shipIfd);
			} else {
				$this->unset_cookie($_SESSION["user_ip"]);
			}
		}
	}
	public function checkDiff($dtdb, $input) {
		foreach ($input as $k => $v) {
			if ($dtdb[$k] != $v) {
				return true;
			}
		}
		return false;
	}
	public function send_cart() {
		$cartIfd = json_decode($_GET["clt_spI"]);
		$insertOrder = $this->mdl_ord->insert_order($cartIfd->client->name,
													$cartIfd->client->phone,
													$cartIfd->client->address);
		$items_list = $cartIfd->cart->items_list;
		for ($i = 0; $i < count($items_list); $i++) {
			$totalPrice = $items_list[$i]->price * $items_list[$i]->qty;
			$this->mdl_pkg->insert_package($items_list[$i]->id,
											$insertOrder,
											$items_list[$i]->qty,
											$totalPrice);
		}
		$this->add_transactions();
	}
	public function check_ADlogin_stt() {
		if (@!$_SESSION["admin_login"]) {
			echo 0;
		} else { 
			echo $_SESSION["admin_login"]["url"]; 
		}
	}
}

?>