<?php 
class Temp_file
{
	private $_db,
			$_data,
			$_tempID,
			$_ssUserID,
			$_count = 0,
			$_errors = false;
	
	public function __construct($temp_ID = null){
		$this->_db = DB::getInstance();
		$this->_ssUserID = Session::get(Config::get('session/session_name'));
		
		if($temp_ID){
			$this->_tempID = $temp_ID;
			$this->get($temp_ID);
		}
	}
	
//Create
	public function insert($fields = array()){
		$fields['user_ID'] = $this->_ssUserID;
		if(!$this->_db->insert('temp_file', $fields)){
			throw new Exception("There was a problem storing a file.");
		}else{
			$this->getCreated($this->_ssUserID);
		}
	}

// select
	public function select($sql = null){
		$data = $this->_db->query("SELECT* FROM `temp_file` {$sql}");
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->results();
		}
	}
	
// get
	public function get($temp_ID){
		$data = $this->_db->get('temp_file',array('ID','=',$temp_ID));
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->first();
		}
	}
	
// delete
	public function delete($user_ID,$tempFor,$position = null){
		$temp_file = new Temp_file();
		
		$temp_file->select("WHERE `user_ID` = '{$user_ID}' && `tempFor`='{$tempFor}'");
		if($temp_file->count()){
			foreach($temp_file->data() as $row_data){
			
				$file_type = $row_data->anyfile;
				if($file_type != '0'){
					$start = '';
					
					if($position === -1){
						$start = '../';
					}
					
					$del_path = $start.$row_data->path;
					
					FileManager::delete($del_path);
					
					if($file_type == 1){
					
						$del_path_array = explode("resized/",$del_path);
						
						if(count($del_path_array)>=2){
							$del_path_original = $del_path_array[0].$del_path_array[1];
							FileManager::delete($del_path_original);
						}
						
					}
				}
				$this->_db->query("DELETE FROM `temp_file` WHERE `ID`='{$row_data->ID}' && `tempFor`='{$tempFor}'");
			}
		}
	}
	
// delete row
	public function deleteRow($temp_ID){
		$this->_db->delete('temp_file',array('ID','=',$temp_ID));
	}
	
// get last 
	public function getCreated($user_ID){
		if($user_ID){
			$this->select("WHERE `user_ID` = {$user_ID} ORDER BY `ID` DESC LIMIT 1");
		}
	}
	
// data	
	public function data(){
		return $this->_data;
	}
// count	
	public function count(){
		return $this->_count;
	}
// first
	// public function first(){
	// 	$data = @$this->data();
	// 	if(isset($data[0])){
	// 		return @$data[0];
	// 	}
	// 	return '';
	// }	
}
?>