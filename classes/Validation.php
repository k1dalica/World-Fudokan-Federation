<?php

class Validation {
	private $_passed = false,
			$_errors = array(),
			$_db = null;
			
	public function __construct() {
		$this->_db = DB::getInstance();
	}
	
	public function check($source, $items = array()) {
		foreach($items as $item => $rules) {
			$fieldname = $item;
			foreach($rules as $rule => $rule_value) {
				if($rule=="fieldname") {
					$fieldname = $rule_value;
				}
				$value = trim($source[$item]);
				if($rule === 'required' && empty($value)) {
					$this->addError("Field <b>{$fieldname}</b> is required.");
				} else if(!empty($value)) {
					switch($rule) {
						case 'fieldname':
							$fieldname = $rule_value;
						break;	
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$fieldname} needs to have at least {$rule_value} characters.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$fieldname} can have maximum {$rule_value} characters.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError("{$rule_value} isn't same as in this {$fieldname} field.");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()) {
								$this->addError("{$fieldname} already exists.");
							}
						break;
                        case 'equals':
							if($value != $rule_value) {
								$this->addError("{$fieldname} doesnt match.");
							}
						break;
						case 'email':
							if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
								$this->addError("Invalid email adress.");
							}
						break;
						case 'less':
							if(intval($value) > intval($rule_value)) {
								$this->addError("{$fieldname} must be less then $rule_value");
							}
						break;
						case 'greater':
							if(intval($value) < intval($rule_value)) {
								$this->addError("{$fieldname} must be greater then $rule_value");
							}
						break;
					}
				}
			}
		}
		
		if(empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}
	
	private function addError($error) {
		$this->_errors[] = $error;
	}
	
	public function errors() {
		return $this->_errors;
	}
	
	public function passed() {
		return $this->_passed;
	}
}