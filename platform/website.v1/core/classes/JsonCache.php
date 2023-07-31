<?php 
class JsonCache
{
	public static function exportToJson($filename,$records,$lang = null){
		if($lang==null){ $lang = Session::get('lang');}
		
		$filename = 'cache_dir/'.$lang.'_'.$filename.'.json';
		if(!file_exists($filename)){
			$filename = bk_dir($filename);
		}
		if(!file_exists($filename)){
			$fp = fopen($filename,'w');
			fwrite($fp,json_encode($records));
			fclose($fp);
		}else{
			file_put_contents($filename, json_encode($records));
		}
	}
	public static function getData($filename,$lang = null){
		if($lang==null){ $lang = Session::get('lang');}
		$filename = 'cache_dir/'.$lang.'_'.$filename.'.json';
		if(!file_exists($filename)){
			$filename = bk_dir($filename);
		}
		$records = json_decode(file_get_contents($filename));
		return $records;
	}
	public static function ready($filename,$lang = null){
		if($lang==null){ $lang = Session::get('lang');}
		$filename = 'cache_dir/'.$lang.'_'.$filename.'.json';
		if(!file_exists($filename)){
			$filename = bk_dir($filename);
		}
		if(file_exists($filename)){
			return true;
		}
		return false;
	}
	public static function modifTime($filename,$lang = null){
		if($lang==null){ $lang = Session::get('lang');}
		$filename = 'cache_dir/'.$lang.'_'.$filename.'.json';
		if(!file_exists($filename)){
			$filename = bk_dir($filename);
		}
		return filemtime($filename);
	}
}
?>