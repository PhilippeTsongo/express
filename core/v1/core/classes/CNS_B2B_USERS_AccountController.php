<?php
class CNS_B2B_USERS_AccountController
{
	public static function create($_platform, $_b2b)
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

		$validation = $validate->check($_SIGNUP, array(
			'type' => array(
				'name' => 'Type',
				'string' => true,
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
			$AccountTable = new \CNS_B2B_USERS_Account();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH        = new \Hash();

			$_type 		 = $HASH->decryptAES( $Str->data_in($_SIGNUP->type) );
			$_join_date 	 = !Input::checkInput($prfx.'joindate', 'post', 1)?time():strtotime($Str->data_in($_SIGNUP->joindate));

			$_firstname 	 = $Str->data_in($_SIGNUP->firstname);
			$_lastname 	 = $Str->data_in($_SIGNUP->lastname);
			$_email 	 = $Str->data_in($_SIGNUP->email);
			$_telephone 	 = $Str->data_in($_SIGNUP->telephone);

			$_language = !Input::checkInput($prfx.'language', 'post', 1)?'fr-lang':($Str->data_in($_SIGNUP->language));

			/** Password Handler */
			$_salt 			    = Hash::salt(32);
			$_generate_password = Hash::randomPassword(8);
			$_password 			= Hash::make($_generate_password, $_salt);

			/** Get Platform Data By Platform ID */
			$_platform_data = CNS_B2B_PlatformController::getPlatformByID($_platform);
			if(!$_platform_data)
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Error platform is invalid"
				];
			$_platform_data = (Object) $_platform_data ;

			$account_type = 1;

			$_adminID = 1;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';

			$account_code = self::generateCode();

			$_fields = array(

				'cns_platform' => $_platform,
				'cns_b2b' => $_b2b,
				'account_code' => $account_code,
				'account_type' => $_type,

				'firstname' => $_firstname,
				'lastname' => $_lastname,

				'email' => $_email,
				'telephone' => $_telephone,

				'profile' => '',

				'language' => $_language,
				'join_date' => $_join_date,
				'default_password' => $_generate_password,

				'password' => $_password,
				'salt' => $_salt,
				'pin' => 1,

				'status' => $_status,
				'last_access' => 0,
				'last_login' => 0,
				'account_session' => 0,


				'auth_token' => '',
				'auth_generated_datetime' => 0,
				'auth_exipration_datetime' => 0,

				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),

			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->insert($_fields);

					/** EMAIL */
					$_DATA_ = array(
						'firstname' => $_firstname,
						'email' => $_email,
						'password' => $_generate_password,
						'link' => "http://system.afriexpressglobal.cnsplateforme.com/login",

					);
					CNS_EMAIL::send('CNSEMAIL.00002',  $_DATA_);
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

	public static function get_system_portal_link_by_platform_id($_platform_id){
		$_portal_link = "https://stock.cnsplateforme.com";
		if( $_platform_id == 1) // Stock
			$_portal_link = "https://stock.cnsplateforme.com";
		if( $_platform_id == 2) // Tontine
			$_portal_link = "https://tontine.cnsplateforme.com";
		if( $_platform_id == 3) // Event
			$_portal_link = "https://myevent.cnsplateforme.com";

		return $_portal_link;
	}

	public static function edit_basic_information()
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
			// 'language' => array(
			// 	'name' => 'Language',
			// 	'required' => true
			// ),
			'telephone' => array(
				'name' => 'Telephone',
				'required' => true
			)
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_USERS_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_join_date  = !Input::checkInput($prfx.'joindate', 'post', 1)?time():strtotime($Str->data_in($_SIGNUP->joindate));
			$_firstname  = $Str->data_in($Str->sanAsName($_SIGNUP->firstname));
			$_lastname   = $Str->data_in($Str->sanAsName($_SIGNUP->lastname));
			$_telephone = $Str->data_in($_SIGNUP->telephone);
			$_email = $Str->data_in($_SIGNUP->email);

			$_language = !Input::checkInput($prfx.'language', 'post', 1)?'fr-lang':($Str->data_in($_SIGNUP->language));

			$_fields = array(
				'firstname' => $_firstname,
				'lastname' => $_lastname,
				'email' => $_email,
				'telephone' => $_telephone,
				'language' => $_language,
				'join_date' => $_join_date,
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

	public static function edit_address_information()
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

		$validation = $validate->check($_SIGNUP, array(
			'_id_' => array(
				'name' => 'ID',
				'required' => true
			),
			'country' => array(
				'name' => 'Country',
				'required' => true
			),
			'province' => array(
				'name' => 'Province',
				'required' => true
			),
			'city' => array(
				'name' => 'City',
				'required' => true
			),
			'address' => array(
				'name' => 'Address',
				'required' => true
			)
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_USERS_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_country 	 = $HASH->decryptAES( $Str->data_in($_SIGNUP->country) );
			$_province 	 = $HASH->decryptAES( $Str->data_in($_SIGNUP->province) );
			$_city 	     = $HASH->decryptAES( $Str->data_in($_SIGNUP->city) );
			$_address    = $Str->data_in($_SIGNUP->address);

			$_fields = array(
				'country' => $_country,
				'province' => $_province,
				'city' => $_city,
				'address' => $_address
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


	public static function edit_b2b_social_media_information()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'link-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			// 'type' => array(
			// 	'name' => 'Account Facebook',
			// 	'required' => true
			// ),
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_USERS_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_facebook = $Str->data_in($_SIGNUP->facebook);
			$_instagram = $Str->data_in($_SIGNUP->instagram);
			$_tweeter = $Str->data_in($_SIGNUP->tweeter);

			$_snapchat = $Str->data_in($_SIGNUP->snapchat);
			$_linkedin = $Str->data_in($_SIGNUP->linkedin);
			$_whatsapp = $Str->data_in($_SIGNUP->whatsapp);

			$_youtube = $Str->data_in($_SIGNUP->youtube);
			$_tiktok = $Str->data_in($_SIGNUP->tiktok);
			
			$_fields = array(

				'facebook' => $_facebook,
				'instagram' => $_instagram,
				'tweeter' => $_tweeter,
				'youtube' => $_youtube,

				'whatsapp' => $_whatsapp,
				'linkedin' => $_linkedin,
				'snapchat' => $_snapchat,
				'tiktok' => $_tiktok,

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
			$diagnoArray[] = ul_array($validation->errors());
		}
		if ($diagnoArray[0] == 'ERRORS_FOUND') {
			return (object)[
				'ERRORS' => true,
				'SUCCESS' => false,
				'ERRORS_SCRIPT' => "Error 00-" . implode(', ', $diagnoArray)
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


	public static function changeStatus()
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
			$AccountTable = new \CNS_B2B_USERS_Account();
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

	public static function resetPassword($_platform)
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

		$validation = $validate->check($_SIGNUP, array(
			'_id_' => array(
				'name' => 'ID',
				'required' => true
			),
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_USERS_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));


			/** Get Platform Data By Platform ID */
			$_platform_data = CNS_B2B_PlatformController::getPlatformByID($_platform);
			if(!$_platform_data)
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Error platform is invalid"
				];
			$_platform_data = (Object) $_platform_data ;


			/** Get Platform Data By Platform ID */
			$_user_data = CNS_B2B_USERS_AccountController::getAccountByID($_ID);
			if(!$_user_data)
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Error user is invalid"
				];
			$_user_data = (Object) $_user_data ;

			$_salt = Hash::salt(32);
			$_generate_password = Hash::randomPassword(8);
			$_password = Hash::make($_generate_password, $_salt);

			$_fields = array(
				'password' => $_password,
				'salt' => $_salt,
				'pin' => 0,
				'default_password' => $_generate_password,
			);


			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->update($_fields, $_ID);

					/** EMAIL */
					$_DATA_ = array(
						'firstname' => $_user_data->firstname,
						'email' => $_user_data->email,
						'password' => $_generate_password
					);
					CNS_EMAIL::send('CNSEMAIL.00009',  $_DATA_);
				}
				catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
			}
		}
		else {
			$diagnoArray[0] = 'ERRORS_FOUND';
			$diagnoArray = ul_array($validation->errors());
		}
		if ($diagnoArray[0] == 'ERRORS_FOUND') {
			return (object)[
				'ERRORS' => true,
				'SUCCESS' => false,
				'ERRORS_SCRIPT' => $diagnoArray
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
			$AccountTable = new \CNS_B2B_USERS_Account();
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

	// public static function getAccounts($_filter_condition_ = "")
	// {
	// 	$AccountTable = new \CNS_B2B_USERS_Account();
	// 	$AccountTable->selectQuery("SELECT * FROM `cns_cluster_account_b2b_users`");
	// 	if ($AccountTable->count())
	// 		return $AccountTable->data();
	// 	return false;
	// }

	public static function getAccountCount($_filter_condtion_ = "")
	{
		$AccountTable = new \CNS_B2B_USERS_Account();
		$CNSROOTLastUserTable = new \CNS_B2B_USERS_Account();

		$AccountTable->selectQuery("SELECT COUNT(cns_cluster_account_b2b_users.id) as total_user FROM cns_cluster_account_b2b_users WHERE cns_cluster_account_b2b_users.status != 'DELETED' $_filter_condtion_ ORDER BY cns_cluster_account_b2b_users.id DESC");
		$CNSROOTLastUserTable->selectQuery("SELECT max(creation_datetime) as last_user_creation_datetime FROM cns_cluster_account_b2b_users WHERE cns_cluster_account_b2b_users.status != 'DELETED' $_filter_condtion_ ORDER BY cns_cluster_account_b2b_users.id DESC");
		
		if ($AccountTable->count())
			$_DATA_ = array();
			foreach ($AccountTable->data() as $list_):
				$list_->total_user = $AccountTable->first()->total_user;
				$list_->last_user_creation_datetime = date('d/m/Y', $CNSROOTLastUserTable->first()->last_user_creation_datetime);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		return false;
	}
	

	public static function generateCode($TYPE = 1)
	{
		return 'CNSBU.' . rand(10, 90) . date('s') . ($TYPE == 1 ? 'S' : 'N') . date('d');
	}

	public static function generateToken($STR)
	{
		$seconds = time();
		$token_hash = md5($seconds . sha1($STR));
		return $token_hash;
	}

	public static function getLastID($table = "cns_cluster_account_b2b_users")
	{
		$AccountTable = new \CNS_B2B_USERS_Account();
		$AccountTable->selectQuery("SELECT id FROM $table ORDER BY id DESC LIMIT 1");
		if ($AccountTable->count())
			return $AccountTable->first()->id;
		return false;
	}

	public static function checkIfExists($_condition_ = "")
	{
		$AccountTable = new \CNS_B2B_USERS_Account();
		$AccountTable->selectQuery("SELECT id FROM app_users $_condition_  ORDER BY id DESC LIMIT 1");
		if ($AccountTable->count())
			return true;
		return false;
	}

	public static function getAccounts($_filter_condition_ = ""){
        $CNSROOTAccountTable = new \CNS_B2B_USERS_Account();
		$HASH = new \Hash();
        $CNSROOTAccountTable->selectQuery("SELECT id as token_id, cns_platform as platform, cns_b2b as company, firstname, lastname, email, telephone, join_date, status, (SELECT name FROM cns_access_level WHERE id = cns_cluster_account_b2b_users.account_type) as account_type FROM cns_cluster_account_b2b_users WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccountTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTAccountTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$list_->join_date    = $list_->join_date <= 0 ? '':date('D d M, Y', $list_->join_date);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getAccountTypes($_filter_condition_ = ""){
        $CNSROOTAccountTable = new \CNS_B2B_USERS_Account();
		$HASH = new \Hash();
        $CNSROOTAccountTable->selectQuery("SELECT id as token_id, code, name, description, status FROM cns_access_level WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccountTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTAccountTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getAccountByID($ID)
	{
		$CNSROOTAccountTable = new \CNS_B2B_USERS_Account();
		$HASH = new \Hash();
        $CNSROOTAccountTable->selectQuery("SELECT id as token_id, (SELECT name FROM cns_access_level WHERE id = cns_cluster_account_b2b_users.account_type) as account_type, cns_platform as platform, cns_b2b as company, firstname, lastname, email, telephone, status FROM cns_cluster_account_b2b_users WHERE id =? ORDER BY id DESC LIMIT 1", array($ID));
		if ($CNSROOTAccountTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTAccountTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_ 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getAccountSalt($email)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        $CNS_ROOT_AccountTable->selectQuery("SELECT salt FROM cns_cluster_account_b2b_users WHERE email = '{$email}'  ORDER BY ID DESC");
        if ($CNS_ROOT_AccountTable->count())
            return $CNS_ROOT_AccountTable->first()->salt;
        return false;
    }
 
	public static function hashPassword($password)
    {
        /** Hashing  App Password */
        $app_salt = Hash::salt(32);
        $password = Hash::make($password, $app_salt);
        return $password;
    }

    public static function hashPasswordWithSalt($password, $app_salt)
    {
        /** Hashing  App Password */
        // $app_salt = Hash::salt(32);
        $password = Hash::make($password, $app_salt);
        return $password;
    }

	public static function checkAccountExist($email, $password, $platform)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        $CNS_ROOT_AccountTable->selectQuery("SELECT id FROM cns_cluster_account_b2b_users where cns_platform = $platform AND email = '{$email}' AND password = '{$password}' ");
        if ($CNS_ROOT_AccountTable->count()) 
            return true;
        return false;
    }

	public static function checkPlatformExist($code)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        $CNS_ROOT_AccountTable->selectQuery("SELECT id, status, name, code FROM cns_cluster_platform where code = ?", array($code));
        if ($CNS_ROOT_AccountTable->count()) 
            return $CNS_ROOT_AccountTable->first();
        return false;
    }

    public static function getAccountStatus($email)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        $CNS_ROOT_AccountTable->selectQuery("SELECT status FROM cns_cluster_account_b2b_users where  `email` =  '{$email}' ");
        if ($CNS_ROOT_AccountTable->count()) 
            return $CNS_ROOT_AccountTable->first()->status;
        return false;
    }

	public static function getAccountData($email, $password)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        $CNS_ROOT_AccountTable->selectQuery("SELECT id, account_type, status, cns_b2b, auth_generated_datetime, auth_exipration_datetime, auth_token, account_code, cns_platform, cns_platform_product, (SELECT platform_root FROM cns_cluster_platform_product WHERE cns_cluster_platform_product.id = cns_cluster_account_b2b_users.cns_platform_product ) as platform_root FROM cns_cluster_account_b2b_users WHERE `email` =? and password =?  ", array($email, $password));
        if ($CNS_ROOT_AccountTable->count()) 
            return $CNS_ROOT_AccountTable->first();
        return false; 
    }

	public static function getAccountProfile($id)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        $CNS_ROOT_AccountTable->selectQuery("SELECT cns_cluster_account_b2b_users.id as token_id, cns_cluster_account_b2b_users.country, cns_cluster_account_b2b_users.join_date, cns_cluster_account_b2b_users.province, cns_cluster_account_b2b_users.city, cns_cluster_account_b2b_users.zipcode, cns_cluster_account_b2b_users.address, cns_cluster_account_b2b_users.telephone_2, cns_cluster_account_b2b_users.firstname, cns_cluster_account_b2b_users.lastname, cns_cluster_account_b2b_users.account_code,  cns_cluster_account_b2b.company_name as corp_name, cns_cluster_account_b2b.account_code as corp_code, cns_cluster_account_b2b.company_logo,   cns_cluster_account_b2b_users.profile, cns_views_access_level.code as user_type_code, cns_views_access_level.name as user_type_name,   cns_views_access_level.name as user_type_description, cns_cluster_account_b2b_users.profile, cns_cluster_account_b2b_users.email, cns_cluster_account_b2b_users.telephone, cns_cluster_account_b2b_users.language, cns_cluster_account_b2b_users.status, cns_cluster_account_b2b_users.facebook, cns_cluster_account_b2b_users.instagram, cns_cluster_account_b2b_users.tweeter, cns_cluster_account_b2b_users.youtube, cns_cluster_account_b2b_users.whatsapp, cns_cluster_account_b2b_users.snapchat, cns_cluster_account_b2b_users.tiktok, cns_cluster_account_b2b_users.linkedin, (SELECT name FROM cns_data_country where id = cns_cluster_account_b2b_users.country) as country_name, (SELECT name FROM cns_data_province where id = cns_cluster_account_b2b_users.province) as province_name, (SELECT name FROM cns_data_city where id = cns_cluster_account_b2b_users.city) as city_name FROM cns_cluster_account_b2b_users, cns_cluster_account_b2b,   cns_views_access_level   WHERE cns_cluster_account_b2b_users.cns_b2b = cns_cluster_account_b2b.id AND cns_views_access_level.id = cns_cluster_account_b2b_users.account_type  AND cns_cluster_account_b2b_users.id = ? ORDER BY cns_cluster_account_b2b_users.id DESC LIMIT 1", array($id));
        if ($CNS_ROOT_AccountTable->count()):
			$HASH = new \Hash();
			$_DATA_ = array();
			foreach( $CNS_ROOT_AccountTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$list_->country = $HASH->encryptAES($list_->country);
				$list_->province = $HASH->encryptAES($list_->province);
				$list_->city = $HASH->encryptAES($list_->city);
				
				$list_->language_name = ($list_->language == 'eng-lang')?"English": "French";
				
				$list_->join_date_value = $list_->join_date <= 0 ? '':date('Y-m-d', $list_->join_date);
				$list_->join_date    = $list_->join_date <= 0 ? '':date('D d M, Y', $list_->join_date);
				$_DATA_ 			    = (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
        return false;
    }

	public static function getSessionAccountProfile($id)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        $CNS_ROOT_AccountTable->selectQuery("SELECT cns_cluster_account_b2b_users.id as robot, cns_cluster_account_b2b_users.firstname, cns_cluster_account_b2b_users.lastname, cns_cluster_account_b2b_users.account_code,  cns_cluster_account_b2b.company_name as corp_name, cns_cluster_account_b2b.account_code as corp_code, cns_cluster_account_b2b_users.profile, cns_views_access_level.name as user_type_name, cns_views_access_level.name as user_type_description, cns_cluster_account_b2b_users.profile, cns_cluster_account_b2b_users.email, cns_cluster_account_b2b_users.telephone, cns_cluster_account_b2b_users.language, cns_cluster_account_b2b_users.status FROM cns_cluster_account_b2b_users, cns_cluster_account_b2b,   cns_views_access_level   WHERE cns_cluster_account_b2b_users.cns_b2b = cns_cluster_account_b2b.id AND cns_views_access_level.id = cns_cluster_account_b2b_users.account_type  AND cns_cluster_account_b2b_users.id = ? ORDER BY cns_cluster_account_b2b_users.id DESC LIMIT 1", array($id));
        if ($CNS_ROOT_AccountTable->count()):
			$HASH = new \Hash();
			$_DATA_ = array();
			foreach( $CNS_ROOT_AccountTable->data() As $list_ ):
				$list_->robot   = $HASH->encryptAES($list_->robot);
				$_DATA_ 		= (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
        return false;
    }

	public static function getSessionAccountAccess($account_data)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
		$_SQL_ = " AND  access_level = {$account_data->account_type} and  cns_platform = {$account_data->cns_platform} and ( cns_platform_product = 0 OR cns_platform_product = {$account_data->cns_platform_product}) AND ( cns_b2b = 0 OR cns_b2b = {$account_data->cns_b2b} ) ";
        $CNS_ROOT_AccountTable->selectQuery("SELECT task_name as task FROM cns_views_access_level_task WHERE status = 'ACTIVE' $_SQL_ ");
        if ($CNS_ROOT_AccountTable->count()):
			$HASH = new \Hash();
			$_DATA_ = array();
			foreach( $CNS_ROOT_AccountTable->data() As $list_ ):
				$_DATA_[] 		= (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
        return array();
    }

	public static function getAccountB2BProfile($id)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        $CNS_ROOT_AccountTable->selectQuery("SELECT cns_cluster_account_b2b_users.firstname, cns_cluster_account_b2b_users.lastname, cns_cluster_account_b2b_users.account_code, cns_cluster_account_b2b.company_name as corp_name, cns_cluster_account_b2b.account_code as corp_code, cns_cluster_account_b2b.company_logo, cns_cluster_account_b2b_users.profile, cns_views_access_level.code as user_type_code, cns_views_access_level.name as user_type_name, cns_views_access_level.name as user_type_description FROM cns_cluster_account_b2b_users, cns_cluster_account_b2b, cns_views_access_level WHERE cns_cluster_account_b2b_users.cns_b2b = cns_cluster_account_b2b.id AND cns_views_access_level.id = cns_cluster_account_b2b_users.account_type  AND cns_cluster_account_b2b_users.id = ? ORDER BY cns_cluster_account_b2b_users.id DESC LIMIT 1;", array($id));
        if ($CNS_ROOT_AccountTable->count()) 
            return $CNS_ROOT_AccountTable->first();
        return false;
    }

    public static function checkToken($token)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        $CNS_ROOT_AccountTable->selectQuery("SELECT id, status, account_type,  auth_generated_datetime, auth_exipration_datetime, auth_token, account_code, cns_platform, cns_platform_product, cns_b2b FROM cns_cluster_account_b2b_users where  `auth_token` = ? ", array($token));
        if ($CNS_ROOT_AccountTable->count()) 
            return $CNS_ROOT_AccountTable->first();
        return false;
    }

	public static function getAccountActiveSession($email)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        $CNS_ROOT_AccountTable->selectQuery("SELECT auth_generated_datetime, auth_expiration_datetime, account_code FROM val_agent where  `email` = '{$email}' ");
        if ($CNS_ROOT_AccountTable->count())
            return $CNS_ROOT_AccountTable->first();
        return false;
    }

	public static function updateEntries($fields, $conditions)
    {
        $CNS_ROOT_AccountTable = new \CNS_B2B_USERS_Account();
        try {
            $CNS_ROOT_AccountTable->updateMultiple($fields, $conditions);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }


}
