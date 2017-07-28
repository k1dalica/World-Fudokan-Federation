<?php
class Referee extends Controller {
    public function index() {
        $this->view('referee/index', []);
    }
	
	public function fudokan() {
        $this->view('referee/fudokan', []);
    }
}