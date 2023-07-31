<?php
class UserToken
{
	private $_db,
			$_data,
			$contactID,
			$_count = 0,
			$_errors = array();

	public function __construct($contact_ID = ''){
		$this->_db = DB::getInstance();
		if($contact_ID){
			$this->contactID = $contact_ID;
			$this->get($contact_ID);
		}
	}

//ADD new
	public function insert($fields = array()){
		if(!$this->_db->insert('app_user_token', $fields)){
			throw new Exception("There was a problem registering a Contact.");
		}
	}

// UPDATE
	public function update($fields = array(),$id = null){
		if(!$this->_db->update('app_user_token',$id,$fields)){
			throw new Exception('There was a problem updating');
		}
	}

// select
	public function select($fields=array(),$sql = null,$params = array()){
		$fields_str = DB::arrayToFields($fields);
		$data = $this->_db->query("SELECT {$fields_str} FROM `app_user_token` {$sql}",$params);
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->results();
		}
	}
// get
	public function get($contact_ID){
		$data = $this->_db->get('app_user_token',array('id','=',$contact_ID));
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->first();
		}
	}

// DELETE
	public function delete($id){
		if(!$this->_db->delete('app_user_token',array('id', '=', $id))){
			throw new Exception('There was a problem deleting');
		}
	}

// data
	public function data(){
		return $this->_data;
	}
// first
	public function first(){
		$data = (array)$this->data();
		if(isset($data[0])){
			return $data[0];
		}
		return '';
	}
// count
	public function count(){
		return $this->_count;
	}

// ADD ERRORS NOTIF
	private function addError($error){
		$this->_errors[] = $error;
	}
// ERROR COLLECT
	public function errors(){
		return $this->_errors;
	}


}
?>
