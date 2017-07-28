<?php
class Kyubelts {
	private $_result = array();
	private $_count = 0;
	private $_db;
	
	public function __construct($country = '') {
		$_db = DB::getInstance()->query("SELECT * FROM `kyubelts` WHERE `country`='$country'", []);
		if(!$_db->error()) {
			$this->_result = $_db->results();
			$this->_count = $_db->count();
		}
	}
	public function count() {
		return $this->_count;
	}
	
	public function get() {
		return $this->_result;
	}
}