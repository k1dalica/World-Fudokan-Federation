<?php
if(Moderator::loggedin()===false) {
	echo "<article>
		<div class='header'>
			<span class='title'>Login</span>
		</div><div class='text ta-c' aling='center'>
			<div class='notify mb-10'><div class='icon'></div><div class='text'>In order to continue to this page, you need to confirm your county code.</div></div>";
			$db = DB::getInstance();
			if(Input::exists()) {
				if(Token::check(Input::get('token'))) {
					$country = Input::get('countryname');
					$code = Input::get('code');
					$query = $db->query("SELECT * FROM `country` WHERE `name`='$country' AND `code`='$code'");
					if($query->error()===false) {
						if($query->count()!=0) {
							Moderator::login($country);
							Session::flash("loginsuccess", "You are now logged in as {$country}.");
							Redirect::to("/wff/black_belts/");
						} else {
							Session::flash("errors", "Incorect Country/Code combination! $country - $code");
						}
					} else {
						Session::flash("errors","There was an error. Please try again.");
					}
				}
			}
			if(Session::exists('errors')) {
				echo "<div class='notify error mb-10'><div class='icon'></div><div class='text'>" . Session::flash('errors') . "</div></div>";
			}
			echo "<form action='' method='post'>
				<label>Choose your country</label>
				<br/><select name='countryname' class='input mt-5 mb-10'>";
					$query = $db->query("SELECT * FROM `country`");
					if($query->count()!=0) {
						foreach($query->results() as $c) {
							echo "<option id='{$c->id}'>{$c->name}</option>";
						}
					}
				echo "</select>
				<br/><label>Enter selected county code</label>
				<br/><input type='password' name='code' class='input ta-c'>
				<input type='hidden' name='token' value='" . Token::generate() . "'>
				<br/><input type='submit' class='input button mt-10' value='Log in'>
			</form>";
	echo "</div>
	</article>";
}