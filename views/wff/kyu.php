<?php
if(Moderator::loggedin()===false) {
	require_once '/views/wff/login.php';
} else {
	$country = Session::get(Config::get("session/session_name"));
	if(Session::exists('loginsuccess')) {
		echo "<div class='notify success mb'><div class='icon'></div><div class='text'>" . Session::flash('loginsuccess') . "</div><div class='close'><i></i></div></div>";
	}
	
	if(Input::exists()) {
		if(Token::check(Input::get('token'))) {
			$validate = new Validation();
			$validation = $validate->check($_POST, array(
				'name' => array(
					'fieldname' => 'Full name',
					'required' => true,
					'min' => 5,
					'max' => 150
				),
				'born' => array(
					'fieldname' => 'Year of birth',
					'required' => true,
					'greater' => '1910',
					'less' => '2010'
				),
				'dan' => array(
					'fieldname' => 'Dan',
					'required' => true,
					'less' => '10',
					'greater' => '1'
				),
				'tks' => array(
					'fieldname' => 'Training Karate since',
					'required' => true,
					'greater' => '1910',
					'less' => '2010'
				),
				'diploma' => array(
					'fieldname' => 'Diploma ID',
					'required' => true
				)
			));
			if($validation->passed()) {
				$slika = null;
				if(Input::get('file')) {
					if(!empty(Input::get('file')['name'])) {
						$code = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(25/strlen($x)) )),1,25);
						$fajlname = Input::get('file')['name'];
						$extension = explode(".", $fajlname);
						$extension = end($extension);
						$location = "uploads/". $code .".".$extension;
						if(move_uploaded_file(Input::get('file')['tmp_name'], $location)) {
							$slika = "/".$location;
						}
					}
				}
				$db = DB::getInstance()->insert('kyubelts',array(
					'country' => $country,							 
					'name' => Input::get('name'),							 
					'born' => Input::get('born'),							 
					'dan' => Input::get('dan'),
					'since' => Input::get('tks'),
					'diploma' => Input::get('diploma'),
					'picture' => $slika
				));
				Session::flash("success", "New Kyu Belt successfully registered.");			
			} else {
				Session::flash("errors", implode('<br/>',$validation->errors()));
			}
		}
	}
	
	echo "<article class='mb'>
		<div class='header'>
			<span class='title'>Kyu Belts registry for country ". $country ."</span>
		</div><div class='text ta-c' aling='center'>
			<form action='' method='post' enctype='multipart/form-data'>";
				if(Session::exists('errors')) {
					echo "<div class='notify error mb-15'><div class='icon'></div><div class='text'>" . Session::flash('errors') . "</div><div class='close'><i></i></div></div>";
				}
				if(Session::exists('success')) {
					echo "<div class='notify success mb-15'><div class='icon'></div><div class='text'>" . Session::flash('success') . "</div><div class='close'><i></i></div></div>";
				}
				echo "<div class='dinline mr'>
					<label>Full name</label>
					<br/><input type='text' name='name' class='input ta-c mb-10'>
				</div><div class='dinline'>
					<label>Year of birth</label>
					<br/><input type='text' name='born' class='input ta-c mb-10' maxlength='4' onkeydown=\"return ( event.ctrlKey || event.altKey || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) || (95<event.keyCode && event.keyCode<106) || (event.keyCode==8) || (event.keyCode==9) || (event.keyCode>34 && event.keyCode<40) || (event.keyCode==46) )\">
				</div><div class='dinline mr'>
					<label>Dan</label>
					<br/><input type='text' name='dan' class='input ta-c mb-10'>
				</div><div class='dinline'>
					<label>Training Karate since (year)</label>
					<br/><input type='text' name='tks' class='input ta-c mb-10' maxlength='4' onkeydown=\"return ( event.ctrlKey || event.altKey || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) || (95<event.keyCode && event.keyCode<106) || (event.keyCode==8) || (event.keyCode==9) || (event.keyCode>34 && event.keyCode<40) || (event.keyCode==46) )\">
				</div>
				<div><label>Diploma ID</label>
				<br/><input type='text' name='diploma' class='input ta-c mb-10' onkeydown=\"return ( event.ctrlKey || event.altKey || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) || (95<event.keyCode && event.keyCode<106) || (event.keyCode==8) || (event.keyCode==9) || (event.keyCode>34 && event.keyCode<40) || (event.keyCode==46) )\"></div>
				<div class='dinline mr'>
					<input type='file' class='hidden' name='file' id='addimg' accept='image/*'>
					<input type='button' class='input button mt-10' value='Upload picture' onClick=\"$('#addimg').click();\">
				</div><div class='dinline'>
					<input type='hidden' name='token' value='" . Token::generate() . "'>
					<input type='submit' class='input button mt-10' value='Register'>
				</div>
			</form>
		</div>
	</article>";
	
	echo "<article class='mb'>
		<div class='header'>
			<span class='title'>Registered Kyu Belts for country ". $country ."</span>
		</div><div class='list ta-c' aling='center'>";
		$kyubelts = new Kyubelts($country);
		if($kyubelts->count()!=0) {
			foreach($kyubelts->get() as $kb) {
				echo "<div class='li'><span>{$kb->name}</span>
					<div class='buttons'><!--<i class='edit'></i>--><i class='delete' onClick=\"deleteItem('{$kb->id}','2')\"></i></div>
				</div>";
			}
		} else {
			echo "<div class='notify mt-10'><div class='icon'></div><div class='text'>There are no registered Kyu Belts for your country.</div></div>";
		}
		echo "</div>
	</article>";
}
?>