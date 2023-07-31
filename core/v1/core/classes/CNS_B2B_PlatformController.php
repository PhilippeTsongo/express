<?php
class CNS_B2B_PlatformController
{

	public static function create_platform_product($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'software-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'name' => array(
				'name' => 'Platform name',
				'string' => true,
				'required' => true
			),
		));

		if ($validation->passed()) {
			$PlatformTable = new \CNS_B2B_Platform();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_cns_platform = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_name  	   = $Str->data_in(($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($_SIGNUP->description);
		
			$_adminID = $_cns_user;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';
			$_code = self::generateCode('PLATFORM_PRODUCT');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				
				'code' => $_code,
				'name' => $_name,
				'description' => $_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$PlatformTable->insert_platform_product($_fields);
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

	public static function edit_platform_product($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'software-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'name' => array(
				'name' => 'Platform name',
				'string' => true,
				'required' => true
			),
		));

		if ($validation->passed()) {
			$PlatformTable = new \CNS_B2B_Platform();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_cns_platform = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));

			$_name  	 = $Str->data_in(($_SIGNUP->name));
			$_description= !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($_SIGNUP->description);
	
			$_adminID = $_cns_user;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';
			$_code = self::generateCode('PLATFORM_PRODUCT');

			$_fields = array(
				// 'cns_platform' => $_cns_platform,
				'name' 		=> $_name,
				'description' => $_description,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$PlatformTable->update_platform_product($_fields, $_ID);
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
	
	public static function change_status_platform_product()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'update-';
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
			$PlatformTable = new \CNS_B2B_Platform();
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
					$PlatformTable->update_platform_product($_fields, $_ID);

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


	public static function create_platform_package($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'package-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'name' => array(
				'name' => 'Platform name',
				'string' => true,
				'required' => true
			),
		));

		if ($validation->passed()) {
			$PlatformTable = new \CNS_B2B_Platform();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_cns_platform = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product = $HASH->decryptAES($Str->data_in(($_SIGNUP->software)));

			$_name  	 = $Str->data_in(($_SIGNUP->name));
			$_price  	 = $Str->data_in(($_SIGNUP->price));
			$_description= !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($_SIGNUP->description);
		
			$_adminID = $_cns_user;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';
			$_code = self::generateCode('PLATFORM_PACKAGE');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				
				'code' => $_code,
				'name' => $_name,
				'description' => $_description,
				'price' => $_price,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$PlatformTable->insert_platform_package($_fields);
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

	public static function edit_platform_package($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'package-';
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
			$PlatformTable = new \CNS_B2B_Platform();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_cns_platform = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product = $HASH->decryptAES($Str->data_in(($_SIGNUP->software)));

			$_name  	 = $Str->data_in(($_SIGNUP->name));
			$_price  	 = $Str->data_in(($_SIGNUP->price));
			$_description= !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($_SIGNUP->description);
		
			$_adminID = $_cns_user;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';
			$_code = self::generateCode('PLATFORM_PACKAGE');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				
				'name' => $_name,
				'description' => $_description,
				'price' => $_price,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$PlatformTable->update_platform_package($_fields, $_ID);
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
	
	public static function change_status_package()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'update-';
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
			$PlatformTable = new \CNS_B2B_Platform();
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
					$PlatformTable->update_platform_package($_fields, $_ID);

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


	public static function generateCode($TYPE = 'PLATFORM')
	{
		if( $TYPE == 'PLATFORM' )
			return 'CNSPTF.' . rand(10, 90) . date('s') .rand(20, 80) ;

		if( $TYPE == 'PLATFORM_PRODUCT' )
			return 'CNSPTFP.' . rand(10, 90) . date('s') .rand(20, 80) ;
		
		if( $TYPE == 'PLATFORM_PACKAGE' )
			return 'CNSPCK.' . rand(10, 90) . date('s') .rand(20, 80) ;

		if( $TYPE == 'PLATFORM_PRODUCT_SUBSCRIPTION' )
			return 'CNSPCKS.' . rand(10, 90) . date('s') .rand(20, 80) ;
		
	}

	public static function generateToken($STR)
	{
		$seconds = time();
		$token_hash = md5($seconds . sha1($STR));
		return $token_hash;
	}

	public static function getLastID($_table_ = "cns_cluster_platform")
	{
		$PlatformTable = new \CNS_B2B_Platform();
		$PlatformTable->selectQuery("SELECT id FROM $_table_ ORDER BY id DESC LIMIT 1");
		if ($PlatformTable->count())
			return $PlatformTable->first()->id;
		return false;
	}

	public static function checkIfExists($_table_ = "cns_cluster_platform", $_condition_ = "")
	{
		$PlatformTable = new \CNS_B2B_Platform();
		$PlatformTable->selectQuery("SELECT id FROM $_table_  $_condition_  ORDER BY id DESC LIMIT 1");
		if ($PlatformTable->count())
			return true;
		return false;
	}

	public static function getPlatforms($_filter_condition_ = ""){
        $CNSROOTPlatformTable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
        $CNSROOTPlatformTable->selectQuery("SELECT id as token_id, code, name, description, status FROM cns_cluster_platform WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPlatformTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTPlatformTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getPlatformByID($ID)
	{
		$CNSROOTPlatformTable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
        $CNSROOTPlatformTable->selectQuery("SELECT id as token_id, code,	name, description, status FROM cns_cluster_platform WHERE status != 'DELETED' AND id = ? ORDER BY id DESC LIMIT 1", array($ID));
		if ($CNSROOTPlatformTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTPlatformTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_ 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_platform_product($_filter_condition_ = ""){
        $CNSROOTPlatformTable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
        $CNSROOTPlatformTable->selectQuery("SELECT cns_cluster_platform_product.id as token_id, cns_cluster_platform.name AS cns_platform, cns_cluster_platform_product.code,	cns_cluster_platform_product.name, cns_cluster_platform_product.description, cns_cluster_platform_product.status FROM cns_cluster_platform_product, cns_cluster_platform  WHERE cns_cluster_platform.id =  cns_cluster_platform_product.cns_platform AND cns_cluster_platform_product.status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPlatformTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTPlatformTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_platform_product_by_ID($ID)
	{
		$CNSROOTPlatformTable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
        $CNSROOTPlatformTable->selectQuery("SELECT id as token_id, code, cns_platform,	name, description, status FROM cns_cluster_platform_product WHERE status != 'DELETED' AND id = ? ORDER BY id DESC LIMIT 1", array($ID));
		if ($CNSROOTPlatformTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTPlatformTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_  			 = (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_platform_product_package($_filter_condition_ = ""){
        $CNSROOTPlatformTable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
        $CNSROOTPlatformTable->selectQuery("SELECT cns_cluster_platform_package.id as token_id, cns_cluster_platform.name as cns_platform, cns_cluster_platform_product.name AS cns_platform_software, cns_cluster_platform_package.code,	cns_cluster_platform_package.name, cns_cluster_platform_package.description, cns_cluster_platform_package.price, cns_cluster_platform_package.status FROM cns_cluster_platform_package, cns_cluster_platform, cns_cluster_platform_product WHERE cns_cluster_platform.id = cns_cluster_platform_package.cns_platform AND cns_cluster_platform_product.id = cns_cluster_platform_package.cns_platform_product AND cns_cluster_platform_package.status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPlatformTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTPlatformTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$list_->package   	 = $list_->name .' - '. $list_->price . 'USD/ Month';
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_platform_product_package_by_ID($ID)
	{
		$CNSROOTPlatformTable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
        $CNSROOTPlatformTable->selectQuery("SELECT id as token_id, code, cns_platform,	name, description, price, status FROM cns_cluster_platform_package WHERE status != 'DELETED' AND id = ? ORDER BY id DESC LIMIT 1", array($ID));
		if ($CNSROOTPlatformTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTPlatformTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


}
