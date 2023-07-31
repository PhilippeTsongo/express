<?php
class Link
{
	public static function css($css){
		echo '<link href="'.RT._PATH_.'css'._.$css.'.css'.'" type="text/css" rel="stylesheet">';
	}
	public static function js($css){
		echo '<script type="text/javascript" src="'.RT._PATH_.'js'._.$css.'.js'.'"></script>';
	}
	public static function usedir($categ,$path){
		if($categ == 'css'){
			echo '<link href="'.RT._PATH_.'use'._.$path.'.css'.'" type="text/css" rel="stylesheet">';
		}elseif($categ == 'js'){
			echo '<script type="text/javascript" src="'.RT._PATH_.'use'._.$path.'.js'.'"></script>';
		}else{
			
		}
	}
	public static function js_plugin($link){
		echo '<script type="text/javascript" src="'.RT._PATH_.$link.'.js'.'"></script>';
	}
	public static function css_plugin($link){
		echo '<link href="'.RT._PATH_.$link.'.css'.'"type="text/css" rel="stylesheet">';
	}
}
?>