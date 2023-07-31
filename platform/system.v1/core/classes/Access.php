<?php
class Access
{
	public static function cns_auth_access($auth_token)
	{
		$ACCESS = array();
		$DATA = HttpRequest::post("http://127.0.0.1/cns/core/cns.platform.core.v1/cns/master/api/platform/account/authentification/acc", "POST", array(), "Bearer $auth_token");
		// $DATA = HttpRequest::post("http://197.243.24.119/cns/core/cns.platform.core.v1/cns/master/api/platform/account/authentification/acc", "POST", array(), "Bearer $auth_token");
		$DATA = json_decode($DATA);
		if ($DATA->status == 200):
			$ACCESS = $DATA->data;
		else:
		endif;
		return json_encode($ACCESS);
	}

	public static function cns_access_granted()
	{
		$_ACCESSTASKSGRANTED_ = Session::get(Session::get(Config::get("session/session_name")));
		return $_ACCESSTASKSGRANTED_;
	}

	public static function cns_access_granted_encoded()
	{
		$_ACCESSTASKSGRANTED_ = base64_encode( base64_encode( Session::get(Session::get(Config::get("session/session_name"))) ) );
		return $_ACCESSTASKSGRANTED_;
	}

	public static function granted($task)
	{
		$_ACCESSTASKSGRANTED_ = self::cns_access_granted();
		$_ACCESSTASKSGRANTED_ = json_decode($_ACCESSTASKSGRANTED_);
		if ($_ACCESSTASKSGRANTED_)
			foreach ($_ACCESSTASKSGRANTED_ as $_ACCESS_):
				if ($_ACCESS_->task === $task)
					return true;
			endforeach;
		return false;
	}
}
?>