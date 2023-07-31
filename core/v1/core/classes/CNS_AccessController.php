<?php
class CNS_AccessController
{

	public static function create_level($_access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'level-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'name' => array(
				'name' => 'Name',
				'required' => true
			),
			'platform' => array(
				'name' => 'Platform',
				'required' => true
			),
			'software' => array(
				'name' => 'Software',
				'required' => true
			),
		)
		);

		if ($validation->passed()) {
			$AccessTable = new \CNS_Access();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_cns_user = $_access_data->id;

			$_cns_platform = $HASH->decryptAES($Str->data_in($_SIGNUP->platform));
			$_cns_software = $HASH->decryptAES($Str->data_in($_SIGNUP->software));
			$_name = $Str->data_in(($_SIGNUP->name));

			if (self::checkIfExists("cns_access_level", "WHERE name = '$_name' ")):
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "This name already exists"
				];
			endif;

			$_adminID = $_cns_user;
			$_status = 'ACTIVE';
			$_code = self::generateCode('LEVEL');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,

				'code' => $_code,
				'name' => $_name,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccessTable->insert_level($_fields);
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
				'ERRORS_SCRIPT' => ""
			];
		}
	}

	public static function edit_level($_access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'level-';
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
			'platform' => array(
				'name' => 'Platform',
				'required' => true
			),
			'software' => array(
				'name' => 'Software',
				'required' => true
			),
		)
		);

		if ($validation->passed()) {
			$AccessTable = new \CNS_Access();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_cns_user = $_access_data->id;

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_cns_platform = $HASH->decryptAES($Str->data_in($_SIGNUP->platform));
			$_cns_software = $HASH->decryptAES($Str->data_in($_SIGNUP->software));
			$_name = $Str->data_in(($_SIGNUP->name));

			if (self::checkIfExists("cns_access_level", "WHERE name = '$_name' AND id != $_ID ")):
				return (object) [
					'ERRORS' => false,
					'SUCCESS' => true,
					'ERRORS_SCRIPT' => "This name already exists"
				];
			endif;

			$_adminID = $_cns_user;
			$_status = 'ACTIVE';
			$_code = self::generateCode('LEVEL');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'name' => $_name,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccessTable->update_level($_fields, $_ID);
				} catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
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
				'ERRORS_SCRIPT' => $validate->errors()
			];
		}
	}

	public static function change_status_level()
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
		)
		);

		if ($validation->passed()) {
			$AccessTable = new \CNS_Access();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_status = $Str->data_in($_SIGNUP->status);

			$_fields = array(
				'status' => $_status,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccessTable->update_level($_fields, $_ID);
				} catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
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
				'SUCCESS_SCRIPT' => $_success_response_,
				'ERRORS_SCRIPT' => $validate->errors()
			];
		}
	}
















	public static function create_task($_access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'task-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'name' => array(
				'name' => 'Name',
				'required' => true
			),
			'platform' => array(
				'name' => 'Platform',
				'required' => true
			),
			'software' => array(
				'name' => 'Software',
				'required' => true
			),
		)
		);

		if ($validation->passed()) {
			$AccessTable = new \CNS_Access();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_cns_user = $_access_data->id;

			$_cns_platform = $HASH->decryptAES($Str->data_in($_SIGNUP->platform));
			$_cns_software = $HASH->decryptAES($Str->data_in($_SIGNUP->software));
			$_name = self::clean_task( $Str->data_in(($_SIGNUP->name)) );
			$_description = $Str->data_in(($_SIGNUP->description));

			if (self::checkIfExists("cns_access_task", "WHERE name = '$_name' AND cns_platform = $_cns_platform AND cns_platform_product =   $_cns_software ")):
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "This name already exists"
				];
			endif;


			$_adminID = $_cns_user;
			$_status = 'ACTIVE';
			$_code = self::generateCode('TASK');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software ,

				'code' => $_code,
				'name' => $_name,
				'description' => $_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccessTable->insert_task($_fields);
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
				'ERRORS_SCRIPT' => ""
			];
		}
	}

	public static function edit_task($_access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'task-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'name' => array(
				'name' => 'Name',
				'required' => true
			),
			'platform' => array(
				'name' => 'Platform',
				'required' => true
			),
			'software' => array(
				'name' => 'Software',
				'required' => true
			),
		)
		);

		if ($validation->passed()) {
			$AccessTable = new \CNS_Access();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_cns_user = $_access_data->id;

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			
			$_cns_platform = $HASH->decryptAES($Str->data_in($_SIGNUP->platform));
			$_cns_software = $HASH->decryptAES($Str->data_in($_SIGNUP->software));
			$_name = self::clean_task( $Str->data_in(($_SIGNUP->name)) );
			$_description = $Str->data_in(($_SIGNUP->description));

			if (self::checkIfExists("cns_access_task", "WHERE name = '$_name' AND cns_platform = $_cns_platform AND cns_platform_product =   $_cns_software and id != $_ID ")):
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "This name already exists"
				];
			endif;


			$_adminID = $_cns_user;
			$_status = 'ACTIVE';

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software ,

				'name' => $_name,
				'description' => $_description,

			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccessTable->update_task($_fields, $_ID);
				} catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
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
				'ERRORS_SCRIPT' => $validate->errors()
			];
		}
	}

	public static function change_status_task()
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
		)
		);

		if ($validation->passed()) {
			$AccessTable = new \CNS_Access();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_status = $Str->data_in($_SIGNUP->status);

			$_fields = array(
				'status' => $_status,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccessTable->update_task($_fields, $_ID);
				} catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
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
				'SUCCESS_SCRIPT' => $_success_response_,
				'ERRORS_SCRIPT' => $validate->errors()
			];
		}
	}






























	public static function create_level_task($_access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'task-';
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
			'software' => array(
				'name' => 'Software',
				'required' => true
			),

			'level' => array(
				'name' => 'Level',
				'required' => true
			),
			'task' => array(
				'name' => 'Task',
				'required' => true
			),

			'package' => array(
				'name' => 'Package',
				'required' => true
			),
			'b2b' => array(
				'name' => 'Business',
				'required' => true
			),
		)
		);

		if ($validation->passed()) {
			$AccessTable = new \CNS_Access();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_cns_user = $_access_data->id;

			$_cns_platform = $HASH->decryptAES($Str->data_in($_SIGNUP->platform));
			$_cns_software = $HASH->decryptAES($Str->data_in($_SIGNUP->software));
			$_access_level = $HASH->decryptAES($Str->data_in($_SIGNUP->level));
			$_access_task = $HASH->decryptAES($Str->data_in($_SIGNUP->task));
			$_package = $HASH->decryptAES($Str->data_in($_SIGNUP->package));
			$_cns_b2b = $HASH->decryptAES($Str->data_in($_SIGNUP->b2b));

			if (self::checkIfExists("cns_access_level_task", "WHERE cns_platform = $_cns_platform AND cns_platform_product = $_cns_software and cns_platform_package = $_package and cns_b2b = $_cns_b2b and access_level = $_access_level and access_task = $_access_task ")):
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "This information already exists"
				];
			endif;

			$_adminID = $_cns_user;
			$_status = 'ACTIVE';
			$_code = self::generateCode('LEVEL_TASK');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_platform_package' => $_package,

				'cns_b2b' => $_cns_b2b,
				'access_level' => $_access_level,
				'access_task' => $_access_task,

				'code' => $_code,
				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccessTable->insert_level_task($_fields);
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
				'ERRORS_SCRIPT' => ""
			];
		}
	}

	public static function edit_level_task($_access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'task-';
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
			'software' => array(
				'name' => 'Software',
				'required' => true
			),

			'level' => array(
				'name' => 'Level',
				'required' => true
			),
			'task' => array(
				'name' => 'Task',
				'required' => true
			),

			'package' => array(
				'name' => 'Package',
				'required' => true
			),
			'b2b' => array(
				'name' => 'Business',
				'required' => true
			),
		)
		);

		if ($validation->passed()) {
			$AccessTable = new \CNS_Access();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_cns_user = $_access_data->id;

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			
			$_cns_platform = $HASH->decryptAES($Str->data_in($_SIGNUP->platform));
			$_cns_software = $HASH->decryptAES($Str->data_in($_SIGNUP->software));
			$_access_level = $HASH->decryptAES($Str->data_in($_SIGNUP->level));
			$_access_task = $HASH->decryptAES($Str->data_in($_SIGNUP->task));
			$_package = $HASH->decryptAES($Str->data_in($_SIGNUP->package));
			$_cns_b2b = $HASH->decryptAES($Str->data_in($_SIGNUP->b2b));

			if (self::checkIfExists("cns_access_level_task", "WHERE id = $_ID and cns_platform = $_cns_platform AND cns_platform_product = $_cns_software and cns_platform_package = $_package and cns_b2b = $_cns_b2b and access_level = $_access_level and access_task = $_access_task ")):
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "This information already exists"
				];
			endif;

			$_adminID = $_cns_user;
			$_status = 'ACTIVE';
			$_code = self::generateCode('LEVEL_TASK');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_platform_package' => $_package,

				'cns_b2b' => $_cns_b2b,
				'access_level' => $_access_level,
				'access_task' => $_access_task,

				'code' => $_code,
				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccessTable->update_level_task($_fields, $_ID);
				} catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
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
				'ERRORS_SCRIPT' => $validate->errors()
			];
		}
	}

	public static function change_status_level_task()
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
		)
		);

		if ($validation->passed()) {
			$AccessTable = new \CNS_Access();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_status = $Str->data_in($_SIGNUP->status);

			$_fields = array(
				'status' => $_status,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$AccessTable->update_level_task($_fields, $_ID);
				} catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
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
				'SUCCESS_SCRIPT' => $_success_response_,
				'ERRORS_SCRIPT' => $validate->errors()
			];
		}
	}















	public static function generateCode($TYPE = 'LEVEL')
	{
		if ($TYPE == 'LEVEL')
			return 'CNSAL.' . rand(10, 90) . date('s') . rand(20, 80);

		if ($TYPE == 'TASK')
			return 'CNSAT.' . rand(10, 90) . date('s') . rand(20, 80);

		if ($TYPE == 'LEVEL_TASK')
			return 'CNSALT.' . rand(10, 90) . date('s') . rand(20, 80);

		if ($TYPE == 'SOFTWARE_USER')
			return 'CNSASU.' . rand(10, 90) . date('s') . rand(20, 80);

	}

	public static function generateToken($STR)
	{
		$seconds = time();
		$token_hash = md5($seconds . sha1($STR));
		return $token_hash;
	}

	public static function getLastID($_table_ = "cns_cluster_platform")
	{
		$AccessTable = new \CNS_Access();
		$AccessTable->selectQuery("SELECT id FROM $_table_ ORDER BY id DESC LIMIT 1");
		if ($AccessTable->count())
			return $AccessTable->first()->id;
		return false;
	}

	public static function checkIfExists($_table_ = "cns_cluster_platform", $_condition_ = "")
	{
		$AccessTable = new \CNS_Access();
		$AccessTable->selectQuery("SELECT id FROM $_table_  $_condition_  ORDER BY id DESC LIMIT 1");
		if ($AccessTable->count())
			return true;
		return false;
	}











	public static function get_list_access_level($_filter_condition_ = "")
	{
		$CNSROOTAccessTable = new \CNS_Access();
		$HASH = new \Hash();
		$CNSROOTAccessTable->selectQuery("SELECT id AS token_id, cns_platform as ctiplatform, cns_platform_product as ctisoftware,  cns_platform_name as platform_name, cns_platform_product_name as software_name,  code, name, status, creation_datetime FROM cns_views_access_level WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccessTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccessTable->data() as $list_):

				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);

				$list_->ctaplatform = $HASH->encryptAES($list_->ctiplatform);
				$list_->ctiplatform = Hash::encryptToken($list_->ctiplatform);

				$list_->ctasoftware = $HASH->encryptAES($list_->ctisoftware);
				$list_->ctisoftware = Hash::encryptToken($list_->ctisoftware);

				$list_->creation_datetime = date("d/M/Y H:i:s", $list_->creation_datetime);
				$list_->platform_name = Str::clean($list_->platform_name);
				$list_->software_name = Str::clean($list_->software_name);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_access_level($ID)
	{
		$CNSROOTAccessTable = new \CNS_Access();
		$HASH = new \Hash();
		$CNSROOTAccessTable->selectQuery("SELECT id AS token_id, cns_platform as ctiplatform, cns_platform_product as ctisoftware,  code, cns_platform_name as platform_name, cns_platform_product_name as software_name,  name, status, creation_by, creation_datetime FROM cns_views_access_level WHERE status != 'DELETED' AND id = ? ORDER BY id DESC LIMIT 1", array($ID));
		if ($CNSROOTAccessTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccessTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->creation_datetime = date("d/M/Y H:i:s", $list_->creation_datetime);

				$list_->ctaplatform = $HASH->encryptAES($list_->ctiplatform);
				$list_->ctiplatform = Hash::encryptToken($list_->ctiplatform);

				$list_->ctasoftware = $HASH->encryptAES($list_->ctisoftware);
				$list_->ctisoftware = Hash::encryptToken($list_->ctisoftware);


				$list_->platform_name = Str::clean($list_->platform_name);
				$list_->software_name = Str::clean($list_->software_name);

				$_DATA_ = (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}









	public static function get_list_access_task($_filter_condition_ = "")
	{
		$CNSROOTAccessTable = new \CNS_Access();
		$HASH = new \Hash();
		$CNSROOTAccessTable->selectQuery("SELECT id AS token_id, cns_platform as ctiplatform, cns_platform_product as ctisoftware, cns_platform_name as platform_name, cns_platform_product_name as software_name, code, name, description, status, creation_datetime FROM cns_views_access_task WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccessTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccessTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->creation_datetime = date("d/M/Y H:i:s", $list_->creation_datetime);

				$list_->ctaplatform = $HASH->encryptAES($list_->ctiplatform);
				$list_->ctiplatform = Hash::encryptToken($list_->ctiplatform);

				$list_->ctasoftware = $HASH->encryptAES($list_->ctisoftware);
				$list_->ctisoftware = Hash::encryptToken($list_->ctisoftware);


				$list_->platform_name = Str::clean($list_->platform_name);
				$list_->software_name = Str::clean($list_->software_name);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_access_task($ID)
	{
		$CNSROOTAccessTable = new \CNS_Access();
		$HASH = new \Hash();
		$CNSROOTAccessTable->selectQuery("SELECT id AS token_id, cns_platform as ctiplatform, cns_platform_product as ctisoftware,   cns_platform_name as platform_name, cns_platform_product_name as software_name, code, name, description, status, creation_datetime FROM cns_views_access_task WHERE status != 'DELETED'  AND id = ? ORDER BY id DESC LIMIT 1", array($ID));
		if ($CNSROOTAccessTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccessTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->creation_datetime = date("d/M/Y H:i:s", $list_->creation_datetime);


				$list_->ctaplatform = $HASH->encryptAES($list_->ctiplatform);
				$list_->ctiplatform = Hash::encryptToken($list_->ctiplatform);

				$list_->ctasoftware = $HASH->encryptAES($list_->ctisoftware);
				$list_->ctisoftware = Hash::encryptToken($list_->ctisoftware);


				$list_->platform_name = Str::clean($list_->platform_name);
				$list_->software_name = Str::clean($list_->software_name);

				$_DATA_ = (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}















	public static function get_list_access_level_task($_filter_condition_ = "")
	{
		$CNSROOTAccessTable = new \CNS_Access();
		$HASH = new \Hash();
		$CNSROOTAccessTable->selectQuery("SELECT id AS token_id, code, b2b_name, status, cns_platform as ctiplatform, cns_platform_product as ctisoftware, cns_platform_package as ctipackage, cns_b2b as ctib2b, access_level as ctilevel, access_task as ctitask, creation_datetime, cns_platform_name as platform_name, cns_platform_product_name as software_name, level_name, task_name, cns_package_name as package_name, cns_package_price as package_price FROM cns_views_access_level_task WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTAccessTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccessTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->creation_datetime = date("d/M/Y H:i:s", $list_->creation_datetime);


				$list_->ctaplatform = $HASH->encryptAES($list_->ctiplatform);
				$list_->ctiplatform = Hash::encryptToken($list_->ctiplatform);

				$list_->ctasoftware = $HASH->encryptAES($list_->ctisoftware);
				$list_->ctisoftware = Hash::encryptToken($list_->ctisoftware);

				$list_->ctapackage = $HASH->encryptAES($list_->ctipackage);
				$list_->ctipackage = Hash::encryptToken($list_->ctipackage);

				$list_->ctab2b = $HASH->encryptAES($list_->ctib2b);
				$list_->ctib2b = Hash::encryptToken($list_->ctib2b);

				$list_->ctalevel = $HASH->encryptAES($list_->ctilevel);
				$list_->ctilevel = Hash::encryptToken($list_->ctilevel);

				$list_->ctatask = $HASH->encryptAES($list_->ctitask);
				$list_->ctitask = Hash::encryptToken($list_->ctitask);

				$list_->platform_name = Str::clean($list_->platform_name);
				$list_->software_name = Str::clean($list_->software_name);

				$list_->package_name = Str::clean($list_->package_name);
				$list_->package_price = Str::clean($list_->package_price);
				$list_->b2b_name = Str::clean($list_->b2b_name);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_access_level_task($ID)
	{
		$CNSROOTAccessTable = new \CNS_Access();
		$HASH = new \Hash();
		$CNSROOTAccessTable->selectQuery("SELECT id AS token_id,  cns_platform as ctiplatform, cns_platform_product as ctisoftware, cns_platform_package as ctipackage, cns_b2b as ctib2b,   code, b2b_name, creation_datetime, cns_platform_name as platform_name, cns_platform_product_name as software_name, level_name, task_name, cns_package_name as package_name, cns_package_price as package_price FROM cns_views_access_level_task WHERE status != 'DELETED' AND id = ? ORDER BY id DESC LIMIT 1", array($ID));
		if ($CNSROOTAccessTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTAccessTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->creation_datetime = date("d/M/Y H:i:s", $list_->creation_datetime);


				$list_->ctaplatform = $HASH->encryptAES($list_->ctiplatform);
				$list_->ctiplatform = Hash::encryptToken($list_->ctiplatform);

				$list_->ctasoftware = $HASH->encryptAES($list_->ctisoftware);
				$list_->ctisoftware = Hash::encryptToken($list_->ctisoftware);


				$list_->platform_name = Str::clean($list_->platform_name);
				$list_->software_name = Str::clean($list_->software_name);

				$list_->platform_name = Str::clean($list_->platform_name);
				$list_->software_name = Str::clean($list_->software_name);

				$list_->package_name = Str::clean($list_->package_name);
				$list_->package_price = Str::clean($list_->package_price);
				$list_->b2b_name = Str::clean($list_->b2b_name);

				$_DATA_ = (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function clean_task($_task){
		$_result = strtoupper( trim($_task) );
		$_result = str_replace(["     ", "    ", "  ", " "], "", $_result);
		$_result = str_replace(["'", ".", ",", ";", ":"], "",$_result);
		$_result = str_replace(["'", ".", ",", ";", ":", "?", "!", " ", "_", "/", "@", "(", ")"], "-",$_result);
		return $_result;
	}

}