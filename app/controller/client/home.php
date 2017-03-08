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
	public $fb_auth;
	private $mdl_fb;
	public function __construct() {
		$this->mdl_gnr_p = $this->model("general","products");
		$this->mdl_gnr_c = $this->model("general","clients");
		$this->mdl_prd = $this->model("client_model/product","products");
		$this->mdl_clt = $this->model("client_model/client","clients");
		$this->mdl_ord = $this->model("client_model/order","orders");
		$this->mdl_pkg = $this->model("client_model/package","packages");
		$this->mdl_fb = $this->model("client_model/fb_auth","users");
		$this->mdl_ban = $this->model("admin_model/user","ban_user");

		$this->profile_ad = getcwd()."/data/";
		$this->profile_fn = "profile.txt";
	}
	public function index() {
		if (!$this->check_is_ajax()) {
			$args = func_get_args();
			$_SESSION['crr_url'] = $args[count($args) - 1];
			$this->load_facebook_url();
			$this->load_header_files();
			$this->load_page_content();
			$this->initiate_pageData();
			// call view
			$this->view('client/home',$this->page_data);
		}
	}
	public function load_page_content() {
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
		// CHANGE PRICE OF PRICE
		$cpg = [$this->page_data["items"]["popular"],
				$this->page_data["items"]["special"],
				$this->page_data["items"]["saleOff"]];
		for ($i = 0; $i < count($cpg); $i++) {
			for ($j = 0; $j < count($cpg[$i]); $j++) {
				$sale = floatval($cpg[$i][$j]['sale']);
				$cpg[$i][$j]['price_s'] = intval($cpg[$i][$j]['price']) * (1 - $sale);
			}
		}
		$this->page_data["items"]["popular"] = $cpg[0];
		$this->page_data["items"]["special"] = $cpg[1];
		// SUGGESTED ITEMS
		$suggestFd = $this->mdl_prd->select_random(10, ["display","1"]);
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
		$this->page_data["items"]["menu"] = json_encode($this->page_data["items"]["menu"]);
		// load page contact data
		$this->page_data["contact"] = $this->load_contact_data();
		// set privilege 
		$this->page_data["USER_PRIVILEGE"] = false;
		if (@$_SESSION['fb_user_data']) {
			$user_id = $_SESSION['fb_user_data']['oauth_uid'];
			$user_id = $this->mdl_fb->user_record_id($user_id);
			$user_id = reset($user_id);
			$ban_stt = $this->mdl_ban->ban_exist($user_id);
			$ban_stt = reset($ban_stt);
			$this->page_data["USER_PRIVILEGE"] = $ban_stt == 0;
			$this->page_data["BAN_STATUS"] = $ban_stt == 1;
		}
	}
	public function load_header_files() {
		$this->page_data["header"]["user"] = "client"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "home";
		$this->page_data["header"]["css"][2] = "color";
		$this->page_data["header"]["js"][0] = "home";
		$this->page_data["header"]["js"][1] = "auth_admin";
		$this->page_data["base_url"] = $_SESSION['crr_url'];
	}	
	public function load_facebook_url() {
		$this->page_data["fb_url"]['href'] = "#";
		$this->page_data["fb_url"]['label'] = "Error";

		try {
            $this->fb_auth = new init($this->mdl_fb);
            $this->page_data["fb_url"] = $this->fb_auth->set_url;
        } catch (FacebookApiException $e) {
            error_log($e);
        } 
	}
	public function load_contact_data() {
		$r = getcwd()."/data/contact.txt";
		$r = $this->load_file_content(false, $r);
		preg_match_all("/{.+}/", $r, $r);
		$r = "\"".$r[0][0]. "\"";
		$r = json_decode(json_decode($r),true);
		return $r;
	}
	public function add_page_view() {
		$dt = $this->open_pageData();

		if (@!$dt[PG_D]["VIEWS"][TODAY_DATE]) $dt[PG_D]["VIEWS"][TODAY_DATE] = 0;
		if (@!$dt[PG_D]["TRANSACTIONS"][TODAY_DATE]) $dt[PG_D]["TRANSACTIONS"][TODAY_DATE] = 0;
		if (@!$dt[PG_D]["ACCOUNTS"][TODAY_DATE]) $dt[PG_D]["ACCOUNTS"][TODAY_DATE] = 0;
		if (@!$dt[PG_D]["INCOMES"][TODAY_DATE]) $dt[PG_D]["INCOMES"][TODAY_DATE] = 0;

		$dt[PG_D]["VIEWS"][TODAY_DATE] += 1;
		$dt[PG_S]["S_VIEWS"] += 1;

		$this->put_pageData($dt);
	}
	public function add_transactions() {
		$dt = $this->open_pageData();

		$dt[PG_D]["TRANSACTIONS"][TODAY_DATE] += 1;
		$dt[PG_S]["S_TRANSACTIONS"] += 1;
		
		$this->put_pageData($dt);
	}
	public function add_accounts() {
		$dt = $this->open_pageData();

		$dt[PG_D]["ACCOUNTS"][TODAY_DATE] += 1;
		$dt[PG_S]["S_ACCOUNTS"] += 1;
		
		$this->put_pageData($dt);
	}
	public function add_incomes($r) {
		$dt = $this->open_pageData();

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
		$_SESSION["fb_id"] = $this->encrypt_decrypt('encrypt', $_SESSION["fb_user_data"]["oauth_uid"]);
		for ($i = 0; $i < 10; $i++) $_SESSION["fb_id"] = md5($_SESSION["fb_id"]);
		$inDB = $this->mdl_clt->chkClientData($_SESSION["fb_id"]);
		$inCK = $this->check_cookie($_SESSION["fb_id"]);

		if ($inDB && $inCK) {
			$this->mdl_clt->update_last_activity($_SESSION["fb_id"]);
			$c_info = $this->mdl_clt->getClientData($_SESSION["fb_id"])[0];
			foreach ($c_info as $k => $v) $_SESSION["client_data"][$k] = $v;
			$_SESSION["client_data"]['tokenKey'] = $_SESSION["fb_id"];
			print_r(json_encode($_SESSION["client_data"]));
		} else {
			$_SESSION["client_data"] = null;
			$this->unset_cookie($_SESSION["fb_id"]);
			$this->mdl_clt->deleteClientData($_SESSION["fb_id"]);
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
		    setcookie($cookie_name, false, time() - 3600,"/");
		  	unset($_COOKIE[$cookie_name]);
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
		setcookie($cn, $cv, time() + (86400 * $exd),"/");
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
	public function push_shipInfo() {
		$this->add_page_view();
		$r = $this->shipInfo(json_decode($_GET["r"]));
	}
	public function shipInfo($shipIfd) {
		$shipIfd->tokenKey = $_SESSION["fb_id"];
		$shipIfd->last_update = date('Y-m-d H:i:s',time());;
		$shipIfd_arr = json_decode(json_encode($shipIfd),true);
		
		$exd_ck = time() + 86400 * 30;
		if (@(!is_null($_SESSION["client_data"]) && isset($_SESSION["client_data"]))) {
			$clt_dta_arr = json_decode(json_encode($_SESSION["client_data"]),true);
			if ($this->checkDiff($clt_dta_arr, $shipIfd_arr)) {
				$this->mdl_clt->updateClientInfo($shipIfd);
				if ($shipIfd->saveData == 1) {
					setcookie($_SESSION["fb_id"],time(),$exd_ck, '/');
				} else {
					unset($_SESSION["client_data"]);
					$this->unset_cookie($_SESSION["fb_id"]);
					$this->mdl_clt->deleteClientData($_SESSION["fb_id"]);
				}
			}
		} else {
			if ($shipIfd->saveData == 1) {
				$_SESSION["client_data"] = $shipIfd_arr;
				setcookie($_SESSION["fb_id"], time() ,$exd_ck, '/');
				$this->mdl_clt->insert_clientInfo($shipIfd);
				$this->add_accounts();
			} else {
				unset($_SESSION["client_data"]);
				$this->unset_cookie($_SESSION["fb_id"]);
				$this->mdl_clt->deleteClientData($_SESSION["fb_id"]);
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
		$this->shipInfo($cartIfd->client);
		if (count($cartIfd->cart->items_list) <= 0) return;
		$insert_content = [
			"name" => $cartIfd->client->name,
			"phone" => $cartIfd->client->phone,
			"address" => $cartIfd->client->address,
			"tokenKey" => $cartIfd->client->tokenKey,
			"client_id" => $cartIfd->client->id,
			"totalValue" => $cartIfd->cart->total_bill,
			"client_notes" => $cartIfd->cart->order_note
		];
		$ord_id = $this->mdl_ord->insert_order($insert_content);
		$items_list = $cartIfd->cart->items_list;
		$total_pQty = 0;
		for ($i = 0; $i < count($items_list); $i++) {
			$totalPrice = $items_list[$i]->price_s * $items_list[$i]->qty;
			$total_pQty += $items_list[$i]->qty;
			$this->mdl_pkg->insert_package($items_list[$i]->id,
											$ord_id,
											$items_list[$i]->qty,
											$totalPrice,
											$items_list[$i]->note,
											$items_list[$i]->store_id);
			$this->mdl_prd->add_purchase_count($items_list[$i]->id, $items_list[$i]->qty);
		}

		$c_PC = $total_pQty;
		$c_PV = $cartIfd->cart->total_bill;
		$this->mdl_clt->upd_client_record($_SESSION["fb_id"], $cartIfd->cart->total_bill, $c_PC, $c_PV);
		$this->add_incomes($cartIfd->cart->total_bill);
		$this->add_transactions();
	}
	public function check_ADlogin_stt() {
		if (@!$_SESSION["admin_login"]) {
			echo 0;
		} else { 
			echo $_SESSION["admin_login"]["url"]; 
		}
	}
	public function get_ord_antiquity() {
		$r = json_decode($_GET["r"],true);
		$aqd_data = [];
		$slc_cols = ["id","time_order","address","ship_status"];
		$qry_data = [
			"cnd1" => ["tokenKey",$r["tk"]],
			"cnd2" => ["display","1"],
			"cnd3" => ["client_id",$r["c_id"]],
			"sort" => ["time_order","DESC"],
			"mere" => [$r["limit"],$r["offset"]]
		];
		$ord_data = $this->mdl_ord->select_order($qry_data,$slc_cols);
		for ($i = 0; $i < count($ord_data); $i++) {
			$aqd_data[$i] = array();
			$aqd_data[$i]["ord"] = [];
			foreach ($ord_data[$i] as $k => $v) {
				$aqd_data[$i]["ord"][$k] = $v;
			}
			$aqd_data[$i]["prd"] = array();
			// select pkg_qty, pkg_ttp, pkg_prd_id => prd_name, prd_price
			$pkg_slc_cols = ["product_id","qty","prcTotal"];
			$pkg_data = $this->mdl_pkg->slc_spec($pkg_slc_cols, 
														  "order_id", 
														  $ord_data[$i]["id"]);
			for ($j = 0; $j < count($pkg_data); $j++) {
				$ord_slc_cols = ["name","price","avatar_img"];
				$prd_data = $this->mdl_prd->slc_spec_unique($ord_slc_cols,"id",$pkg_data[$j]["product_id"]);
				$aqd_data[$i]["prd"][$j] = [
					"name" => $prd_data["name"],
					"price" => $prd_data["price"],
					"qty" => $pkg_data[$j]["qty"],
					"prcTotal" => $pkg_data[$j]["prcTotal"],
					"thumbnail" => $prd_data["avatar_img"]
				];
			}
		}
		print_r(json_encode($aqd_data));
	}
	public function change_display_orders() {
		$r = $_GET["r"];
		$r = json_decode($r);
		print_r($r);
		$r = $this->mdl_ord->edit_display('0',$r);
		
	}
	public function count_orders_wcd() {
		$r = json_decode($_GET["r"],true);
		$d[0] = $this->mdl_ord->count_orders_wCnds([["tokenKey",$r['tk']],
													["client_id",$r['c_id']]]);
		$d[1] = $this->mdl_ord->count_orders_wCnds([["tokenKey",$r['tk']],
													["client_id",$r['c_id']],
													["display",$r['dp']]]);
		$d[0] = reset($d[0]);
		$d[1] = reset($d[1]);
		$d = json_encode($d);
		print_r($d);
	}
	public function fb_login() {
		header("Location:".BASE_URL);
	}
	public function fb_logout() {
		$this->fb_auth = new init($this->mdl_fb);
		unset($_SESSION["fb_user_data"]);
		$this->fb_auth->facebook->destroySession();
		header("Location:".BASE_URL);
	}
	public function last_ord_ID() {
		print_r($this->mdl_ord->getlast_ord_ID());
	}
}

?>