<?php
class CNS_STORE_ProductController
{
	public static function create_product_bulk($_cns_platform, $_cns_b2b, $_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'product-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
				
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			// 'name' => array(
			// 	'name' => 'Name',
			// 	'string' => true,
			// 	'required' => true
			// ),
			// 'unit' => array(
			// 	'name' => 'Unit',
			// 	'required' => true
			// ),
			// 'shelf' => array(
			// 	'name' => 'Shelf',
			// 	'required' => true
			// )
		));

		if ($validation->passed()) {
			$ProductTable = new \CNS_STORE_Product();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;
			$HASH		  = new \Hash();

			$_name_array_  = (array)(($_SIGNUP->name));
			$_unit_array_ = ($_SIGNUP->unit) ;
			$_shelf_array_ = ($_SIGNUP->shelf) ;
			$_category_array_ =   ($_SIGNUP->category) ;
			$_description_array_  = ($_SIGNUP->description);
			$_image  = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($Str->sanAsName($_SIGNUP->image));

			$_adminID = $_cns_user;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					/** Fetch Array */
					$_count_ = 0;
					foreach ($_name_array_ as $key => $value):
						if ($_name_array_[$key] && $_unit_array_[$key] && $_shelf_array_[$key] && $_category_array_[$key]):

							$_name  = $Str->data_in( $_name_array_[$key] );
							$_unit = $HASH->decryptAES( $_unit_array_[$key] );
							$_shelf = $HASH->decryptAES( $_shelf_array_[$key] );
							$_category = $HASH->decryptAES( $_category_array_[$key] == ""?0:$_category_array_[$key] );
							$_description  = $Str->data_in( $_description_array_[$key] );

							$_count_++;
							$_code = self::generateCode('PRODUCT');

							$_fields = array(
								'cns_platform' => $_cns_platform,
								'cns_b2b' => $_cns_b2b,
								'code' => $_code,

								'name' => $_name,
								'description' => $_description,

								'unit' => $_unit,
								'shelf' => $_shelf,

								'status' => $_status,
								'creation_by' => $_adminID,
								'creation_datetime' => Dates::seconds(),
							);
							$ProductTable->insert($_fields);
						endif;
					endforeach;
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

	public static function create_product($_cns_platform, $_cns_b2b, $_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'product-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'name' => array(
				'name' => 'Name',
				'string' => true,
				'required' => true
			),
			'unit' => array(
				'name' => 'Unit',
				'required' => true
			),
			'shelf' => array(
				'name' => 'Shelf',
				'required' => true
			)
		));

		if ($validation->passed()) {
			$ProductTable = new \CNS_STORE_Product();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;
			$HASH		  = new \Hash();

			$_name  = $Str->data_in(($_SIGNUP->name));
			$_unit = $HASH->decryptAES( $Str->data_in($_SIGNUP->unit) );
			$_shelf = $HASH->decryptAES( $Str->data_in($_SIGNUP->shelf) );
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($Str->sanAsName($_SIGNUP->description));
			$_image  = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($Str->sanAsName($_SIGNUP->image));

			$_adminID = $_cns_user;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';

			$_code = self::generateCode('PRODUCT');

			$_fields = array(

				'cns_platform' => $_cns_platform,
				'cns_b2b' => $_cns_b2b,
				'code' => $_code,

				'name' => $_name,
				'description' => $_description,

				'unit' => $_unit,
				'shelf' => $_shelf,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->insert($_fields);
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


	public static function edit_product($_cns_platform, $_cns_b2b, $_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'product-';
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
				'name' => 'Token',
				'required' => true
			),
			'name' => array(
				'name' => 'Name',
				'string' => true,
				'required' => true
			),
			'unit' => array(
				'name' => 'Unit',
				'required' => true
			),
			'shelf' => array(
				'name' => 'Shelf',
				'required' => true
			)
		));

		if ($validation->passed()) {
			$ProductTable = new \CNS_STORE_Product();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_name  = $Str->data_in(($_SIGNUP->name));
			$_unit = $HASH->decryptAES( $Str->data_in($_SIGNUP->unit) );
			$_shelf = $HASH->decryptAES( $Str->data_in($_SIGNUP->shelf) );
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($Str->sanAsName($_SIGNUP->description));
			$_image  = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($Str->sanAsName($_SIGNUP->image));

			$_adminID = $_cns_user;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';

			$_code = self::generateCode();

			$_fields = array(
				'name' => $_name,
				'description' => $_description,
				'unit' => $_unit,
				'shelf' => $_shelf,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->update($_fields, $_ID);
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


	public static function change_status_product($_cns_platform, $_cns_b2b, $_cns_user)
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
			$ProductTable = new \CNS_STORE_Product();
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
					$ProductTable->update($_fields, $_ID);

					/** Success Response */
					$_success_response_ = "Status has been successfully updated";

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

	public static function change_status_product_publish($_cns_platform, $_cns_b2b, $_cns_user)
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
			$ProductTable = new \CNS_STORE_Product();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_status = $Str->data_in($_SIGNUP->status);

			$_fields = array(
				'eshop_publish_datetime' => time(),
				'eshop_publish_status' => $_status,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->update($_fields, $_ID);

					/** Success Response */
					$_success_response_ = "Status has been successfully updated";

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


	public static function create_unit($_cns_platform, $_cns_b2b, $_cns_user)
	{   
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'unit-';
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
			$ProductTable = new \CNS_STORE_Product();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;

			$_name = ($Str->data_in($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($Str->sanAsName($_SIGNUP->description));
			// $_image = !Input::checkInput($prfx."unit_name", "post", 1)?'':$Str->data_in($_SIGNUP->email);

			$_adminID = $_cns_user;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';
			$_code    = self::generateCode('PRODUCT');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_b2b' => $_cns_b2b,
				'code' => $_code,
				'name' => $_name,
				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->insert_unit($_fields);
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

	public static function edit_unit($_cns_platform, $_cns_b2b, $_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'unit-';
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
				'name' => 'Name',
				'string' => true,
				'required' => true
			),
		));

		if ($validation->passed()) {
			$ProductTable = new \CNS_STORE_Product();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID  = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_name= $Str->data_in(($_SIGNUP->name));
			
			$_fields = array(
				'name' => $_name,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->update_unit($_fields, $_ID);
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


	public static function change_status_unit($_cns_platform, $_cns_b2b, $_cns_user)
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
			$ProductTable = new \CNS_STORE_Product();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_status = $Str->data_in($_SIGNUP->status);


			/** For Delete Unit */
			if($_status == 'DELETED'):
				if(self::checkIfExists("cns_store_product", "WHERE unit = $_ID "))
					return (object)[
						'ERRORS' => true,
						'SUCCESS' => false,
						'ERRORS_SCRIPT' => "This unit has already been used. You can not delete it!"
					];
			endif;

			$_fields = array(
				'status' => $_status,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->update_unit($_fields, $_ID);

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

	public static function create_category($_cns_platform, $_cns_b2b, $_cns_user)
	{   
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'category-';
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
			$ProductTable = new \CNS_STORE_Product();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;

			$_name = ($Str->data_in($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($Str->sanAsName($_SIGNUP->description));
			// $_image = !Input::checkInput($prfx."unit_name", "post", 1)?'':$Str->data_in($_SIGNUP->email);

			$_adminID = $_cns_user;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';
			$_code    = self::generateCode('PRODUCT');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_b2b' => $_cns_b2b,
				'code' => $_code,
				'name' => $_name,
				'description' => $_description,
				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->insert_category($_fields);
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

	public static function edit_category($_cns_platform, $_cns_b2b, $_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'category-';
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
				'name' => 'Name',
				'string' => true,
				'required' => true
			),
		));

		if ($validation->passed()) {
			$ProductTable = new \CNS_STORE_Product();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID  = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_name= $Str->data_in(($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($Str->sanAsName($_SIGNUP->description));
			
			$_fields = array(
				'name' => $_name,
				'description' => $_description,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->update_category($_fields, $_ID);
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


	public static function change_status_category($_cns_platform, $_cns_b2b, $_cns_user)
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
			$ProductTable = new \CNS_STORE_Product();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_status = $Str->data_in($_SIGNUP->status);

			/** For Delete Unit */
			if($_status == 'DELETED'):
				if(self::checkIfExists("cns_store_product", "WHERE category = $_ID "))
					return (object)[
						'ERRORS' => true,
						'SUCCESS' => false,
						'ERRORS_SCRIPT' => "This category has already been used. You can not delete it!"
					];
			endif;

			$_fields = array(
				'status' => $_status,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->update_category($_fields, $_ID);

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

	public static function create_shelf($_cns_platform, $_cns_b2b, $_cns_user)
	{   
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'shelf-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'name' => array(
				'name' => 'Account Type',
				'required' => true
			),
		));

		if ($validation->passed()) {
			$ProductTable = new \CNS_STORE_Product();
			$Str 		  = new \Str();
			$datetime     = \Config::get('time/date_time');
			$_SIGNUP      = (object)$_SIGNUP;

			$_name = $Str->data_in($_SIGNUP->name);
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($Str->sanAsName($_SIGNUP->description));
			$_image = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($_SIGNUP->image);

			$_adminID = $_cns_user;//Session::get(Config::get('session/admin'));
			$_status  = 'ACTIVE';
			$_code    = self::generateCode('SHELF');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_b2b' => $_cns_b2b,
				'code' => $_code,
				'name' => $_name,
				'description' => $_description,
				'image' => $_image,
				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->insert_shelf($_fields);
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

	public static function edit_shelf($_cns_platform, $_cns_b2b, $_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'shelf-';
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
				'name' => 'Name',
				'string' => true,
				'required' => true
			),
		));

		if ($validation->passed()) {
			$ProductTable = new \CNS_STORE_Product();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID  = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_name= $Str->data_in(($_SIGNUP->name));
			$_description  = !Input::checkInput($prfx."description", "post", 1)?'':$Str->data_in($Str->sanAsName($_SIGNUP->description));
			$_image = !Input::checkInput($prfx."image", "post", 1)?'':$Str->data_in($_SIGNUP->image);
			
			$_fields = array(
				'name' => $_name,
				'description' => $_description,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->update_shelf($_fields, $_ID);
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


	public static function change_status_shelf($_cns_platform, $_cns_b2b, $_cns_user)
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
			$ProductTable = new \CNS_STORE_Product();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object)$_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));
			$_status = $Str->data_in($_SIGNUP->status);

			/** For Delete Unit */
			if($_status == 'DELETED'):
				if(self::checkIfExists("cns_store_product", "WHERE category = $_ID "))
					return (object)[
						'ERRORS' => true,
						'SUCCESS' => false,
						'ERRORS_SCRIPT' => "This shelf has already been used. You can not delete it!"
					];
			endif;

			$_fields = array(
				'status' => $_status,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductTable->update_shelf($_fields, $_ID);

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

	public static function getAccountCount($_account_id, $_event_id)
	{
		$ProductTable = new \CNS_STORE_Product();
		$ProductTable->selectQuery("SELECT COUNT(app_users.id) as total_count FROM app_users WHERE app_users.status != 'DELETED' ORDER BY app_users.id DESC");
		if ($ProductTable->count())
			return $ProductTable->first()->total_count;
		return false;
	}

	public static function generateCode($TYPE = 'PRODUCT')
	{
		if( $TYPE == 'PRODUCT' )
			return 'CNSPPT.' . rand(10, 90) . date('s') . rand(100,999) . date('d');
		
		if( $TYPE == 'UNIT' )
			return 'CNSPPU.' . rand(10, 90) . date('s')  . rand(100,999) . date('d');
		
		if( $TYPE == 'SHELF' )
			return 'CNSPPS.' . rand(10, 90) . date('s')  . rand(100,999) . date('d');
	}

	public static function generateToken($STR)
	{
		$seconds = time();
		$token_hash = md5($seconds . sha1($STR));
		return $token_hash;
	}

	public static function getLastID($table)
	{
		$ProductTable = new \CNS_STORE_Product();
		$ProductTable->selectQuery("SELECT id FROM $table ORDER BY id DESC LIMIT 1");
		if ($ProductTable->count())
			return $ProductTable->first()->id;
		return false;
	}

	public static function checkIfExists($table, $_condition_ = "")
	{
		$ProductTable = new \CNS_STORE_Product();
		$ProductTable->selectQuery("SELECT id FROM $table $_condition_  ORDER BY id DESC LIMIT 1");
		if ($ProductTable->count())
			return true;
		return false;
	}

	public static function getProducts($_filter_condition_ = ""){
        $CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, cns_platform,	cns_b2b, code, name, description, unit, shelf, image, status, (SELECT name FROM cns_store_product_unit WHERE cns_store_product_unit.id = cns_store_product.unit ORDER BY id DESC LIMIT 1) as unit_name, (SELECT name FROM cns_store_product_shelf WHERE cns_store_product_shelf.id = cns_store_product.shelf ORDER BY id DESC LIMIT 1) as shelf_name FROM cns_store_product WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$list_->branch_name  = 'Branch 01';
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getProductsEshop($_filter_condition_ = ""){
        $CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, cns_platform,	cns_b2b, code, name, description, unit, shelf, image, eshop_publish_status as  status, eshop_publish_datetime as publish_datetime, (SELECT name FROM cns_store_product_unit WHERE cns_store_product_unit.id = cns_store_product.unit ORDER BY id DESC LIMIT 1) as unit_name, (SELECT name FROM cns_store_product_shelf WHERE cns_store_product_shelf.id = cns_store_product.shelf ORDER BY id DESC LIMIT 1) as shelf_name FROM cns_store_product WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$list_->branch_name  = 'Branch 01';
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getProductsEshopOrders($_filter_condition_ = ""){
        $CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, cns_platform,	cns_b2b, code,	total_items,	total_amount_due,	total_amount_paid,	payment_method,	status FROM cns_store_eshop_order WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getProductCategory($_filter_condition_ = ""){
        $CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, code, name, description, status FROM cns_store_product_category WHERE status != 'DELETED' $_filter_condition_  ORDER BY name ASC");
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getProductCategoryByID($ID){
        $CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, code, name, description, status FROM cns_store_product_category WHERE status != 'DELETED' AND id =?", array($ID));
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getProductByID($ID)
	{
		$CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, cns_platform,	cns_b2b, code, name, description, unit, shelf, image, status, (SELECT name FROM cns_store_product_unit WHERE cns_store_product_unit.id = cns_store_product.unit ORDER BY id DESC LIMIT 1) as unit_name, (SELECT name FROM cns_store_product_shelf WHERE cns_store_product_shelf.id = cns_store_product.shelf ORDER BY id DESC LIMIT 1) as shelf_name FROM cns_store_product WHERE status != 'DELETED' AND id =? ", array($ID));
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_ 			 = (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getProductByStockID($ID)
	{
		$CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT cns_store_product.id as token_id, cns_store_product.name  FROM cns_store_product, cns_store_stock WHERE cns_store_stock.product = cns_store_product.id AND cns_store_product.status != 'DELETED' AND cns_store_stock.id =? ", array($ID));
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_ 			 = (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getUnits($_filter_condition_ = ""){
        $CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, cns_platform,	cns_b2b, code, name, status FROM cns_store_product_unit WHERE status != 'DELETED' $_filter_condition_  ORDER BY name ASC");
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getUnitByID($ID){
        $CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, cns_platform,	cns_b2b, code, name, status FROM cns_store_product_unit WHERE status != 'DELETED' AND id =?", array($ID));
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	public static function getShelf($_filter_condition_ = ""){
        $CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, cns_platform,	cns_b2b, code, name, description,  status FROM cns_store_product_shelf WHERE status != 'DELETED' $_filter_condition_ ORDER BY name ASC");
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getShelfByID($ID){
        $CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, cns_platform,	cns_b2b, code, name, description, status FROM cns_store_product_shelf WHERE status != 'DELETED' AND id =? ", array($ID));
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getProductListOptions($_filter_condition_ = ""){
        $CNSROOTProductTable = new \CNS_STORE_Product();
		$HASH = new \Hash();
        $CNSROOTProductTable->selectQuery("SELECT id as token_id, name, (SELECT name FROM cns_store_product_unit WHERE cns_store_product_unit.id = cns_store_product.unit ORDER BY id DESC LIMIT 1) as unit_name, (SELECT name FROM cns_store_product_shelf WHERE cns_store_product_shelf.id = cns_store_product.shelf ORDER BY id DESC LIMIT 1) as shelf_name FROM cns_store_product WHERE status != 'DELETED' $_filter_condition_  ORDER BY name ASC");
		if ($CNSROOTProductTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTProductTable->data() As $list_ ):
				$list_->token_auth   = $HASH->encryptAES($list_->token_id);
				$list_->token_id   	 = Hash::encryptToken($list_->token_id);
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


}
