<?php
class AppHeaders
{
	public static function getRequestHeaders()
	{
		$headers = null;
		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			//print_r($requestHeaders);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}

	public static function getHeadersAuthorization()
	{
		$headers = null;
		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}

	public static function getHeadersCNSTokenSoftware()
	{
		$headers = null;
		$headersName = "CNSTOKENST";
		if (isset($_SERVER[$headersName])) {
			$headers = trim($_SERVER[$headersName]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders[$headersName])) {
				$headers = trim($requestHeaders[$headersName]);
			}
		}
		return $headers;
	}

	public static function getHeadersCNSTokenB2B()
	{
		$headers = null;
		$headersName = "CNSTOKENBS";
		if (isset($_SERVER[$headersName])) {
			$headers = trim($_SERVER[$headersName]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders[$headersName])) {
				$headers = trim($requestHeaders[$headersName]);
			}
		}
		return $headers;
	}

	public static function getHeadersCNSTokenReq()
	{
		$headers = null;
		$headersName = "CNSTOKENREQ";
		if (isset($_SERVER[$headersName])) {
			$headers = trim($_SERVER[$headersName]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders[$headersName])) {
				$headers = trim($requestHeaders[$headersName]);
			}
		}
		return $headers;
	}

	public static function getHeadersCNSTokenReqID()
	{
		$headers = null;
		$headersName = "CNSTOKENREQID";
		if (isset($_SERVER[$headersName])) {
			$headers = trim($_SERVER[$headersName]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders[$headersName])) {
				$headers = trim($requestHeaders[$headersName]);
			}
		}
		return $headers;
	}

	public static function getHeadersCNSTokenReqName()
	{
		$headers = null;
		$headersName = "CNSTOKENREQNAME";
		if (isset($_SERVER[$headersName])) {
			$headers = trim($_SERVER[$headersName]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders[$headersName])) {
				$headers = trim($requestHeaders[$headersName]);
			}
		}
		return $headers;
	}

	public static function getHeadersCNSTokenReqUrl()
	{
		$headers = null;
		$headersName = "CNSTOKENREQURL";
		if (isset($_SERVER[$headersName])) {
			$headers = trim($_SERVER[$headersName]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders[$headersName])) {
				$headers = trim($requestHeaders[$headersName]);
			}
		}
		return $headers;
	}

	public static function getHeadersCNSTokenSignIn()
	{
		$headers = null;
		$headersName = "CNSTOKENSI";
		if (isset($_SERVER[$headersName])) {
			$headers = trim($_SERVER[$headersName]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders[$headersName])) {
				$headers = trim($requestHeaders[$headersName]);
			}
		}
		return $headers;
	}
	
	public static function getHeadersCNSTokenSignOut()
	{
		$headers = null;
		$headersName = "CNSTOKENSO";
		if (isset($_SERVER[$headersName])) {
			$headers = trim($_SERVER[$headersName]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders[$headersName])) {
				$headers = trim($requestHeaders[$headersName]);
			}
		}
		return $headers;
	}

	public static function getBasicAuthValue($headers)
	{
		return str_replace("Basic ", "", $headers);
	}

	public static function getBearerAuthValue($headers)
	{
		return str_replace("Bearer ", "", $headers);
	}

	public static function getCNSWEBAuthValue($headers)
	{
		return str_replace("CNS ", "", $headers);
	}

}

?>