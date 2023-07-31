<?php
class CNS_B2C_Controller
{
	public static function create_2bc($_POST_)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'account-';
		foreach ($_POST_ as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'firstname' => array(
				'name' => 'First Name',
				'required' => true
			),
			'lastname' => array(
				'name' => 'Last name',
				'required' => true
			),
			'email' => array(
				'name' => 'Company Email',
				'email' => true,
				'required' => true
			),
			'telephone' => array(
				'name' => 'Telephone',
				'required' => true
			)
		)
		);

		if ($validation->passed()) {
			$CNS_B2C_Table = new \CNS_B2C();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			// $_cns_platform = Hash::decryptToken($Str->data_in($_SIGNUP->cns_platform));
			// $_cns_platform_product = Hash::decryptToken($Str->data_in($_SIGNUP->cns_platform_product));

			// $_type = Hash::decryptToken($Str->data_in($_SIGNUP->type));
			$_firstname = $Str->data_in($Str->sanAsName($_SIGNUP->firstname));
			$_lastname = $Str->data_in($Str->sanAsName($_SIGNUP->lastname));
			$_email = $Str->data_in($_SIGNUP->email);
			$_telephone = $Str->data_in($_SIGNUP->telephone);

			$_cns_platform = $Str->data_in($_SIGNUP->platform);
			$_cns_platform_product = $Str->data_in($_SIGNUP->platform_product);
			$_cns_b2b = $Str->data_in($_SIGNUP->cns_b2b);

			$_IDCode_ = self::getLastID() + 1 + 1000;
			// $_short_name = !Input::checkInput($prfx.'short_name', 'post', 1)?$_IDCode_: $Str->data_in($Str->sanAsName($_SIGNUP->short_name));

			// $_email_public = !Input::checkInput($prfx.'email_public', 'post', 1)?'': $Str->data_in($_SIGNUP->email_public);
			// $_telephone_public = !Input::checkInput($prfx.'telephone_public', 'post', 1)?'': $Str->data_in($_SIGNUP->telephone_public);

			/** Password Handler */
			$_salt = Hash::salt(32);
			$_generate_password = !Input::checkInput($prfx . 'password', 'post', 1) ? '' : Hash::randomPassword(8);
			$_password = Hash::make($_generate_password, $_salt);

			$account_type = 1;

			$_adminID = 1; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$code = self::generateCode();

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b' => $_cns_b2b,

				'code' => $code,
				'firstname' => $_firstname,
				'lastname' => $_lastname,
				'email' => $_email,
				'telephone' => $_telephone,

				'country' => 1,
				'province' => 1,
				'city' => 1,
				'address' => "",

				'password' => $_password,
				'salt' => $_salt,
				'pin' => 1,
				'join_datetime' => Dates::seconds(),
				'status' => $_status,

				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),

				// 'update_by' => $access_token,
				// 'update_datetime' => $token_generated_date
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$CNS_B2C_Table->insert($_fields);
					$_cns_b2c = self::getLastID();

					/** Send Email To New Agent */
					/** EMAIL */
					$_DATA_ = array(
						'firstname' => $_firstname,
						'email' => $_email,
						'password' => $_generate_password, 
						// 'b2b' => $_cns_b2bname,
						'link' => "https://afriexpressglobal.cnsplateforme.com/user/login",

					);
					CNS_EMAIL::send('CNSEMAIL.00003',  $_DATA_);

				} catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
			}
		} else {
			$diagnoArray[0] = 'ERRORS_FOUND';
			$diagnoArray[] = ul_array($validation->errors());
		}
		if ($diagnoArray[0] == 'ERRORS_FOUND') {
			return (object) [
				'ERRORS' => true,
				'SUCCESS' => false,
				'ERRORS_SCRIPT' => "Error 00-" . implode(', ', $diagnoArray)
			];
		} else {
			return (object) [
				'ERRORS' => false,
				'SUCCESS' => true,
				'ID' => $_cns_b2c,
				'ERRORS_SCRIPT' => ""
			];
		}
	}

	public static function signup_2bc($_cns_platform, $_POST_)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'account-';
		foreach ($_POST_ as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'firstname' => array(
				'name' => 'First Name',
				'required' => true
			),
			'lastname' => array(
				'name' => 'Last name',
				'required' => true
			),
			'email' => array(
				'name' => 'Company Email',
				'email' => true,
				'required' => true
			),
			'telephone' => array(
				'name' => 'Telephone',
				'required' => true
			)
		)
		);

		if ($validation->passed()) {
			$CNS_B2C_Table = new \CNS_B2C();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			$_firstname = $Str->data_in($Str->sanAsName($_SIGNUP->firstname));
			$_lastname = $Str->data_in($Str->sanAsName($_SIGNUP->lastname));
			$_email = $Str->data_in($_SIGNUP->email);
			$_telephone = $Str->data_in($_SIGNUP->telephone);

			$_cns_platform_product = 0;
			$_cns_b2b = 0;

			/** Password Handler */
			$_salt = Hash::salt(32);
			$_generate_password = !Input::checkInput('password', 'post', 1) ? $Str->data_in($_SIGNUP->password) : Hash::randomPassword(8);
			$_password = Hash::make($_generate_password, $_salt);

			/** Check */
			if (self::checkIfExists("WHERE email = '$_email' ")):
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Error email already used!"
				];
			endif;

			if (self::checkIfExists("WHERE telephone = '$_telephone' ")):
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Error telephone already used!"
				];
			endif;

			if ( strlen($_generate_password) < 6 ):
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Error password is not strong. Minimum 6 caracters!"
				];
			endif;

			if (self::checkIfExists("WHERE telephone = '$_telephone' ")):
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Error email already used!"
				];
			endif;
			

			$_adminID = 1;
			$_status = 'ACTIVE';

			$code = self::generateCode();

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b' => $_cns_b2b,

				'code' => $code,
				'firstname' => $_firstname,
				'lastname' => $_lastname,
				'email' => $_email,
				'telephone' => $_telephone,

				'country' => 1,
				'province' => 1,
				'city' => 1,
				'address' => "",

				'password' => $_password,
				'salt' => $_salt,
				'token' => $_generate_password,

				'pin' => 1,
				'join_datetime' => Dates::seconds(),
				'status' => $_status,

				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),

			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$CNS_B2C_Table->insert($_fields);
					$_cns_b2c = self::getLastID();

					/** Send Email To B2C */
					/** EMAIL */
					$_DATA_ = array(
						'firstname' => $_firstname,
						'email' => $_email,
						'password' => $_generate_password, 
						// 'b2b' => $_cns_b2bname,
						'link' => "https://afriexpressglobal.cnsplateforme.com/user/login",

					);
					CNS_EMAIL::send('CNSEMAIL.00003',  $_DATA_);

				} catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
			}
		} else {
			$diagnoArray[0] = 'ERRORS_FOUND';
			$diagnoArray[] = ul_array($validation->errors());
		}
		if ($diagnoArray[0] == 'ERRORS_FOUND') {
			return (object) [
				'ERRORS' => true,
				'SUCCESS' => false,
				'ERRORS_SCRIPT' => "Error 00-" . implode(', ', $diagnoArray)
			];
		} else {
			return (object) [
				'ERRORS' => false,
				'SUCCESS' => true,
				'CUSTOMERID' => $_cns_b2c,
				'ERRORS_SCRIPT' => ""
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
		)
		);

		if ($validation->passed()) {
			$CNS_B2C_Table = new \CNS_B2C();
			$db = DB::getInstance();

			$str = new \Str();
			$_LOGIN = (object) $_LOGIN;
			$username = $str->data_in($_LOGIN->email);
			$password_txt = $str->data_in($_LOGIN->password);
			$remember = false;
			if (Input::checkInput($prfx . 'remember', 'post', 1)) {
				$remember = (Input::get($prfx . 'remember', 'post') == 'on') ? true : false;
			}
			$login = $CNS_B2C_Table->login($username, $password_txt, $remember);


			if ($login !== true) {
				$diagnoArray[0] = "ERRORS_FOUND";
			}
			if (count($CNS_B2C_Table->errors())) {
				if ($login == 'password') {
					$form_error = true;
					$diagnoArray[0] = "ERRORS_FOUND";
					Session::put('loginerror', 'Password');
				} else if ($login == 'username') {
					$form_error = true;
					$diagnoArray[0] = "ERRORS_FOUND";
					Session::put('loginerror', 'Username');
				}
			}

			$seconds = \Config::get('time/seconds');
			if ($diagnoArray[0] == 'NO_ERRORS') {

			}
		} else {
			$diagnoArray[0] = 'ERRORS_FOUND';
			$error_msg = ul_array($validation->errors());
		}
		if ($diagnoArray[0] == 'ERRORS_FOUND') {
			return (object) [
				'ERRORS' => true,
				'SUCCESS' => false,
				'ERRORS_SCRIPT' => $validate->getErrorLocation()
			];
		} else {
			return (object) [
				'ERRORS' => false,
				'SUCCESS' => true,
				'ERRORS_SCRIPT' => ""
			];
		}
	}

	public static function generateCode($TYPE = 'ACCOUNT')
	{
		if ($TYPE == 'BRANCH')
			return 'CNSBR.' . rand(10, 90) . date('s') . rand(5, 50) . date('d');
		return 'CNSB.' . rand(10, 90) . date('s') . ($TYPE == 1 ? 'S' : 'N') . date('d');
	}

	public static function generateToken($STR)
	{
		$seconds = time();
		$token_hash = md5($seconds . sha1($STR));
		return $token_hash;
	}

	public static function getLastID($_table_ = 'cns_b2c_customer')
	{
		$CNS_B2C_Table = new \CNS_B2C();
		$CNS_B2C_Table->selectQuery("SELECT id FROM $_table_ ORDER BY id DESC LIMIT 1");
		if ($CNS_B2C_Table->count())
			return $CNS_B2C_Table->first()->id;
		return false;
	}

	public static function checkIfExists($_condition_ = "")
	{
		$CNS_B2C_Table = new \CNS_B2C();
		$CNS_B2C_Table->selectQuery("SELECT id FROM cns_b2c_customer $_condition_  ORDER BY id DESC LIMIT 1");
		if ($CNS_B2C_Table->count())
			return true;
		return false;
	}

	public static function getAccounts($_filter_condition_ = "")
	{
		$CNS_B2CTable = new \CNS_B2C();
		$HASH = new \Hash();
		$CNS_B2CTable->selectQuery("SELECT id as token_id, cns_platform, account_code, account_type,	company_name, company_email, company_telephone,  company_email_public, company_telephone_public,	country, province, city, address, status FROM cns_b2c_customer WHERE status != 'DELETED' $_filter_condition_");
		if ($CNS_B2CTable->count()):
			$_DATA_ = array();
			foreach ($CNS_B2CTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_b2c_list($_filter_condition_ = "")
	{
		$CNS_B2CTable = new \CNS_B2C();
		$HASH = new \Hash();
		$CNS_B2CTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product,	code, name,	description,	country, province, city, address, status FROM cns_b2c_customer_branch WHERE status != 'DELETED' $_filter_condition_");
		if ($CNS_B2CTable->count()):
			$_DATA_ = array();
			foreach ($CNS_B2CTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_cns_b2c_by_profile($_customer_profile_)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$HASH = new \Hash();
		$_customer_profile_ = (Object) $_customer_profile_;
		$_filter_condition_ = " AND telephone = '{$_customer_profile_->telephone}' ";

		$CNS_B2CTable->selectQuery("SELECT id, code, firstname, lastname, email, telephone, status FROM cns_b2c_customer WHERE status != 'DELETED' $_filter_condition_ ORDER BY id DESC LIMIT 1 ");
		if ($CNS_B2CTable->count()):
			return $CNS_B2CTable->first()->id;
		else:
			$register_b2c = self::create_2bc($_customer_profile_);
			if ($register_b2c->ERRORS == false):
				return $register_b2c->ID;
			endif;
		endif;
		return false;
	}

	//edit cns_source_b2c_by_profile
	public static function edit_cns_b2c_by_profile($_customer_profile_)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$HASH = new \Hash();
		$_customer_profile_ = (Object) $_customer_profile_;
		$_filter_condition_ = " AND telephone = '{$_customer_profile_->telephone}' ";
		$_filter_condition_ = " AND email = '{$_customer_profile_->email}' ";

		$CNS_B2CTable->selectQuery("SELECT id, code, firstname, lastname, email, telephone, status FROM cns_b2c_customer WHERE status != 'DELETED' $_filter_condition_ ORDER BY id DESC LIMIT 1 ");
		if ($CNS_B2CTable->count()):
			//update the source info id he exist
			$id = $CNS_B2CTable->first()->id;

			$fields = array(
				'firstname' => $_customer_profile_->firstname,
				'lastname' => $_customer_profile_->lastname,
				'email' => $_customer_profile_->email,
				'telephone' => $_customer_profile_->telephone
			);

			$CNS_B2CTable->update($fields, $id);
			// return $CNS_B2CTable->first()->id;
		else:
			$register_b2c = self::create_2bc($_customer_profile_);
			if ($register_b2c->ERRORS == false):
				return $register_b2c->ID;
			endif;
		endif;
		return false;
	}


	//edit cns_destination_b2c_by_profile
	public static function edit_destination_cns_b2c_by_profile($_customer_profile_)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$HASH = new \Hash();
		$_customer_profile_ = (Object) $_customer_profile_;
		$_filter_condition_ = " AND telephone = '{$_customer_profile_->telephone}' ";

		$CNS_B2CTable->selectQuery("SELECT id, code, firstname, lastname, email, telephone, status FROM cns_b2c_customer WHERE status != 'DELETED' $_filter_condition_ ORDER BY id DESC LIMIT 1 ");
		if ($CNS_B2CTable->count()):
			//update the source info id he exist
			$id = $CNS_B2CTable->first()->id;
			$CNS_B2CTable->update($_customer_profile_, $id);
			// return $CNS_B2CTable->first()->id;
		else:
			$register_b2c = self::create_2bc($_customer_profile_);
			if ($register_b2c->ERRORS == false):
				return $register_b2c->ID;
			endif;
		endif;
		return false;
	}



	public static function get_cns_b2c_by_id($_customer_id_)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$HASH = new \Hash();
		$_filter_condition_ = " AND id = $_customer_id_ ";

		$CNS_B2CTable->selectQuery("SELECT id, code, firstname, lastname, email, telephone, address, status FROM cns_b2c_customer WHERE status != 'DELETED' $_filter_condition_ ORDER BY id DESC LIMIT 1 ");
		if ($CNS_B2CTable->count())
			return $CNS_B2CTable->first();
		return false;
	}

























	public static function getAccountSalt($email)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$CNS_B2CTable->selectQuery("SELECT salt FROM cns_b2c_customer WHERE email = '{$email}'  ORDER BY ID DESC");
		if ($CNS_B2CTable->count())
			return $CNS_B2CTable->first()->salt;
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

	public static function checkAccountExist($email, $password)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$CNS_B2CTable->selectQuery("SELECT id FROM cns_b2c_customer where email = '{$email}' AND password = '{$password}' ");
		if ($CNS_B2CTable->count())
			return true;
		return false;
	}

	public static function checkPlatformExist($code)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$CNS_B2CTable->selectQuery("SELECT id, status, name, code FROM cns_cluster_platform where code = ?", array($code));
		if ($CNS_B2CTable->count())
			return $CNS_B2CTable->first();
		return false;
	}

	public static function getAccountStatus($email)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$CNS_B2CTable->selectQuery("SELECT status FROM cns_b2c_customer where  email =  '{$email}' ");
		if ($CNS_B2CTable->count())
			return $CNS_B2CTable->first()->status;
		return false;
	}

	public static function getAccountData($email, $password)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$CNS_B2CTable->selectQuery("SELECT id, status, auth_generated_datetime, auth_expiration_datetime, auth_token, code as account_code FROM cns_b2c_customer WHERE email =? and password =?  ", array($email, $password));
		if ($CNS_B2CTable->count())
			return $CNS_B2CTable->first();
		return false;
	}

	public static function getAccountProfile($id)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$CNS_B2CTable->selectQuery("SELECT cns_b2c_customer.id as cticustomer, code, firstname, lastname, gender, email, email_validation, telephone FROM cns_b2c_customer  WHERE cns_b2c_customer.status != 'DELETED' AND cns_b2c_customer.id =? ORDER BY cns_b2c_customer.id DESC LIMIT 1", array($id));
		if ($CNS_B2CTable->count()):
			$HASH = new \Hash();
			$_DATA_ = array();
			foreach ($CNS_B2CTable->data() as $list_):
				$list_->ctacustomer = $HASH->encryptAES($list_->cticustomer);
				$list_->cticustomer = Hash::encryptToken($list_->cticustomer);

				$list_->join_date_value = $list_->join_date <= 0 ? '' : date('Y-m-d', $list_->join_date);
				$list_->join_date = $list_->join_date <= 0 ? '' : date('D d M, Y', $list_->join_date);
				$_DATA_ = (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getSessionAccountProfile($id)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$CNS_B2CTable->selectQuery("SELECT cns_b2c_customer.id as cticustomer, code, firstname, lastname, gender, email, email_validation, telephone FROM cns_b2c_customer  WHERE cns_b2c_customer.status != 'DELETED' AND cns_b2c_customer.id =? ORDER BY cns_b2c_customer.id DESC LIMIT 1", array($id));
		if ($CNS_B2CTable->count()):
			$HASH = new \Hash();
			$_DATA_ = array();
			foreach ($CNS_B2CTable->data() as $list_):
				$list_->ctacustomer = $HASH->encryptAES($list_->cticustomer);
				$list_->cticustomer = Hash::encryptToken($list_->cticustomer);
				$_DATA_ = (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getAccountB2BProfile($id)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$CNS_B2CTable->selectQuery("SELECT cns_b2c_customer.firstname, cns_b2c_customer.lastname, cns_b2c_customer.account_code, cns_cluster_account_b2b.company_name as corp_name, cns_cluster_account_b2b.account_code as corp_code, cns_cluster_account_b2b.company_logo, cns_b2c_customer.profile, cns_b2c_customer_type.code as user_type_code, cns_b2c_customer_type.name as user_type_name, cns_b2c_customer_type.description as user_type_description FROM cns_b2c_customer, cns_cluster_account_b2b, cns_b2c_customer_type WHERE cns_b2c_customer.cns_b2b = cns_cluster_account_b2b.id AND cns_b2c_customer_type.id = cns_b2c_customer.account_type  AND cns_b2c_customer.id = ? ORDER BY cns_b2c_customer.id DESC LIMIT 1;", array($id));
		if ($CNS_B2CTable->count())
			return $CNS_B2CTable->first();
		return false;
	}

	public static function checkToken($token)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$CNS_B2CTable->selectQuery("SELECT id, status, auth_generated_datetime, auth_expiration_datetime, auth_token, code as account_code, cns_platform, cns_platform_product FROM cns_b2c_customer where  auth_token = ? ", array($token));
		if ($CNS_B2CTable->count())
			return $CNS_B2CTable->first();
		return false;
	}

	public static function getAccountActiveSession($email)
	{
		$CNS_B2CTable = new \CNS_B2C();
		$CNS_B2CTable->selectQuery("SELECT auth_generated_datetime, auth_expiration_datetime, account_code FROM val_agent where  email = '{$email}' ");
		if ($CNS_B2CTable->count())
			return $CNS_B2CTable->first();
		return false;
	}

	public static function updateEntries($fields, $conditions)
	{
		$CNS_B2CTable = new \CNS_B2C();
		try {
			$CNS_B2CTable->updateMultiple($fields, $conditions);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}



}