<?php

class Controller {
    protected function model($model) {
        require_once 'core/models/' . $model . '.php';
        return new $model();
    }
    
    public function view($view, $data = []) {
		$path = '/public/';
		$imgspath = '/public/images/';
		
        require_once 'public/header.php';
        require_once 'views/' . $view . '.php';
        require_once 'public/side.php';
        require_once 'public/footer.php';
    }
}