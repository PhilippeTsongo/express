<?php
class Functions
{
	public static function getRequestHeaders()
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

	public static function getBasicAuthValue($headers)
	{
		return str_replace("Basic ", "", $headers);
	}

	public static function getBearerAuthValue($headers)
	{
		return str_replace("Bearer ", "", $headers);
	}

	public static function getCompanyCodeByTelephone($telephone)
	{
		if (substr($telephone, 0, -7) == "25073" || substr($telephone, 0, -7) == "25072")
			return "AIRTELRW";
		else if (substr($telephone, 0, -7) == "25078")
			return "MTNRW";

		return false;
	}

	public static function callAPI($method, $url, $data)
	{
		$curl = curl_init();

		switch ($method) {
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			default:
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}

		// OPTIONS:
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'APIKEY: 111111111111111111111',
			'Content-Type: application/json',
		)
		);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		// EXECUTE:
		$result = curl_exec($curl);
		if (!$result) {
			die("Connection Failure");
		}
		curl_close($curl);
		return $result;

	}
	public static function HttRequest($url, $method = "POST", $data = array(), $requesttoken = '', $contenttype = "urlform")
	{
		$ch = curl_init();
		switch ($contenttype) {
			case "urlform":
				$data = http_build_query($data);
				$contenttype = 'application/x-www-form-urlencoded';
				break;
			case "json":
				$data = json_encode($data);
				$contenttype = 'application/json';
				break;
			case "xml":
				$xml = new SimpleXMLElement('COMMAND');
				array_walk_recursive($data, array($xml, 'command'));
				print $xml->asXML();
				$contenttype = 'application/xml';
				break;

			default:
				break;
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		switch ($method) {
			case "POST":
				curl_setopt($ch, CURLOPT_POST, true);
				if ($data)
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				if ($data)
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				break;
			default:
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $requesttoken, 'Content-Type:' . $contenttype));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;

	}

	public static function json_enc($str)
	{
		return json_encode($str, true);
	}

	public static function json_dec($str)
	{
		return json_decode($str, true);
	}


	public static function print_time_($dt_retr_date)
	{
		$cur_retr_date = Config::get('time/date_time');
		$cur_plit_date = substr($cur_retr_date, 5, 10);
		$cur_time = substr($cur_retr_date, 16, 11);
		$cur_day = substr($cur_retr_date, 0, 3);

		$dt_plit_date = substr($dt_retr_date, 5, 10);
		$dt_time = substr($dt_retr_date, 16, 11);
		$dt_day = substr($dt_retr_date, 0, 3);

		if ($dt_plit_date === $cur_plit_date) {
			return '<value title="' . $dt_retr_date . '" style="cursor: pointer">' . 'at ' . $dt_time . '</value>';
		}
		if ($dt_plit_date < $cur_plit_date) {
			return '<value title="' . $dt_retr_date . '" style="cursor: pointer">' . 'on ' . $dt_day . ' ' . $dt_plit_date . '</value>';
		}
		return $dt_retr_date;
	}
	public static function time_past($ref_sec)
	{
		$cur_sec = Config::get('time/timestamp');
		$band = ($cur_sec - $ref_sec) / 60;
		$split = explode('.', $band);
		$min = $split[0];
		$sec = $cur_sec - $ref_sec;
		if ($band < 1) {
			return '<value style="cursor: pointer">' . $sec . 'sec ago </value>';
		} elseif ($min < 60) {
			return '<value style="cursor: pointer">' . $min . 'min ago </value>';
		} else {
			$band1 = $min / 60;
			$split1 = explode('.', $band1);
			$hour = $split1[0];
			if ($hour < 24) {
				return '<value style="cursor: pointer">' . $hour . 'h ago </value>';
			} else {
				$band2 = $hour / 24;
				$split2 = explode('.', $band2);
				$day = $split2[0];
				if ($day < 7) {
					return '<value style="cursor: pointer">' . $day . 'd ago </value>';
				} else {
					return '<value style="cursor: pointer">' . $day . 'd ago </value>';
				}
			}
		}
	}

	public static function get_timeago($ptime)
	{
		$temp = Config::get('time/temp');
		$estimate_time = (double) $temp - (double) $ptime;

		if ($estimate_time < 1) {
			return ' < 1 sec ago';
		}

		$condition = array(
			12 * 30 * 24 * 60 * 60 => 'year',
			30 * 24 * 60 * 60 => 'month',
			24 * 60 * 60 => 'day',
			60 * 60 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($condition as $secs => $str) {
			$d = $estimate_time / $secs;

			if ($d >= 1) {
				$r = round($d);
				return $r . ' ' . $str . ($r > 1 ? 's' : '');
			}
		}
	}
	public static function print_F_size($ref_size)
	{
		$size_K = $ref_size / 1000;
		if ($ref_size < 1000) {
			return '<value style="cursor: pointer">' . $ref_size . ' B </value>';
		} elseif ($ref_size < 1000000) {
			return '<value style="cursor: pointer">' . (int) ($ref_size / 1000) . 'Kb </value>';
		} elseif ($ref_size < 1000000000) {
			return '<value style="cursor: pointer">' . (int) ($ref_size / 1000000) . 'Mb </value>';
		} elseif ($ref_size < 1000000000000) {
			return '<value style="cursor: pointer">' . (int) ($ref_size / 1000000) . 'Gb </value>';
		}
	}
	public static function getFileIcon($anyfile)
	{
		if ($anyfile == 1) {
			return 'icon/file_type/img.png';
		} else {
			return 'icon/file_type/file1.png';
		}
	}


	public static function flashMsg()
	{
?>
<?php
		$session_exist_success = Session::exists('success');
		if ($session_exist_success) {
			$session_success = Session::get('success');
			if (!empty($session_success)) { ?>
<div class=" alert alert-success" role="alert" onclick="$(this).hide()">
	<div class="row">
		<div class="col-xs-1">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
		</div>
		<div class="col-xs-10">
			<?php echo Session::flash('success'); ?>
		</div>
		<div class="col-xs-1">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
</div>
<?php
			}
		} ?>

<?php
		$session_exist_errors = Session::exists('errors');
		if ($session_exist_errors) {
			$session_errors = Session::get('errors');
			if (!empty($session_errors)) { ?>
<div class=" alert alert-danger" role="alert" onclick="$(this).hide()">
	<div class="row">
		<div class="col-xs-12 col-sm-1">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		</div>
		<div class="col-xs-12 col-sm-10">
			<?php echo Session::flash('errors'); ?>
		</div>
		<div class="col-xs-12 col-sm-1">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
</div>
<?php
			}
		} ?>
<?php
	}

	public static function smartSMS($telephone, $message, $operator = "AIRTEL")
	{


		if ($operator == "AIRTEL") {
			$url = Config::get('api/airtel_sms');
		} else if ($operator == "MTN") {
			$url = "http://localhost:3636/valwallet/sms/sms.php";
		}

		$myvars = 'telephone=' . $telephone . '&message=' . $message . '&operator=' . $operator;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		return $response = curl_exec($ch);
	}

	public static function sendSmartSMS($recipients = array(), $message)
	{
		$_url = "https://rest.messagebird.com/messages";
		$data = http_build_query([
			'recipients' => $recipients,
			'originator' => 'Valwallet',
			'body' => $message
		]);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $_url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: AccessKey oiYBdC1AuX8nemIimQDUuyxam'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		@curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = @curl_exec($ch);
		@curl_close($ch);
		return $result;

	}

	public static function makeCapcha($fieldname)
	{
		$capcha = substr(md5(rand(1000, 9999)), 0, 4);
        ?>
<div style="height:30px; width: 100%; overflow: hidden; position: relative; background: #fff">
	<span
		style="top: 3px; width: 100%; text-align: center;position: absolute; font-size: 20px; font-weight: 700; font-family: 'Roboto-Bold'; color: #000">
		<?= $capcha ?>
	</span>
	<img src="<?= DN ?>/img/kcc.jpg"
		style="opacity: .3; width: 400px; margin-top: -<?= rand(50, 120) ?>px; margin-left: <?= rand(-200, 0) ?>px;">
</div>
<input type="hidden" name="<?= $fieldname ?>" value="<?= $capcha ?>" style="width: 0px; height: 0px">
<?php
	}

	public static function errorPage($number)
	{
		if ($number == 404) {
			include 'views/errors/404' . P;
		} else {
			include 'views/errors/404' . P;
		}
		echo '<div class="clearfix"></div>';
	}

	public static function getStateCol($state)
	{
		switch ($state) {
			case 'Activate':
			case 'Activated':
				return '#4093D0';
				break;
			case 'Attend':
			case 'Attended':
				return '#00a65a';
				break;
			case 'Pending':
				return 'orange';
				break;
			case 'Deactivate':
			case 'Deactivated':
				return '#999';
				break;
		}
	}



	public static function getUserIP()
	{
		$client = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote = $_SERVER['REMOTE_ADDR'];

		if (filter_var($client, FILTER_VALIDATE_IP)) {
			$ip = $client;
		} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
			$ip = $forward;
		} else {
			$ip = $remote;
		}

		return $ip;
	}

	public static function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
	{
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		}
		$purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support = array("country", "countrycode", "state", "region", "city", "location", "address");
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				switch ($purpose) {
					case "location":
						$output = array(
							"city" => @$ipdat->geoplugin_city,
							"state" => @$ipdat->geoplugin_regionName,
							"country" => @$ipdat->geoplugin_countryName,
							"country_code" => @$ipdat->geoplugin_countryCode,
							"continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
							"continent_code" => @$ipdat->geoplugin_continentCode,
							"latitude" => @$ipdat->geoplugin_latitude,
							"longitude" => @$ipdat->geoplugin_longitude,
						);
						break;
					case "address":
						$address = array($ipdat->geoplugin_countryName);
						if (@strlen($ipdat->geoplugin_regionName) >= 1)
							$address[] = $ipdat->geoplugin_regionName;
						if (@strlen($ipdat->geoplugin_city) >= 1)
							$address[] = $ipdat->geoplugin_city;
						$output = implode(", ", array_reverse($address));
						break;
					case "city":
						$output = @$ipdat->geoplugin_city;
						break;
					case "state":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "region":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "country":
						$output = @$ipdat->geoplugin_countryName;
						break;
					case "countrycode":
						$output = @$ipdat->geoplugin_countryCode;
						break;
					case "latitude":
						$output = @$ipdat->geoplugin_latitude;
						break;
					case "longitude":
						$output = @$ipdat->geoplugin_longitude;
						break;
				}
			}
		}
		return $output;
	}

	public static function generateStrongPassword($length = 6, $add_dashes = false, $available_sets = 'luds')
	{
		$sets = array();
		if (strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if (strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if (strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if (strpos($available_sets, 's') !== false)
			$sets[] = '!@#$%&*?';
		$all = '';
		$password = '';
		foreach ($sets as $set) {
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}
		$all = str_split($all);
		for ($i = 0; $i < $length - count($sets); $i++)
			$password .= $all[array_rand($all)];
		$password = str_shuffle($password);
		if (!$add_dashes)
			return $password;
		$dash_len = floor(sqrt($length));
		$dash_str = '';
		while (strlen($password) > $dash_len) {
			$dash_str .= substr($password, 0, $dash_len) . '-';
			$password = substr($password, $dash_len);
		}
		$dash_str .= $password;
		return $dash_str;
	}

	public static function generateQRString($qr_code)
	{
		$qr_string = strtoupper(hash_hmac('SHA256', $qr_code, pack('H*', 3061995)));
		return $qr_string;
	}

	public static function discount($amount_gross, $discount)
	{
		return $amount_gross - $amount_gross * $discount / 100;
	}

	public static function array_sort($array, $on, $order = SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}

			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}

		return $new_array;
	}

	public static function build_sorter($key, $dir = 'ASC')
	{
		return function ($a, $b) use ($key, $dir) {
			$t1 = strtotime(is_array($a) ? $a[$key] : $a->$key);
			$t2 = strtotime(is_array($b) ? $b[$key] : $b->$key);
			if ($t1 == $t2)
				return 0;
			return (strtoupper($dir) == 'ASC' ? ($t1 < $t2) : ($t1 > $t2)) ? -1 : 1;
		};
	}

	public static function pre($array, $display = 'print_r')
	{
		echo '<pre>';
		$display($array);
		echo '</pre>';
	}

	public static function Log($file, $indicator, $data, $thread = "")
	{
		file_put_contents($file, Dates::timestamp() . " seq." . $thread . "  " . $indicator . " " . json_encode($data) . ' ' . PHP_EOL, FILE_APPEND | LOCK_EX);
	}

}
   ?>