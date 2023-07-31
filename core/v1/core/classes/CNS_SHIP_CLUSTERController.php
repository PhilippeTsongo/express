<?php
class CNS_SHIP_CLUSTERController
{

#PARTNERS
public static function contact_message($access_data)
{
	$diagnoArray[0] = 'NO_ERRORS';
	$validate = new \Validate();
	$prfx = 'message-';
	foreach ($_POST as $index => $val):
		$ar = explode($prfx, $index);
		if (count($ar)):
			$_SIGNUP[end($ar)] = $val;
		endif;
	endforeach;

	$validation = $validate->check(
		$_SIGNUP,
		array(
			'sender_name' => array(
				'sender_name' => 'sender_name',
				'required' => true
			),
			'sender_email' => array(
				'sender_email' => 'sender_email',
				'required' => true
			),
			'subject' => array(
				'subject' => 'subject',
				'required' => true
			),
			'description' => array(
				'description' => 'description',
				'required' => true
			),
		)
	);

	if ($validation->passed()) {
		$MessageTable = new \CNS_SHIP_CLUSTER();
		$Str = new \Str();
		$datetime = \Config::get('time/date_time');
		$_SIGNUP = (object) $_SIGNUP;
		$HASH = new \Hash();

		$_name = $Str->data_in($_SIGNUP->sender_name);
		$_email = $Str->data_in($_SIGNUP->sender_email);
		$_subject = $Str->data_in($_SIGNUP->subject);
		$_description = $Str->data_in($_SIGNUP->description);

		$_cns_platform = $access_data->cns_platform;
		$_cns_b2b = $access_data->cns_b2b;

		$_status = 'ACTIVE';

		$_fields = array(

			'name' => $_name,
			'email' => $_email,
			'subject' => $_subject,
			'description' => $_description,

			'cns_platform' => $_cns_platform,
			'cns_b2b' => $_cns_b2b,

			'status' => $_status,
			'creation_datetime' => Dates::seconds(),
		);

		if ($diagnoArray[0] == 'NO_ERRORS') {
			try {
				$MessageTable->send_message($_fields);
				$_DATA_ = array(
					'firstname' => $_name,
					'email' => 'afriexpressglobal@aol.com',
					'emailsubject' => $_subject,
					'description' => $_description,
				);
				CNS_EMAIL::send('CNSEMAIL.00008',  $_DATA_);

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


	#PARTNERS
	public static function record_partner($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'partner-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				),
				'website' => array(
					'name' => 'website',
					'required' => false
				),
				'telephone' => array(
					'name' => 'telephone',
					'required' => true
				),
				'email' => array(
					'name' => 'email',
					'required' => true
				),
				'address' => array(
					'name' => 'address',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$PartnerTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_name = $Str->data_in($_SIGNUP->name);
			$_email = $Str->data_in($_SIGNUP->email);
			$_website = $Str->data_in($_SIGNUP->website);
			$_address = $Str->data_in($_SIGNUP->address);
			$_telephone = $Str->data_in($_SIGNUP->telephone);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_code_partner = self::generateCode('PARTNER');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,
				'code' => $_code_partner,

				'name' => $_name,
				'email' => $_email,
				'website' => $_website,
				'address' => $_address,
				'telephone' => $_telephone,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$PartnerTable->insert_partner($_fields);

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

	public static function edit_partner($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'partner-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				),
				'website' => array(
					'name' => 'website',
					'required' => false
				),
				'telephone' => array(
					'name' => 'telephone',
					'required' => true
				),
				'email' => array(
					'name' => 'email',
					'required' => true
				),
				'address' => array(
					'name' => 'address',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipPartner = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_name = $Str->data_in($_SIGNUP->name);
			$_email = $Str->data_in($_SIGNUP->email);
			$_website = $Str->data_in($_SIGNUP->website);
			$_address = $Str->data_in($_SIGNUP->address);
			$_telephone = $Str->data_in($_SIGNUP->telephone);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'name' => $_name,
				'email' => $_email,
				'website' => $_website,
				'address' => $_address,
				'telephone' => $_telephone,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipPartner->update_partner($_fields, $_ID);
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

	public static function delete_partner($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'partner-';
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
					'name' => 'partner',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipPartner = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_partner_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_partner_data = self::getInfoPartnerByID($_partner_ID);
			if (!$_partner_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_partner_data = (Object) $_partner_data;

			$_partner_ID = $_partner_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipPartner->delete_partner($_partner_ID);

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

	public static function change_status_partner()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'partner-';
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
			$ShipPartnerTable = new \CNS_SHIP_CLUSTER();
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
					$ShipPartnerTable->change_status_partner($_fields, $_ID);
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

	public static function getPartners($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, code, name, website, telephone, email, address, status, creation_by, creation_datetime FROM cns_express_partners WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->code = $list_->code;
				$list_->name = $list_->name;
				$list_->website = $list_->website;
				$list_->telephone = $list_->telephone;
				$list_->email = $list_->email;
				$list_->address = $list_->address;
				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoPartnerByID($ID)
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery(" SELECT id, cns_platform, cns_platform_product, cns_b2b, code, name, website, telephone, email, address, status, creation_by, creation_datetime FROM cns_express_partners WHERE id = ?", array($ID));
		if ($CNSROOTPartnerTable->count()):
			return $CNSROOTPartnerTable->first();
		endif;
		return false;
	}


	#DELIVERY AGENT
	public static function record_delivery_agent($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'delivery-agent-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'firstname' => array(
					'name' => 'first name',
					'required' => true
				),
				'lastname' => array(
					'name' => 'last name',
					'required' => true
				),
				'telephone' => array(
					'name' => 'telephone',
					'required' => true
				),
				'email' => array(
					'name' => 'email',
					'required' => true
				),
				'address' => array(
					'name' => 'address',
					'required' => true
				),
				'identity_number' => array(
					'name' => 'Identity Number',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$DeliveryTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_firstname = $Str->data_in($_SIGNUP->firstname);
			$_lastname = $Str->data_in($_SIGNUP->lastname);
			$_email = $Str->data_in($_SIGNUP->email);
			$_address = $Str->data_in($_SIGNUP->address);
			$_telephone = $Str->data_in($_SIGNUP->telephone);
			$_identity_number = $Str->data_in($_SIGNUP->identity_number);

			/** Password Handler */
			$_salt 			    = Hash::salt(32);
			$_generate_password = Hash::randomPassword(8);
			$_password 			= Hash::make($_generate_password, $_salt);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_code_delivery_agent = self::generateCode('DELIVERY-AGENT');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,
				'code' => $_code_delivery_agent,
				'firstname' => $_firstname,
				'lastname' => $_lastname,
				'email' => $_email,
				'identity_number' => $_identity_number,
				'address' => $_address,
				'telephone' => $_telephone,

				'salt' => $_salt,
				'default_password' => $_generate_password,
				'password' => $_password,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$DeliveryTable->insert_delivery_agent($_fields);
					/** Send Email To New Agent */
					/** EMAIL */
					$_DATA_ = array(
						'firstname' => $_firstname,
						'email' => $_email,
						'password' => $_generate_password, 
						// 'b2b' => $_cns_b2bname,
						'link' => "#",

					);
					CNS_EMAIL::send('CNSEMAIL.00007',  $_DATA_);

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

	public static function edit_delivery_agent($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'delivery-agent-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'firstname' => array(
					'name' => 'first name',
					'required' => true
				),
				'lastname' => array(
					'name' => 'last name',
					'required' => true
				),
				'telephone' => array(
					'name' => 'telephone',
					'required' => true
				),
				'email' => array(
					'name' => 'email',
					'required' => true
				),
				'address' => array(
					'name' => 'address',
					'required' => true
				),
				'identity_number' => array(
					'name' => 'Identity Number',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$DeliveryAgentTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_firstname = $Str->data_in($_SIGNUP->firstname);
			$_lastname = $Str->data_in($_SIGNUP->lastname);
			$_email = $Str->data_in($_SIGNUP->email);
			$_address = $Str->data_in($_SIGNUP->address);
			$_telephone = $Str->data_in($_SIGNUP->telephone);
			$_identity_number = $Str->data_in($_SIGNUP->identity_number);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'firstname' => $_firstname,
				'lastname' => $_lastname,
				'email' => $_email,
				'identity_number' => $_identity_number,
				'address' => $_address,
				'telephone' => $_telephone,

			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$DeliveryAgentTable->update_delivery_agent($_fields, $_ID);
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

	public static function delete_delivery_agent($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'delivery-agent-';
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
					'name' => 'Delivery Agent',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$DeliveryAgent = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_delivery_agent_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_delivery_agent_data = self::getInfoDeliveryAgentByID($_delivery_agent_ID);
			if (!$_delivery_agent_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_delivery_agent_data = (Object) $_delivery_agent_data;
			
			// var_dump($_delivery_agent_data);

			$_agent_ID = $_delivery_agent_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$DeliveryAgent->delete_delivery_agent($_agent_ID);

				} catch (Exception $e) {
					$diagnoArray[0] = "ERRORS_FOUND";
					$diagnoArray[] = $e->getMessage();
				}
			}
		}else {
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

	public static function change_status_delivery_agent()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'delivery-agent-';
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
			$DeliveryAgentTable = new \CNS_SHIP_CLUSTER();
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
					$DeliveryAgentTable->change_status_delivery_agent($_fields, $_ID);
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

	public static function getDeliveryAgents($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, code, firstname, lastname, telephone, email, address, identity_number, status, creation_by, creation_datetime FROM cns_express_delivery_agent WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoDeliveryAgentByID($ID)
	{
		$CNSROOTDeliveryAgentTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTDeliveryAgentTable->selectQuery("SELECT id, cns_platform, cns_platform_product, cns_b2b, code, firstname, lastname, telephone, email, address, identity_number, status, creation_by, creation_datetime FROM cns_express_delivery_agent WHERE id = ?", array($ID));
		if ($CNSROOTDeliveryAgentTable->count()):
			return $CNSROOTDeliveryAgentTable->first();
		endif;
		return false;
	}


	#Customer
	public static function getCustomers($_filter_condition_ = "")
	{
		$CNSROOTShipCustomerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipCustomerTable->selectQuery("SELECT id as token_id, cns_b2b, code, firstname, lastname, telephone, email, (SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_b2c_customer.country ORDER BY id LIMIT 1) as country, (SELECT name FROM cns_data_province WHERE cns_data_province.id = cns_b2c_customer.province ORDER BY id LIMIT 1) as province, (SELECT name FROM cns_data_city WHERE cns_data_city.id = cns_b2c_customer.city ORDER BY id LIMIT 1) as city, status, creation_by, creation_datetime FROM cns_b2c_customer WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTShipCustomerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTShipCustomerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);

				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}






	#ITEM TYPE
	public static function record_item_type($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'item-type-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				),
				'description' => array(
					'name' => 'description',
					'required' => false
				)
			)
		);

		if ($validation->passed()) {
			$ItemTypeTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_name = $Str->data_in($_SIGNUP->name);
			$_description = $Str->data_in($_SIGNUP->description);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_code_item_type = self::generateCode('ITEM-TYPE');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,
				'code' => $_code_item_type,

				'name' => $_name,
				'description' => $_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ItemTypeTable->insert_item_type($_fields);

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

	public static function edit_item_type($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'item-type-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				),
				'description' => array(
					'name' => 'description',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ItemType = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_name = $Str->data_in($_SIGNUP->name);
			$_description = $Str->data_in($_SIGNUP->description);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'name' => $_name,
				'description' => $_description,

				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ItemType->update_item_type($_fields, $_ID);
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

	public static function delete_item_type($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'item-type-';
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
					'name' => 'Item Type',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ItemType = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_item_type_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_item_type_data = self::getInfoItemTypeByID($_item_type_ID);
			if (!$_item_type_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_item_type_data = (Object) $_item_type_data;

			$_item_type_ID = $_item_type_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ItemType->delete_item_type($_item_type_ID);

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

	public static function change_status_item_type()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'item-type-';
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
			$ItemTypeTable = new \CNS_SHIP_CLUSTER();
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
					$ItemTypeTable->change_status_item_type($_fields, $_ID);
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

	public static function getItemTypes($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, code, name, description, status, creation_by, creation_datetime FROM cns_express_item_type WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->code = $list_->code;
				$list_->name = $list_->name;
				$list_->description = $list_->description;

				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoItemTypeByID($ID)
	{
		$CNSROOTItemTypeTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTItemTypeTable->selectQuery(" SELECT id, cns_platform, cns_platform_product, cns_b2b, code, name, description, status, creation_by, creation_datetime FROM cns_express_item_type WHERE id = ?", array($ID));
		if ($CNSROOTItemTypeTable->count()):
			return $CNSROOTItemTypeTable->first();
		endif;
		return false;
	}


	#PACKAGE TYPE
	public static function record_package_type($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'package-type-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				),
				'description' => array(
					'name' => 'description',
					'required' => false
				)
			)
		);

		if ($validation->passed()) {
			$PackageTypeTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_name = $Str->data_in($_SIGNUP->name);
			$_description = $Str->data_in($_SIGNUP->description);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_code_item_type = self::generateCode('PACKAGE-TYPE');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'name' => $_name,
				'description' => $_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$PackageTypeTable->insert_package_type($_fields);

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

	public static function edit_package_type($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'package-type-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				),
				'description' => array(
					'name' => 'description',
					'required' => false
				)
			)
		);

		if ($validation->passed()) {
			$PackageTypeTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_name = $Str->data_in($_SIGNUP->name);
			$_description = $Str->data_in($_SIGNUP->description);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'name' => $_name,
				'description' => $_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$PackageTypeTable->update_package_type($_fields, $_ID);
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

	public static function delete_package_type($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'package-type-';
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
					'name' => 'Package Type',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$PackageTypeTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_package_type_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_package_type_data = self::getInfoPackageTypeByID($_package_type_ID);
			if (!$_package_type_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_package_type_data = (Object) $_package_type_data;

			$_package_type_ID = $_package_type_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$PackageTypeTable->delete_package_type($_package_type_ID);

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

	public static function change_status_package_type()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'package-type-';
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
			$PackageTypeTable = new \CNS_SHIP_CLUSTER();
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
					$PackageTypeTable->change_status_package_type($_fields, $_ID);
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

	public static function getPackageTypes($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, name, description, status, creation_by, creation_datetime FROM cns_express_package_type WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->name = $list_->name;
				$list_->description = $list_->description;

				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoPackageTypeByID($ID)
	{
		$CNSROOTItemTypeTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTItemTypeTable->selectQuery(" SELECT id, cns_platform, cns_platform_product, cns_b2b, name, description, status, creation_by, creation_datetime FROM cns_express_package_type WHERE id = ?", array($ID));
		if ($CNSROOTItemTypeTable->count()):
			return $CNSROOTItemTypeTable->first();
		endif;
		return false;
	}


	# SHIP COST
	public static function record_ship_cost($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-cost-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'ship' => array(
					'name' => 'Ship',
					'required' => false
				),
				'price' => array(
					'name' => 'Price',
					'required' => false
				),
				'currency' => array(
					'name' => 'Currency',
					'required' => false
				)
			)
		);

		if ($validation->passed()) {
			$CostPriceTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_ship = $HASH->decryptAES($Str->data_in($_SIGNUP->ship));

			$_price = $Str->data_in($_SIGNUP->price);
			$_currency = $HASH->decryptAES($Str->data_in($_SIGNUP->currency));

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'express_ship' => $_ship,

				'price' => $_price,
				'currency' => $_currency,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$CostPriceTable->insert_ship_cost($_fields);

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

	public static function edit_ship_cost($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-cost-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'ship' => array(
					'name' => 'Ship',
					'required' => false
				),
				'price' => array(
					'name' => 'Price',
					'required' => false
				),
				'currency' => array(
					'name' => 'Currency',
					'required' => false
				)
			)
		);

		if ($validation->passed()) {
			$PackageTypeTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_ship = $HASH->decryptAES($Str->data_in($_SIGNUP->ship));
			$_price = $Str->data_in($_SIGNUP->price);
			$_currency = $HASH->decryptAES($Str->data_in($_SIGNUP->currency));

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'express_ship' => $_ship,
				'price' => $_price,
				'currency' => $_currency,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$PackageTypeTable->update_ship_cost($_fields, $_ID);
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

	public static function delete_ship_cost($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-cost-';
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
					'name' => 'Ship Cost',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipCostTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_ship_cost_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_ship_cost_data = self::getInfoShipCostByID($_ship_cost_ID);
			if (!$_ship_cost_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_ship_cost_data = (Object) $_ship_cost_data;

			$_ship_cost_ID = $_ship_cost_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipCostTable->delete_ship_cost($_ship_cost_ID);

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

	public static function change_status_ship_cost()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-cost-';
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
			$PackageTypeTable = new \CNS_SHIP_CLUSTER();
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
					$PackageTypeTable->change_status_ship_cost($_fields, $_ID);
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

	public static function getShipCosts($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, price, (SELECT name FROM cns_data_currency WHERE cns_data_currency.id =  cns_express_ship_cost.currency ORDER BY id DESC LIMIT 1) as currency, status, creation_by, creation_datetime,  (SELECT ship_label FROM cns_express_ship WHERE cns_express_ship.id = cns_express_ship_cost.express_ship ORDER BY id DESC LIMIT 1) as ship_label  FROM cns_express_ship_cost WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->price = $list_->price;
				$list_->currency = $list_->currency;

				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoShipCostByID($ID)
	{
		$CNSROOTCostPriceTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTCostPriceTable->selectQuery(" SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, price, currency, status, creation_by, creation_datetime,  (SELECT ship_label FROM cns_express_ship WHERE cns_express_ship.id = cns_express_ship_cost.express_ship ORDER BY id DESC LIMIT 1) as express_ship  FROM cns_express_ship_cost WHERE id = ?", array($ID));
		if ($CNSROOTCostPriceTable->count()):
			return $CNSROOTCostPriceTable->first();
		endif;
		return false;
	}

	#SHIP PURPOSE
	public static function record_ship_purpose($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-purpose-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				),
				'description' => array(
					'name' => 'description',
					'required' => false
				)
			)
		);

		if ($validation->passed()) {
			$ShipPurposeTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_name = $Str->data_in($_SIGNUP->name);
			$_description = $Str->data_in($_SIGNUP->description);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_code_ship_purpose = self::generateCode('SHIP-PURPORSE');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,
				'code' => $_code_ship_purpose,

				'name' => $_name,
				'description' => $_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipPurposeTable->insert_ship_purpose($_fields);

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

	public static function edit_ship_purpose($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-purpose-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				),
				'description' => array(
					'name' => 'description',
					'required' => false
				)
			)
		);

		if ($validation->passed()) {
			$ShipPurposeTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_name = $Str->data_in($_SIGNUP->name);
			$_description = $Str->data_in($_SIGNUP->description);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'name' => $_name,
				'description' => $_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipPurposeTable->update_ship_purpose($_fields, $_ID);
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

	public static function delete_ship_purpose($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-purpose-';
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
					'name' => 'Ship purpose',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ItemType = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_ship_purpose_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_ship_purpose_data = self::getInfoShipPurposeByID($_ship_purpose_ID);
			if (!$_ship_purpose_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_ship_purpose_data = (Object) $_ship_purpose_data;

			$_ship_purpose_ID = $_ship_purpose_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ItemType->delete_ship_purpose($_ship_purpose_ID);

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

	public static function change_status_ship_purpose()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-purpose-';
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
			$ShipPurposeTable = new \CNS_SHIP_CLUSTER();
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
					$ShipPurposeTable->change_status_ship_purpose($_fields, $_ID);
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

	public static function getShipPurposes($_filter_condition_ = "")
	{
		$CNSROOTShipPurposeTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipPurposeTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, code, name, description, status, creation_by, creation_datetime FROM cns_express_ship_purpose WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTShipPurposeTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTShipPurposeTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);

				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoShipPurposeByID($ID)
	{
		$CNSROOTShipPurposeTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipPurposeTable->selectQuery(" SELECT id, cns_platform, cns_platform_product, cns_b2b, code, name, description, status, creation_by, creation_datetime FROM cns_express_ship_purpose WHERE id = ?", array($ID));
		if ($CNSROOTShipPurposeTable->count()):
			return $CNSROOTShipPurposeTable->first();
		endif;
		return false;
	}


	# SHIP ITEMS
	public static function record_ship_item($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-item-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'ship' => array(
					'name' => 'Ship',
					'required' => false
				),
				'name' => array(
					'name' => 'Name',
					'required' => false
				),
				'description' => array(
					'name' => 'Description',
					'required' => false
				),
				'quantity' => array(
					'name' => 'Quantity',
					'required' => false
				),
				'unit' => array(
					'name' => 'Unit',
					'required' => false
				),
				'value' => array(
					'name' => 'value',
					'required' => false
				),
				'weight' => array(
					'name' => 'weight',
					'required' => false
				),
				'manufacture_address' => array(
					'name' => 'Manufacturer address',
					'required' => false
				),
				'manufacture_name' => array(
					'name' => 'Manufacturer name',
					'required' => false
				),
				'item_model' => array(
					'name' => 'Item model',
					'required' => false
				),
				'source' => array(
					'name' => 'Source',
					'required' => false
				),
				'commodity_code' => array(
					'name' => 'Commodity Code',
					'required' => false
				),
				'currency' => array(
					'name' => 'Currency',
					'required' => false
				)
			)
		);

		if ($validation->passed()) {
			$ShipItemTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_ship = $HASH->decryptAES($Str->data_in($_SIGNUP->ship));
			$_unit = $HASH->decryptAES($Str->data_in($_SIGNUP->unit));
			$_currency = $HASH->decryptAES($Str->data_in($_SIGNUP->currency));

			$_name = $Str->data_in($_SIGNUP->name);
			$_description = $Str->data_in($_SIGNUP->description);

			$_quantity = $Str->data_in($_SIGNUP->quantity);
			$_value = $Str->data_in($_SIGNUP->value);
			$_weight = $Str->data_in($_SIGNUP->weight);
			$_manufacture_name = $Str->data_in($_SIGNUP->manufacture_name);
			$_manufacture_address = $Str->data_in($_SIGNUP->manufacture_address);
			$_item_model = $Str->data_in($_SIGNUP->item_model);
			$_source = $Str->data_in($_SIGNUP->source);
			$_commodity_code = $Str->data_in($_SIGNUP->commodity_code);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_code_ship_item = self::generateCode('SHIP-ITEM');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,
				'code' => $_code_ship_item,

				'cns_ship' => $_ship,
				'currency' => $_currency,
				'unit' => $_unit,

				'name' => $_name,
				'description' => $_description,

				'quantity' => $_quantity,
				'value' => $_value,
				'weight' => $_weight,
				'manufacture_name' => $_manufacture_name,
				'manufacture_address' => $_manufacture_address,
				'item_model' => $_item_model,
				'source' => $_source,
				'commodity_code' => $_commodity_code,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipItemTable->insert_ship_item($_fields);

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

	public static function edit_ship_item($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-item-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'ship' => array(
					'name' => 'Ship',
					'required' => true
				),
				'name' => array(
					'name' => 'Name',
					'required' => true
				),
				'description' => array(
					'name' => 'Description',
					'required' => false
				),
				'quantity' => array(
					'name' => 'Quantity',
					'required' => true
				),
				'unit' => array(
					'name' => 'Unit',
					'required' => true
				),
				'value' => array(
					'name' => 'value',
					'required' => false
				),
				'weight' => array(
					'name' => 'weight',
					'required' => false
				),
				'manufacture_address' => array(
					'name' => 'Manufacturer address',
					'required' => false
				),
				'manufacture_name' => array(
					'name' => 'Manufacturer name',
					'required' => false
				),
				'item_model' => array(
					'name' => 'Item model',
					'required' => false
				),
				'source' => array(
					'name' => 'Source',
					'required' => false
				),
				'commodity_code' => array(
					'name' => 'Commodity Code',
					'required' => false
				),
				'currency' => array(
					'name' => 'Currency',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipItemTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_ship = $HASH->decryptAES($Str->data_in($_SIGNUP->ship));
			$_unit = $HASH->decryptAES($Str->data_in($_SIGNUP->unit));
			$_currency = $HASH->decryptAES($Str->data_in($_SIGNUP->currency));

			$_name = $Str->data_in($_SIGNUP->name);
			$_description = $Str->data_in($_SIGNUP->description);
			$_quantity = $Str->data_in($_SIGNUP->quantity);
			$_value = $Str->data_in($_SIGNUP->value);
			$_weight = $Str->data_in($_SIGNUP->weight);
			$_manufacture_name = $Str->data_in($_SIGNUP->manufacture_name);
			$_manufacture_address = $Str->data_in($_SIGNUP->manufacture_address);
			$_item_model = $Str->data_in($_SIGNUP->item_model);
			$_source = $Str->data_in($_SIGNUP->source);
			$_commodity_code = $Str->data_in($_SIGNUP->commodity_code);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'cns_ship' => $_ship,
				'currency' => $_currency,
				'unit' => $_unit,

				'name' => $_name,
				'description' => $_description,

				'quantity' => $_quantity,
				'value' => $_value,
				'weight' => $_weight,
				'manufacture_name' => $_manufacture_name,
				'manufacture_address' => $_manufacture_address,
				'item_model' => $_item_model,
				'source' => $_source,
				'commodity_code' => $_commodity_code,

				'creation_by' => $_adminID
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipItemTable->update_ship_item($_fields, $_ID);
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

	public static function delete_ship_item($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-item-';
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
					'name' => 'Ship Item',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipCostTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_ship_item_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_ship_item_data = self::getInfoShipItemByID($_ship_item_ID);
			if (!$_ship_item_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_ship_item_data = (Object) $_ship_item_data;

			$_ship_item_ID = $_ship_item_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipCostTable->delete_ship_item($_ship_item_ID);

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

	public static function change_status_ship_item()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-item-';
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
			$PackageTypeTable = new \CNS_SHIP_CLUSTER();
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
					$PackageTypeTable->change_status_ship_item($_fields, $_ID);
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

	public static function getShipItems($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, (SELECT ship_label FROM cns_express_ship WHERE cns_express_ship.id = cns_express_ship_item.cns_ship ORDER BY id DESC LIMIT 1) as ship, name, description, quantity, (SELECT name FROM cns_express_ship_unit WHERE cns_express_ship_unit.id = cns_express_ship_item.unit ORDER BY id DESC LIMIT 1) as unit, value, (SELECT name FROM cns_data_currency WHERE cns_data_currency.id = cns_express_ship_item.currency ORDER BY id DESC LIMIT 1) as currency, weight, manufacture_address, manufacture_name, item_model, source, commodity_code, status, creation_by, creation_datetime  FROM cns_express_ship_item WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->quantity = $list_->quantity;
				$list_->unit = $list_->unit;
				$list_->value = $list_->value;
				$list_->ship = $list_->ship;
				$list_->name = $list_->name;
				$list_->description = $list_->description;

				$list_->currency = $list_->currency;

				$list_->weight = $list_->weight;
				$list_->manufacture_address = $list_->manufacture_address;
				$list_->manufacture_name = $list_->manufacture_name;
				$list_->source = $list_->source;
				$list_->item_model = $list_->item_model;
				$list_->commodity_code = $list_->commodity_code;


				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoShipItemByID($ID)
	{
		$CNSROOTShipItemTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipItemTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, (SELECT ship_label FROM cns_express_ship WHERE cns_express_ship.id = cns_express_ship_item.cns_ship ORDER BY id DESC LIMIT 1) as ship, name, description, quantity, (SELECT name FROM cns_express_ship_unit WHERE cns_express_ship_unit.id = cns_express_ship_item.unit ORDER BY id DESC LIMIT 1) as unit, value, (SELECT name FROM cns_data_currency WHERE cns_data_currency.id = cns_express_ship_item.currency ORDER BY id DESC LIMIT 1) as currency, weight, manufacture_address, manufacture_name, item_model, source, commodity_code, status, creation_by, creation_datetime  FROM cns_express_ship_item WHERE id = ?", array($ID));
		if ($CNSROOTShipItemTable->count()):
			return $CNSROOTShipItemTable->first();
		endif;
		return false;
	}


	# SHIP COST ITEM 
	public static function record_ship_cost_item($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-cost-item-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'ship' => array(
					'name' => 'Ship',
					'required' => true
				),
				'item' => array(
					'name' => 'Item',
					'required' => true
				),
				'price' => array(
					'name' => 'Price',
					'required' => true
				),
				'currency' => array(
					'name' => 'Currency',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipCostItemTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_ship = $HASH->decryptAES($Str->data_in($_SIGNUP->ship));
			$_item = $HASH->decryptAES($Str->data_in($_SIGNUP->item));

			$_price = $Str->data_in($_SIGNUP->price);
			$_currency = $HASH->decryptAES($Str->data_in($_SIGNUP->currency));

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			//$_code_ship_cost_item = self::generateCode('SHIP-COST-ITEM');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'cns_ship' => $_ship,
				'cns_item' => $_item,

				'price' => $_price,
				'currency' => $_currency,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipCostItemTable->insert_ship_cost_item($_fields);

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

	public static function edit_ship_cost_item($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-cost-item-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'ship' => array(
					'name' => 'Ship',
					'required' => true
				),
				'item' => array(
					'name' => 'Item',
					'required' => true
				),
				'price' => array(
					'name' => 'Price',
					'required' => true
				),
				'currency' => array(
					'name' => 'Currency',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipItemTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_ship = $HASH->decryptAES($Str->data_in($_SIGNUP->ship));
			$_item = $HASH->decryptAES($Str->data_in($_SIGNUP->item));
			$_currency = $HASH->decryptAES($Str->data_in($_SIGNUP->currency));

			$_price = $Str->data_in($_SIGNUP->price);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'cns_ship' => $_ship,
				'cns_item' => $_item,

				'price' => $_price,
				'currency' => $_currency,

				'creation_by' => $_adminID
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipItemTable->update_ship_cost_item($_fields, $_ID);
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

	public static function delete_ship_cost_item($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-cost-item-';
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
					'name' => 'Ship Item',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipCostItemTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_ship_cost_item_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_ship_cost_item_data = self::getInfoShipCostItemByID($_ship_cost_item_ID);
			if (!$_ship_cost_item_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_ship_cost_item_data = (Object) $_ship_cost_item_data;

			$_ship_cost_item_ID = $_ship_cost_item_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipCostItemTable->delete_ship_cost_item($_ship_cost_item_ID);

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

	public static function change_status_ship_cost_item()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-cost-item-';
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
			$ShipCostItemTable = new \CNS_SHIP_CLUSTER();
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
					$ShipCostItemTable->change_status_ship_cost_item($_fields, $_ID);
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

	public static function getShipCostItems($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, shipment_code, source_b2c, source_firstname, 
		source_lastname, source_province, source_city, source_address_1, source_address_2, source_email, source_telephone, destination_firstname, destination_lastname, 
		destination_province, destination_city, destination_company_status, destination_company_name, destination_address_1, destination_address_2, destination_email, 
		destination_telephone, ship_label, ship_description, ship_type, ship_additional_detail, ship_short_description, invoice_number, invoice_description, 
		source_pickup_type, source_pickup_location, source_pickup_intsruction, ship_cost, (SELECT name FROM cns_express_ship_purpose WHERE cns_express_ship_purpose.id = cns_express_ship.id ORDER BY id DESC LIMIT 1) as ship_purpose, status, creation_by, creation_datetime FROM cns_express_ship WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;
				$list_->cns_b2c = $list_->cns_b2c;


				$list_->shipment_code = $list_->shipment_code;
				$list_->source_firstname = $list_->source_firstname;
				$list_->source_lastname = $list_->source_lastname;
				$list_->source_province = $list_->source_province;
				$list_->source_address_1 = $list_->source_address_1;
				$list_->source_address_2 = $list_->source_address_2;
				$list_->source_email = $list_->source_email;
				$list_->source_telephone = $list_->source_telephone;

				$list_->destination_firstname = $list_->destination_firstname;
				$list_->destination_lastname = $list_->destination_lastname;
				$list_->destination_province = $list_->destination_province;
				$list_->destination_company_status = $list_->destination_company_status;
				$list_->destination_company_name = $list_->destination_company_name;
				$list_->destination_address_1 = $list_->destination_address_1;
				$list_->destination_address_2 = $list_->destination_address_2;
				$list_->destination_email = $list_->destination_email;
				$list_->destination_telephone = $list_->destination_telephone;

				$list_->ship_label = $list_->ship_label;
				$list_->ship_description = $list_->ship_description;
				$list_->ship_type = $list_->ship_type;
				$list_->ship_additional_detail = $list_->ship_additional_detail;
				$list_->ship_short_description = $list_->ship_short_description;

				$list_->invoice_number = $list_->invoice_number;
				$list_->invoice_description = $list_->invoice_description;

				$list_->source_pickup_type = $list_->source_pickup_type;
				$list_->source_pickup_location = $list_->source_pickup_location;
				$list_->source_pickup_intsruction = $list_->source_pickup_intsruction;

				$list_->ship_cost = $list_->ship_cost;
				$list_->source_pickup_intsruction = $list_->source_pickup_intsruction;
				$list_->ship_purpose = $list_->ship_purpose;
				$list_->source_pickup_intsruction = $list_->source_pickup_intsruction;


				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoShipCostItemByID($ID)
	{
		$CNSROOTShipCostItemTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipCostItemTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, price, (SELECT ship_label FROM cns_express_ship WHERE cns_express_ship.id = cns_express_ship_cost_item.cns_ship ORDER BY id DESC LIMIT 1) as ship, (SELECT name FROM cns_express_ship_item WHERE cns_express_ship_item.id = cns_express_ship_cost_item.cns_item ORDER BY id DESC LIMIT 1) as item, (SELECT name FROM cns_data_currency WHERE cns_data_currency.id = cns_express_ship_cost_item.currency ORDER BY id DESC LIMIT 1) as currency, status, creation_by, creation_datetime FROM cns_express_ship_cost_item WHERE id = ?", array($ID));
		if ($CNSROOTShipCostItemTable->count()):
			return $CNSROOTShipCostItemTable->first();
		endif;
		return false;
	}


	#ITEM TYPE
	public static function record_product_prohibited($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'product-prohibited-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				),
				'short_description' => array(
					'name' => 'Short Description',
					'required' => false
				),
				'description' => array(
					'name' => 'description',
					'required' => false
				)
			)
		);

		if ($validation->passed()) {
			$ProductProhibitedTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_name = $Str->data_in($_SIGNUP->name);
			$_short_description = $Str->data_in($_SIGNUP->short_description);
			$_description = $Str->data_in($_SIGNUP->description);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_product_prohibited = self::generateCode('PRODUCT-PROHIBITED');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,
				'code' => $_product_prohibited,

				'name' => $_name,
				'short_description' => $_short_description,
				'description' => $_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ProductProhibitedTable->insert_product_prohibited($_fields);

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

	public static function edit_product_prohibited($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'product-prohibited-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				),
				'short_description' => array(
					'name' => 'Short Description',
					'required' => false
				),
				'description' => array(
					'name' => 'Description',
					'required' => false
				)
			)
		);

		if ($validation->passed()) {
			$ItemType = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_name = $Str->data_in($_SIGNUP->name);
			$_short_description = $Str->data_in($_SIGNUP->short_description);
			$_description = $Str->data_in($_SIGNUP->description);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'name' => $_name,
				'short_description' => $_short_description,
				'description' => $_description,

				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ItemType->update_product_prohibited($_fields, $_ID);
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

	public static function delete_product_prohibited($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'product-prohibited-';
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
					'name' => 'Prohibited Product',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ItemType = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_product_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_product_data = self::getInfoProductProhibitedByID($_product_ID);
			if (!$_product_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_product_data = (Object) $_product_data;

			$_product_ID = $_product_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ItemType->delete_product_prohibited($_product_ID);

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

	public static function change_status_product_prohibited()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'product-prohibited-';
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
			$ProductProhibitedTable = new \CNS_SHIP_CLUSTER();
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
					$ProductProhibitedTable->change_status_product_prohibited($_fields, $_ID);
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

	public static function getProductProhibited($_filter_condition_ = "")
	{
		$CNSROOTProductProhibitedTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTProductProhibitedTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, code, name, short_description, description, status, creation_by, creation_datetime FROM cns_express_product_prohibited WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTProductProhibitedTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTProductProhibitedTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->code = $list_->code;
				$list_->name = $list_->name;
				$list_->short_description = $list_->short_description;
				$list_->description = $list_->description;

				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoProductProhibitedByID($ID)
	{
		$CNSROOTItemTypeTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTItemTypeTable->selectQuery(" SELECT id, cns_platform, cns_platform_product, cns_b2b, code, name, short_description, description, status, creation_by, creation_datetime FROM cns_express_product_prohibited WHERE id = ?", array($ID));
		if ($CNSROOTItemTypeTable->count()):
			return $CNSROOTItemTypeTable->first();
		endif;
		return false;
	}



	#B2B INFO
	public static function record_b2b_info($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'b2b-info-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'company_name' => array(
					'name' => 'Company Name',
					'required' => true
				),
				'company_email' => array(
					'name' => 'Company Email',
					'required' => true
				),
				'company_telephone' => array(
					'name' => 'Company Email',
					'required' => true
				),
				'company_address' => array(
					'name' => 'Company Address',
					'required' => true
				),
				'facebook_link' => array(
					'name' => 'Facebook Link',
					// 'required' => false
				),
				'instagram_link' => array(
					'name' => 'Instagram Link',
					// 'required' => false
				),
				'tweeter_link' => array(
					'name' => 'Tweeter Link',
					// 'required' => false
				),
				'youtube_link' => array(
					'name' => 'Youtube Link',
					// 'required' => false
				),
				'about' => array(
					'name' => 'About',
					'required' => true
				),
				'mission' => array(
					'name' => 'Mission',
					'required' => true
				),
				'vision' => array(
					'name' => 'Vision',
					'required' => true
				),
				'value' => array(
					'name' => 'Value',
					'required' => true
				),
				'terms' => array(
					'name' => 'Terms',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$B2bInfoTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_company_name = $Str->data_in($_SIGNUP->company_name);
			$_company_email = $Str->data_in($_SIGNUP->company_email);
			$_company_telephone = $Str->data_in($_SIGNUP->company_telephone);
			$_company_address = $Str->data_in($_SIGNUP->company_address);

			$_facebook_link = $Str->data_in($_SIGNUP->facebook_link);
			$_instagram_link = $Str->data_in($_SIGNUP->instagram_link);
			$_tweeter_link = $Str->data_in($_SIGNUP->tweeter_link);
			$_youtube_link = $Str->data_in($_SIGNUP->youtube_link);

			$_about = $Str->data_in($_SIGNUP->about);
			$_terms = $Str->data_in($_SIGNUP->terms);
			$_mission = $Str->data_in($_SIGNUP->mission);
			$_value = $Str->data_in($_SIGNUP->value);
			$_vision = $Str->data_in($_SIGNUP->vision);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'company_name' => $_company_name,
				'company_email' => $_company_email,
				'company_telephone' => $_company_telephone,
				'company_address' => $_company_address,

				'facebook_link' => $_facebook_link,
				'instagram_link' => $_instagram_link,
				'tweeter_link' => $_tweeter_link,
				'youtube_link' => $_youtube_link,

				'about' => $_about,
				'terms' => $_terms,
				'mission' => $_mission,
				'value' => $_value,
				'vision' => $_vision,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$B2bInfoTable->insert_b2b_info($_fields);

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

	public static function edit_b2b_info($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'b2b-info-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'company_name' => array(
					'name' => 'Company Name',
					'required' => true
				),
				'company_email' => array(
					'name' => 'Company Email',
					'required' => true
				),
				'company_telephone' => array(
					'name' => 'Company Email',
					'required' => true
				),
				'company_address' => array(
					'name' => 'Company Address',
					'required' => true
				),
				'facebook_link' => array(
					'name' => 'Facebook Link',
					//'required' => false
				),
				'instagram_link' => array(
					'name' => 'Instagram Link',
					// 'required' => false
				),
				'tweeter_link' => array(
					'name' => 'Tweeter Link',
					// 'required' => false
				),
				'youtube_link' => array(
					'name' => 'About',
					// 'required' => false
				),
				'about' => array(
					'name' => 'About',
					'required' => true
				),
				'mission' => array(
					'name' => 'Mission',
					'required' => true
				),
				'vision' => array(
					'name' => 'Vision',
					'required' => true
				),
				'value' => array(
					'name' => 'Value',
					'required' => true
				),
				'terms' => array(
					'name' => 'Terms',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$B2bInfoTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));


			$_company_name = $Str->data_in($_SIGNUP->company_name);
			$_company_email = $Str->data_in($_SIGNUP->company_email);
			$_company_telephone = $Str->data_in($_SIGNUP->company_telephone);
			$_company_address = $Str->data_in($_SIGNUP->company_address);

			$_facebook_link = $Str->data_in($_SIGNUP->facebook_link);
			$_instagram_link = $Str->data_in($_SIGNUP->instagram_link);
			$_tweeter_link = $Str->data_in($_SIGNUP->tweeter_link);
			$_youtube_link = $Str->data_in($_SIGNUP->youtube_link);


			$_about = $Str->data_in($_SIGNUP->about);
			$_vision = $Str->data_in($_SIGNUP->vision);
			$_mission = $Str->data_in($_SIGNUP->mission);
			$_value = $Str->data_in($_SIGNUP->value);
			$_terms = $Str->data_in($_SIGNUP->terms);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'company_name' => $_company_name,
				'company_email' => $_company_email,
				'company_telephone' => $_company_telephone,
				'company_address' => $_company_address,

				'facebook_link' => $_facebook_link,
				'instagram_link' => $_instagram_link,
				'tweeter_link' => $_tweeter_link,
				'youtube_link' => $_youtube_link,

				'about' => $_about,
				'mission' => $_mission,
				'vision' => $_vision,
				'value' => $_value,
				'terms' => $_terms,

				'creation_by' => $_adminID,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$B2bInfoTable->update_b2b_info($_fields, $_ID);
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

	public static function delete_b2b_info($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'b2b-info-';
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
					'name' => 'Identify',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$B2bInfoTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_b2b_info_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_b2b_info_data = self::getInfoB2bInfoByID($_b2b_info_ID);
			if (!$_b2b_info_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_b2b_info_data = (Object) $_b2b_info_data;

			$_b2b_info_ID = $_b2b_info_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$B2bInfoTable->delete_b2b_info($_b2b_info_ID);

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

	public static function change_status_b2b_info()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'b2b-info-';
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
			$B2bInfoTable = new \CNS_SHIP_CLUSTER();
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
					$B2bInfoTable->change_status_b2b_info($_fields, $_ID);
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

	public static function getB2bInfo($_filter_condition_ = "")
	{
		$CNSROOTB2BTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTB2BTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, company_name, company_email, company_telephone, company_address, facebook_link, instagram_link, tweeter_link, youtube_link, about, mission, value, terms, vision, status, creation_by, creation_datetime FROM cns_cluster_b2b_info WHERE status != 'DELETED' $_filter_condition_ , LIMIT 1");
		if ($CNSROOTB2BTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTB2BTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->about = $list_->about;
				$list_->mission = $list_->mission;
				$list_->vision = $list_->vision;
				$list_->terms = $list_->terms;

				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoB2bInfoByID($ID)
	{
		$CNSB2bInfoTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSB2bInfoTable->selectQuery(" SELECT id, cns_platform, cns_platform_product, cns_b2b, company_name, company_email, company_telephone, company_address, facebook_link, instagram_link, tweeter_link, youtube_link, about, mission, value, terms, vision, status, creation_by, creation_datetime FROM cns_cluster_b2b_info WHERE id = ?", array($ID));
		if ($CNSB2bInfoTable->count()):
			return $CNSB2bInfoTable->first();
		endif;
		return false;
	}



	# SHIP PACKAGE
	public static function record_ship_package($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-package-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'ship' => array(
					'name' => 'Ship',
					'required' => true
				),
				'name' => array(
					'name' => 'Name',
					'required' => true
				),
				'description' => array(
					'name' => 'Description',
					'required' => false
				),
				'weight' => array(
					'name' => 'Weight',
					'required' => true
				),
				'type' => array(
					'name' => 'Package Type',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipPackageTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_ship = $HASH->decryptAES($Str->data_in($_SIGNUP->ship));
			$_cns_b2c = $HASH->decryptAES($Str->data_in($_SIGNUP->cns_b2c));
			$_type = $HASH->decryptAES($Str->data_in($_SIGNUP->type));

			$_name = $Str->data_in($_SIGNUP->name);
			$_description = $Str->data_in($_SIGNUP->description);
			$_weight = $Str->data_in($_SIGNUP->weight);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_ship_package = self::generateCode('SHIP-PACKAGE');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,
				'cns_b2c' => $_cns_b2c,

				'code' => $_ship_package,
				'ship' => $_ship,
				'type' => $_type,

				'name' => $_name,
				'description' => $_description,
				'weight' => $_weight,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipPackageTable->insert_ship_package($_fields);

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

	public static function edit_ship_package($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-package-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'ship' => array(
					'name' => 'Ship',
					'required' => true
				),
				'name' => array(
					'name' => 'Name',
					'required' => true
				),
				'description' => array(
					'name' => 'Description',
					'required' => false
				),
				'weight' => array(
					'name' => 'Weight',
					'required' => true
				),
				'type' => array(
					'name' => 'Package Type',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipPackageTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_ship = $HASH->decryptAES($Str->data_in($_SIGNUP->ship));
			$_cns_b2c = $HASH->decryptAES($Str->data_in($_SIGNUP->cns_b2c));
			$_type = $HASH->decryptAES($Str->data_in($_SIGNUP->type));

			$_name = $Str->data_in($_SIGNUP->name);
			$_description = $Str->data_in($_SIGNUP->description);
			$_weight = $Str->data_in($_SIGNUP->weight);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,
				'cns_b2c' => $_cns_b2c,

				'ship' => $_ship,
				'type' => $_type,

				'name' => $_name,
				'description' => $_description,
				'weight' => $_weight,

				'creation_by' => $_adminID,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipPackageTable->update_ship_package($_fields, $_ID);
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

	public static function delete_ship_package($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-package-';
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
					'name' => 'Ship Cost',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipPackageTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_ship_package_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_ship_package_data = self::getInfoShipPackageByID($_ship_package_ID);
			if (!$_ship_package_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_ship_package_data = (Object) $_ship_package_data;

			$_ship_package_ID = $_ship_package_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipPackageTable->delete_ship_package($_ship_package_ID);

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

	public static function change_status_ship_package()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-package-';
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
			$PackagePackageTable = new \CNS_SHIP_CLUSTER();
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
					$PackagePackageTable->change_status_ship_package($_fields, $_ID);
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

	public static function getShipPackages($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, (SELECT lastname FROM cns_b2c_customer WHERE cns_b2c_customer.id = cns_express_package.cns_b2c ORDER BY id DESC LIMIT 1) as cns_b2c, (SELECT ship_label FROM cns_express_ship WHERE cns_express_ship.id = cns_express_package.ship ORDER BY id DESC LIMIT 1) as ship, (SELECT name FROM cns_express_package_type WHERE cns_express_package_type.id = cns_express_package.type ORDER BY id DESC LIMIT 1) as type, name, description, weight, status, creation_by, creation_datetime  FROM cns_express_package WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;
				$list_->cns_b2c = $list_->cns_b2c;

				$list_->ship = $list_->ship;
				$list_->type = $list_->type;
				$list_->name = $list_->name;
				$list_->description = $list_->description;
				$list_->weight = $list_->weight;

				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoShipPackageByID($ID)
	{
		$CNSROOTShipPackageTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipPackageTable->selectQuery(" SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, (SELECT lastname FROM cns_b2c_customer WHERE cns_b2c_customer.id = cns_express_package.cns_b2c ORDER BY id DESC LIMIT 1) as cns_b2c, (SELECT ship_label FROM cns_express_ship WHERE cns_express_ship.id = cns_express_package.ship ORDER BY id DESC LIMIT 1) as ship, (SELECT name FROM cns_express_package_type WHERE cns_express_package_type.id = cns_express_package.type ORDER BY id DESC LIMIT 1) as type, name, description, weight, status, creation_by, creation_datetime  FROM cns_express_package WHERE id = ?", array($ID));
		if ($CNSROOTShipPackageTable->count()):
			return $CNSROOTShipPackageTable->first();
		endif;
		return false;
	}




	# SHIP WORKING SOURCE COUNTRY
	public static function record_source_country($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'source-country-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'country' => array(
					'name' => 'Country',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$SourceCountryTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_country = $HASH->decryptAES($Str->data_in($_SIGNUP->country));

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_source_country_code = self::generateCode('SOURCE-COUNTRY');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'code' => $_source_country_code,
				'country' => $_country,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$SourceCountryTable->insert_source_country($_fields);

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

	public static function edit_source_country($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'source-country-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'country' => array(
					'name' => 'Country',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$SourceCountryTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_country = $HASH->decryptAES($Str->data_in($_SIGNUP->country));

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'country' => $_country,

				'creation_by' => $_adminID,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$SourceCountryTable->update_source_country($_fields, $_ID);
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

	public static function delete_source_country($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'source-country-';
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
					'name' => 'Ship Cost',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$SourceCountryTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_source_country_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_source_country_data = self::getInfoSourceCountryByID($_source_country_ID);
			if (!$_source_country_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_source_country_data = (Object) $_source_country_data;

			$_source_countrye_ID = $_source_country_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$SourceCountryTable->delete_source_country($_source_country_ID);

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

	public static function change_status_source_country()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'source-country-';
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
			$SourceCountryTable = new \CNS_SHIP_CLUSTER();
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
					$SourceCountryTable->change_status_source_country($_fields, $_ID);
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

	public static function getSourceCountry($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, (SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_express_working_source_country.country ORDER BY id DESC LIMIT 1) as source_country, status, creation_by, creation_datetime  FROM cns_express_working_source_country WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->source_country = $list_->source_country;

				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoSourceCountryByID($ID)
	{
		$CNSROOTSourceCountryTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTSourceCountryTable->selectQuery(" SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, (SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_express_working_source_country.country ORDER BY id DESC LIMIT 1) as source_country, status, creation_by, creation_datetime  FROM cns_express_working_source_country WHERE id = ?", array($ID));
		if ($CNSROOTSourceCountryTable->count()):
			return $CNSROOTSourceCountryTable->first();
		endif;
		return false;
	}


	# SHIP WORKING DESTINATION COUNTRY
	public static function record_destination_country($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'destination-country-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'country' => array(
					'name' => 'Country',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$DestinationCountryTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_country = $HASH->decryptAES($Str->data_in($_SIGNUP->country));

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_destination_country_code = self::generateCode('DESTINATION-COUNTRY');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'code' => $_destination_country_code,
				'country' => $_country,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$DestinationCountryTable->insert_destination_country($_fields);

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

	public static function edit_destination_country($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'destination-country-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'country' => array(
					'name' => 'Country',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$DestinationCountryTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_country = $HASH->decryptAES($Str->data_in($_SIGNUP->country));

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'country' => $_country,

				'creation_by' => $_adminID,
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$DestinationCountryTable->update_destination_country($_fields, $_ID);
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

	public static function delete_destination_country($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'destination-country-';
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
					'name' => 'Ship Cost',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$DestinationCountryTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_destination_country_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_destination_country_data = self::getInfoDestinationCountryByID($_destination_country_ID);
			if (!$_destination_country_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_destination_country_data = (Object) $_destination_country_data;

			$_destination_countrye_ID = $_destination_country_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$DestinationCountryTable->delete_destination_country($_destination_country_ID);

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

	public static function change_status_destination_country()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'destination-country-';
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
			$DestinationCountryTable = new \CNS_SHIP_CLUSTER();
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
					$DestinationCountryTable->change_status_destination_country($_fields, $_ID);
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

	public static function getDestinationCountry($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, (SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_express_working_destination_country.country ORDER BY id DESC LIMIT 1) as destination_country, status, creation_by, creation_datetime  FROM cns_express_working_destination_country WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->destination_country = $list_->destination_country;

				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoDestinationCountryByID($ID)
	{
		$CNSROOTSourceCountryTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTSourceCountryTable->selectQuery(" SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, (SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_express_working_destination_country.country ORDER BY id DESC LIMIT 1) as source_country, status, creation_by, creation_datetime  FROM cns_express_working_destination_country WHERE id = ?", array($ID));
		if ($CNSROOTSourceCountryTable->count()):
			return $CNSROOTSourceCountryTable->first();
		endif;
		return false;
	}

	#SHIP UNIT
	public static function record_ship_unit($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-unit-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipUnitTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_name = $Str->data_in($_SIGNUP->name);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));
			$_status = 'ACTIVE';

			$_ship_unit_type = self::generateCode('SHIP-UNIT');

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,
				'code' => $_ship_unit_type,

				'name' => $_name,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipUnitTable->insert_ship_unit($_fields);

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

	public static function edit_ship_unit($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-unit-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				'name' => array(
					'name' => 'name',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipUnitTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_name = $Str->data_in($_SIGNUP->name);

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			$_cns_user = $access_data->id;

			$_adminID = $_cns_user; //Session::get(Config::get('session/admin'));

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'name' => $_name,

				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipUnitTable->update_ship_unit($_fields, $_ID);
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

	public static function delete_ship_unit($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-unit-';
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
					'name' => 'Item Type',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipUitTable = new \CNS_SHIP_CLUSTER();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SIGNUP = (object) $_SIGNUP;
			$HASH = new \Hash();

			$_ship_unit_ID = $HASH->decryptAES($Str->data_in($_SIGNUP->_id_));

			$_ship_unit_data = self::getInfoShipUnitByID($_ship_unit_ID);
			if (!$_ship_unit_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_ship_unit_data = (Object) $_ship_unit_data;

			$_ship_unit_ID = $_ship_unit_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipUitTable->delete_ship_unit($_ship_unit_ID);

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

	public static function change_status_ship_unit()
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-unit-';
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
			$ShipUnitTable = new \CNS_SHIP_CLUSTER();
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
					$ShipUnitTable->change_status_ship_unit($_fields, $_ID);
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

	public static function getShipUnits($_filter_condition_ = "", $cns_b2b)
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, code, name, status, creation_by, creation_datetime FROM cns_express_ship_unit WHERE status != 'DELETED' AND cns_b2b = $cns_b2b $_filter_condition_");
		if ($CNSROOTPartnerTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTPartnerTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->cns_platform = $list_->cns_platform;
				$list_->cns_platform_product = $list_->cns_platform_product;
				$list_->cns_b2b = $list_->cns_b2b;

				$list_->code = $list_->code;
				$list_->name = $list_->name;

				$list_->status = $list_->status;
				$list_->creation_by = $list_->creation_by;
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoShipUnitByID($ID)
	{
		$CNSROOTItemTypeTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTItemTypeTable->selectQuery(" SELECT id, cns_platform, cns_platform_product, cns_b2b, code, name, status, creation_by, creation_datetime FROM cns_express_ship_unit WHERE id = ?", array($ID));
		if ($CNSROOTItemTypeTable->count()):
			return $CNSROOTItemTypeTable->first();
		endif;
		return false;
	}


	#USERS LOGS
	public static function record_users_logs($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'user-log-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SIGNUP[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SIGNUP,
			array(
				"page_id" => array(
					'name' => 'page id',
					'required' => true
				),
				"page_name" => array(
					'name' => 'page name',
					'required' => true
				),
				"page_sub_name" => array(
					'name' => 'page sub name',
					'required' => true
				),
				"user_id" => array(
					'name' => 'user id',
					'required' => true
				),
				"email" => array(
					'name' => 'Email',
					'required' => true
				),
				"type" => array(
					'name' => 'Type',
					'required' => true
				),
				"grabbed_info" => array(
					'name' => 'Grabbed Info',
					'required' => true
				),
				"device_info" => array(
					'name' => 'Device Info',
					'required' => true
				),
				"device_details" => array(
					'name' => 'Device Detail',
					'required' => true
				),
				"device" => array(
					'name' => 'Device',
					'required' => true
				),
				"user_country_code" => array(
					'name' => 'User country Code',
					'required' => true
				),
				"user_country" => array(
					'name' => 'User country',
					'required' => true
				),
				"user_city" => array(
					'name' => 'User city',
					'required' => true
				),
				"user_latitude" => array(
					'name' => 'User latitude',
					'required' => true
				),
				"user_longitude" => array(
					'name' => 'User longitude',
					'required' => true
				),
			)
		);

		$UserLogsTable = new \CNS_SHIP_CLUSTER();
		$Str = new \Str();
		$datetime = \Config::get('time/date_time');
		$_SIGNUP = (object) $_SIGNUP;
		$HASH = new \Hash();

		$page_id = "1";
		$page_name = "1";
		$page_sub_name = "1";
		$user_id = "1";
		$email = "1";
		$type = "1";
		$grabbed_info = "1";
		$device_details = "1";
		$device = "1";
		$user_country_code = "1";
		$user_country = "1";
		$user_city = "1";
		$user_latitude = "1";
		$user_longitude = "1";
		$day_name = date('D');
		$day = date('d');
		$month = date('M');
		$year = \Dates::current_year();
		$hour = date('h');
		$minute = date('i');
		$second = date('s');
		$user_ip = $_SERVER['REMOTE_ADDR'];
		$c_date = date('d-M-Y');

		$_cns_platform = '1';

		$_fields = array(
			'platform' => $_cns_platform,
			'page_id' => $page_id,
			'page_name' => $page_name,
			'page_sub_name' => $page_sub_name,
			'user_id' => $user_id,
			'email' => $email,
			'type' => $type,
			'grabbed_info' => $grabbed_info,
			'device_details' => $device_details,
			'device' => $device,
			'user_country_code' => $user_country_code,
			'user_country' => $user_country,
			'user_city' => $user_city,
			'user_latitude' => $user_latitude,
			'user_longitude' => $user_longitude,
			'day_name' => $day_name,
			'day' => $day,
			'month' => $month,
			'year' => $year,
			'hour' => $hour,
			'minute' => $minute,
			'second' => $second,
			'user_ip' => $user_ip,
			'c_date' => $c_date,
		);

		if ($diagnoArray[0] == 'NO_ERRORS') {
			try {
				$UserLogsTable->insert_users_logs($_fields);

			} catch (Exception $e) {
				$diagnoArray[0] = "ERRORS_FOUND";
				$diagnoArray[] = $e->getMessage();
			}
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

	public static function getUsersLogs($_filter_condition_ = "")
	{
		$UserLogsTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$UserLogsTable->selectQuery("SELECT id as token_id, platform, page_id, page_name, page_sub_name, user_id, email, type, grabbed_info, device_details, device, day_name, day, month, year, hour, minute, second, user_ip, user_country_code, user_country, user_city, user_latitude, user_longitude, c_date FROM app_user_logs $_filter_condition_");
		if ($UserLogsTable->count()):
			$_DATA_ = array();
			foreach ($UserLogsTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}















	#COUNTRY SELECT OPTIONS
	public static function get_data_country_list_options($_filter_condition_ = "")
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name, country_iso FROM cns_data_country WHERE status != 'DELETED' $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	#SOURCE WORKING COUNTRY LIST OPTION
	public static function get_data_source_country_list_options($_filter_condition_ = "" )
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, (SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_express_working_source_country.country ORDER BY id DESC LIMIT 1) as name FROM cns_express_working_source_country WHERE status != 'DELETED' $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	#SOURCE WORKING COUNTRY LIST OPTION
	public static function get_source_country_list_options($_filter_condition_ = "")
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT country as token_id, (SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_express_working_source_country.country ORDER BY id DESC LIMIT 1) as name FROM cns_express_working_source_country WHERE status != 'DELETED' $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	#DESTINATION WORKING COUNTRY LIST OPTION
	public static function get_data_destination_country_list_options($_filter_condition_ = "")
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, (SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_express_working_destination_country.country ORDER BY id DESC LIMIT 1) as name FROM cns_express_working_destination_country WHERE status != 'DELETED' $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	#DESTINATION WORKING COUNTRY LIST OPTION
	public static function get_destination_country_list_options($_filter_condition_ = "")
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT country as token_id, (SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_express_working_destination_country.country ORDER BY id DESC LIMIT 1) as name FROM cns_express_working_destination_country WHERE status != 'DELETED' $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	#UNIT LIST OPTION
	public static function get_data_unit_list_options($_filter_condition_ = "")
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name FROM cns_express_ship_unit WHERE status != 'DELETED'");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	public static function get_data_province_list_options($_filter_condition_ = "")
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT cns_data_province.id as ctiprovince, cns_data_province.country as cticountry, cns_data_province.name FROM cns_data_province, cns_data_country WHERE cns_data_province.country = cns_data_country.id and cns_data_province.status = 'ACTIVE' $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->ctaprovince = $HASH->encryptAES($list_->ctiprovince);
				$list_->ctiprovince = Hash::encryptToken($list_->ctiprovince);

				$list_->ctacountry = $HASH->encryptAES($list_->cticountry);
				$list_->cticountry = Hash::encryptToken($list_->cticountry);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}



	public static function get_data_city_list_options($_filter_condition_ = "")
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT cns_data_city.id as cticity, cns_data_city.country as cticountry, cns_data_city.province as ctiprovince, cns_data_city.name FROM cns_data_city WHERE cns_data_city.status = 'ACTIVE' $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->ctacity = $HASH->encryptAES($list_->cticity);
				$list_->cticity = Hash::encryptToken($list_->cticity);

				$list_->ctaprovince = $HASH->encryptAES($list_->ctiprovince);
				$list_->ctiprovince = Hash::encryptToken($list_->ctiprovince);

				$list_->ctacountry = $HASH->encryptAES($list_->cticountry);
				$list_->cticountry = Hash::encryptToken($list_->cticountry);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	public static function get_data_ship_purpose_list_options($_filter_condition_ = "")
	{
		$CNSROOTShipPurposeTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipPurposeTable->selectQuery("SELECT id as ctipurpose, name FROM cns_express_ship_purpose WHERE status = 'ACTIVE' $_filter_condition_");
		if ($CNSROOTShipPurposeTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTShipPurposeTable->data() as $list_):
				$list_->ctapurpose = $HASH->encryptAES($list_->ctipurpose);
				$list_->ctipurpose = Hash::encryptToken($list_->ctipurpose);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_item_unit_list_options($_filter_condition_ = "")
	{
		$CNSROOTShipItemUnitTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipItemUnitTable->selectQuery("SELECT id as ctiitemunit, name FROM cns_express_ship_unit WHERE status = 'ACTIVE' $_filter_condition_");
		if ($CNSROOTShipItemUnitTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTShipItemUnitTable->data() as $list_):
				$list_->ctaitemunit = $HASH->encryptAES($list_->ctiitemunit);
				$list_->ctiitemunit = Hash::encryptToken($list_->ctiitemunit);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	public static function get_data_item_type_list_options($_filter_condition_ = "")
	{
		$CNSROOTShipItemTypeTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipItemTypeTable->selectQuery("SELECT id as ctiitemtype, name FROM cns_express_item_type WHERE status = 'ACTIVE' $_filter_condition_");
		if ($CNSROOTShipItemTypeTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTShipItemTypeTable->data() as $list_):
				$list_->ctaitemtype = $HASH->encryptAES($list_->ctiitemtype);
				$list_->ctiitemtype = Hash::encryptToken($list_->ctiitemtype);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function get_data_pickup_types_list_options($_filter_condition_ = "")
	{
		$CNSROOTShipPickupTypeTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipPickupTypeTable->selectQuery("SELECT id as ctipickuptype, (SELECT name FROM cns_express_ship_pickup_type WHERE cns_express_ship_pickup_types.pickup_type = cns_express_ship_pickup_type.id ORDER BY id DESC LIMIT 1) as pickup_type_name, category, status FROM cns_express_ship_pickup_types WHERE status = 'ACTIVE' $_filter_condition_");
		if ($CNSROOTShipPickupTypeTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTShipPickupTypeTable->data() as $list_):
				$list_->ctapickuptype = $HASH->encryptAES($list_->ctipickuptype);
				$list_->ctipickuptype = Hash::encryptToken($list_->ctipickuptype);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	#CURRENCY LIST OPTION
	public static function get_data_currency_list_options($_filter_condition_ = "")
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name, description FROM cns_data_currency WHERE status != 'DELETED' $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	#SHIP LIST OPTION
	public static function get_data_ship_list_options($_filter_condition_ = "", $cns_b2b)
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, ship_label FROM cns_express_ship WHERE status != 'DELETED' AND cns_b2b = $cns_b2b $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	#ITEM LIST OPTION
	public static function get_data_item_list_options($_filter_condition_ = "", $cns_b2b)
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name FROM cns_express_ship_item WHERE status != 'DELETED' AND cns_b2b = $cns_b2b $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	#PACKAGE LIST OPTION
	public static function get_data_package_list_options($_filter_condition_ = "", $cns_b2b)
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name FROM cns_express_package WHERE status != 'DELETED' AND cns_b2b = $cns_b2b $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	#PACKAGE TYPE LIST OPTION
	public static function get_data_package_type_list_options($_filter_condition_ = "", $cns_b2b)
	{
		$CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
		$CNSROOTClusterDataTable->selectQuery("SELECT id as token_id, name FROM cns_express_package_type WHERE status != 'DELETED' AND cns_b2b = $cns_b2b $_filter_condition_ ");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTClusterDataTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	

	public static function generateCode($TYPE = 'PARTNER')
	{
		if ($TYPE == 'PARTNER')
			return 'CNSPSR.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'DELIVERY-AGENT')
			return 'CNSPSR.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');
			
		if ($TYPE == 'ITEM-TYPE')
			return 'CNSIT.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'PACKAGE-TYPE')
			return 'CNSPT.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'SHIP-COST')
			return 'CNSSC.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'SHIP-PURPOSE')
			return 'CNSSP.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'SHIP-ITEM')
			return 'CNSSI.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'PRODUCT-PROHIBITED')
			return 'CNSPPR.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'SHIP-COST-ITEM')
			return 'CNSSCI.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'B2B-INFO')
			return 'CNSBI.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'SHIP-PACKAGE')
			return 'CNSBI.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'SOURCE-COUNTRY')
			return 'CNSSC.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'DESTINATION-COUNTRY')
			return 'CNSDC.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		return false;
	}

	public static function generateToken($STR)
	{
		$seconds = time();
		$token_hash = md5($seconds . sha1($STR));
		return $token_hash;
	}

	public static function getLastID($table)
	{
		$StockTable = new \CNS_SHIP_CLUSTER();
		$StockTable->selectQuery("SELECT id FROM $table ORDER BY id DESC LIMIT 1");
		if ($StockTable->count())
			return $StockTable->first()->id;
		return false;
	}

	public static function checkIfExists($table, $_condition_ = "")
	{
		$StockTable = new \CNS_SHIP_CLUSTER();
		$StockTable->selectQuery("SELECT id FROM $table $_condition_  ORDER BY id DESC LIMIT 1");
		if ($StockTable->count())
			return true;
		return false;
	}











	public static function clean_null_value($_key_)
	{
		return ($_key_ == null) ? 0 : $_key_;
	}

	public static function percentage($_value_, $_total_)
	{
		$_percentage_ = $_value_ * 100;
		$_percentage_ /= ($_total_ == 0) ? 1 : $_total_;
		return abs(number_format($_percentage_));
	}

	public static function number_format($_number_)
	{
		return number_format($_number_);
	}

}