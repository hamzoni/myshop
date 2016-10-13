<?php
class app { // MAIN FUNCTION: ROUTING
	protected $component = '';
	protected $controller = '';
	protected $method = '';
	protected $params = [];
	public function __construct() {
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
		require_once '../app/controller/'.$this->component.'/'.$this->controller.'.php';
		$this->controller = new $this->controller;
		// check existed method 
		if (isset($url[2])) {
			if (method_exists($this->controller, $url[2])) {
				$this->method = $url[2];
				unset($url[2]);
			}
		}
		$this->params = $url ? array_values($url) : [];
		call_user_func_array([$this->controller,$this->method], $this->params);
	}
	public function parseUrl() {
		if (isset($_GET['url'])) {
			$url_str = filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL);
			return $url = explode('/', $url_str);
		}
	}
}