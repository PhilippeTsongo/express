<?php 
class AppData
{
	private $db_status;
	
	public function setDBStatus($value){
		$this->db_status = $value;
	}
	public function getDBStatus(){
		return $this->db_status;
	}

	public static function DNCTRLUP()
	{
		echo '<input type="hidden" class="hostname" value="' . DNADMIN . '"/>';
	}

	# $HASH->encryptAES('app.valwallet.system.agents.vw.portal.v01.webservices.api.master.2022.#PoweredBy.Ir.Ezpk.agents.system.management');
	public static function checkBasicAuthToken($auth_token){
		return (Config::get('webservice_api/authorization_key') == $auth_token)?true:false;
	}

	public static function checkBearerAuthToken($auth_token){
		return (Config::get('webservice_api/authorization_key') == $auth_token)?true:false;
	}

	public static function getBodyData(){
		return (Object) json_decode(str_replace("\\", "", file_get_contents('php://input') ));
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

	public static function getIpInfo($ip = NULL, $purpose = "location", $deep_detect = TRUE)
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

}?>