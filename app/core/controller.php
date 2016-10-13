<?php
class controller {
	public function model($model_name) {
		require_once '../app/model/'.$model.'_model.php';
		return new $model();
	}
	public function view($view, $data) {
		require_once '../app/view/'.$view.'.php';
	}
}