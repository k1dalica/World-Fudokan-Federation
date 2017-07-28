<?php
class Moderator {
    public static function loggedin() {
		if(Session::exists(Config::get("session/session_name"))) {
			return true;
		}
		return false;
	}
	
	public static function login($country) {
		Session::put(Config::get("session/session_name"), $country);
	}
	
	public static function logout() {
		Session::delete(Config::get("session/session_name"));
	}
}