<?php
function RT()
{
	return RT;
}

function bk_dir($path)
{
	return Config::get('url/bk_dir') . _ . $path;
}

function dyna_dir($path)
{
	if (is_file(bk_dir($path))) {
		return RT . '/' . bk_dir($path);
	}
	else {
		return $path;
	}
}

function accessKey($level)
{
	global $session_user_data;
	$user_group = $session_user_data->groups;
	switch ($level) {
		case '1':
			return ($user_group == "Admin");
			break;
		case '2':
			return ($user_group == "Admin" || $user_group == "Chefeditor");
			break;
		case '3':
			return ($user_group == "Admin" || $user_group == "Chefeditor" || $user_group == "Editor");
			break;
	}
}

function data_out($data)
{
	$data = stripslashes($data);
	return $data;
}

function data_in($data)
{
	$data = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $data);
	//$data = str_replace('"', "'", $data);
	//$data = addslashes($data);
	$data = htmlentities($data, ENT_QUOTES, 'UTF-8');
	return $data;
}

function filter($data)
{
	$data = trim(htmlentities(strip_tags($data)));
	if (get_magic_quotes_gpc())
		$data = stripslashes($data);
	$data = mysql_real_escape_string($data);
	return $data;
}


function array_sanitize(&$item)
{
	$item = htmlentities(strip_tags(addslashes($item)));
}

function sanitize($data)
{
	return htmlentities(strip_tags(addslashes($data)));
}



function firstUC($character)
{
	return ucfirst($character);
}


function sanName($data)
{
	$data = strip_tags($data);
	$data = preg_replace("/[^A-Za-z0-9\-\ \']/", "", $data);
	$list = explode(' ', $data);
	$stri = "";
	if (count($list)) {
		for ($i = 0; $i < count($list); $i++) {
			if ($i > 0) {
				$stri .= " ";
			}
			$stri .= firstUC(strtolower($list[$i]));
		}
	}
	return htmlentities($stri);
}


function sanUsername($data)
{
	$data = strip_tags($data);
	$data = preg_replace("/[^A-Za-z0-9\ ]/", "", $data);
	$data = preg_replace("/\ /", ".", $data);
	$data = preg_replace("/\.+/", ".", rtrim($data, "."));
	return strtolower($data);
}
function rem_bugs($data)
{
	$data = strip_tags($data);
	$data = preg_replace("/[^A-Za-z0-9\ ]/", " ", $data);
	return strtolower($data);
}


function remSpaces($data)
{
	$data = preg_replace("/\ /", "", $data);
	return $data;
}


function sanAsID($data)
{
	$data = strip_tags($data);
	$data = preg_replace("/[^A-Za-z0-9]/", "", $data);
	return htmlentities($data);
}


function valid_pass($candidate)
{
	$r1 = "/[A-Z]/"; //Uppercase
	$r2 = "/[a-z]/"; //lowercase
	$r3 = "/[!@#$%^&*()\-_=+{};:,<.>]/"; // whatever you mean by 'special char'
	$r4 = "/[0-9]/"; //numbers
	$error = false;
	$error_msg = "Your password misses";
	if (!preg_match($r1, $candidate)) {
		$error = true;
		$error_msg .= ", Uppercase";
	}
	if (!preg_match($r2, $candidate)) {
		$error = true;
		$error_msg .= ", lowercase";
	}
	if (!preg_match($r3, $candidate)) {
		$error = true;
		$error_msg .= ", Special";
	}
	if (!preg_match($r4, $candidate)) {
		$error = true;
		$error_msg .= ", Numbers ";
	}
	$error_msg .= " Characters";

	if ($error == true) {
		Session::put("errors", $error_msg);
		return false;
	}
	else {
		return true;
	}
}

function sanHashtag($hashtag)
{
	$data = preg_replace("#[^a-z0-9_]#i", "", $hashtag);
	return $data;
}


