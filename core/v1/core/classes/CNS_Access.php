<?php
class CNS_Access
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
				}
			}
		}
		else {
			$this->find_user($user);
		}
	}

	# USER CREATE LEVEL
	public function insert_level($fields = array())
	{
		if (!$this->_db->insert('cns_access_level', $fields)) 
			throw new Exception("There was a problem creating");
	}

	# UPDATE LEVEL
	public function update_level($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_access_level', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# USER CREATE AN ACCOUNT
	public function insert_task($fields = array())
	{
		if (!$this->_db->insert('cns_access_task', $fields)) 
			throw new Exception("There was a problem creating");
	}

	# USER DATA UPDATE
	public function update_task($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_access_task', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# USER CREATE AN ACCOUNT
	public function insert_level_task($fields = array())
	{
		if (!$this->_db->insert('cns_access_level_task', $fields)) 
			throw new Exception("There was a problem creating");
	}

	# USER DATA UPDATE
	public function update_level_task($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_access_level_task', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	# USER DATA UPDATE
	public function recoverPassword($fields = array(), $id = null)
	{

		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}
		else {
		//Admin Of A group Came Update
		}

		if (!$this->_db->update('cns_cluster_platform', $id, $fields)) {
			throw new Exception('There was a problem updating');
		}
	}

	# FIND USER
	public function find($user = null)
	{
		if ($user) {
			$hit = false;
			if (is_numeric($user)) {
				$field = 'ID';
				$data = $this->_db->get('cns_cluster_platform', array($field, '=', $user));
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			}
			else if (filter_var($user, FILTER_VALIDATE_EMAIL) == true) {
				$field = 'email';
				$data = $this->_db->get('cns_cluster_platform', array($field, '=', $user), $limit = "");
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
		$table = "cns_cluster_platform";
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
		$data = $this->_db->query("SELECT* FROM `cns_cluster_platform` {$sql}", $params);
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
		$data =  (array) $this->data();
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
