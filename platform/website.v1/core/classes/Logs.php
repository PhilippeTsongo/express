<?php
/**
 * Logs
 * @package SOLGLOBAL CLASSES
 * @author Ezechiel Kalengya Kapanga Ezpk [ezechielkalengya@gmail.com]
 * 2020-11-13
 */
class Logs
{
	private $_db,
			$_data,
			$_count = 0,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn,
			$_errors = array();

	public function __construct($user = null){
		$this->_db = DB::getInstance();

		if($user){
			//$this->find($user);
		}
	}

	/**
	 * @method insert
	 * @param Array Fields
	 * @return Exception Message if errors
	 */
	public function insert($fields = array()){
		if(!$this->_db->insert('app_user_logs', $fields)){
			throw new Exception("There was a problem inserting.");
		}
	}

	/**
	 * @method update
	 * @param Array Fields
	 * @param Int ID
	 * @return Exception Message if errors
	 */
	public function update($fields = array(),$id = null){
		if(!$this->_db->update('app_user_logs',$id,$fields)){
			throw new Exception('There was a problem updating');
		}
	}

	/**
	 * @method delete
	 * @param Int ID
	 * @return Exception Message if errors
	 */
	 public function delete($id = null){
 		if(!$this->_db->delete('app_user_logs',array('id', '=', $id))){
 			throw new Exception('There was a problem updating');
 		}
 	}

	/**
	 * @method find
	 * @param Int ID
	 * @param String OutputField : Ex. name of field in table
	 * @param Int Limit
	 * @return Exception Message if errors
	 */
	public function find($id = null, $outputField=null, $limit = null){
		if($id){
			$hit = false;
			if(is_numeric($id)){
				$field = 'id';
				$data = $this->_db->getAll('app_user_logs', array($field, '=', $id),$limit);
				if($data->count()){
					$this->_data = $data->first();
					$hit = true;
				}
			}

			if($hit == false){
					return true;
			}else{
				return $outputField==null?true:$data->first()->$outputField;
			}
		}
		return false;
	}

	/**
	 * @method findCotisation
	 * @param Int ID
	 * @param String OutputField : Ex. name of field in table
	 * @param Int Limit
	 * @return Exception Message if errors
	 */
	public function findCotisation($id = null, $outputField=null, $limit = null){
		if($id){
			$hit = false;
			if(is_numeric($id)){
				$field = 'id';
				$data = $this->_db->getAll('app_user_logs', array($field, '=', $id),$limit);
				if($data->count()){
					$this->_data = $data->first();
					$hit = true;
				}
			}

			if($hit == false){
					return true;
			}else{
				return $outputField==null?true:$data->first()->$outputField;
			}
		}
		return false;
	}

	/**
	 * @method select
	 * @param String sql
	 * @param Array params
	 */
	 public function select($sql = null, $params=array()){
 		$data = $this->_db->query("SELECT* FROM app_user_logs {$sql}", $params);
 		if($data->count()){
 			$this->_count = $data->count();
 			$this->_data = $data->results();
 		}
 	}

	/**
	 * @method selectQuery
	 * @param String sql
	 * @param Array params
	 */
	public function selectQuery($sql,$params=array()){
		$data = $this->_db->query($sql,$params);
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->results();
		}
	}

	/**
	 * @method exists
	 * @return [true or false]
	 */
	public function exists(){
		return (!empty($this->_data))? true : false;
	}

	/**
	 * @method data
	 * @return Array rows
	 */
	public function data(){
		return $this->_data;
	}

	/**
	 * @method first
	 * @return Array first row
	 */
	public function first(){
		$data = $this->data();
		if(isset($data[0])){
			return $data[0];
		}
		return '';
	}

	/**
	 * @method count
	 * @return count
	 */
	public function count(){
		return $this->_count;
	}

	/**
	 * @method addError
	 * @param String error
	 */
	private function addError($error){
		$this->_errors[] = $error;
	}

	/**
	 * @method errors
	 * @return Array erros
	 */
	public function errors(){
		return $this->_errors;
	}
}
?>
