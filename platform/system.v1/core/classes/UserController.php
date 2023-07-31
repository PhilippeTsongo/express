<?php
class UserController
{
	public static function create()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'admin-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		global $session_user_data;
		global $session_company_data;

		$validation = $validate->check($_SIGNUP, array(
			'firstname' => array(
				'name' => 'First Name',
				'string' => true,
				'required' => true
			),
			'lastname' => array(
				'name' => 'Last Names',
				'string' => true,
				'required' => true
			),
			'email' => array(
				'name' => 'Email Address',
				'email' => true,
				'required' => true
			),
			'telephone' => array(
				'name' => 'Telephone',
				'required' => true
			)
		));

		if ($validation->passed()) {
			$AccountTable = new \VWAccount();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			$_firstname = $Str->data_in($Str->sanAsName($_SIGNUP->firstname));
			$_lastname  = $Str->data_in($Str->sanAsName($_SIGNUP->lastname));
			$_telephone = $Str->data_in($_SIGNUP->telephone);
			$_email 	= $Str->data_in($_SIGNUP->email);

			/** Password Handler */
			$_salt 			    = Hash::salt(32);
			$_generate_password = Hash::randomPassword(8);
			$_password 			= Hash::make($_generate_password, $_salt);

			$_account_type_id = 1;
			$_group_id 		  = 1;

			$_adminID = Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';

			$_fields = array(
				'account_type_id'  => $_account_type_id,
				'account_group_id' => $_group_id,
				'code' => self::generateCode(),
				'firstname' => $_firstname,
				'lastname' => $_lastname,
				'email' => $_email,
				'email_state' => 0,
				'telephone' => $_telephone,
				'profile' => 'user.png',
				'password' => $_password,
				'salt' => $_salt,
				'pin' => 0,
				'last_access' => 0,
				'last_login' => 0,
				'account_session' => 0,
				'token' => $_generate_password,
				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->insert($_fields);
				}
				catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
			}
		}
		else {
			$diagnoArray[0] = 'ERRORS_FOUND';
			$diagnoArray[] = ul_array($validation->errors());
		}
		if ($diagnoArray[0] == 'ERRORS_FOUND') {
			return (object)[
				'ERRORS' => true,
				'SUCCESS' => false,
				'ERRORS_SCRIPT' => "Error 00-".implode(', ', $diagnoArray)
			];
		}
		else {
			return (object)[
				'ERRORS' => false,
				'SUCCESS' => true,
				'ERRORS_SCRIPT' => ""
			];
		}
	}

	public static function edit()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'admin-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		global $session_user_data;
		global $session_company_data;

		$validation = $validate->check($_SIGNUP, array(
			'_id_' => array(
				'name' => 'ID',
				'required' => true
			),
			'firstname' => array(
				'name' => 'First Name',
				'string' => true,
				'required' => true
			),
			'lastname' => array(
				'name' => 'Last Names',
				'string' => true,
				'required' => true
			),
			'email' => array(
				'name' => 'Email Address',
				'email' => true,
				'required' => true
			),
			'telephone' => array(
				'name' => 'Telephone',
				'required' => true
			)
		));

		if ($validation->passed()) {
			$AccountTable = new \VWAccount();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_firstname = $Str->data_in($Str->sanAsName($_SIGNUP->firstname));
			$_lastname = $Str->data_in($Str->sanAsName($_SIGNUP->lastname));
			$_telephone = $Str->data_in($_SIGNUP->telephone);
			$_email = $Str->data_in($_SIGNUP->email);

			$_fields = array(
				'firstname' => $_firstname,
				'lastname' => $_lastname,
				'email' => $_email,
				'telephone' => $_telephone,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->update($_fields, $_ID);
				}
				catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
			}
		}
		else {
			$diagnoArray[0] = 'ERRORS_FOUND';
			$error_msg = ul_array($validation->errors());
		}
		if ($diagnoArray[0] == 'ERRORS_FOUND') {
			return (object)[
				'ERRORS' => true,
				'SUCCESS' => false,
				'ERRORS_SCRIPT' => $validate->getErrorLocation()
			];
		}
		else {
			return (object)[
				'ERRORS' => false,
				'SUCCESS' => true,
				'ERRORS_SCRIPT' => $validate->errors()
			];
		}
	}


	public static function changeStatus()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'agent-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		global $session_user_data;
		global $session_company_data;
		$_success_response_ = "";

		$validation = $validate->check($_SIGNUP, array(
			'_id_' => array(
				'name' => 'ID',
				'required' => true
			),
			'status' => array(
				'name' => 'Status',
				'required' => true
			),
		));

		if ($validation->passed()) {
			$AccountTable = new \VWAccount();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_status = $Str->data_in($_SIGNUP->status);

			$_fields = array(
				'status' => $_status,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->update($_fields, $_ID);

					/** Success Response */
					$_success_response_ = "Admin Account has been successfully updated";

				/** Send Email To Account Email */
				}
				catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
			}
		}
		else {
			$diagnoArray[0] = 'ERRORS_FOUND';
			$error_msg = ul_array($validation->errors());
		}
		if ($diagnoArray[0] == 'ERRORS_FOUND') {
			return (object)[
				'ERRORS' => true,
				'SUCCESS' => false,
				'ERRORS_SCRIPT' => $validate->getErrorLocation()
			];
		}
		else {
			return (object)[
				'ERRORS' => false,
				'SUCCESS' => true,
				'SUCCESS_SCRIPT' => $_success_response_,
				'ERRORS_SCRIPT' => $validate->errors()
			];
		}
	}


	public static function resetPassword()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'account-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		global $session_user_data;
		global $session_company_data;

		$validation = $validate->check($_SIGNUP, array(
			'_id_' => array(
				'name' => 'ID',
				'required' => true
			),
		));

		if ($validation->passed()) {
			$AccountTable = new \VWAccount();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_salt = Hash::salt(32);
			$_generate_password = Hash::randomPassword(8);
			$_password = Hash::make($_generate_password, $_salt);

			$_fields = array(
				'password' => $_password,
				'salt' => $_salt,
				'pin' => 0,
				'token' => $_generate_password,
			);


			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->update($_fields, $_ID);

				/** Send Email To Account Email */
				}
				catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
			}
		}
		else {
			$diagnoArray[0] = 'ERRORS_FOUND';
			$error_msg = ul_array($validation->errors());
		}
		if ($diagnoArray[0] == 'ERRORS_FOUND') {
			return (object)[
				'ERRORS' => true,
				'SUCCESS' => false,
				'ERRORS_SCRIPT' => $validate->getErrorLocation()
			];
		}
		else {
			return (object)[
				'ERRORS' => false,
				'SUCCESS' => true,
				'SUCCESS_SCRIPT' => 'Admin Account Password has been successfully reset',
				'ERRORS_SCRIPT' => $validate->errors()
			];
		}
	}


	public static function login($origin = null)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'login_';
		foreach ($_POST as $index => $val) {
			$ar = explode($prfx, $index);
			if (count($ar)) {
				$_LOGIN[end($ar)] = $val;
			}
		}
		$validation = $validate->check($_LOGIN, array(
			'email' => array(
				'name' => 'Email',
				'required' => true
			),
			'password' => array(
				'name' => 'Password',
				'required' => true
			)
		));

		if ($validation->passed()) {
			$AccountTable = new \VWAccount();
			$db = DB::getInstance();

			$str = new \Str();
			$_LOGIN = (object)$_LOGIN;
			$username = $str->data_in($_LOGIN->email);
			$password_txt = $str->data_in($_LOGIN->password);
			$remember = false;
			if (Input::checkInput($prfx . 'remember', 'post', 1)) {
				$remember = (Input::get($prfx . 'remember', 'post') == 'on') ? true : false;
			}
			$login = $AccountTable->login($username, $password_txt, $remember);


			if ($login !== true) {
				$diagnoArray[0] = "ERRORS_FOUND";
			}
			if (count($AccountTable->errors())) {
				if ($login == 'password') {
					$form_error = true;
					$diagnoArray[0] = "ERRORS_FOUND";
					Session::put('loginerror', 'Password');
				}
				else if ($login == 'username') {
					$form_error = true;
					$diagnoArray[0] = "ERRORS_FOUND";
					Session::put('loginerror', 'Username');
				}
			}

			$seconds = \Config::get('time/seconds');
			if ($diagnoArray[0] == 'NO_ERRORS') {

			}
		}
		else {
			$diagnoArray[0] = 'ERRORS_FOUND';
			$error_msg = ul_array($validation->errors());
		}
		if ($diagnoArray[0] == 'ERRORS_FOUND') {
			return (object)[
				'ERRORS' => true,
				'SUCCESS' => false,
				'ERRORS_SCRIPT' => $validate->getErrorLocation()
			];
		}
		else {
			return (object)[
				'ERRORS' => false,
				'SUCCESS' => true,
				'ERRORS_SCRIPT' => ""
			];
		}
	}

	public static function getAccounts($_filter_condition_)
	{
		$AccountTable = new \VWAccount();
		$AccountTable->selectQuery("SELECT app_users.id, app_users.profile, app_users.firstname, app_users.lastname, app_users.email, app_users.telephone, app_users.account_session, app_users.token, app_users.status, app_users.creation_by, app_users.creation_datetime FROM app_users WHERE app_users.status != 'DELETED' ORDER BY app_users.id DESC");
		if ($AccountTable->count())
			return $AccountTable->data();
		return false;
	}

	public static function getAccountCount($_account_id, $_event_id)
	{
		$AccountTable = new \VWAccount();
		$AccountTable->selectQuery("SELECT COUNT(app_users.id) as total_count FROM app_users WHERE app_users.status != 'DELETED' ORDER BY app_users.id DESC");
		if ($AccountTable->count())
			return $AccountTable->first()->total_count;
		return false;
	}

	public static function getAccountByID($ID)
	{
		$AccountTable = new \VWAccount();
		$AccountTable->selectQuery("SELECT app_users.profile, app_users.firstname, app_users.lastname, app_users.email, app_users.telephone, app_users.account_session, app_users.token, app_users.status, app_users.creation_by, app_users.creation_datetime FROM app_users WHERE app_users.status != 'DELETED' AND app_users.id = ? ORDER BY app_users.id DESC LIMIT 1", array($ID));
		if ($AccountTable->count())
			return $AccountTable->first();
		return false;
	}

	public static function generateCode($TYPE = 1)
	{
		return 'BXSA1' . rand(10, 90) . date('s') . ($TYPE == 1 ? 'A' : 'L') . date('d');
	}


	public static function generateToken($STR)
	{
		$seconds = time();
		$token_hash = md5($seconds . sha1($STR));
		return $token_hash;
	}

	public static function getLastID()
	{
		$AccountTable = new \VWAccount();
		$AccountTable->selectQuery("SELECT id FROM app_users ORDER BY id DESC LIMIT 1");
		if ($AccountTable->count())
			return $AccountTable->first()->id;
		return false;
	}

	public static function checkIfExists($_condition_ = "")
	{
		$AccountTable = new \VWAccount();
		$AccountTable->selectQuery("SELECT id FROM app_users $_condition_  ORDER BY id DESC LIMIT 1");
		if ($AccountTable->count())
			return true;
		return false;
	}

	public static function getAccountTypes($_condition_ = "")
	{
		$AccountTable = new \VWAccount();
		$AccountTable->selectQuery("SELECT id, name, description FROM app_account_type $_condition_ ORDER BY id DESC");
		if ($AccountTable->count())
			return $AccountTable->data();
		return false;
	}

	public static function getAccountGroups($_account_type_, $_condition_ = "")
	{
		$AccountTable = new \VWAccount();
		$AccountTable->selectQuery("SELECT id, name, description FROM app_user_groups WHERE account_type_id = ? $_condition_  ORDER BY id DESC", array($_account_type_));
		if ($AccountTable->count())
			return $AccountTable->data();
		return false;
	}


}
