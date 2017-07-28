<?php
class Posts {
	private $_post = array();
	private $_count = 0;
	private $_db;
	
	public function __construct() {
		$_db = DB::getInstance()->query('SELECT * FROM `posts` ORDER BY date DESC', []);
		if(!$_db->error()) {
			$this->_post = $_db->results();
			$this->_count = $_db->count();
		}
	}
	public function count() {
		return $this->_count;
	}
	
	public function get() {
		return $this->_post;
	}
	
	public function show($post) {
		if($post->attr!="") $imageDivShow = "<div class='image'><img src='{$post->attr}'></div>"; else $imageDivShow = "";
		$date = covertDate($post->date);
		echo "<article class='mb'>
			<div class='header'>
				<span class='title'>{$post->title}</span>
				<span class='date'>Published: {$date}</span>
			</div>{$imageDivShow}<div class='text'>{$post->text}</div>
		</article>";
	}
}