function sanLabel($data)
{
	$data = preg_replace("/[^A-Za-z0-9\-\ \/\\'\(\)\?]/", "", $data);
	return htmlentities(firstUC($data));
}
function srg_txt($data)
{
	return htmlentities(strip_tags(addslashes($data)));
}
function srg($data)
{
	return htmlentities(strip_tags($data));
}

function htmlEnt($data)
{
	return htmlentities($data);
}

// dot split


function dot_split($data)
{
	return @end(explode(".", $data));
}

// tack extension

function get_exten($file_name)
{
	return @strtolower(end(explode(".", $file_name)));
}

function fltr_text($string)
{
	$str = $string;
	$str = htmlentities($str, ENT_QUOTES, "UTF-8");
	return $str;
}
function activeURLS($str)
{
	$find = array("`((?:https?|ftp)://\S+[[:alnum:]]/?)`si", "`((?<!//)(www\.\S+[[:alnum:]]/?))`si");
	$replace = array('<a href="$1" target="_blank">$1</a>', '<a href="http://$1" target="_blank">$1</a>');
	return preg_replace($find, $replace, $str);
}


function artag($string)
{
	$str = $string;
	$artag = "@";
	$arr = explode(" ", $str);
	$arrc = count($arr);
	$i = 0;
	while ($i < $arrc) {
		if (substr($arr[$i], 0, 1) == $artag) {

			$tag = substr($arr[$i], 1, strlen($arr[$i]));
			if (!empty($tag) && !is_numeric($tag)) {
				$userClass = new User();
				if ($userClass->find($tag)) {
					$user_data = $userClass->data();
					$arr[$i] = '<a href="profile?username=' . $user_data->username . '">' . $arr[$i] . '</a>';
				}
				else {
					$arr[$i] = '<a>' . $arr[$i] . '</a>';
				}
			}
		}
		$i++;
	}
	$string = implode(" ", $arr);
	return $string;
}

function removeChars($str)
{
	return preg_replace("#[^0-9a-z]#i", "", $str);
}

// errors print

function output_errors($errors)
{
	return "<ul><li>" . implode("</li><li>", $errors) . "</li></ul>";
}
function ul_array($errors)
{
	return "<ul><li>" . implode("</li><li>", $errors) . "</li></ul>";
}

function print_errors($errors)
{
	return "<small style='color: red'>" . implode("", $errors) . "</small>";
}
function print_note($errors)
{
	return "<small style='color: #10b070'>" . implode("", $errors) . "</small>";
}

function hashtag($string)
{
	$str = $string;
	$htag = "#";
	$arr = explode(" ", $str);
	$arrc = count($arr);
	$i = 0;
	while ($i < $arrc) {
		if (substr($arr[$i], 0, 1) == $htag) {
			$arr[$i] = '<a href="#">' . $arr[$i] . '</a>';
		}
		$i++;
	}
	$string = implode(" ", $arr);
	return $string;
}



function convertHashtags($str)
{
	$regex = "/#+([a-zA-Z0-9_]+)/";
	$str = preg_replace($regex, '<a href="hashtag.php?tag=$1">$0</a>', $str);
	return ($str);
}

function fr_time_format($time_str)
{
	if (DateTime::createFromFormat('H:i', $time_str) !== false) {
		$tag_date = srg_txt($time_str);
		$two_part = explode(':', $tag_date);
		$temp = Config::get('time/temp');
		$cur_date = date('m-d-Y', $temp);
		if (count($two_part) == 2 && $two_part[0] <= 23 && $two_part[1] <= 60) {
			return true;
		}
	}
	return false;
}



function printUserData($string)
{
	$str = $string;
	$str = htmlentities($str, ENT_QUOTES, "UTF-8");
	return $str;
}

