<?php
class home extends controller {
	private $mdl_prd; // model of tbl: products
	private $mdl_clt; // model of tbl: clients
	private $mdl_gnr_p; // general model of tbl: products
	private $mdl_gnr_c; // general model of tbl: clients
	public function __construct() {
		$this->mdl_gnr_p = $this->model("general","products");
		$this->mdl_gnr_c = $this->model("general","clients");
		$this->mdl_prd = $this->model("client_model/product","products");
		$this->mdl_clt = $this->model("client_model/client","clients");
	}
	public function index() {
		$args = func_get_args();
		$crr_url = $args[count($args) - 1];
		if (@isset($_SESSION["ntf"])) {
			$this->page_data["ntf"] = $_SESSION["ntf"];
			unset($_SESSION["ntf"]);
		}
		$this->page_data["header"]["user"] = "client"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "home";
		$this->page_data["header"]["css"][2] = "color";
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
	public function chgPag() {
		$_SESSION["crr_offset"] = $_SESSION["slc_lm"]*($_POST["pg_selector"] - 1);
		$chgPgResult = $this->mdl_prd->getMainDishes($_SESSION["slc_lm"],$_SESSION["crr_offset"]);
		print_r(json_encode($chgPgResult));
	}
}

?>