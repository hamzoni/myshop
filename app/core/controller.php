<?php
class controller {
	public function model($model_name) {
		require_once '../app/model/'.$model_name.'.php';
		$model = explode("/",$model_name);
		$model[1] = $model[1]."_c";
		return new $model[1]();
	}
	public function view($view, $data) {
		require_once '../app/view/'.$view.'.php';
	}
}