function categoryAutoload($categ)
{
	global $category;
	$this_category = strtolower($category);
	$categs = array('home', 'contact', 'weather', 'news', 'local', 'business', 'sports', 'entertainment');
	if (in_array($categ, $categs) && in_array($this_category, $categs)) {
		echo 'onclick="openPage(\'' . $categ . '\')"';
	}
	else {
		if ($categ == 'home') {
			echo 'href="' . RT . '"';
		}
		else {
			echo 'href="' . RT . '/' . $categ . '"';
		}
	}
}


function jumb_articles($prefix = null)
{
	global $jumb_articles;
	$sql = "";
	$i = 0;
	foreach ($jumb_articles as $ID) {
		if ($ID) {
			if ($i != 0) {
				$sql .= " && ";
			}
			if ($prefix) {
				$sql .= "{$prefix}.`ID`!='{$ID}'";
			}
			else {
				$sql .= "`ID`!='{$ID}'";
			}
			$i++;
		}
	}
	return $sql;
}

function floatp($n)
{
	$whole = floor($n);
	return $fraction = $n - $whole;
}
function upfloat($n)
{
	$fraction = floatp($n);
	if ($fraction > 0) {
		$n = floor($n) + 1;
	}
	return $n;
}




function dates($str, $sec = 0)
{
	global $timezone;
	global $date;
	global $clone;
	global $time;
	$this_date = $clone;
	if ($sec != 0) {
		$this_sec = $sec - $time;
		$this_date->modify("$this_sec sec");
	}
	return $this_date->format($str);
}



// BK Code

// End Processing

//  ----------------------------------------------------------------------------

// This function uses the QSI Response code retrieved from the Digital
// Receipt and returns an appropriate description for the QSI Response Code
//
// @param $responseCode String containing the QSI Response Code
//
// @return String containing the appropriate description
//

function getResponseDescription($responseCode)
{

	switch ($responseCode) {
		case "0":
			$result = "Transaction Successful";
			break;
		case "?":
			$result = "Transaction status is unknown";
			break;
		case "1":
			$result = "Unknown Error";
			break;
		case "2":
			$result = "Bank Declined Transaction";
			break;
		case "3":
			$result = "No Reply from Bank";
			break;
		case "4":
			$result = "Expired Card";
			break;
		case "5":
			$result = "Insufficient funds";
			break;
		case "6":
			$result = "Error Communicating with Bank";
			break;
		case "7":
			$result = "Payment Server System Error";
			break;
		case "8":
			$result = "Transaction Type Not Supported";
			break;
		case "9":
			$result = "Bank declined transaction (Do not contact Bank)";
			break;
		case "A":
			$result = "Transaction Aborted";
			break;
		case "C":
			$result = "Transaction Cancelled";
			break;
		case "D":
			$result = "Deferred transaction has been received and is awaiting processing";
			break;
		case "F":
			$result = "3D Secure Authentication failed";
			break;
		case "I":
			$result = "Card Security Code verification failed";
			break;
		case "L":
			$result = "Shopping Transaction Locked (Please try the transaction again later)";
			break;
		case "N":
			$result = "Cardholder is not enrolled in Authentication scheme";
			break;
		case "P":
			$result = "Transaction has been received by the Payment Adaptor and is being processed";
			break;
		case "R":
			$result = "Transaction was not processed - Reached limit of retry attempts allowed";
			break;
		case "S":
			$result = "Duplicate SessionID (OrderInfo)";
			break;
		case "T":
			$result = "Address Verification Failed";
			break;
		case "U":
			$result = "Card Security Code Failed";
			break;
		case "V":
			$result = "Address Verification and Card Security Code Failed";
			break;
		default:
			$result = "Unable to be determined";
	}
	return $result;
}



//  -----------------------------------------------------------------------------

// This subroutine takes a data String and returns a predefined value if empty
// If data Sting is null, returns string "No Value Returned", else returns input

// @param $in String containing the data String

// @return String containing the output String

function null2unknown($map, $key)
{
	if (array_key_exists($key, $map)) {
		if (!is_null($map[$key])) {
			return $map[$key];
		}
	}
	return "No Value Returned";
}


//  ----------------------------------------------------------------------------
?>