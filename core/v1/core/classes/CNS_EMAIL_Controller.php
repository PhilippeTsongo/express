<?php
class CNS_EMAIL_Controller
{

	#RECORD EMAIL CONTENT
	public static function record_email_content($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'email-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'platform' => array(
				'name' => 'Platform name',
				'string' => true,
				'required' => true
			),
			'platform_product' => array(
				'name' => 'Software name',
				'string' => true,
				'required' => true
			),
			'cns_b2b' => array(
				'name' => 'cns_b2b',
				'string' => true,
				'required' => true
			),
			'description' => array(
				'name' => 'Email Description',
				'string' => true,
				'required' => true
			),
			'subject' => array(
				'name' => 'Email Subject',
				'string' => true,
				'required' => true
			),
			'email_template' => array(
				'name' => 'Email Template',
				'string' => true,
				'required' => true
			)

		)
		);

		if ($validation->passed()) {
			$EmailContentTable = new \CNS_EMAIL();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_cns_platform = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_email_template = $HASH->decryptAES($Str->data_in(($_SIGNUP->email_template)));
			$_cns_b2b = $HASH->decryptAES($Str->data_in(($_SIGNUP->cns_b2b)));

			$_subject = $Str->data_in(($_SIGNUP->subject));
			$_description = $Str->data_in($_SIGNUP->description);

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';
			$_code = self::generateCode('EMAIL-CONTENT');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b' => $_cns_b2b,

				'code' => $_code,
				'email_template' => $_cns_email_template,
				'subject' => $_subject,
				'description' => $_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => $datetime
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$EmailContentTable->insert_email_content($_fields);
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

	#EDIT EMAIL CONTENT
	public static function edit_email_content($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'email-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'platform' => array(
				'name' => 'Platform name',
				'string' => true,
				'required' => true
			),
			'platform_product' => array(
				'name' => 'Platform product name',
				'string' => true,
				'required' => true
			),
			'cns_b2b' => array(
				'name' => 'cns_b2b',
				'string' => true,
				'required' => true
			),
			'description' => array(
				'name' => 'Email Description',
				'string' => true,
				'required' => true
			),
			'email_template' => array(
				'name' => 'Template',
				'string' => true,
				'required' => true
			),
			'subject' => array(
				'name' => 'Email Subject',
				'string' => true,
				'required' => true
			)
		)
		);

		if ($validation->passed()) {
			$EmailContentTable = new \CNS_EMAIL();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_cns_platform = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_email_template = $HASH->decryptAES($Str->data_in(($_SIGNUP->email_template)));
			$_cns_b2b = $HASH->decryptAES($Str->data_in(($_SIGNUP->cns_b2b)));

			$_subject = $Str->data_in(($_SIGNUP->subject));
			$_description = $Str->data_in($_SIGNUP->description);

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b' => $_cns_b2b,

				'subject' => $_subject,
				'email_template' => $_cns_email_template,
				'description' => $_description,

				'creation_by' => $_adminID,
				'creation_datetime' => $datetime
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$EmailContentTable->update_email_content($_fields, $_ID);
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

	#CHANGE STATUS EMAIL CONTENT
	public static function change_status_email_content()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'email-';
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
			$EmailContentTable = new \CNS_EMAIL();
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
					$EmailContentTable->change_status_email_content($_fields, $_ID);
					/** Success Response */
					$_success_response_ = "Email has been created successfully";
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

	#DELETE EMAIL CONTENT
	public static function delete_email_content($id)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'email-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'_id_' => array(
					'name' => 'email',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$EmailContentTable = new \CNS_EMAIL();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_email_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_email_data = self::getInfoEmailContentByID($_email_ID);
			if (!$_email_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_email_data = (Object) $_email_data;

			$_email_ID = $_email_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$EmailContentTable->delete_email_content($_email_ID);

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
				'ERRORS_SCRIPT' => "Error " . implode(', ', $diagnoArray)
			];
		} else {
			return (object) [
				'ERRORS' => false,
				'SUCCESS' => true,
				'ERRORS_SCRIPT' => ""
			];
		}
	}



	#RECORD EMAIL TEMPLATE
	public static function record_email_template($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'template-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'platform' => array(
				'name' => 'Platform name',
				'string' => true,
				'required' => true
			),
			'platform_product' => array(
				'name' => 'Software name',
				'string' => true,
				'required' => true
			),
			'cns_b2b' => array(
				'name' => 'cns_b2b',
				'string' => true,
				'required' => true
			),
			'description' => array(
				'name' => 'Email Description',
				'string' => true,
				'required' => true
			),
			'subject' => array(
				'name' => 'Email Subject',
				'string' => true,
				'required' => true
			),
			'name' => array(
				'name' => 'Template Name',
				'string' => true,
				'required' => true
			)

		)
		);

		if ($validation->passed()) {
			$EmailtemplateTable = new \CNS_EMAIL();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_cns_platform = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_b2b = $HASH->decryptAES($Str->data_in(($_SIGNUP->cns_b2b)));
			$_name = $HASH->decryptAES($Str->data_in(($_SIGNUP->name)));

			$_subject = $Str->data_in(($_SIGNUP->subject));
			$_description = $Str->data_in($_SIGNUP->description);

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';
			$_code = self::generateCode('EMAIL-TEMPLATE');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,
				'cns_b2b' => $_cns_b2b,

				'code' => $_code,
				'name' => $_name,
				'subject' => $_subject,
				'description' => $_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => $datetime
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$EmailtemplateTable->insert_email_template($_fields);
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

	#EDIT EMAIL TEMPLATE
	public static function edit_email_template($_cns_user)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'template-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check($_SIGNUP, array(
			'platform' => array(
				'name' => 'Platform name',
				'string' => true,
				'required' => true
			),
			'platform_product' => array(
				'name' => 'Software name',
				'string' => true,
				'required' => true
			),
			'cns_b2b' => array(
				'name' => 'CNS b2b',
				'string' => true,
				'required' => true
			),
			'description' => array(
				'name' => 'Email Description',
				'string' => true,
				'required' => true
			),
			'subject' => array(
				'name' => 'Email Subject',
				'string' => true,
				'required' => true
			)
		)
		);

		if ($validation->passed()) {
			$EmailTemplateTable = new \CNS_EMAIL();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_cns_platform = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform)));
			$_cns_platform_product = $HASH->decryptAES($Str->data_in(($_SIGNUP->platform_product)));
			$_cns_b2b = $HASH->decryptAES($Str->data_in(($_SIGNUP->cns_b2b)));
			$_name = $HASH->decryptAES($Str->data_in(($_SIGNUP->cns_b2b)));

			$_name = $Str->data_in(($_SIGNUP->name));
			$_subject = $Str->data_in(($_SIGNUP->subject));
			$_description = $Str->data_in($_SIGNUP->description);

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_platform_product,

				'subject' => $_subject,
				'name' => $_name,
				'description' => $_description,

				'creation_by' => $_adminID,
				'creation_datetime' => $datetime
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$EmailTemplateTable->update_email_template($_fields, $_ID);
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

	#CHANGE STATUS EMAIL TEMPLATE
	public static function change_status_email_template()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'template-';
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
			$EmailTemplateTable = new \CNS_EMAIL();
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
					$EmailTemplateTable->change_status_email_template($_fields, $_ID);
					/** Success Response */
					$_success_response_ = "Email status has been edited successfully";
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

	#DELETE EMAIL TEMPLATE
	public static function delete_email_template($id)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'template-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'_id_' => array(
					'name' => 'email',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$EmailTempalteTable = new \CNS_EMAIL();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_template_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_template_data = self::getInfoEmailContentByID($_template_ID);
			if (!$_template_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_template_data = (Object) $_template_data;

			$_template_ID = $_template_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$EmailTempalteTable->delete_email_template($_template_ID);

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
				'ERRORS_SCRIPT' => "Error " . implode(', ', $diagnoArray)
			];
		} else {
			return (object) [
				'ERRORS' => false,
				'SUCCESS' => true,
				'ERRORS_SCRIPT' => ""
			];
		}
	}

	public static function generateCode($TYPE = 'PLATFORM')
	{
		if ($TYPE == 'EMAIL-CONTENT')
			return 'CNSMAIL.' . rand(10, 90) . date('s') . rand(20, 80);

		if ($TYPE == 'EMAIL-TEMPLATE')
			return 'CNSEMAIL.' . rand(10, 90) . date('s') . rand(20, 80);
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

	#EMAIL CONTENT LIST
	public static function getEmailContents($_filter_condition_ = "")
	{
		$CNSROOTEmailContentable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
		$CNSROOTEmailContentable->selectQuery("SELECT id as token_id, code, subject, description, (SELECT name FROM cns_email_templates WHERE cns_email_templates.id = cns_emails_content.email_template ORDER BY id DESC LIMIT 1) as email_template, (SELECT company_name FROM cns_cluster_account_b2b WHERE cns_cluster_account_b2b.id = cns_emails_content.cns_b2b ORDER BY id DESC LIMIT 1) as b2b_email_content, (SELECT name FROM cns_cluster_platform WHERE cns_cluster_platform.id = cns_emails_content.cns_platform ORDER BY id DESC LIMIT 1) as platform_email_content, (SELECT name FROM cns_cluster_platform_product WHERE cns_cluster_platform_product.id = cns_emails_content.cns_platform_product ORDER BY id DESC LIMIT 1) as software_email_content, status FROM cns_emails_content WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTEmailContentable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTEmailContentable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	#EMAIL CONTENT DATA
	public static function getInfoEmailContent($code)
	{
		$CNSROOTEmailContentable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
		$CNSROOTEmailContentable->selectQuery("SELECT id, code, subject, status FROM cns_emails_content WHERE status = 'ACTIVE' AND code = ? ORDER BY id DESC LIMIT 1", array($code));
		if ($CNSROOTEmailContentable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTEmailContentable->data() as $list_):
				$_DATA_ = (Object) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	#EMAIL CONTENT DATA
	public static function getInfoEmailContentByID($ID)
	{
		$CNSROOTEmailContentable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
		$CNSROOTEmailContentable->selectQuery("SELECT id as token_id, code, subject, description, (SELECT name FROM cns_email_templates WHERE cns_email_templates.id = cns_emails_content.email_template ORDER BY id DESC LIMIT 1) as email_template, (SELECT company_name FROM cns_cluster_account_b2b WHERE cns_cluster_account_b2b.id = cns_emails_content.cns_b2b ORDER BY id DESC LIMIT 1) as b2b_email_content, (SELECT name FROM cns_cluster_platform WHERE cns_cluster_platform.id = cns_emails_content.cns_platform ORDER BY id DESC LIMIT 1) as platform_email_content, (SELECT name FROM cns_cluster_platform_product WHERE cns_cluster_platform_product.id = cns_emails_content.cns_platform_product ORDER BY id DESC LIMIT 1) as software_email_content, status FROM cns_emails_content WHERE status != 'DELETED' AND id = ? ORDER BY id DESC LIMIT 1", array($ID));
		if ($CNSROOTEmailContentable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTEmailContentable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_ = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	#EMAIL TEMPLATE LIST
	public static function getEmailTemplates($_filter_condition_ = "")
	{
		$CNSROOTEmailContentable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
		$CNSROOTEmailContentable->selectQuery("SELECT id as token_id, code, name, subject, description, (SELECT company_name FROM cns_cluster_account_b2b WHERE cns_cluster_account_b2b.id = cns_email_templates.cns_b2b ORDER BY id DESC LIMIT 1) as b2b_email_template, (SELECT name FROM cns_cluster_platform WHERE cns_cluster_platform.id = cns_email_templates.cns_platform ORDER BY id DESC LIMIT 1) as platform_email_template, (SELECT name FROM cns_cluster_platform_product WHERE cns_cluster_platform_product.id = cns_email_templates.cns_platform_product ORDER BY id DESC LIMIT 1) as software_email_content, status FROM cns_email_templates WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTEmailContentable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTEmailContentable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	#EMAIL TEMPLATE DATA
	public static function getInfoEmailTemplateByID($ID)
	{
		$CNSROOTEmailContentable = new \CNS_B2B_Platform();
		$HASH = new \Hash();
		$CNSROOTEmailContentable->selectQuery("SELECT id as token_id, code, name, subject, description, (SELECT company_name FROM cns_cluster_account_b2b WHERE cns_cluster_account_b2b.id = cns_email_templates.cns_b2b ORDER BY id DESC LIMIT 1) as b2b_email_template, (SELECT name FROM cns_cluster_platform WHERE cns_cluster_platform.id = cns_email_templates.cns_platform ORDER BY id DESC LIMIT 1) as platform_email_template, (SELECT name FROM cns_cluster_platform_product WHERE cns_cluster_platform_product.id = cns_email_templates.cns_platform_product ORDER BY id DESC LIMIT 1) as software_email_content, status FROM cns_email_templates WHERE status != 'DELETED' AND id = ? ORDER BY id DESC LIMIT 1", array($ID));
		if ($CNSROOTEmailContentable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTEmailContentable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_ = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


}