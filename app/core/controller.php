<?php
class controller extends general {
	public function model($model_name,$table_name = null) {
		require_once '../app/model/'.$model_name.'.php';
		$model = explode("/",$model_name);

		$idx = count($model) == 1 ? 0 : 1;
		$model[$idx] = $model[$idx]."_c";
		return new $model[$idx]($table_name);
	}
	public function view($view, $data) {
		require_once '../app/view/'.$view.'.php';
	}
}