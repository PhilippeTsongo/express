<?php
/**
 *
 */
class Views
{
	public static function require($main, $sub, $script, $extension='.php'){
		require_once 'views/'.$main.'/'.$sub.'/'.$script.$extension;
	}
}


 ?>
