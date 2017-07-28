<?php
class Wff extends Controller {
    public function index() {
        $this->view('wff/index', []);
    }
	
	public function kyu_belts() {
        $this->view('wff/kyu', []);
    }
	
	public function coach() {
        $this->view('wff/coach', []);
    }
	
	public function guardians_of_fudokan() {
        $this->view('wff/guardians', []);
    }
	
	public function knight_of_fudokan() {
        $this->view('wff/knight', []);
    }
}