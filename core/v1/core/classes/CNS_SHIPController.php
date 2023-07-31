<?php
class CNS_SHIPController
{

	//insert shipment
	public static function createShip($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SUBMIT[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SUBMIT,
			array(
				'source_firstname' => array(
					'name' => 'Source first name',
					'required' => true
				), 
				'source_lastname' => array(
					'name' => 'Source last name',
					'required' => true
				), 
				'source_country' => array(
					'name' => 'Source country',
					'required' => true
				), 
				'source_province' => array(
					'name' => 'Source province',
					'required' => true
				), 
				'source_city' => array(
					'name' => 'Source city',
					'required' => true
				), 
				'source_address_1' => array(
					'name' => 'Source address 1',
					'required' => true
				), 
				'source_email' => array(
					'name' => 'Source email',
					'required' => true
				), 
				'source_telephone' => array(
					'name' => 'Source telephone',
					'required' => true
				), 
				'destination_firstname' => array(
					'name' => 'Destination first name',
					'required' => true
				), 
				'destination_lastname' => array(
					'name' => 'Destination last name',
					'required' => true
				), 
				'destination_country' => array(
					'name' => 'Destination country',
					'required' => true
				), 
				'destination_province' => array(
					'name' => 'Destination province',
					'required' => true
				), 
				'destination_city' => array(
					'name' => 'Destination city',
					'required' => true
				), 
				'destination_address_1' => array(
					'name' => 'Destination address 1',
					'required' => true
				), 
				'destination_email' => array(
					'name' => 'Destination email',
					'required' => true
				), 
				'destination_telephone' => array(
					'name' => 'Destination telephone',
					'required' => true
				), 
				'source_pickup_type' => array(
					'name' => 'Source pickup type',
					'required' => true
				), 
			)
		);

		if ($validation->passed()) {
			$ShipTable = new \CNS_SHIP();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SUBMIT = (object) $_SUBMIT;
			$HASH = new \Hash();


			//source
			$_source_firstname = $Str->data_in($_SUBMIT->source_firstname);
			$_source_lastname = $Str->data_in($_SUBMIT->source_lastname);
			$_source_country = $HASH->decryptAES($Str->data_in($_SUBMIT->source_country));
			$_source_province = $HASH->decryptAES($Str->data_in($_SUBMIT->source_province));  
			$_source_city = $HASH->decryptAES($Str->data_in($_SUBMIT->source_city));
			$_source_address_1 = $Str->data_in($_SUBMIT->source_address_1);
			$_source_address_2 = $Str->data_in($_SUBMIT->source_address_2);
			$_source_email = $Str->data_in($_SUBMIT->source_email);
			$_source_telephone = $Str->data_in($_SUBMIT->source_telephone);
			$_source_pickup_type = $HASH->decryptAES($Str->data_in($_SUBMIT->source_pickup_type));
			$_source_pickup_location = !Input::checkInput('source_pickup_location', 'post',  1) ? '' : $Str->data_in($_SUBMIT->source_pickup_location);
			$_source_pickup_instruction = !Input::checkInput('source_pickup_instruction', 'post',  1) ? '' : $Str->data_in($_SUBMIT->source_pickup_instruction);

			//destination
			$_destination_firstname = $Str->data_in($_SUBMIT->destination_firstname);
			$_destination_lastname = $Str->data_in($_SUBMIT->destination_lastname);
			$_destination_country = $HASH->decryptAES($Str->data_in($_SUBMIT->destination_country));
			$_destination_province = $HASH->decryptAES($Str->data_in($_SUBMIT->destination_province));  
			$_destination_city = $HASH->decryptAES($Str->data_in($_SUBMIT->destination_city));
			$_destination_address_1 = $Str->data_in($_SUBMIT->destination_address_1);
			$_destination_address_2 = $Str->data_in($_SUBMIT->destination_address_2);
			$_destination_email = $Str->data_in($_SUBMIT->destination_email);
			$_destination_telephone = $Str->data_in($_SUBMIT->destination_telephone);
			$_destination_pickup_type = $HASH->decryptAES($Str->data_in($_SUBMIT->destination_pickup_type));
			$_destination_pickup_location = !Input::checkInput('destination_pickup_location', 'post',  1) ? '' : $Str->data_in($_SUBMIT->destination_pickup_location);
			$_destination_pickup_instruction = !Input::checkInput('destination_pickup_instruction', 'post',  1) ? '' : $Str->data_in($_SUBMIT->destination_pickup_instruction);

			$_source_company_status = !Input::checkInput('source_company_status', 'post',  1) ? '' : $Str->data_in($_SUBMIT->source_company_status);
			$_source_company_name = !Input::checkInput('source_company_name', 'post',  1) ? '' : $Str->data_in($_SUBMIT->source_company_name);
			
			$_destination_company_status = !Input::checkInput('destination_company_status', 'post',  1) ? '' : $Str->data_in($_SUBMIT->destination_company_status);
			$_destination_company_name = !Input::checkInput('destination_company_name', 'post',  1) ? '' : $Str->data_in($_SUBMIT->destination_company_name);
			
			//ship
			$_ship_label = $Str->data_in($_SUBMIT->ship_label);
			$_ship_description = !Input::checkInput('ship_description', 'post',  1) ? '' : $Str->data_in($_SUBMIT->ship_description);
			$_ship_purpose = $HASH->decryptAES($Str->data_in($_SUBMIT->ship_purpose));
			$_ship_addition_detail = !Input::checkInput('ship_additional_detail', 'post',  1) ? '' : $Str->data_in($_SUBMIT->ship_additional_detail);
			$_ship_short_description = !Input::checkInput('ship_short_description', 'post',  1) ? '' : $Str->data_in($_SUBMIT->ship_short_description);
			$_ship_item_type =  !Input::checkInput('ship_item_type', 'post',  1) ? '' : $HASH->decryptAES($Str->data_in($_SUBMIT->ship_item_type));

			//invoice
			$_invoice_number = !Input::checkInput('invoice_number', 'post',  1) ? '' : $Str->data_in($_SUBMIT->invoice_number);
			$_invoice_description = !Input::checkInput('invoice_description', 'post',  1) ? '' : $Str->data_in($_SUBMIT->invoice_description);

			//platfoms-user
			$_cns_platform = $access_data->CNSPLATFORM;
			$_cns_software = $access_data->CNSSOFTWARE;
			$_cns_b2b = $access_data->CNSB2B;
			$_cns_user = $access_data->_CNSB2C_;

			$_adminID = $_cns_user; 
			$_status = 'INITIATED';
			$_code = self::generateCode('SHIP');
			$_code_string  = self::generateQRString($_code);

			$_ship_cost = 0;

			/** Get Customer b2c ID */
			$source_b2c_profile = array(
				'platform' => $_cns_platform,
				'platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'firstname' => $_source_firstname,
				'lastname' => $_source_lastname,
				'email' => $_source_email,
				'telephone' => $_source_telephone,
				'password' => "",
			);

			$source_b2c = CNS_B2C_Controller::get_cns_b2c_by_profile($source_b2c_profile);

			$destination_b2c_profile = array(
				'platform' => $_cns_platform,
				'platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'firstname' => $_destination_firstname,
				'lastname' => $_destination_lastname,
				'email' => $_destination_email,
				'telephone' => $_destination_telephone,
				'password' => "",
			);

			$destination_b2c = CNS_B2C_Controller::get_cns_b2c_by_profile($destination_b2c_profile);

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,
				'code' => $_code,
				'code_string' => $_code_string,

				'source_company_status' => $_source_company_status,
				'source_company_name' => $_source_company_name,
				'destination_company_status' => $_destination_company_status,
				'destination_company_name' => $_destination_company_name,

				'source_b2c' => $source_b2c,
				'source_firstname' => $_source_firstname,
				'source_lastname' => $_source_lastname,
				'source_country' => $_source_country,
				'source_province' => $_source_province,
				'source_city' => $_source_city,
				'source_address_1' => $_source_address_1,
				'source_address_2' => $_source_address_2,
				'source_email' => $_source_email,
				'source_telephone' => $_source_telephone,
				'source_pickup_type' => $_source_pickup_type,
				'source_pickup_location' => $_source_pickup_location,
				'source_pickup_instruction' => $_source_pickup_instruction,

				'destination_b2c' => $destination_b2c,
				'destination_firstname' => $_destination_firstname,
				'destination_lastname' => $_destination_lastname,
				'destination_country' => $_destination_country,
				'destination_province' => $_destination_province,
				'destination_city' => $_destination_city,
				'destination_address_1' => $_destination_address_1,
				'destination_address_2' => $_destination_address_2,
				'destination_email' => $_destination_email,
				'destination_telephone' => $_destination_telephone,
				'destination_pickup_type' => $_destination_pickup_type,
				'destination_pickup_location' => $_destination_pickup_location,
				'destination_pickup_instruction' => $_destination_pickup_instruction,
				
				'ship_label' => $_ship_label,
				'ship_description' => $_ship_description,
				'ship_purpose' => $_ship_purpose,
				'ship_item_type' => $_ship_item_type,
				'ship_additional_detail' => $_ship_addition_detail,
				'ship_short_description' => $_ship_short_description,
				'ship_cost' => $_ship_cost,

				// 'invoice_number' => $_invoice_number,
				// 'invoice_description' => $_invoice_description,

				'status' => $_status,
				'creation_by' => $_adminID,
				'creation_datetime' => Dates::seconds(),
				'total_ship_items' => 0
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {

					$ShipTable->insert($_fields);
				
					$_country_name = Self::getCountryNameById($_destination_country);
					$_country_name = (object)  $_country_name;
					$destination_country_name = $_country_name->name;

					//get city name by id
					$_b2c_password = CNS_B2C_Controller::getLastID();
					$_city_name = self::getCityNameById($_destination_city);
					$_city_name = (object) $_city_name;
					$_destination_city_name = $_city_name->name;

					$_DATA_ = array(
						'firstname' => $_source_firstname,
						'email' => $_source_email,
						'destinationcity' => $_destination_city_name,
						'destinationcountry' => $destination_country_name,
						'receiverfname' => $_destination_firstname,
						'receiverlname' => $_destination_lastname,
						'address' => $_destination_address_1

					);

					CNS_EMAIL::send('CNSEMAIL.00005',  $_DATA_);

					$_cns_ship = self::getLastID('cns_express_ship');
					$_cns_ship_token = Hash::encryptAuthToken($_cns_ship);

					$_total_shop_items = 0;
					if($_SUBMIT->SHIPITEMS):
						foreach( $_SUBMIT->SHIPITEMS As $_shipitem):
							$_total_shop_items++;
							$_code_item = self::generateCode("SHIPITEM");
							
							$_shipitem->itemunit = !isset($_shipitem->itemunit) || $_shipitem->itemunit == ""?0: $HASH->decryptAES($_shipitem->itemunit);
							$_shipitem->itemcurrency = !isset($_shipitem->itemcurrency) || $_shipitem->itemcurrency == ""?0: $HASH->decryptAES($_shipitem->itemcurrency);
							
							$_shipitem->itemname  = !isset($_shipitem->itemname)?"":$_shipitem->itemname;
							$_shipitem->itemdescription  = !isset($_shipitem->itemdescription)?"":$_shipitem->itemdescription;
							$_shipitem->itemquantity  = !isset($_shipitem->itemquantity)?"":$_shipitem->itemquantity;;
							$_shipitem->itemunit  = !isset($_shipitem->itemunit)?"":$_shipitem->itemunit;;
							$_shipitem->itemvalue  = !isset($_shipitem->itemvalue)?0:$_shipitem->itemvalue;;
							$_shipitem->itemweight  = !isset($_shipitem->itemweight)?"":$_shipitem->itemweight;;
							$_shipitem->itemdimension  = !isset($_shipitem->itemdimension)?"":$_shipitem->itemdimension;;

							$_fields = array(
								'cns_platform' => $_cns_platform,
								'cns_platform_product' => $_cns_software,
								'cns_b2b' => $_cns_b2b,
								'code' => $_code_item,
								'cns_ship' => $_cns_ship, 
								'name' => $_shipitem->itemname, 
								'description' => $_shipitem->itemdescription, 
								'quantity' => $_shipitem->itemquantity, 
								'unit' => $_shipitem->itemunit,  
								'value' => $_shipitem->itemvalue,  
								'currency' => $_shipitem->itemcurrency, 
								'weight' => $_shipitem->itemweight,  
								'dimension' => $_shipitem->itemdimension,  
								'manufacture_address' => '',  
								'manufacture_name' => '', 
								'item_model' => '',
								'source' => 0,
								'commodity_code' => '',
								'status' => 'ACTIVE', 
								'creation_by' => $source_b2c,
								'creation_datetime' => Dates::today(), 
							);

							$ShipTable->insertShipItem($_fields);
						
						endforeach;
					endif;

					$_fields = array(
						'total_ship_items' => $_total_shop_items
					);
					$ShipTable->update($_fields, $_cns_ship);
					self::generateQRImage($_code, $_code_string);

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
				'SHIPTOKEN' => $_cns_ship_token,
				'ERRORS_SCRIPT' => ""
			];
		}
	}

