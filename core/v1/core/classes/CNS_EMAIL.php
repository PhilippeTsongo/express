<?php
class CNS_EMAIL
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
				} else {
					//logout
				}
			}
		} else {
			$this->find_user($user);
		}
	}

	# create email content
	public function insert_email_content($fields = array())
	{
		if (!$this->_db->insert('cns_emails_content', $fields))
			throw new Exception("There was a problem creating an account.");
	}

	# update email content
	public function update_email_content($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_emails_content', $id, $fields))
			throw new Exception('There was a problem updating');
	}

	# delete email content
	public function delete_email_content($id = null)
	{
		if (!$this->_db->delete('cns_emails_content', array('id', '=', $id)))
			throw new Exception('There was a problem deleting');
	}

	# change status of email content
	public function change_status_email_content($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_emails_content', $id, $fields))
			throw new Exception('There was a problem deleting');
	}


	# create email template
	public function insert_email_template($fields = array())
	{
		if (!$this->_db->insert('cns_email_templates', $fields))
			throw new Exception("There was a problem creating an account.");
	}

	# update email template
	public function update_email_template($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_email_templates', $id, $fields))
			throw new Exception('There was a problem updating');
	}

	# delete email template
	public function delete_email_template($id = null)
	{
		if (!$this->_db->delete('cns_email_templates', array('id', '=', $id)))
			throw new Exception('There was a problem deleting');
	}

	# change status of email template
	public function change_status_email_template($fields = array(), $id = null)
	{
		if (!$this->_db->update('cns_email_templates', $id, $fields))
			throw new Exception('There was a problem deleting');
	}

	# FIND USER
	public function find($user = null)
	{
		if ($user) {
			$hit = false;
			if (is_numeric($user)) {
				$field = 'ID';
				$data = $this->_db->get('cns_emails_content', array($field, '=', $user));
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			} else if (filter_var($user, FILTER_VALIDATE_EMAIL) == true) {
				$field = 'email';
				$data = $this->_db->get('cns_emails_content', array($field, '=', $user), $limit = "");
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			} else {
				$userClass = new \CNS_EMAIL();
				$userClass->select("WHERE `username` = '{$user}' LIMIT 1");
				if ($userClass->count()) {
					$this->_data = $userClass->first();
					$hit = true;
				}
			}

		}
		return false;
	}

	# FIND USER
	public function find_user($user = null, $fields = array())
	{
		$table = "cns_emails_content";
		if ($user) {
			$hit = false;
			if (is_numeric($user)) {
				$field = 'ID';
				$data = $this->_db->get($fields, $table, array($field, '=', $user));
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			} elseif (filter_var($user, FILTER_VALIDATE_EMAIL) == true) {
				$field = 'email';
				$data = $this->_db->get($fields, $table, array($field, '=', $user));
				if ($data->count()) {
					$this->_data = $data->first();
					$hit = true;
				}
			} else {
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

	# Select
	public function select($sql = null, $params = array())
	{
		$data = $this->_db->query("SELECT* FROM `cns_emails_content` {$sql}", $params);
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

	public static function send($_EMAILCODE_, $_DATA_)
	{
		$Email = new \Email();
		$_DATA_ = (Object) $_DATA_;
		$_EMAILOBJ_ = CNS_EMAIL_Controller::getInfoEmailContent($_EMAILCODE_);
		$_Message_ = self::cnsemailbody($_EMAILOBJ_->code, $_DATA_);
		return $Email->send($_EMAILOBJ_->subject, $_Message_, $_DATA_->email, $_DATA_->firstname);
	}

	public static function cnsemailbody($emailfile, $data)
	{
		$mailbody = file_get_contents(EMAILFILE . $emailfile . '.html');
		$data = (Object) $data;
		$body = $mailbody;

		$body = !(strpos($body, '$__FIRSTNAME__')) ? $body : str_replace('$__FIRSTNAME__', $data->firstname, $body);
		$body = !(strpos($body, '$__EMAIL__')) ? $body : str_replace('$__EMAIL__', $data->email, $body);
		$body = !(strpos($body, '$__PASSWORD__')) ? $body : str_replace('$__PASSWORD__', $data->password, $body);
		$body = !(strpos($body, '$__LINK__')) ? $body : str_replace('$__LINK__', $data->link, $body);
		$body = !(strpos($body, '$__B2B__')) ? $body : str_replace('$__B2B__', $data->b2b, $body);

		$body = !(strpos($body, '$__PRODUCTNAME__')) ? $body : str_replace('$__PRODUCTNAME__', $data->productname, $body);
		$body = !(strpos($body, '$__ORDERNUMBER__')) ? $body : str_replace('$__ORDERNUMBER__', $data->ordernumber, $body);
		$body = !(strpos($body, '$__ORDERDATE__')) ? $body : str_replace('$__ORDERDATE__', $data->orderdate, $body);
		$body = !(strpos($body, '$__QUANTITY__')) ? $body : str_replace('$__QUANTITY__', $data->quantity, $body);
		$body = !(strpos($body, '$__PRICE__')) ? $body : str_replace('$__PRICE__', $data->price, $body);

		
		$body = !(strpos($body, '$__DESTINATIONCOUNTRY__')) ? $body : str_replace('$__DESTINATIONCOUNTRY__', $data->destinationcountry, $body);
		$body = !(strpos($body, '$__DESTINATIONPROVINCE__')) ? $body : str_replace('$__DESTINATIONPROVINCE__', $data->destinationprovince, $body);
		$body = !(strpos($body, '$__DESTIONATIONCITY__')) ? $body : str_replace('$__DESTIONATIONCITY__', $data->destinationcity, $body);
		$body = !(strpos($body, '$__ADDRESS__')) ? $body : str_replace('$__ADDRESS__', $data->address, $body);
		$body = !(strpos($body, '$__RECEIVERFIRSTNAME__')) ? $body : str_replace('$__RECEIVERFIRSTNAME__', $data->receiverfname, $body);
		$body = !(strpos($body, '$__RECEIVERLASTNAME__')) ? $body : str_replace('$__RECEIVERLASTNAME__', $data->receiverlname, $body);
		$body = !(strpos($body, '$__SHIPMENTSTATUS__')) ? $body : str_replace('$__SHIPMENTSTATUS__', $data->shipmentstatus, $body);
		$body = !(strpos($body, '$__EMAILSUBJECT__')) ? $body : str_replace('$__EMAILSUBJECT__', $data->emailsubject, $body);
		$body = !(strpos($body, '$__EMAILDESCRIPTION__')) ? $body : str_replace('$__EMAILDESCRIPTION__', $data->description, $body);
		
		$body = !(strpos($body, '$__COMMENT__')) ? $body : str_replace('$__COMMENT__', $data->comment, $body);
		$body = !(strpos($body, '$__TABLE__')) ? $body : str_replace('$__TABLE__', $data->table, $body);

		return $body;
	}
}
?>