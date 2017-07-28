<?php
session_start();
$action = $_POST['action'];
$id = $_POST['id'];
		
try {
	$pdo = new PDO('mysql:host=127.0.0.1;dbname=wff', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch(PDOException $e) {
	die($e->getMessage());	
}

if($action=="deleteitem") {
	$kac = $_POST['from'];
	switch($kac) {
		case '1': $t = 'blackbelts'; break;
		case '2': $t = 'kyubelts'; break;
		case '3': $t = 'coaches'; break;
		case '4': $t = 'refereegk'; break;
		case '5': $t = 'refereef'; break;
	}
	$query = $pdo->query("SELECT * FROM {$t} WHERE `id` = '{$id}'");
	$res = $query->fetch(PDO::FETCH_ASSOC);
	$file = $res['picture'];
	unlink("..".$file);
	$sql = "DELETE FROM ". $t ." WHERE id = ?";
	$query = $pdo->prepare($sql);
	$query->execute(array($id));
}