	//update shipmennt
	public static function editShip($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SUBMIT[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SUBMIT,
			array(
				'source_firstname' => array(
					'name' => 'Source first name',
					'required' => true
				), 
				'source_lastname' => array(
					'name' => 'Source last name',
					'required' => true
				), 
				'source_country' => array(
					'name' => 'Source country',
					'required' => true
				), 
				'source_province' => array(
					'name' => 'Source province',
					'required' => true
				), 
				'source_city' => array(
					'name' => 'Source city',
					'required' => true
				), 
				'source_address_1' => array(
					'name' => 'Source address 1',
					'required' => true
				), 
				'source_email' => array(
					'name' => 'Source email',
					'required' => true
				), 
				'source_telephone' => array(
					'name' => 'Source telephone',
					'required' => true
				), 
				'destination_firstname' => array(
					'name' => 'Destination first name',
					'required' => true
				), 
				'destination_lastname' => array(
					'name' => 'Destination last name',
					'required' => true
				), 
				'destination_country' => array(
					'name' => 'Destination country',
					'required' => true
				), 
				'destination_province' => array(
					'name' => 'Destination province',
					'required' => true
				), 
				'destination_city' => array(
					'name' => 'Destination city',
					'required' => true
				), 
				'destination_address_1' => array(
					'name' => 'Destination address 1',
					'required' => true
				), 
				'destination_email' => array(
					'name' => 'Destination email',
					'required' => true
				), 
				'destination_telephone' => array(
					'name' => 'Destination telephone',
					'required' => true
				), 
				'source_pickup_type' => array(
					'name' => 'Source pickup type',
					'required' => true
				), 
			)
		);

		if ($validation->passed()) {
			$ShipTable = new \CNS_SHIP();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SUBMIT = (object) $_SUBMIT;
			$HASH = new \Hash();

			//ship id
			$_ID = $HASH->decryptAES($Str->data_in($_SUBMIT->_id_));

			//source
			$_source_firstname = $Str->data_in($_SUBMIT->source_firstname);
			$_source_lastname = $Str->data_in($_SUBMIT->source_lastname);
			$_source_country = $HASH->decryptAES($Str->data_in($_SUBMIT->source_country));
			$_source_province = $HASH->decryptAES($Str->data_in($_SUBMIT->source_province));  
			$_source_city = $HASH->decryptAES($Str->data_in($_SUBMIT->source_city));
			$_source_address_1 = $Str->data_in($_SUBMIT->source_address_1);
			$_source_address_2 = $Str->data_in($_SUBMIT->source_address_2);
			$_source_email = $Str->data_in($_SUBMIT->source_email);
			$_source_telephone = $Str->data_in($_SUBMIT->source_telephone);
			$_source_pickup_type = $HASH->decryptAES($Str->data_in($_SUBMIT->source_pickup_type));
			$_source_pickup_location = !Input::checkInput('source_pickup_location', 'post',  1) ? '' : $Str->data_in($_SUBMIT->source_pickup_location);
			$_source_pickup_instruction = !Input::checkInput('source_pickup_instruction', 'post',  1) ? '' : $Str->data_in($_SUBMIT->source_pickup_instruction);

			//destination
			$_destination_firstname = $Str->data_in($_SUBMIT->destination_firstname);
			$_destination_lastname = $Str->data_in($_SUBMIT->destination_lastname);
			$_destination_country = $HASH->decryptAES($Str->data_in($_SUBMIT->destination_country));
			$_destination_province = $HASH->decryptAES($Str->data_in($_SUBMIT->destination_province));  
			$_destination_city = $HASH->decryptAES($Str->data_in($_SUBMIT->destination_city));
			$_destination_address_1 = $Str->data_in($_SUBMIT->destination_address_1);
			$_destination_address_2 = $Str->data_in($_SUBMIT->destination_address_2);
			$_destination_email = $Str->data_in($_SUBMIT->destination_email);
			$_destination_telephone = $Str->data_in($_SUBMIT->destination_telephone);
			$_destination_pickup_type = $HASH->decryptAES($Str->data_in($_SUBMIT->destination_pickup_type));
			$_destination_pickup_location = !Input::checkInput('destination_pickup_location', 'post',  1) ? '' : $Str->data_in($_SUBMIT->destination_pickup_location);
			$_destination_pickup_instruction = !Input::checkInput('destination_pickup_instruction', 'post',  1) ? '' : $Str->data_in($_SUBMIT->destination_pickup_instruction);

			$_source_company_status = !Input::checkInput('source_company_status', 'post',  1) ? '' : $Str->data_in($_SUBMIT->source_company_status);
			$_source_company_name = !Input::checkInput('source_company_name', 'post',  1) ? '' : $Str->data_in($_SUBMIT->source_company_name);
			
			$_destination_company_status = !Input::checkInput('destination_company_status', 'post',  1) ? '' : $Str->data_in($_SUBMIT->destination_company_status);
			$_destination_company_name = !Input::checkInput('destination_company_name', 'post',  1) ? '' : $Str->data_in($_SUBMIT->destination_company_name);
			
			//ship
			$_ship_label = $Str->data_in($_SUBMIT->ship_label);
			$_ship_description = !Input::checkInput('ship_description', 'post',  1) ? '' : $Str->data_in($_SUBMIT->ship_description);
			$_ship_purpose = $HASH->decryptAES($Str->data_in($_SUBMIT->ship_purpose));
			$_ship_addition_detail = !Input::checkInput('ship_additional_detail', 'post',  1) ? '' : $Str->data_in($_SUBMIT->ship_additional_detail);
			$_ship_short_description = !Input::checkInput('ship_short_description', 'post',  1) ? '' : $Str->data_in($_SUBMIT->ship_short_description);
			$_ship_item_type =  !Input::checkInput('ship_item_type', 'post',  1) ? '' : $HASH->decryptAES($Str->data_in($_SUBMIT->ship_item_type));

			//invoice
			$_invoice_number = !Input::checkInput('invoice_number', 'post',  1) ? '' : $Str->data_in($_SUBMIT->invoice_number);
			$_invoice_description = !Input::checkInput('invoice_description', 'post',  1) ? '' : $Str->data_in($_SUBMIT->invoice_description);

			//platfoms-user

			$_cns_platform = $access_data->cns_platform;
			$_cns_software = $access_data->cns_platform_product;
			$_cns_b2b = $access_data->cns_b2b;
			// $_cns_user = $access_data->_CNSB2C_;

			// $_adminID = $_cns_user; 

			$_ship_cost = 0;

			/** Get Customer b2c ID */
			$source_b2c_profile = array(
				'platform' => $_cns_platform,
				'platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'firstname' => $_source_firstname,
				'lastname' => $_source_lastname,
				'email' => $_source_email,
				'telephone' => $_source_telephone,
			);

			$source_b2c = CNS_B2C_Controller::edit_cns_b2c_by_profile($source_b2c_profile);

			$destination_b2c_profile = array(
				'platform' => $_cns_platform,
				'platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'firstname' => $_destination_firstname,
				'lastname' => $_destination_lastname,
				'email' => $_destination_email,
				'telephone' => $_destination_telephone,
			);

			$destination_b2c = CNS_B2C_Controller::edit_cns_b2c_by_profile($destination_b2c_profile);

			$_fields = array(
				'cns_platform' => $_cns_platform,
				'cns_platform_product' => $_cns_software,
				'cns_b2b' => $_cns_b2b,

				'source_company_status' => $_source_company_status,
				'source_company_name' => $_source_company_name,
				'destination_company_status' => $_destination_company_status,
				'destination_company_name' => $_destination_company_name,

				'source_b2c' => $source_b2c,
				'source_firstname' => $_source_firstname,
				'source_lastname' => $_source_lastname,
				'source_country' => $_source_country,
				'source_province' => $_source_province,
				'source_city' => $_source_city,
				'source_address_1' => $_source_address_1,
				'source_address_2' => $_source_address_2,
				'source_email' => $_source_email,
				'source_telephone' => $_source_telephone,
				'source_pickup_type' => $_source_pickup_type,
				'source_pickup_location' => $_source_pickup_location,
				'source_pickup_instruction' => $_source_pickup_instruction,

				'destination_b2c' => $destination_b2c,
				'destination_firstname' => $_destination_firstname,
				'destination_lastname' => $_destination_lastname,
				'destination_country' => $_destination_country,
				'destination_province' => $_destination_province,
				'destination_city' => $_destination_city,
				'destination_address_1' => $_destination_address_1,
				'destination_address_2' => $_destination_address_2,
				'destination_email' => $_destination_email,
				'destination_telephone' => $_destination_telephone,
				'destination_pickup_type' => $_destination_pickup_type,
				'destination_pickup_location' => $_destination_pickup_location,
				'destination_pickup_instruction' => $_destination_pickup_instruction,
				
				'ship_label' => $_ship_label,
				'ship_description' => $_ship_description,
				'ship_purpose' => $_ship_purpose,
				'ship_item_type' => $_ship_item_type,
				'ship_additional_detail' => $_ship_addition_detail,
				'ship_short_description' => $_ship_short_description,
				'ship_cost' => $_ship_cost,

				// 'invoice_number' => $_invoice_number,
				// 'invoice_description' => $_invoice_description,

				// 'creation_by' => $_adminID,
				'total_ship_items' => 0
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {

					//$ShipTable->update($_fields, $_ID);
				
					
					// $_country_name = Self::getCountryNameById($_destination_country);
					// $_country_name = (object)  $_country_name;
					// $destination_country_name = $_country_name->name;

					// //get city name by id
					// $_b2c_password = CNS_B2C_Controller::getLastID();
					// $_city_name = self::getCityNameById($_destination_city);
					// $_city_name = (object) $_city_name;
					// $_destination_city_name = $_city_name->name;

					// $_DATA_ = array(
					// 	'firstname' => $_source_firstname,
					// 	'email' => $_source_email,
					// 	'destinationcity' => $_destination_city_name,
					// 	'destinationcountry' => $destination_country_name,
					// 	'receiverfname' => $_destination_firstname,
					// 	'receiverlname' => $_destination_lastname,
					// 	'address' => $_destination_address_1
					// );

					//CNS_EMAIL::send('CNSEMAIL.00010',  $_DATA_);

					$_cns_ship = self::getLastID('cns_express_ship');
					$_cns_ship_token = Hash::encryptAuthToken($_cns_ship);

					$_total_shop_items = 0;

					if($_SUBMIT->SHIPITEMS):
						foreach( $_SUBMIT->SHIPITEMS As $_shipitem):
							$_total_shop_items++;
							
							$_shipitem->itemunit = !isset($_shipitem->itemunit) || $_shipitem->itemunit == ""?0: $HASH->decryptAES($_shipitem->itemunit);
							$_shipitem->itemcurrency = !isset($_shipitem->itemcurrency) || $_shipitem->itemcurrency == ""?0: $HASH->decryptAES($_shipitem->itemcurrency);
							
							$_shipitem->itemname  = !isset($_shipitem->itemname)?"":$_shipitem->itemname;
							$_shipitem->itemdescription  = !isset($_shipitem->itemdescription)?"":$_shipitem->itemdescription;
							$_shipitem->itemquantity  = !isset($_shipitem->itemquantity)?"":$_shipitem->itemquantity;;
							$_shipitem->itemunit  = !isset($_shipitem->itemunit)?"":$_shipitem->itemunit;;
							$_shipitem->itemvalue  = !isset($_shipitem->itemvalue)?0:$_shipitem->itemvalue;;
							$_shipitem->itemweight  = !isset($_shipitem->itemweight)?"":$_shipitem->itemweight;;
							$_shipitem->itemdimension  = !isset($_shipitem->itemdimension)?"":$_shipitem->itemdimension;;

							//ship item id
							$_shipitem->itemID = $HASH->decryptAES($Str->data_in($_shipitem->_id_));

							$_fields = array(
								'cns_platform' => $_cns_platform,
								'cns_platform_product' => $_cns_software,
								'cns_b2b' => $_cns_b2b,
								'cns_ship' => $_cns_ship, 
								'name' => $_shipitem->itemname, 
								'description' => $_shipitem->itemdescription, 
								'quantity' => $_shipitem->itemquantity, 
								'unit' => $_shipitem->itemunit,  
								'value' => $_shipitem->itemvalue,  
								'currency' => $_shipitem->itemcurrency, 
								'weight' => $_shipitem->itemweight,  
								'dimension' => $_shipitem->itemdimension,  
								'manufacture_address' => '',  
								'manufacture_name' => '', 
								'item_model' => '',
								'source' => 0,
								'commodity_code' => '',
								'status' => 'ACTIVE', 
								'creation_by' => $source_b2c,
								'creation_datetime' => Dates::today(), 
							);

							$ShipTable->updateShipItem($_fields, $_shipitem->itemID);
						
						endforeach;
					endif;

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
				'SHIPTOKEN' => $_ID,
				'ERRORS_SCRIPT' => ""
			];
		}
	}


	public static function delete_ship($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SUBMIT[end($ar)] = $val;
			endif;
		endforeach;

		$validation = $validate->check(
			$_SUBMIT,
			array(
				'_id_' => array(
					'name' => 'ship',
					'required' => true
				)
			)
		);

		if ($validation->passed()) {
			$ShipTable = new \CNS_SHIP();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SUBMIT = (object) $_SUBMIT;
			$HASH = new \Hash();

			$_ship_ID = $HASH->decryptAES($Str->data_in($_SUBMIT->_id_));

			$_ship_data = self::getInfoShipByID($_ship_ID);
			if (!$_ship_data)
				return (object) [
					'ERRORS' => true,
					'SUCCESS' => false,
					'ERRORS_SCRIPT' => "Invalid data"
				];
			$_ship_data = (Object) $_ship_data;

			$_ship_ID = $_ship_data->id;

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipTable->delete($_ship_ID);

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

	public static function change_status_ship($access_data)
	{
		$diagnoArray[0] = 'NO_ERRORS';
		$validate = new \Validate();
		$prfx = 'ship-';
		foreach ($_POST as $index => $val):
			$ar = explode($prfx, $index);
			if (count($ar)):
				$_SUBMIT[end($ar)] = $val;
			endif;
		endforeach;

		$_success_response_ = "";

		$validation = $validate->check($_SUBMIT, array(
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
			$ShipChangeStatusTable = new \CNS_SHIP();
			$Str = new \Str();
			$datetime = \Config::get('time/date_time');
			$_SUBMIT = (object)$_SUBMIT;

			/** Encryption Hash Class */
			$HASH = new \Hash();

			$_ID = $HASH->decryptAES($Str->data_in($_SUBMIT->_id_));
			$_status = $Str->data_in($_SUBMIT->status);
			$_status_stage = $Str->data_in($_SUBMIT->status_stage);
			$_status_comment = $Str->data_in($_SUBMIT->status_comment);


			if($_status_stage = 'INITIATION'):
				$_status_stage_next = 'SOURCE RECEPTION';
			endif;

			if($_status_stage = 'SOURCE RECEPTION'):
				$_status_stage_next = 'TRAVELLING';
			endif;

			if($_status_stage = 'SOURCE RECEPTION'):
				$_status_stage_next = 'DESTINATION ARRIVAL';
			endif;

			$update_datetime = Dates::seconds();

			$_fields = array(
				'status' => $_status,
				'status_stage' => $_status_stage,
				'status_stage_next' => $_status_stage_next,
				'update_datetime' => $update_datetime
			);

			if ($diagnoArray[0] == 'NO_ERRORS') {
				try {
					$ShipChangeStatusTable->change_status_ship($_fields, $_ID);

					$ShipLogsTable = new \CNS_SHIP();

					$_cns_platform = $access_data->cns_platform;
					$_cns_software = $access_data->cns_platform_product;
					$_cns_b2b = $access_data->cns_b2b;
					$_cns_user = $access_data->id;

					$ship_data = self::getInfoShipByID($_ID);
					
					if (!$ship_data)
						return (object) [
							'ERRORS' => true,
							'SUCCESS' => false,
							'ERRORS_SCRIPT' => "Invalid ship"
						];
						
					$ship_data = (Object) $ship_data;

					$logs_fields = array(
						'cns_platform' => $_cns_platform,
						'cns_platform_product' => $_cns_software,
						'cns_b2b' => $_cns_b2b,
						'ship' => $ship_data->token_id,
						'source_b2c' => $ship_data->source_b2c,
						'destination_b2c' => $ship_data->destination_b2c,
						'delivery_agent' => 0,
						'status' => $_status,
						'status_stage' => $_status_stage,
						'comment' => $_status_comment,
						'creation_by' => $_cns_user,
						'creation_datetime' => $update_datetime
					);					

					$ShipLogsTable->save_ship_status_ship_logs($logs_fields);

					/** Send Email To New Agent */
					/** EMAIL */
					$source_email = $ship_data->source_email;
					$source_name = $ship_data->source_firstname;

					$destination_email = $ship_data->destination_email;
					$destination_name = $ship_data->destination_firstname;

					$_DATA_ = array(
						'firstname' => $source_name,
						'email' => $source_email,
						'shipmentstatus' => $_status,
						'comment' => $_status_comment,
						'link' => 'http://afriexpressglobal.cnsplateforme.com/user/login'

					);

					CNS_EMAIL::send('CNSEMAIL.00004',  $_DATA_);

					$_DATA_ = array(
						'firstname' => $destination_name,
						'email' => $destination_email,
						'shipmentstatus' => $_status,
						'comment' => $_status_comment,
						'link' => 'http://afriexpressglobal.cnsplateforme.com/user/login'

					);

					CNS_EMAIL::send('CNSEMAIL.00004',  $_DATA_);

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
				'ERRORS_SCRIPT' => json_encode($diagnoArray)
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

	public static function getShips($_filter_condition_ = "")
	{
		$CNSROOTShipTable = new \CNS_SHIP();
		$HASH = new \Hash();
		$CNSROOTShipTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, code, source_firstname, source_lastname, (SELECT name from cns_data_country WHERE cns_express_ship.source_country = cns_data_country.id) as source_country,  (SELECT name from cns_data_province WHERE cns_express_ship.source_province = cns_data_province.id) as source_province, (SELECT name from cns_data_city WHERE cns_express_ship.source_city = cns_data_city.id) as source_city, source_address_1, source_address_2, source_email, source_telephone, source_company_status, source_company_name, destination_firstname, destination_lastname,  (SELECT name from cns_data_country WHERE cns_express_ship.destination_country = cns_data_country.id) as destination_country,  (SELECT name from cns_data_province WHERE cns_express_ship.destination_province = cns_data_province.id) as destination_province,  (SELECT name from cns_data_city WHERE cns_express_ship.destination_city = cns_data_city.id) as destination_city, destination_company_status, source_company_name, destination_company_name, destination_address_1, destination_address_2,  destination_email, destination_telephone, ship_label, ship_description,  (SELECT name FROM cns_express_ship_purpose WHERE cns_express_ship_purpose.id = cns_express_ship.ship_purpose) as ship_purpose,  (SELECT name FROM cns_express_item_type WHERE cns_express_item_type.id = cns_express_ship.ship_item_type) as ship_item_type, ship_additional_detail, ship_short_description, (SELECT name FROM cns_express_ship_pickup_type WHERE cns_express_ship_pickup_type.id = cns_express_ship.source_pickup_type) as source_pickup_type, source_pickup_location, source_pickup_instruction, (SELECT name FROM cns_express_ship_pickup_type WHERE cns_express_ship_pickup_type.id = cns_express_ship.destination_pickup_type) as destination_pickup_type, destination_pickup_location, destination_pickup_instruction, ship_cost, status, status_stage, status_stage_next, creation_by, creation_datetime FROM cns_express_ship WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTShipTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTShipTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	//ship status track list system
	public static function getShipStatusLogsList($ID)
	{
		$CNSROOTShipTable = new \CNS_SHIP();
		$HASH = new \Hash();
		$CNSROOTShipTable->selectQuery("SELECT id as token_id, (SELECT ship_label FROM cns_express_ship WHERE cns_express_ship.id = cns_express_ship_status_logs.ship ORDER BY id DESC LIMIT 1) as ship, status_stage, status, comment, creation_datetime FROM cns_express_ship_status_logs WHERE status != 'DEACTIVE' AND ship = ? ORDER BY id DESC", array($ID));
		if ($CNSROOTShipTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTShipTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	//ship status track list website
	public static function getShipStatusLogsListWeb($ID)
	{
		$CNSROOTShipTable = new \CNS_SHIP();
		$HASH = new \Hash();
		$CNSROOTShipTable->selectQuery("SELECT cns_express_ship_status_logs.id as token_id, cns_express_ship.ship_label,
		 cns_express_ship_status_logs.status_stage, cns_express_ship_status_logs.status, cns_express_ship_status_logs.comment, cns_express_ship_status_logs.creation_datetime, cns_express_ship.status as current_status
		  FROM cns_express_ship_status_logs, cns_express_ship WHERE cns_express_ship.id = cns_express_ship_status_logs.ship and cns_express_ship_status_logs.ship = ? ORDER BY cns_express_ship_status_logs.id ASC", array($ID));
		if ($CNSROOTShipTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTShipTable->data() as $list_):
				$list_->token_auth = $HASH->encryptAES($list_->token_id);
				$list_->token_id = Hash::encryptToken($list_->token_id);
				$list_->creation_datetime = date('d/m/Y  h:m:s', $list_->creation_datetime);

				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	public static function getB2CShips($_filter_condition_ = "", $_CNS_B2C)
	{
		$CNSROOTShipTable = new \CNS_SHIP();
		$HASH = new \Hash();
		$CNSROOTShipTable->selectQuery("SELECT id as ctiship, ship_label, destination_firstname, destination_lastname, (SELECT name from cns_data_country WHERE cns_express_ship.destination_country = cns_data_country.id) as destination_country, (SELECT name from cns_data_province WHERE cns_express_ship.destination_province = cns_data_province.id) as destination_province, (SELECT name from cns_data_city WHERE cns_express_ship.destination_city = cns_data_city.id) as destination_city, (SELECT count(id) FROM cns_express_ship_item WHERE cns_express_ship_item.cns_ship = cns_express_ship.id) as ship_item_count, status, status_stage, status_stage_next, creation_datetime FROM cns_express_ship WHERE (source_b2c = $_CNS_B2C OR destination_b2c = $_CNS_B2C) AND status != 'DELETED' $_filter_condition_");
		if ($CNSROOTShipTable->count()):
			$_DATA_ = array();
			foreach ($CNSROOTShipTable->data() as $list_):
				$list_->ctaship = $HASH->encryptAES($list_->ctiship);
				$list_->ctiship = Hash::encryptToken($list_->ctiship);
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);
				$_DATA_[] = (Array) $list_;
				
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	public static function getInfoShipByID($ID)
	{
		$CNSROOTShipTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipTable->selectQuery(" SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, code, source_firstname, source_lastname, source_b2c, destination_b2c, (SELECT name from cns_data_country WHERE cns_express_ship.source_country = cns_data_country.id) as source_country,  (SELECT name from cns_data_province WHERE cns_express_ship.source_province = cns_data_province.id) as source_province, (SELECT name from cns_data_city WHERE cns_express_ship.source_city = cns_data_city.id) as source_city, source_address_1, source_address_2, source_email, source_telephone, source_company_status, source_company_name, destination_firstname, destination_lastname,  (SELECT name from cns_data_country WHERE cns_express_ship.destination_country = cns_data_country.id) as destination_country,  (SELECT name from cns_data_province WHERE cns_express_ship.destination_province = cns_data_province.id) as destination_province,  (SELECT name from cns_data_city WHERE cns_express_ship.destination_city = cns_data_city.id) as destination_city, destination_company_status, source_company_name, destination_company_name, destination_address_1, destination_address_2,  destination_email, destination_telephone, ship_label, ship_description,  (SELECT name FROM cns_express_ship_purpose WHERE cns_express_ship_purpose.id = cns_express_ship.ship_purpose) as ship_purpose,  (SELECT name FROM cns_express_item_type WHERE cns_express_item_type.id = cns_express_ship.ship_item_type) as ship_item_type, ship_additional_detail, ship_short_description, (SELECT name FROM cns_express_ship_pickup_type WHERE cns_express_ship_pickup_type.id = cns_express_ship.source_pickup_type) as source_pickup_type, source_pickup_location, source_pickup_instruction, (SELECT name FROM cns_express_ship_pickup_type WHERE cns_express_ship_pickup_type.id = cns_express_ship.destination_pickup_type) as destination_pickup_type, destination_pickup_location, destination_pickup_instruction, ship_cost, status, status_stage, status_stage_next, creation_by, creation_datetime FROM cns_express_ship  WHERE id = ?", array($ID));
		if ($CNSROOTShipTable->count()):

			// return $CNSROOTShipTable->first();

			$_DATA_ = array();
			foreach ($CNSROOTShipTable->data() as $list_):
				$list_->creation_datetime = date('d/m/Y', $list_->creation_datetime);
				$_DATA_ = (Array) $list_;
				
			endforeach;
			return $_DATA_;

		endif;
		return false;
	}

	public static function getInfoShipItemByID($ID)
	{
		$CNSROOTShipTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTShipTable->selectQuery("SELECT cns_express_ship_item.name, cns_express_ship_item.quantity, cns_express_ship_item.dimension, cns_express_ship_item.description, cns_express_ship_item.value, cns_express_ship_item.weight, (SELECT name FROM cns_express_ship_unit WHERE cns_express_ship_item.unit = cns_express_ship_unit.id ) as unit, (SELECT name FROM cns_data_currency WHERE cns_data_currency.id = cns_express_ship_item.currency ) as currency FROM cns_express_ship_item, cns_express_ship WHERE cns_express_ship.id  = cns_express_ship_item.cns_ship AND cns_express_ship.id  = ?", array($ID));
		if ($CNSROOTShipTable->count()):

			$_DATA_ = array();
			foreach ($CNSROOTShipTable->data() as $list_):
				$_DATA_[] = (Array) $list_;
			endforeach;
			return $_DATA_;

		endif;
		return false;
	}

	

	public static function getShipUnits($_filter_condition_ = "")
	{
		$CNSROOTPartnerTable = new \CNS_SHIP_CLUSTER();
		$HASH = new \Hash();
		$CNSROOTPartnerTable->selectQuery("SELECT id as token_id, cns_platform, cns_platform_product, cns_b2b, code, name, status, creation_by, creation_datetime FROM cns_express_ship_unit WHERE status != 'DELETED' $_filter_condition_");
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

	public static function generateCode($TYPE = 'SHIP')
	{
		if ($TYPE == 'INVOICE')
			return 'CNSINV.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'SHIP')
			return 'CNSSHIP.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'PACKAGE-TYPE')
			return 'CNSSTYP.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'SHIP-COST')
			return 'CNSSC.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

		if ($TYPE == 'SHIP-PURPOSE')
			return 'CNSSPS.' . rand(10, 90) . date('ms') . rand(100, 999) . date('d');

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

	public static function get_data_currency_list_options($_filter_condition_ = ""){
        $CNSROOTClusterDataTable = new \CNS_CLUSTER_Data();
		$HASH = new \Hash();
        $CNSROOTClusterDataTable->selectQuery("SELECT id as cticurrency, name, description FROM cns_data_currency WHERE status != 'DELETED' $_filter_condition_");
		if ($CNSROOTClusterDataTable->count()):
			$_DATA_ = array();
			foreach( $CNSROOTClusterDataTable->data() As $list_ ):
				$list_->ctacurrency   = $HASH->encryptAES($list_->cticurrency);
				$list_->cticurrency   	 = Hash::encryptToken($list_->cticurrency);
				$_DATA_[] 					= (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	public static function cns_ship_company_data($_filter_condition_ = "")
	{
		$CNSSHIPTABLE = new \CNS_SHIP();
		$HASH = new \Hash();
		$CNSSHIPTABLE->selectQuery("SELECT cns_b2b as ctib2b, cns_platform as ctiplatform, cns_platform_product as ctisoftware, currency_id as cticurrency, currency, currency_name, country_id as cticountry, country_name, province_id as ctiprovince, province_name, city_id as cticity, city_name, status, code, b2b_code, company_name, company_email, company_telephone, company_logo, language, address, facebook, instagram, tweeter, youtube, whatsapp, linkedin, snapchat, tiktok FROM cns_views_cluster_b2b WHERE status != 'DELETED' $_filter_condition_ ORDER BY cns_b2b DESC LIMIT 1");
		if ($CNSSHIPTABLE->count()):
			$_DATA_ = array();
			foreach ($CNSSHIPTABLE->data() as $list_):
				$list_->ctaplatform = $HASH->encryptAES($list_->ctiplatform);
				$list_->ctiplatform = Hash::encryptToken($list_->ctiplatform);
				$list_->ctasoftware = $HASH->encryptAES($list_->ctisoftware);
				$list_->ctisoftware = Hash::encryptToken($list_->ctisoftware);
				$list_->ctab2b = $HASH->encryptAES($list_->ctib2b);
				$list_->ctib2b = Hash::encryptToken($list_->ctib2b);

				$list_->ctacountry = $HASH->encryptAES($list_->cticountry);
				$list_->cticountry = Hash::encryptToken($list_->cticountry);
				$list_->ctaprovince = $HASH->encryptAES($list_->ctiprovince);
				$list_->ctiprovince = Hash::encryptToken($list_->ctiprovince);
				$list_->ctacity = $HASH->encryptAES($list_->cticity);
				$list_->cticity = Hash::encryptToken($list_->cticity);

				$list_->ctacurrency = $HASH->encryptAES($list_->cticurrency);
				$list_->cticurrency = Hash::encryptToken($list_->cticurrency);

				$_DATA_ = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	//get country name by id
	public static function getCountryNameById($_country_name)
	{
		$CNSROOTShipTable = new \CNS_SHIP();
		$HASH = new \Hash();
		$CNSROOTShipTable->selectQuery("SELECT name FROM cns_data_country WHERE cns_data_country.id = $_country_name" );
		if ($CNSROOTShipTable->count()):
			return $CNSROOTShipTable->first();
		endif;
		return false;
	}

	//get city name by id
	public static function getCityNameById($_city_name)
	{
		$CNSROOTShipTable = new \CNS_SHIP();
		$HASH = new \Hash();
		$CNSROOTShipTable->selectQuery("SELECT name FROM cns_data_city WHERE cns_data_city.id = $_city_name" );
		if ($CNSROOTShipTable->count()):
			return $CNSROOTShipTable->first();
		endif;
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


	public static function generateQRString($qr_code){
        $qr_string = strtoupper(hash_hmac('SHA256', $qr_code, pack('H*',3061995)));
        return $qr_string;
    }

    public static function generateQrID($ticket_ID){
        return "CNSSHIP0".rand(0,9).$ticket_ID."".date("s")."0".rand(1,9).date("d").rand(20,90).rand(20,90);
    }

	public static function generateQRImage($_qrID_, $_qrEncoded_){
		$_DR_		   = Config::get('filepath/shipqr/');
		$_qrFilename_  = $_qrID_.".png";
		$_qrFile_ 	   = $_DR_.$_qrFilename_;
		QRcode::png($_qrEncoded_, $_qrFile_);
	}



}



