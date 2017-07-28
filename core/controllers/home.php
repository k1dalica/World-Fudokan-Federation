<?php
class Home extends Controller {
    public function index() {
        $this->view('home/index', []);
    }
	
	public function countries() {
        $this->view('home/countries', []);
    }
	
	public function logout() {
        $this->view('home/logout', []);
    }
}