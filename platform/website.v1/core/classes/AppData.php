<?php
class AppData
{
	private $db_status;

	public function setDBStatus($value)
	{
		$this->db_status = $value;
	}
	public function getDBStatus()
	{
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

	public static function cns_platform_map_root_main($auth_platform){
		return Hash::decryptAuthToken( $auth_platform ) . '/';
	}
}
?>
