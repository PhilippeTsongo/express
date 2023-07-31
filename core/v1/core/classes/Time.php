<?php
class Dates
{
	public static function convTo($format,$time){
		if($format == 'date'){
			return date('d-m-Y',$time); 
		}
	}

	public static function timestamp(){
		$now = DateTime::createFromFormat('U.u', microtime(true));
		return $now->format("m-d-Y H:i:s.u");

	}
}
?>