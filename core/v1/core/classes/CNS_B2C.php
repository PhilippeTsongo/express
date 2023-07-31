<?php
class CNS_B2C
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

	#  CREATE 
	public function insert($fields = array())
	{
		if (!$this->_db->insert('cns_b2c_customer', $fields)) 
			throw new Exception("There was a problem creating an account.");
	}

	#  DATA UPDATE
	public function update($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_b2c_customer', $id, $fields)) 
			throw new Exception('There was a problem updating');
	}

	public function updateMultiple($fields = array(), $conditions = array()){
		if(!$this->_db->updateMultiple('cns_b2c_customer', $conditions, $fields))
			throw new Exception('There was a problem updating');
	}

	#  UPDATE
	public function recoverPassword($fields = array(), $id = null)
	{

		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}
		else {
		//Admin Of A group Came Update
		}

		if (!$this->_db->update('cns_b2c_customer', $id, $fields)) {
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
				$data = $this->_db->get('cns_b2c_customer', array($field, '=', $user));
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			}
			else if (filter_var($user, FILTER_VALIDATE_EMAIL) == true) {
				$field = 'email';
				$data = $this->_db->get('cns_b2c_customer', array($field, '=', $user), $limit = "");
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
		$table = "cns_b2c_customer";
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
		$data = $this->_db->query("SELECT* FROM `cns_b2c_customer` {$sql}", $params);
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

	# USER LOGIN
	public function login($username = null, $password = null, $remember = false)
	{
		$time = Config::get('time/temp');
		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->ID);
			$userID = $this->data()->ID;

			$userTokenClass = new UserToken();
			$userTokenClass->select(array('id', 'user_id'), "WHERE `user_id`= ? ", array($userID));
			if (!$userTokenClass->count()) {
				$token_hash = Hash::unique();
				$userTokenClass->insert(array('user_id' => $userID, 'hash' => $token_hash));
			}
		}
		else {
			$user = $this->find_user($username);
			if ($user) {
				if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
					Session::put($this->_sessionName, $this->data()->ID);

					$userID = $this->data()->ID;
					$this->updateAccountAccess($userID, 'IN');

					// $userTokenClass = new UserToken();
					// $userTokenClass->select(array('id', 'user_id'), "WHERE `user_id`= ? ", array($userID));
					// if (!$userTokenClass->count()) {
					// 	$token_hash = Hash::unique();
					// 	$userTokenClass->insert(array('user_id' => $userID, 'hash' => $token_hash));
					// }
					// Set last login

					// $pageviewClass = new PageView();
					// $page_type = 'Logged In';
					// $page_item_ID = 2;

					// $grab_info = 'Username: ' . $username;

					// $pageviewClass->insert(array('page_id' => $page_item_ID,
					// 	'user_id' => $userID,
					// 	'email' => $username,
					// 	'type' => $page_type,
					// 	'grabbed_info' => $grab_info));

					return true;

				}
				else {
					$this->addError('Wrong Password');
					return 'password--';
				}
			}
			else {
				$this->addError('That username doesn\'t exist');
				return 'username';
			}
		}
		return false;
	}


	public function exists()
	{
		return (!empty($this->_data)) ? true : false;
	}

	// USER LOGOUT
	public function logout()
	{
		$sessionName = Config::get('session/admin');
		$cookieName = Config::get('remember/cookie_name');
		if (Session::exists($sessionName)) {

			$user_ID = Session::get($this->_sessionName);
			$this->_db->delete('user_session', array('user_id', '=', $user_ID));
			$this->updateAccountAccess($user_ID, 'OUT');
			Session::delete($this->_sessionName);

			$userTokenClass = new UserToken();
			$userTokenClass->select(array('ID', 'user_id'), "WHERE `user_id`= ? ", array($user_ID));
			if ($userTokenClass->count()) {
				$usertoken_data = $userTokenClass->first();
				$userTokenClass->delete($usertoken_data->ID);
			}
		}
		Cookie::delete($this->_cookieName);
	}

	public function updateAccountAccess($account_id, $_state_ = 'IN')
	{
		if ($_state_ == 'IN') {
			$_session_account_ = array(
				'last_access' => Dates::seconds(),
				'last_login' => Dates::seconds(),
				'account_session' => 1,
			);
		}
		else {
			$_session_account_ = array(
				'account_session' => 0,
			);
		}
		$this->update($_session_account_, $account_id);
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