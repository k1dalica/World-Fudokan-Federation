<article>
	<div class="header">
		<span class="title">Send us a message</span>
	</div><div class="text">
	<?php
		if(Input::exists()) {
			if(Token::check(Input::get('token'))) {
				$validate = new Validation();
				$validation = $validate->check($_POST, array(
					'name' => array(
						'fieldname' => 'Full name',
						'required' => true,
						'min' => 5,
						'max' => 100
					),
					'message' => array(
						'fieldname' => 'Message',
						'required' => true
					),
					'email' => array(
						'fieldname' => 'Email',
						'required' => true,
						'email' => true
					)
					
				));
				$res = post_captcha($_POST['g-recaptcha-response']);
				if(!$res['success']) {
					if($validation->passed()) {
						$to = "office@antvelsgroup.rs";
						$from = Input::get('email');
						$name = Input::get('ime');
						$subject = "Poruka sa websajta od {$name}";
						$txt = nl2br(Input::get('ime'));
						
						$headers = "From: " . $from . "\r\n" .
						"Reply-To: $from" . "\r\n" .
						"Content-Type: text/html; charset=utf-8\r\n";
						
						/*ini_set("SMTP","mail.reikonkarate.com");
						ini_set('smtp_port', 25);
						ini_set('sendmail_from', $email);*/
						
						if(mail($to,$subject,$txt,$headers)) {
							Session::flash("success", "Thank you for contacting us. Well will respond to you as soon possible.");
						} else {
							Session::flash("errors", "There was an error. Message wasn't sent. Please try again.");
						}						
						
					} else {
						Session::flash("errors", implode('<br/>',$validation->errors()));
					}
				} else {
					Session::flash("errors", "You need to check the security CAPTCHA box.");
				}	
			}
		}
	
		if(Session::exists('errors')) {
			echo "<div class='notify error mb-15'><div class='icon'></div><div class='text'>" . Session::flash('errors') . "</div><div class='close'><i></i></div></div>";
		}
		if(Session::exists('success')) {
			echo "<div class='notify success mb-15'><div class='icon'></div><div class='text'>" . Session::flash('success') . "</div><div class='close'><i></i></div></div>";
		}
	
	?>
		<form action="" method="post">
			<div class="dinline mr width-50">
				<label>Full name</label>
				<br><input type="text" name="name" class="input ta-c mb-10 width-100">
			</div><div class="dinline width-50">
				<label>Email</label>
				<br><input type="text" name="email" class="input ta-c mb-10 width-100">
			</div>
			<label>Message</label>
			<textarea class='mb-10' rows="5" name='message'></textarea>
			<div class="g-recaptcha floatl" data-sitekey="6Ld2IxoUAAAAAGge5GG6bzqKsptPTugaCY3dEAy7"></div>
			<input type='hidden' name='token' value='<?= Token::generate();?>'>
			<input type='submit' class='floatr input button' value='Send'>
			<div class="clear"></div>
		</form>
	</div>
</article>