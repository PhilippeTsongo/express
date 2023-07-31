<?php
class CNS_SHIP_CLUSTER
{
	private $_db,
	$_data,
	$_count = 0,
	$_sessionName,
	$_cookieName,
	$_isLoggedIn,
	$_errors = array();

	public function __construct($user = null)
	{
		$this->_db = DB::getInstance();

		$this->_sessionName = Config::get('session/admin');
		$this->_cookieName = Config::get('remember/cookie_name');

		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				if ($this->find_user($user)) {
					$this->_isLoggedIn = true;
				}
				else {
				//logout
				}
			}
		}
		else {
			$this->find_user($user);
		}
	}

	# CREATE PATNER
	public function send_message($fields = array())
	{
		if (!$this->_db->insert('cns_express_contact_message', $fields)) 
			throw new Exception("There was a problem seding message.");
	}

	# CREATE PATNER
	public function insert_partner($fields = array())
	{
		if (!$this->_db->insert('cns_express_partners', $fields)) 
			throw new Exception("There was a problem creating an account.");
	}

	# UPDATE PATNER
	public function update_partner($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_partners', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE PATNER
	public function delete_partner($id = null)
	{
		if (!$this->_db->delete('cns_express_partners', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE STATUS PATNER
	public function change_status_partner($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_partners', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# CREATE ITEM TYPE
	public function insert_item_type($fields = array())
	{
		if (!$this->_db->insert('cns_express_item_type', $fields)) 
			throw new Exception("There was a problem creating an account.");
	}

	# UPDATE ITEM TYPE
	public function update_item_type($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_item_type', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE ITEM TYPE
	public function delete_item_type($id = null)
	{
		if (!$this->_db->delete('cns_express_item_type', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE ITEM TYPE 
	public function change_status_item_type($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_item_type', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# CREATE PACKAGE TYPE
	public function insert_package_type($fields = array())
	{
		if (!$this->_db->insert('cns_express_package_type', $fields)) 
			throw new Exception("There was a problem creating an account.");
	}

	# UPDATE PACKAGE TYPE
	public function update_package_type($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_package_type', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# CHANGE STATUS PACKAGE TYPE
	public function change_status_package_type($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_package_type', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE PACKAGE TYPE
	public function delete_package_type($id = null)
	{
		if (!$this->_db->delete('cns_express_package_type', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CREATE SHIP COST 
	public function insert_ship_cost($fields = array())
	{
		if (!$this->_db->insert('cns_express_ship_cost', $fields)) 
			throw new Exception("There was a problem creating an account.");
	}

	# UPDATE SHIP COST 
	public function update_ship_cost($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_ship_cost', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE SHIP COST 
	public function delete_ship_cost($id = null)
	{
		if (!$this->_db->delete('cns_express_ship_cost', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE STATUS SHIP COST 
	public function change_status_ship_cost($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_ship_cost', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# CREATE COST ITEM
	public function insert_ship_cost_item($fields = array())
	{
		if (!$this->_db->insert('cns_express_ship_cost_item', $fields)) 
			throw new Exception("There was a problem creating an account.");
	}

	# UPDATE COST ITEM
	public function update_ship_cost_item($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_ship_cost_item', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# CHANGE STATUS SHIP COST ITEM 
	public function change_status_ship_cost_item($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_ship_cost_item', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE COST ITEM
	public function delete_ship_cost_item($id = null)
	{
		if (!$this->_db->delete('cns_express_ship_cost_item', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CREATE SHIP PURPOSE
	public function insert_ship_purpose($fields = array())
	{
		if (!$this->_db->insert('cns_express_ship_purpose', $fields)) 
			throw new Exception("There was a problem creating an account.");
	}

	# UPDATE SHIP PURPOSE
	public function update_ship_purpose($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_ship_purpose', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE SHIP PURPOSE
	public function delete_ship_purpose($id = null)
	{
		if (!$this->_db->delete('cns_express_ship_purpose', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE STATUS SHIP PURPOSE
	public function change_status_ship_purpose($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_ship_purpose', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}


	# CREATE SHIP ITEMS
	public function insert_ship_item($fields = array())
	{
		if (!$this->_db->insert('cns_express_ship_item', $fields)) 
			throw new Exception("There was a problem creating.");
	}

	# UPDATE SHIP ITEMS
	public function update_ship_item($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_ship_item', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE SHIP ITEMS
	public function delete_ship_item($id = null)
	{
		if (!$this->_db->delete('cns_express_ship_item', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE STATUS SHIP ITEMS
	public function change_status_ship_item($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_ship_item', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	

	# CREATE SHIP ITEMS
	public function insert_product_prohibited($fields = array())
	{
		if (!$this->_db->insert('cns_express_product_prohibited', $fields)) 
			throw new Exception("There was a problem creating.");
	}

	# UPDATE SHIP ITEMS
	public function update_product_prohibited($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_product_prohibited', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE SHIP ITEMS
	public function delete_product_prohibited($id = null)
	{
		if (!$this->_db->delete('cns_express_product_prohibited', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE STATUS SHIP ITEMS
	public function change_status_product_prohibited($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_product_prohibited', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}



	# CREATE B2B INFO
	public function insert_b2b_info($fields = array())
	{
		if (!$this->_db->insert('cns_cluster_b2b_info', $fields)) 
			throw new Exception("There was a problem creating.");
	}

	# UPDATE B2B INFO
	public function update_b2b_info($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_cluster_b2b_info', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE B2B INFO
	public function delete_b2b_info($id = null)
	{
		if (!$this->_db->delete('cns_cluster_b2b_info', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE B2B INFO
	public function change_status_b2b_info($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_cluster_b2b_info', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}



	# CREATE SHIP PACKAGE
	public function insert_ship_package($fields = array())
	{
		if (!$this->_db->insert('cns_express_package', $fields)) 
			throw new Exception("There was a problem creating.");
	}

	# UPDATE SHIP PACKAGE
	public function update_ship_package($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_package', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE SHIP PACKAGE
	public function delete_ship_package($id = null)
	{
		if (!$this->_db->delete('cns_express_package', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE STATUS SHIP PACKAGE
	public function change_status_ship_package($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_package', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}


	# CREATE WORKING SOURCE
	public function insert_source_country($fields = array())
	{
		if (!$this->_db->insert('cns_express_working_source_country', $fields)) 
			throw new Exception("There was a problem creating.");
	}

	# UPDATE WORKING SOURCE
	public function update_source_country($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_working_source_country', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE WORKING SOURCE
	public function delete_source_country($id = null)
	{
		if (!$this->_db->delete('cns_express_working_source_country', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE WORKING SOURCE
	public function change_status_source_country($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_working_source_country', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}



	# CREATE WORKING DESTINATION
	public function insert_destination_country($fields = array())
	{
		if (!$this->_db->insert('cns_express_working_destination_country', $fields)) 
			throw new Exception("There was a problem creating.");
	}

	# UPDATE WORKING SOURCE
	public function update_destination_country($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_working_destination_country', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE WORKING SOURCE
	public function delete_destination_country($id = null)
	{
		if (!$this->_db->delete('cns_express_working_destination_country', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE WORKING SOURCE
	public function change_status_destination_country($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_working_destination_country', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}



	
	# CREATE SHIP UNIT
	public function insert_ship_unit($fields = array())
	{
		if (!$this->_db->insert('cns_express_ship_unit', $fields)) 
			throw new Exception("There was a problem creating.");
	}

	# UPDATE SHIP UNIT
	public function update_ship_unit($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_ship_unit', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE SHIP UNIT
	public function delete_ship_unit($id = null)
	{
		if (!$this->_db->delete('cns_express_ship_unit', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE SHIP UNIT
	public function change_status_ship_unit($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_ship_unit', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}
	


	# CREATE DELIVERY AGENT
	public function insert_delivery_agent($fields = array())
	{
		if (!$this->_db->insert('cns_express_delivery_agent', $fields)) 
			throw new Exception("There was a problem creating.");
	}

	# UPDATE DELIVERY AGENT
	public function update_delivery_agent($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_delivery_agent', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# DELETE DELIVERY AGENT
	public function delete_delivery_agent($id = null)
	{
		if (!$this->_db->delete('cns_express_delivery_agent', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}

	# CHANGE DELIVERY AGENT
	public function change_status_delivery_agent($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_express_delivery_agent', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}
	



	# CREATE USERS LOGS
	public function insert_users_logs($fields = array())
	{
		if (!$this->_db->insert('app_user_logs', $fields)) 
			throw new Exception("There was a problem creating.");
	}

	# DELETE USERS LOGS
	public function delete_users_logs($id = null)
	{
		if (!$this->_db->delete('app_user_logs', array('id', '=', $id))) 
			throw new Exception('There was a problem deleting');
	}





	# FIND USER

	# FIND USER
	public function find($user = null)
	{
		if ($user) {
			$hit = false;
			if (is_numeric($user)) {
				$field = 'ID';
				$data = $this->_db->get('cns_store_product', array($field, '=', $user));
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			}
			else if (filter_var($user, FILTER_VALIDATE_EMAIL) == true) {
				$field = 'email';
				$data = $this->_db->get('cns_store_product', array($field, '=', $user), $limit = "");
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			}
			else {
				$userClass = new \CNS_ROOT_Account();
				$userClass->select("WHERE `username` = '{$user}' LIMIT 1");
				if ($userClass->count()) {
					$this->_data = $userClass->first();
					$hit = true;
				}
			}

			if ($hit == false) {
				if ($this->findUserByPhone($user)) {
					return true;
				}
			}
			else {
				return true;
			}
		}
		return false;
	}

	# FIND USER
	public function find_user($user = null, $fields = array())
	{
		$table = "cns_store_product";
		if ($user) {
			$hit = false;
			if (is_numeric($user)) {
				$field = 'ID';
				$data = $this->_db->get($fields, $table, array($field, '=', $user));
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			}
			elseif (filter_var($user, FILTER_VALIDATE_EMAIL) == true) {
				$field = 'email';
				$data = $this->_db->get($fields, $table, array($field, '=', $user));
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			}
			else {
				// $field = 'username';
				$field = 'email';
				$data = $this->_db->get($fields, $table, array($field, '=', $user));
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			}

			if ($hit == true) {
				return true;
			}
		}
		return false;
	}

	# FIND USER
	public function findUserByPhone($user = null)
	{
		if ($user) {
			$userClass = new \CNS_ROOT_Account();
			$userClass->select("WHERE `telephone`='{$user}' LIMIT 1");
			if ($userClass->count()) {
				$this->_data = $userClass->first();
				return true;
			}
		}
		return false;
	}


	public function isCurrentSession($user_ID)
	{
		$id = Session::get(Config::get('session/admin'));
		if ($user_ID == $id) {
			return true;
		}
		return false;

	}

	# Select
	public function select($sql = null, $params = array())
	{
		$data = $this->_db->query("SELECT* FROM `cns_store_stock` {$sql}", $params);
		if ($data->count()) {
			$this->_count = $data->count();
			$this->_data = $data->results();
		}
	}

	# Select
	public function selectQuery($sql, $params = array())
	{
		$data = $this->_db->query($sql, $params);
		if ($data->count()) {
			$this->_count = $data->count();
			$this->_data = $data->results();
		}
	}


	public function exists()
	{
		return (!empty($this->_data)) ? true : false;
	}


	# CHECK USER LOGGED IN
	public function isLoggedIn()
	{
		return $this->_isLoggedIn;
	}

	# DATA COLLECT
	public function data()
	{
		return $this->_data;
	}

	# first
	public function first()
	{
		$data = (array) $this->data();
		if (isset($data[0])) {
			return $data[0];
		}
		return '';
	}

	# DATA COUNT
	public function count()
	{
		return $this->_count;
	}

	# ADD ERRORS NOTIF
	private function addError($error)
	{
		$this->_errors[] = $error;
	}

	# ERROR COLLECT
	public function errors()
	{
		return $this->_errors;
	}
}
?>
