<?php
class Cookie
{
	public static function exists($name){
		return (isset($_COOKIE[$name]))? true : false;
	}

	public static function get($name){
		return $_COOKIE[$name];
	}
	
	public static function put($name, $value, $expiry){
		if(setcookie($name,$value, Dates::get('U')+$expiry, '/')){
			return true;
		}
		return false;
	}
	
	public static function delete($name){
		unset($_COOKIE[$name]);
		self::put($name,null,-10*24*12*60*60*60);
	}
	
}
?>