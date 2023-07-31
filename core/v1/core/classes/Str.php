<?php
class Str
{

	public static function clean($string){
		return $string == null?"":$string;
	}

	public static function shortName($name){
		return substr($name,0,1).'.';
	}
	
	public static function showBrief($string,$number,$link =null){
		$length = strlen($string);
		$out = substr($string,0,$number);
		if($length>$number){
			if($link==null){
			$out .= ' ... ';
			}else{
				$out .= ' '.$link;
			}
		}
		return $out;
	}
	
	public static function data_out($data){
		$data = stripslashes($data);
		return $data;
	}

	public static function data_in($data){
        
//		$data = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $data);
//		$data  = htmlentities($data, ENT_QUOTES, 'UTF-8');
        
        //$data = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $data);
        //$data = str_replace('"', "'", $data);
        //$data = addslashes($data);
	   $data  = htmlentities($data, ENT_QUOTES, 'UTF-8');
		return $data;
	}
		
	public static function sanAsID($data){
		$data = strip_tags($data);
		$data = preg_replace("/[^A-Za-z0-9]/", "", $data);
		return htmlentities($data);
	}

	public static function sanAsName($data){
		$data = strip_tags($data);
//		$data = preg_replace("/[^A-Za-z0-9\-\ \']/", "", $data);
		$list = explode(' ',$data);
		$stri = "";
		if(count($list)){
			for($i=0;$i<count($list);$i++){
				if($i>0){
					$stri .= " ";
				}
				$stri .= firstUC(strtolower($list[$i]));
			}
		}
		return htmlentities($stri);
	}
	public function sanAsLabel($data){
		$data = strip_tags($data);
		$data = preg_replace("/[^A-Za-z0-9\-\ \']/", "", $data);
		$list = explode(' ',$data);
		$stri = "";
		if(count($list)){
			for($i=0;$i<count($list);$i++){
				if($i>0){
					$stri .= " ";
				}
				$stri .= $list[$i];
			}
		}
		return htmlentities($stri);
	}
    
		
	function sanAsUsername($data){
		$data = strip_tags($data);
		$data = preg_replace("/[^A-Za-z0-9\ ]/", "", $data);
		$data = preg_replace("/\ /", ".", $data);
		$data = preg_replace("/\.+/", ".", rtrim($data, "."));
		return strtolower($data);
	}
		
}
?>