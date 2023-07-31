<?php
class CNS_B2B_AccountController
{
	public static function create()
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
				'name' => 'Account Type',
				'required' => true
			),
			'name' => array(
				'name' => 'Company name',
				'string' => true,
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
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			$_cns_platform = Hash::decryptToken($Str->data_in($_SIGNUP->cns_platform));
			$_cns_platform_product = Hash::decryptToken($Str->data_in($_SIGNUP->cns_platform_product));

			$_type = Hash::decryptToken($Str->data_in($_SIGNUP->type));
			$_name = $Str->data_in($Str->sanAsName($_SIGNUP->name));
			$_email = $Str->data_in($_SIGNUP->email);
			$_telephone = $Str->data_in($_SIGNUP->telephone);

			$_IDCode_ = self::getLastID() + 1 + 1000;
			$_short_name = !Input::checkInput($prfx.'short_name', 'post', 1)?$_IDCode_: $Str->data_in($Str->sanAsName($_SIGNUP->short_name));

			$_email_public = !Input::checkInput($prfx.'email_public', 'post', 1)?'': $Str->data_in($_SIGNUP->email_public);
			$_telephone_public = !Input::checkInput($prfx.'telephone_public', 'post', 1)?'': $Str->data_in($_SIGNUP->telephone_public);

			/** Password Handler */
			$_salt = Hash::salt(32);
			$_generate_password = Hash::randomPassword(8);
			$_password = Hash::make($_generate_password, $_salt);

			$account_type = 1;

			$_adminID = 1; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$account_code = self::generateCode();

			$_fields = array(

				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'account_code' => $account_code,
				'account_type' => $account_type,

				'company_short_name' => $_short_name,
				'company_name' => $_name,
				'company_email' => $_email,
				'company_telephone' => $_telephone,

				'company_email_public' => $_email_public,
				'company_telephone_public' => $_telephone_public,

				'country' => 1,
				'province' => 1,
				'city' => 1,
				'address' => 1,

				'password' => $_password,
				'salt' => $_salt,
				'pin' => 1,
				'status' => $_status,

				// 'auth_token' => '',
				// 'auth_generated_datetime' => 0,
				// 'auth_exipration_datetime' => 0,

				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),

				// 'update_by' => $access_token,
				// 'update_datetime' => $token_generated_date
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->insert($_fields);

					$_cns_b2b = self::getLastID();
					$_code = self::generateCode('BRANCH');

					/** Create Default Branch 1 */
					$_fields = array(
						'cns_platform' => $_cns_platform,
						'cns_platform_product' => $_cns_platform_product,
						'cns_b2b' => $_cns_b2b,

						'code' => $_code,
						'name' => 'Branch 01',
						'description' => 'Branch 01 for ' . $_name,

						'country' => 1,
						'province' => 1,
						'city' => 1,
						'address' => '',

						'status' => $_status,
						'creation_by' => $_adminID,
						'creation_datetime' => Dates::seconds(),
					);
					$AccountTable->insert_branch($_fields);
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

	public static function edit_b2b_basic_information($_cns_b2b)
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
			// 'type' => array(
			// 	'name' => 'Account Type',
			// 	'required' => true
			// ),
			'short_name' => array(
				'name' => 'Company Short Name',
				'string' => true,
				'required' => true
			),
			'name' => array(
				'name' => 'Company name',
				'string' => true,
				'required' => true
			),
			// 'email' => array(
			// 	'name' => 'Company Email',
			// 	'email' => true,
			// 	'required' => true
			// ),
			// 'telephone' => array(
			// 	'name' => 'Telephone',
			// 	'required' => true
			// ),
			// 'currency' => array(
			// 	'name' => 'Currency',
			// 	'email' => true,
			// 	'required' => true
			// ),
			// 'language' => array(
			// 	'name' => 'Language',
			// 	'required' => true
			// )
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			$HASH = new \Hash();

			$_ID = $_cns_b2b;

			$_name = $Str->data_in($Str->sanAsName($_SIGNUP->name));
			$_email = $Str->data_in($_SIGNUP->email);
			$_telephone = $Str->data_in($_SIGNUP->telephone);

			$_curency = $HASH->decryptAES($Str->data_in($_SIGNUP->currency));
			$_language = ($Str->data_in($_SIGNUP->language));

			$_IDCode_ = self::getLastID() + 1 + 1000;
			$_short_name = !Input::checkInput($prfx.'short_name', 'post', 1)?$_IDCode_: strtolower($Str->data_in($Str->sanAsName($_SIGNUP->short_name)));

			$_email_public = !Input::checkInput($prfx.'email_public', 'post', 1)?$_IDCode_: $Str->data_in($_SIGNUP->email_public);
			$_telephone_public = !Input::checkInput($prfx.'telephone_public', 'post', 1)?$_IDCode_: $Str->data_in($_SIGNUP->telephone_public);

			/** Password Handler */
			$_salt = Hash::salt(32);
			$_generate_password = Hash::randomPassword(8);
			$_password = Hash::make($_generate_password, $_salt);

			$account_type = 1;

			$_adminID = 1; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			// $account_code = self::generateCode();

			$_fields = array(

				'company_code' => $_short_name,
				'company_name' => $_name,
				'company_email' => $_email,
				'company_telephone' => $_telephone,

				'company_email_public' => $_email_public,
				'company_telephone_public' => $_telephone_public,

				'language' => $_language,
				'currency' => $_curency,
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

	public static function edit_b2b_social_media_information($_cns_b2b)
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
			$AccountTable = new \CNS_B2B_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			$HASH = new \Hash();

			$_ID = $_cns_b2b;

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


	public static function b2b_sign_up_onboard($_cns_platform_, $_user_password)
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
			// 'platform' => array(
			// 	'name' => 'Platform ',
			// 	'required' => true
			// ),
			'software' => array(
				'name' => 'Platform software',
				'required' => true
			),
			'company_short_name' => array(
				'name' => 'Company short name',
				'string' => true,
				'required' => true
			),
			'company_name' => array(
				'name' => 'Company name',
				'string' => true,
				'required' => true
			),
			'company_email' => array(
				'name' => 'Company Email',
				'email' => true,
				'required' => true
			),
			'company_telephone' => array(
				'name' => 'Telephone',
				'required' => true
			)
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_cns_platform = $_cns_platform_; //$HASH->decryptAES($Str->data_in($_SIGNUP->platform));
			$_cns_platform_product = $HASH->decryptAES($Str->data_in($_SIGNUP->software));

			$_company_code = $Str->data_in($_SIGNUP->company_short_name);
			$_company_name = $Str->data_in(($_SIGNUP->company_name));
			$_company_email = $Str->data_in($_SIGNUP->company_email);
			$_company_telephone = $Str->data_in($_SIGNUP->company_telephone);

			$_currency = $HASH->decryptAES($Str->data_in($_SIGNUP->currency));
			$_language = $HASH->decryptAES($Str->data_in($_SIGNUP->language));

			if( $_language == 1)
				$_language = "fr-lang";
			else if($_language == 2)
				$_language = "eng-lang";
			else	
				$_language = "fr-lang";
				
			$_user_email = $Str->data_in($_SIGNUP->user_email);

			/** Get Plaftorm */
			$_software_data_ = CNS_B2B_PlatformController::get_platform_product_by_ID($_cns_platform_product);
			if(!$_software_data_ )
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid platform info"
				];
			$_software_data_  = (object) $_software_data_ ;
			/** Check If Exists */
			if( self::checkIfExists("cns_cluster_account_b2b", "WHERE company_code = '$_company_code' OR company_email = '$_company_email'  OR company_name = '$_company_name' ") ):
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "This Company already exists. Use a different name or email!"
				];
			endif;

			/** Check If Exists */
			if( self::checkIfExists("cns_cluster_account_b2b_users", "WHERE email = '$_user_email' ") ):
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "This User already exists. Use a different name or email!"
				];
			endif;

			$_form_password = !Input::checkInput($prfx . "password", "post", 1)?"":$Str->data_in($_SIGNUP->password);
			$_form_repassword = !Input::checkInput($prfx . "repassword", "post", 1)?"":$Str->data_in($_SIGNUP->repassword);

			/** Validate Password */
			if( strlen($_form_password) < 6 ):
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Your password is not strong! Use minimum 6 caracters - ".$_form_password
				];

			elseif( $_form_password != $_form_repassword ):
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Password don't match"
				];
			
			endif;

			/** Password Handler */
			$_salt = Hash::salt(32);
			$_generate_password = Hash::randomPassword(8);
			$_password = Hash::make($_generate_password, $_salt);

			$account_type = 1;

			$_adminID = 1; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$account_code = self::generateCode();

			$_fields = array(

				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'account_code' => $account_code,
				'account_type' => $account_type,

				'company_code' => $account_code,
				'company_name' => $_company_name,
				'company_email' => $_company_email,
				'company_telephone' => $_company_telephone,

				'country' => $_currency,
				'province' => 0,
				'city' => 0,
				'address' => '',

				'password' => $_password,
				'salt' => $_salt,
				'pin' => 1,
				'status' => $_status,

				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),

			);

	
			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->insert($_fields);

					$_cns_b2b = self::getLastID();
					$_code = self::generateCode('BRANCH');

					/** Create Default Branch 1 */
					$_fields = array(
						'cns_platform' => $_cns_platform,
						'cns_platform_product' => $_cns_platform_product,
						'cns_b2b' => $_cns_b2b,

						'code' => $_code,
						'name' => 'Branch 01',
						'description' => 'Branch 01 - ' . $_company_name,

						'country' => 1,
						'province' => 1,
						'city' => 1,
						'address' => '',

						'status' => $_status,
						'creation_by' => $_adminID,
						'creation_datetime' => Dates::seconds(),
					);
					$AccountTable->insert_branch($_fields);

					/** Register B2B Administrator */
					$_firstname = $Str->data_in($_SIGNUP->user_firstname);
					$_lastname = $Str->data_in($_SIGNUP->user_lastname);
					$_email = $Str->data_in($_SIGNUP->user_email);
					$_telephone = $Str->data_in($_SIGNUP->user_telephone);

					/** Password Handler */
					$_salt = Hash::salt(32);
					$_generate_password = ($_form_password); //Hash::randomPassword(8);
					$_password = Hash::make($_generate_password, $_salt);

					$account_type = 1;

					$_adminID = 0; //Session::get(Config::get('session/admin'));
					$_status = 'ACTIVE';

					$account_code = CNS_B2B_USERS_AccountController::generateCode();

					$_fields = array(
						'cns_platform' => $_cns_platform,
						'cns_platform_product' => $_cns_platform_product,
						'cns_b2b' => $_cns_b2b,
						'account_code' => $account_code,
						'account_type' => $account_type,

						'firstname' => $_firstname,
						'lastname' => $_lastname,

						'email' => $_email,
						'telephone' => $_telephone,

						'profile' => '',

						'language' => 'ENG',
						'default_password' => $_form_password,

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
						'creation_datetime' => Dates::seconds()
					);
 					$AccountTable = new \CNS_B2B_USERS_Account();
					$AccountTable->insert($_fields);

					/** User ID */
					$_user_ID =  CNS_B2B_USERS_AccountController::getLastID('cns_cluster_account_b2b_users');
					$TOKENAUTH = Hash::encryptAuthToken($_user_ID);

					/** NOTIFICATION */
					$_NOTIF_ = array(
						'notification-receiver' => $_user_ID,
						'notification-receiver_type' => 'B2B_USER',
						'notification-name' => 'Creation of B2B Account success!',
						'notification-description' => 'Your Business Account Created Successfully! Welcome to CNS Platform!'
					);
					CNS_CLUSTER_NotificationController::record_notification($_NOTIF_, $_cns_platform, $_cns_b2b, $_adminID, $_cns_platform_product);

					/** Send Email */
					$_data_ = array(
						'email' => $_email,
						'firstname' => $_firstname,
						'platform_name' => $_software_data_->name
					);

					/** STORE */
					// if( $_cns_platform == 1 )
					// 	EmailController::sendEmailToStoreUserB2bOnRegister($_data_);
					// if( $_cns_platform == 2 )
					// 	EmailController::sendEmailToTontineUserB2bOnRegister($_data_);
					// if( $_cns_platform == 3 )
					// 	EmailController::sendEmailToEventUserB2bOnRegister($_data_);

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
				'ERRORS_SCRIPT' => "" . implode(', ', $diagnoArray)
			];
		}
		else {
			return (object)[
				'ERRORS' => false,
				'SUCCESS' => true,
				'ERRORS_SCRIPT' => "",
				'TOKENAUTH' => $TOKENAUTH
			];
		}
	}

	public static function create_branch($_cns_platform, $_cns_b2b, $_cns_user, $_cns_platform_product)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'branch-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'name' => array(
				'name' => 'Branch name',
				'string' => true,
				'required' => true
			),
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_name = $Str->data_in(($_SIGNUP->name));
			$_description = !Input::checkInput($prfx . "description", "post", 1) ? '' : $Str->data_in($_SIGNUP->description);
			$_country = !Input::checkInput($prfx . "country", "post", 1) ? 1 : $HASH->decryptAES($Str->data_in($_SIGNUP->country));
			$_province = !Input::checkInput($prfx . "province", "post", 1) ? 1 : $HASH->decryptAES($Str->data_in($_SIGNUP->province));
			$_city = Input::checkInput($prfx . "city", "post", 1) ? 1 : $HASH->decryptAES($Str->data_in($_SIGNUP->city));
			$_address = $Str->data_in($_SIGNUP->address);

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';
			$_code = self::generateCode('BRANCH');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b' => $_cns_b2b,

				'code' => $_code,
				'name' => $_name,
				'description' => $_description,

				'country' => $_country,
				'province' => $_province,
				'city' => $_city,
				'address' => $_address,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->insert_branch($_fields);

					/** NOTIFICATION */
					$_NOTIF_ = array(
						'notification-receiver' => $_adminID,
						'notification-receiver_type' => 'B2B_USER',
						'notification-name' => 'Creation of B2B Branch!',
						'notification-description' => "You created Business Branch $_name  Successfully!"
					);
					$_notification_ = CNS_CLUSTER_NotificationController::record_notification($_NOTIF_, $_cns_platform, $_cns_b2b, 0, $_cns_platform_product);
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

	public static function record_subscription($_cns_platform, $_cns_b2b, $_cns_user, $_cns_platform_product)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'subscription-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'platform' => array(
				'name' => 'Platform',
				'required' => true
			),
			'b2b' => array(
				'name' => 'B2B',
				'required' => true
			),
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_cns_platform = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_platform_package = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_package)));
			$_cns_b2b = $HASH->decryptAES($Str->data_in(($_SIGNUP->b2b)));

			/** Get Package By ID */
			$_cns_platform_package_data_ = CNS_B2B_PlatformController::get_platform_product_package_by_ID($_cns_platform_package);
			if (!$_cns_platform_package_data_)
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Errors occured. Invalid Package"
				];
			$_cns_platform_package_data_ = (object) $_cns_platform_package_data_ ;

			$_paid_amount = $Str->data_in($_SIGNUP->paid_amount);
			$_duration_month = $Str->data_in($_SIGNUP->duration_month);

			$_transaction_ref = $Str->data_in($_SIGNUP->transaction_ref);
			$_transaction_status = "PENDING";

			$_cns_agent = 0;
			$_approved_by = 1; // CNS Root Admin

			$_start_datetime = Dates::today();
			$_end_datetime = Dates::date_calculation_from_today(" + $_duration_month month ");

			$_name = $_cns_platform_package_data_->name;
			$_description = $_cns_platform_package_data_->description;
			$_package_amount = $_cns_platform_package_data_->price;

			if ($_paid_amount < 0)
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Errors occured. Invalid Paid Amount"
				];

			if ($_paid_amount < $_package_amount)
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Errors occured. Invalid Paid Amount!"
				];

			$_city = Input::checkInput($prfx . "city", "post", 1) ? 1 : $Str->data_in($_SIGNUP->city);
			$_address = $Str->data_in($_SIGNUP->address);

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';
			$_code = self::generateCode('BRANCH');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_platform_package' => $_cns_platform_package,
				'cns_b2b' => $_cns_b2b,

				'code' => $_code,
				'name' => $_name,
				'description' => $_description,

				'package_amount' => $_package_amount,
				'paid_amount' => $_paid_amount,
				'duration_month' => $_duration_month,
				'start_datetime' => $_start_datetime,
				'end_datetime' => $_end_datetime,
				'transaction_ref' => $_transaction_ref,
				'transaction_status' => $_transaction_status,
				'cns_agent' => $_cns_agent,
				'approved_by' => $_approved_by,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->insert_subscription($_fields);
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


	public static function edit()
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
			// // 'type' => array(
			// // 	'name' => 'Account Type',
			// // 	'string' => true,
			// // 	'required' => true
			// ),
			'name' => array(
				'name' => 'Company name',
				'string' => true,
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
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_name = $Str->data_in($Str->sanAsName($_SIGNUP->name));
			$_email = $Str->data_in($_SIGNUP->email);
			$_telephone = $Str->data_in($_SIGNUP->telephone);

			/** Password Handler */
			$_salt = Hash::salt(32);
			$_generate_password = Hash::randomPassword(8);
			$_password = Hash::make($_generate_password, $_salt);

			$_fields = array(

				'company_name' => $_name,
				'company_email' => $_email,
				'company_telephone' => $_telephone,
				// 'country' => 1,
				// 'province' => 1,
				// 'city' => 1,
				// 'address' => 1,
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


	public static function edit_branch($_cns_platform, $_cns_b2b, $_cns_user, $_cns_platform_product)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'branch-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		global $session_user_data;
		global $session_company_data;

		$validation = $validate->check($_SIGNUP, array(
			'name' => array(
				'name' => 'Branch name',
				'string' => true,
				'required' => true
			),
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_name = $Str->data_in(($_SIGNUP->name));
			$_description = !Input::checkInput($prfx . "description", "post", 1) ? '' : $Str->data_in($_SIGNUP->description);
			$_country = !Input::checkInput($prfx . "country", "post", 1) ? 1 : $HASH->decryptAES($Str->data_in($_SIGNUP->country));
			$_province = !Input::checkInput($prfx . "province", "post", 1) ? 1 : $HASH->decryptAES($Str->data_in($_SIGNUP->province));
			$_city = Input::checkInput($prfx . "city", "post", 1) ? 1 : $HASH->decryptAES($Str->data_in($_SIGNUP->city));
			$_address = $Str->data_in($_SIGNUP->address);

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';
			$_code = self::generateCode('BRANCH');

			$_fields = array(
				'name' => $_name,
				'description' => $_description,

				'country' => $_country,
				'province' => $_province,
				'city' => $_city,
				'address' => $_address,

			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->update_brach($_fields, $_ID);
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

	public static function edit_subscription($_cns_platform, $_cns_b2b, $_cns_user, $_cns_platform_product)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'subscription-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'platform' => array(
				'name' => 'Platform',
				'required' => true
			),
			'b2b' => array(
				'name' => 'B2B',
				'required' => true
			),
		));

		if ($validation->passed()) {
			$AccountTable = new \CNS_B2B_Account();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_cns_platform = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_platform_package = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_package)));
			$_cns_b2b = $HASH->decryptAES($Str->data_in(($_SIGNUP->b2b)));

			/** Get Package By ID */
			$_cns_platform_package_data_ = (object)CNS_B2B_PlatformController::get_platform_product_package_by_ID($_cns_platform_package);
			if (!$_cns_platform_package_data_)
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Errors occured. Invalid Package"
				];
			$_cns_platform_package_data_ = (object)$_cns_platform_package_data_;

			$_paid_amount = $Str->data_in($_SIGNUP->paid_amount);
			$_duration_month = $Str->data_in($_SIGNUP->duration_month);

			$_transaction_ref = $Str->data_in($_SIGNUP->transaction_ref);
			$_transaction_status = "PENDING";

			$_cns_agent = 0;
			$_approved_by = 1; // CNS Root Admin

			$_start_datetime = Dates::today();
			$_end_datetime = Dates::date_calculation_from_today(" + $_duration_month month ");

			$_name = $_cns_platform_package_data_->name;
			$_description = $_cns_platform_package_data_->description;
			$_package_amount = $_cns_platform_package_data_->price;

			if ($_paid_amount < 0)
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Errors occured. Invalid Paid Amount"
				];

			if ($_paid_amount < $_package_amount)
				return (object)[
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Errors occured. Invalid Paid Amount!"
				];

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';
			$_code = self::generateCode('BRANCH');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_platform_package' => $_cns_platform_package,
				'cns_b2b' => $_cns_b2b,

				'name' => $_name,
				'description' => $_description,

				'package_amount' => $_package_amount,
				'paid_amount' => $_paid_amount,
				'duration_month' => $_duration_month,
				'start_datetime' => $_start_datetime,
				'end_datetime' => $_end_datetime,
				'transaction_ref' => $_transaction_ref,
				'transaction_status' => $_transaction_status,
				'cns_agent' => $_cns_agent,
				'approved_by' => $_approved_by,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccountTable->update_subscription($_fields, $_ID);
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
			$AccountTable = new \CNS_B2B_Account();
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

	public static function change_status_branch()
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
			$AccountTable = new \CNS_B2B_Account();
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
					$AccountTable->update_brach($_fields, $_ID);

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

	public static function change_status_subscription()
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
			$AccountTable = new \CNS_B2B_Account();
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
					$AccountTable->update_subscription($_fields, $_ID);

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
			$AccountTable = new \CNS_B2B_Account();
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
			$AccountTable = new \CNS_B2B_Account();
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
	// 	$AccountTable = new \CNS_B2B_Account();
	// 	$AccountTable->selectQuery("SELECT * FROM `cns_cluster_account_b2b`");
	// 	if ($AccountTable->count())
	// 		return $AccountTable->data();
	// 	return false;
	// }

	public static function getAccountCount($_account_id, $_event_id)
	{
		$AccountTable = new \CNS_B2B_Account();
		$AccountTable->selectQuery("SELECT COUNT(app_users.id) as total_count FROM app_users WHERE app_users.status != 'DELETED' ORDER BY app_users.id DESC");
		if ($AccountTable->count())
			return $AccountTable->first()->total_count;
		return false;
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

	public static function getLastID($_table_ = 'cns_cluster_account_b2b')
	{
		$AccountTable = new \CNS_B2B_Account();
		$AccountTable->selectQuery("SELECT id FROM $_table_ ORDER BY id DESC LIMIT 1");
		if ($AccountTable->count())
			return $AccountTable->first()->id;
		return false;
	}

	public static function checkIfExists($table = "app_users", $_condition_ = "")
	{
		$AccountTable = new \CNS_B2B_Account();
		$AccountTable->selectQuery("SELECT id FROM $table $_condition_  ORDER BY id DESC LIMIT 1");
		if ($AccountTable->count())
			return true;
		return false;
	}

	public static function getAccounts($_filter_condition_ = "")
	{
		$CNSROOTAccountTable = new \CNS_B2B_Account();
		$HASH = new \Hash();
		$CNSROOTAccountTable->selectQuery("SELECT id as token_id, cns_platform,	account_code, account_type,	company_name, company_email, company_telephone,  company_email_public, company_telephone_public,	country, province, city, address, status FROM cns_cluster_account_b2b WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccountTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccountTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (array)$list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getAccountsOptions($_filter_condition_ = "")
	{
		$CNSROOTAccountTable = new \CNS_B2B_Account();
		$HASH = new \Hash();
		$CNSROOTAccountTable->selectQuery("SELECT id as token_id, company_name FROM cns_cluster_account_b2b WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccountTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccountTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (array)$list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getBranches($_filter_condition_ = "")
	{
		$CNSROOTAccountTable = new \CNS_B2B_Account();
		$HASH = new \Hash();
		$CNSROOTAccountTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product,	code, name,	description,	country, province, city, address, status FROM cns_cluster_account_b2b WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccountTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccountTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (array)$list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getAccountTypes($_filter_condition_ = "")
	{
		$CNSROOTAccountTable = new \CNS_B2B_Account();
		$HASH = new \Hash();
		$CNSROOTAccountTable->selectQuery("SELECT id as token_id, code, name, description, status FROM cns_cluster_account_b2b_type WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccountTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccountTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (array)$list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getAccountByID($ID)
	{
		$CNSROOTAccountTable = new \CNS_B2B_Account();
		$HASH = new \Hash();
		$CNSROOTAccountTable->selectQuery("SELECT id as token_id, cns_platform, account_code, account_type, company_code as company_short_code, company_name, company_email, company_telephone, company_email_public, company_telephone_public, country, province, city, address, status, facebook, instagram, tweeter, youtube, whatsapp, snapchat, tiktok, linkedin, language, currency, (SELECT description FROM cns_data_currency where id = cns_cluster_account_b2b.currency) as currency_name, (SELECT name FROM cns_data_country where id = cns_cluster_account_b2b.country) as country_name, (SELECT name FROM cns_data_province where id = cns_cluster_account_b2b.province) as province_name, (SELECT name FROM cns_data_city where id = cns_cluster_account_b2b.city) as city_name FROM cns_cluster_account_b2b WHERE id = ? ORDER BY id DESC LIMIT 1", array($ID));
		if ($CNSROOTAccountTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccountTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);

				$list_->currency = $HASH->encryptAES($list_->currency);
				$list_->country = $HASH->encryptAES($list_->country);
				$list_->province = $HASH->encryptAES($list_->province);
				$list_->city = $HASH->encryptAES($list_->city);

				$list_->website_url = 'http://shop.cnsplateforme.com/'.$list_->company_short_code;
				$_DATA_ = (array)$list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_b2b_branch_list($_filter_condition_ = "")
	{
		$CNSROOTAccountTable = new \CNS_B2B_Account();
		$HASH = new \Hash();
		$CNSROOTAccountTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product,	code, name,	description,	country, province, city, address, status FROM cns_cluster_account_b2b_branch WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccountTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccountTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (array)$list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_b2b_branch_list_options($_filter_condition_ = "")
	{
		$CNSROOTAccountTable = new \CNS_B2B_Account();
		$HASH = new \Hash();
		$CNSROOTAccountTable->selectQuery("SELECT id as token_id, name FROM cns_cluster_account_b2b_branch WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccountTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccountTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (array)$list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


}
