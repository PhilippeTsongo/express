<?php
class Dates
{
	public static function convTo($format,$time){
		if($format == 'date'){
			return date('d-m-Y',$time); 
		}
	}
}
?>