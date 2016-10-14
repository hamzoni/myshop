<?php
class home extends controller {
	public function __construct() {
		
	}
	public function index($param1 = '', $param2 = '') { // DEFAULT METHOD
		
		/* sample
		echo $param1."<br>".$param2;
		$data = $this->model('client_model/home');
		$data->name = $name;
		$this->view('client/home',['name' => $data->name]);
		**echo data: <?=$data['name'] ? >
		*/
		$this->page_data["header"]["user"] = "client"; 
		$this->page_data["header"]["css"][0] = "main";
		$this->page_data["header"]["css"][1] = "home";
		$this->page_data["header"]["css"][2] = "color";
		$this->view('client/home',$this->page_data);
	}
}

?>