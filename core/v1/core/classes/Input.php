<?php
class Input
{
	public static function exists($type = 'get')
	{
		switch ($type) {
			case 'post':
				return (!empty($_POST)) ? true : false;
				break;
			case 'get':
				return (!empty($_GET)) ? true : false;
				break;
			default:
				return false;
				break;
		}
	}

	public static function get($item, $source = 'get')
	{
		switch ($source) {
			case 'post':
				if (isset($_POST[$item])) {
					return $_POST[$item];
				}
				break;
			case 'get':
				if (isset($_GET[$item])) {
					return $_GET[$item];
				}
				break;
		}
		return '';
	}

	public static function put($item, $source = 'get', $value = '')
	{
		switch ($source) {
			case 'post':
				$_POST[$item] = $value;
				break;
			case 'get':
				$_GET[$item] = $value;
				break;
		}
	}

	public static function checkFieldSubmited($item, $source = 'get', $state = '0')
	{
		switch ($source) {
			case 'post':
				if (isset($_POST[$item]) && $state == '1') {
					return (!empty($_POST[$item])) ? true : false;
				} else if (isset($_POST[$item])) {
					return (empty($_POST[$item])) ? true : false;
				}
				break;
			case 'get':
				if (isset($_GET[$item]) && $state == '1') {
					return (!empty($_GET[$item])) ? true : false;
				} else if (isset($_GET[$item])) {
					return (empty($_GET[$item])) ? true : false;
				}
				break;
		}
		return false;
	}

	public static function checkInput($item, $source = 'get', $state = 0)
	{
		$_POST = (array) $_POST;
		switch ($source) {
			case 'post':
				if (isset($_POST[$item]) && $state == 1) {
					return (!empty($_POST[$item])) ? true : false;
				} else if (isset($_POST[$item])) {
					return (empty($_POST[$item])) ? true : false;
				}
				break;
			case 'get':
				if (isset($_GET[$item]) && $state == 1) {
					return (!empty($_GET[$item])) ? true : false;
				} else if (isset($_GET[$item])) {
					return (empty($_GET[$item])) ? true : false;
				}
				break;
		}
		return false;
	}
}

?>