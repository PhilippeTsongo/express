<?php
class Config{
	public static function get($path = null){
		if($path){
			$config = $GLOBALS['config'];
			$path = explode('/', $path);
			
			foreach($path as $bit){
				if(isset($config[$bit])){
					$config = $config[$bit];
				}
			}
			return $config;
		}
		return false;
	}
	public static function resetPage(){
		@$_SESSION['paging'] = 1;
	}
	public static function getPage(){
		if(!isset($_SESSION['paging'])){
			$_SESSION['paging'] = 1;
		}
		return @$_SESSION['paging'];
	}
	public static function incPage(){
		if(!isset($_SESSION['paging'])){
			$_SESSION['paging'] = 1;
		}
		@$_SESSION['paging']++;
	}
	public static function decPage(){
		if(!isset($_SESSION['paging'])){
			$_SESSION['paging'] = 1;
		}
		if(@$_SESSION['paging']>1){
			@$_SESSION['paging']--;
		}
	}
	
	
	public static function resetNewPage(){
		@$_SESSION['newPaging'] = 1;
	}
	public static function getNewPage(){
		if(!isset($_SESSION['newPaging'])){
			$_SESSION['newPaging'] = 1;
		}
		return @$_SESSION['newPaging'];
	}
	public static function incNewPage(){
		if(!isset($_SESSION['newPaging'])){
			$_SESSION['newPaging'] = 1;
		}
		@$_SESSION['newPaging']++;
	}
} 
?>