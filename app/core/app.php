<?php
class app { // MAIN FUNCTION: ROUTING
	public $cc;
	protected $component = '';
	protected $controller = '';
	protected $method = '';
	protected $params = [];
	public $base_url = ''; 
	public function __construct() {
		session_start();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->base_url = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
		$url = $this->parseUrl();
		// set default component/controller/method
		if ($url[0] == 'admin') {
			$this->component = 'admin';
			$this->controller = 'order';
			$this->method = 'index';
		} else {
			$this->component = 'client';
			$this->controller = 'home';
			$this->method = 'index';
		}
		// check existed component & controller
		if (@file_exists('../app/controller/'.$url[0].'/'.$url[1].'.php')) {
			$this->component = $url[0];
			$this->controller = $url[1];
			unset($url[0]); unset($url[1]);
		}
		$this->base_url .= $this->component;
		$this->base_url .= "/".$this->controller;

		require_once '../app/controller/'.$this->component.'/'.$this->controller.'.php';
		$this->controller = new $this->controller;
		
		// check existed method 
		if (isset($url[2])) {
			if (method_exists($this->controller, $url[2])) {
				$this->method = $url[2];
			} else {
				$this->method = "page_not_found";
			}
			unset($url[2]);
		}
		$this->params = $url ? array_values($url) : [];
		$this->params[] = $this->base_url;
		call_user_func_array([$this->controller,$this->method], $this->params);
	}
	public function parseUrl() {
		if (isset($_GET['url'])) {
			$url_str = filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL);
			return $url = explode('/', $url_str);
		}
	}
}