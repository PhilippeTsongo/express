<?php


function escape($string){
	return htmlentities($string, ENT_QUOTES, 'UTF-8');  
}
function cleanLikeUrl($string){
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.	
	return $string;  
}

function tel_num($data){
	return preg_replace('#[^0-9+]#i',"",$data);
}

function utf8($str){
	return Encoding::toUTF8($str);
}
?>