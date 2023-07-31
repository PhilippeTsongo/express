<?php
class CNS_CLUSTER_DataController
{
	
	public static function create_data_store_category($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'data-';
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
		));

		if ($validation->passed()) {
			$ClusterDataTable = new \CNS_CLUSTER_Data();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;
			$HASH		  = new \Hash();

			$_cns_platform  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_b2b_type  = $HASH->decryptAES($Str->data_in(($_SIGNUP->b2b_type)));

			$_name  = $Str->data_in(($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($_SIGNUP->description);
			$_image  = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($_SIGNUP->image);
			$_icon  = !Input::checkInput($prfx."icon", "post", 1)?'':$Str->data_in($_SIGNUP->icon);
			
			$_adminID = $_cns_user;
			$_status  = 'ACTIVE';
			// $_code = self::generateCode('STORE_CATEGORY');

			$_code = trim( strtolower( $_name ) );
			$_code = str_replace(['  ', ' ', '\\', '/', '//', '&', '_', '#', '@', '!'], '', $_code);

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b_type' => $_cns_b2b_type,
				'code' => $_code,

				'name' => $_name,
				'description' => $_description,

				'icon' => $_icon,
				'image' => $_image,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ClusterDataTable->insert_store_category($_fields);

					/** NOTIFICATION */
					$_NOTIF_ = array(
						'notification-receiver' => $_adminID,
						'notification-receiver_type' => 'CNS_ADMIN',
						'notification-name' => 'Record of Store Category material success!',
						'notification-description' => 'You have recorded Successfully your Logistic material!'
					);
					CNS_CLUSTER_NotificationController::record_notification($_NOTIF_, 0, 0, $_adminID, 0);
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

	public static function edit_data_store_category($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'data-';
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
		));

		if ($validation->passed()) {
			$ClusterDataTable = new \CNS_CLUSTER_Data();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID  = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_cns_platform  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_b2b_type  = $HASH->decryptAES($Str->data_in(($_SIGNUP->b2b_type)));

			$_name  = $Str->data_in(($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($_SIGNUP->description);
			$_image  = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($_SIGNUP->image);
			$_icon  = !Input::checkInput($prfx."icon", "post", 1)?'':$Str->data_in($_SIGNUP->icon);
			
			$_adminID = $_cns_user;
			$_status  = 'ACTIVE';
			// $_code = self::generateCode('STORE_CATEGORY');

			$_code = trim( strtolower( $_name ) );
			$_code = str_replace(['  ', ' ', '\\', '/', '//', '&', '_', '#', '@', '!'], '', $_code);

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b_type' => $_cns_b2b_type,

				'code' => $_code,
				'name' => $_name,
				'description' => $_description,

				'icon' => $_icon,
				'image' => $_image,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ClusterDataTable->update_store_category($_fields, $_ID);
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


	public static function change_status_data_store_category($_cns_user)
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
			$ClusterDataTable = new \CNS_CLUSTER_Data();
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
					$ClusterDataTable->update_store_category($_fields, $_ID);

					/** Success Response */
					$_success_response_ = "Status has been successfully updated";
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


	public static function create_data_store_sub_category($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'data-';
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
		));

		if ($validation->passed()) {
			$ClusterDataTable = new \CNS_CLUSTER_Data();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;
			$HASH		  = new \Hash();

			$_cns_platform  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_b2b_type  = $HASH->decryptAES($Str->data_in(($_SIGNUP->b2b_type)));
			$_store_category  = $HASH->decryptAES($Str->data_in(($_SIGNUP->category)));

			$_name  = $Str->data_in(($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($_SIGNUP->description);
			$_image  = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($_SIGNUP->image);
			$_icon  = !Input::checkInput($prfx."icon", "post", 1)?'':$Str->data_in($_SIGNUP->icon);
			
			$_adminID = $_cns_user;
			$_status  = 'ACTIVE';
			// $_code = self::generateCode('STORE_SUB_CATEGORY');

			$_code = trim( strtolower( $_name ) );
			$_code = str_replace(['  ', ' ', '\\', '/', '//', '&', '_', '#', '@', '!'], '', $_code);

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b_type' => $_cns_b2b_type,
				'store_category' => $_store_category,
				'code' => $_code,

				'name' => $_name,
				'description' => $_description,

				'icon' => $_icon,
				'image' => $_image,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ClusterDataTable->insert_store_sub_category($_fields);

					/** NOTIFICATION */
					$_NOTIF_ = array(
						'notification-receiver' => $_adminID,
						'notification-receiver_type' => 'CNS_ADMIN',
						'notification-name' => 'Record of Store Sub Category material success!',
						'notification-description' => 'You have recorded Successfully the store category!'
					);
					CNS_CLUSTER_NotificationController::record_notification($_NOTIF_, 0, 0, $_adminID, 0);
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

	public static function edit_data_store_sub_category($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'data-';
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
		));

		if ($validation->passed()) {
			$ClusterDataTable = new \CNS_CLUSTER_Data();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID  = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_cns_platform  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_b2b_type  = $HASH->decryptAES($Str->data_in(($_SIGNUP->b2b_type)));
			$_store_category  = $HASH->decryptAES($Str->data_in(($_SIGNUP->category)));

			$_name  = $Str->data_in(($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($_SIGNUP->description);
			$_image  = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($_SIGNUP->image);
			$_icon  = !Input::checkInput($prfx."icon", "post", 1)?'':$Str->data_in($_SIGNUP->icon);
			
			$_adminID = $_cns_user;
			$_status  = 'ACTIVE';
			// $_code = self::generateCode('STORE_SUB_CATEGORY');

			$_code = trim( strtolower( $_name ) );
			$_code = str_replace(['  ', ' ', '\\', '/', '//', '&', '_', '#', '@', '!'], '', $_code);

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b_type' => $_cns_b2b_type,
				'store_category' => $_store_category,

				'code' => $_code,
				'name' => $_name,
				'description' => $_description,

				'icon' => $_icon,
				'image' => $_image,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ClusterDataTable->update_store_sub_category($_fields, $_ID);
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


	public static function change_status_data_store_sub_category($_cns_user)
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
			$ClusterDataTable = new \CNS_CLUSTER_Data();
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
					$ClusterDataTable->update_store_sub_category($_fields, $_ID);

					/** Success Response */
					$_success_response_ = "Status has been successfully updated";
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

	public static function create_data_store_collection($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'data-';
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
		));

		if ($validation->passed()) {
			$ClusterDataTable = new \CNS_CLUSTER_Data();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;
			$HASH		  = new \Hash();

			$_cns_platform  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_b2b_type  = $HASH->decryptAES($Str->data_in(($_SIGNUP->b2b_type)));
			$_store_category  = $HASH->decryptAES($Str->data_in(($_SIGNUP->category)));
			$_store_sub_category  = $HASH->decryptAES($Str->data_in(($_SIGNUP->sub_category)));

			$_name  = $Str->data_in(($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($_SIGNUP->description);
			$_image  = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($_SIGNUP->image);
			$_icon  = !Input::checkInput($prfx."icon", "post", 1)?'':$Str->data_in($_SIGNUP->icon);
			
			$_adminID = $_cns_user;
			$_status  = 'ACTIVE';
			$_code = self::generateCode('STORE_SUB_CATEGORY');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b_type' => $_cns_b2b_type,
				'store_category' => $_store_category,
				'store_sub_category' => $_store_sub_category,
				'code' => $_code,

				'name' => $_name,
				'description' => $_description,

				'icon' => $_icon,
				'image' => $_image,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ClusterDataTable->insert_store_collection($_fields);

					/** NOTIFICATION */
					$_NOTIF_ = array(
						'notification-receiver' => $_adminID,
						'notification-receiver_type' => 'CNS_ADMIN',
						'notification-name' => 'Record of Store Collections success!',
						'notification-description' => 'You have recorded Successfully the store collection!'
					);
					CNS_CLUSTER_NotificationController::record_notification($_NOTIF_, 0, 0, $_adminID, 0);
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

	public static function edit_data_store_collection($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'data-';
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
		));

		if ($validation->passed()) {
			$ClusterDataTable = new \CNS_CLUSTER_Data();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID  = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_cns_platform  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product  = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_b2b_type  = $HASH->decryptAES($Str->data_in(($_SIGNUP->b2b_type)));
			$_store_category  = $HASH->decryptAES($Str->data_in(($_SIGNUP->category)));
			$_store_sub_category  = $HASH->decryptAES($Str->data_in(($_SIGNUP->sub_category)));

			$_name  = $Str->data_in(($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($_SIGNUP->description);
			$_image  = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($_SIGNUP->image);
			$_icon  = !Input::checkInput($prfx."icon", "post", 1)?'':$Str->data_in($_SIGNUP->icon);
			
			$_adminID = $_cns_user;
			$_status  = 'ACTIVE';
			$_code = self::generateCode('STORE_SUB_CATEGORY');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b_type' => $_cns_b2b_type,
				'store_category' => $_store_category,
				'store_sub_category' => $_store_sub_category,

				'name' => $_name,
				'description' => $_description,

				'icon' => $_icon,
				'image' => $_image,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ClusterDataTable->update_store_collection($_fields, $_ID);
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


	public static function change_status_data_store_collection($_cns_user)
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
			$ClusterDataTable = new \CNS_CLUSTER_Data();
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
					$ClusterDataTable->update_store_collection($_fields, $_ID);

					/** Success Response */
					$_success_response_ = "Status has been successfully updated";
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

	public static function generateCode($TYPE = 'LOGISTIC')
	{
		if( $TYPE == 'STORE_CATEGORY' )
			return 'CNSSC.' . rand(10, 90) . date('s') . rand(10,99) . date('d');
		
		if( $TYPE == 'STORE_SUB_CATEGORY' )
			return 'CNSSBC.' . rand(10, 90) . date('s')  . rand(10,99) . date('d');

		if( $TYPE == 'STORE_COLLECTION' )
			return 'CNSSC.' . rand(10, 90) . date('s') . rand(10,99) . date('d');
		
		if( $TYPE == 'STORE_BRAND' )
			return 'CNSSBD.' . rand(10, 90) . date('s')  . rand(10,99) . date('d');
	}

	public static function generateToken($STR)
	{
		$seconds = time();
		$token_hash = md5($seconds . sha1($STR));
		return $token_hash;
	}

	public static function getLastID($table)
	{
		$ClusterDataTable = new \CNS_CLUSTER_Data();
		$ClusterDataTable->selectQuery("SELECT id FROM $table ORDER BY id DESC LIMIT 1");
		if ($ClusterDataTable->count())
			return $ClusterDataTable->first()->id;
		return false;
	}

	public static function checkIfExists($table, $_condition_ = "")
	{
		$ClusterDataTable = new \CNS_CLUSTER_Data();
		$ClusterDataTable->selectQuery("SELECT id FROM $table $_condition_  ORDER BY id DESC LIMIT 1");
		if ($ClusterDataTable->count())
			return true;
		return false;
	}

	public static function get_data_store_category_list($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b_type, code, name, description, icon, image, status FROM cns_data_store_category WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_store_category_by_ID($ID, $_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT  id as token_id, cns_platform, cns_platform_product, cns_b2b_type, code, name, description, icon, image, status FROM cns_data_store_category WHERE status != 'DELETED' AND id =? $_filter_condition_ ", array($ID));
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_ 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_store_category_list_options($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name FROM cns_data_store_category WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 					= (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_store_sub_category_list($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b_type, store_category, code, name, description, icon, image, status FROM cns_data_store_sub_category WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 					= (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_store_sub_category_by_ID($ID, $_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b_type, store_category, code, name, description, icon, image, status FROM cns_data_store_sub_category WHERE status != 'DELETED' AND id =? $_filter_condition_ ", array($ID));
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_ 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_store_sub_category_list_options($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name FROM cns_data_store_sub_category WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_store_collection_list($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b_type, store_category, store_sub_category, code, name, description, icon, image, status FROM cns_data_store_collection WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 					= (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_store_collection_by_ID($ID, $_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b_type, store_category, store_sub_category, code, name, description, icon, image, status FROM cns_data_store_collection WHERE status != 'DELETED' AND id =? $_filter_condition_ ", array($ID));
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_ 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_store_collection_list_options($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name FROM cns_data_store_collection WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 					= (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_country_list_options($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name, country_iso FROM cns_data_country WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 					= (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_city_list_options($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name FROM cns_data_city WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 					= (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}
	
	public static function get_data_province_list_options($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name FROM cns_data_province WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 					= (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}
	
	public static function get_data_currency_list_options($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name, description FROM cns_data_currency WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 					= (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	

	

}
