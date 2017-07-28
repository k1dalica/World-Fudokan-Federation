<?php
function post_captcha($user_response) {
	$fields_string = '';
	$fields = array(
		'secret' => '_______________PRIVATE_KEY_______________',
		'response' => $user_response
	);
	foreach($fields as $key=>$value)
	$fields_string .= $key . '=' . $value . '&';
	$fields_string = rtrim($fields_string, '&');

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
	curl_setopt($ch, CURLOPT_POST, count($fields));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

	$result = curl_exec($ch);
	curl_close($ch);

	return json_decode($result, true);
}

function covertDate($date) {
	$date = explode(" ", $date);
	$date = explode("-", $date[0]);
	$d = $date[2]; $m = $date[1]; $y = $date[0];
	$mesec = date("F $d\, $y\.", mktime(0, 0, 0, $m, $d, $y));
	return $mesec;
}