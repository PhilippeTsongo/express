<?php 
class File
{
	private $_db,
			$_data,
			$_fileID,
			$_ssUserID,
			$_count = 0,
			$_errors = false;
	
	public function __construct($file_ID = null){
		$this->_db = DB::getInstance();
		
		if($file_ID){
			$this->_fileID = $file_ID;
			$this->get($file_ID);
		}
	}
	
//Create
	public function insert($fields = array()){
		//$fields['user_ID'] = $this->_ssUserID;
		if(!$this->_db->insert('file', $fields)){
			throw new Exception("There was a problem storing a file.");
		}else{
			$this->getCreated($this->_ssUserID);
		}
	}

// select
	public function select($sql = null,$indexes=null){
		$sql_index = "*";
		if($indexes != null){
			$sql_index = $indexes;
		}
		$data = $this->_db->query("SELECT {$sql_index} FROM `file` {$sql}");
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->results();
		}
	}
// DATA UPDATE
	public function update($fields = array(),$id = null){
		if(!$this->_db->update('file',$id,$fields)){
			throw new Exception('There was a problem updating');
		}
	}
// DATA UPDATE 
	public function delete($id){
		$db = DB::getInstance();
		if(!$db->delete('file',array("ID","=",$id))){
			throw new Exception('There was a problem deleting your file');
		}
	}
    

	public function get_video_categ(){
		$data = $this->_db->query("SELECT `category`  FROM `file` WHERE `media`='Video' AND `state`='Published' ORDER BY `category` DESC, `ID` DESC");
		
        $categ_list = array();
        
        if($data->count()){
           $i = 0;
            
            foreach($data->results() as $row_data){
                
                $category = $row_data->category;
                $i++;
                
                if($i == 1){
                    $categ_list[] = $category;
                }elseif(!in_array($category,$categ_list)){
                    $categ_list[] = $category;
                }
                
            }
		}
        return $categ_list;
	}
	public function get_audio_categ($chanel_ID=null){
        if($chanel_ID != null){
            $chanel_ID_cond = "`chanel_ID` = '{$chanel_ID}' AND ";
        }else{
             $chanel_ID_cond = "";
        }
        
		$data = $this->_db->query("SELECT* FROM `file` WHERE {$chanel_ID_cond} `media`='Audio' AND `state`='Published' ORDER BY `category` DESC");
		
        $categ_list = array();
        
        if($data->count()){
           $i = 0;
            
            foreach($data->results() as $row_data){
                
                $category = $row_data->category;
                $i++;
                
                if($i == 1){
                    $categ_list[] = $category;
                }elseif(!in_array($category,$categ_list)){
                    $categ_list[] = $category;
                }
            }
		}
        return $categ_list;
	}
	
// get
	public function get($file_ID){
		$data = $this->_db->get('file',array('ID','=',$file_ID));
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->first();
		}
	}
// get
	public function getFileByName($filename){
		$data = $this->_db->get('file',array('name','=',$filename));
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->first();
		}
	}
	
	public static function cleanVideoPath($file_path,$subdir){
		$file_path_len = strlen($file_path);
					
		$file_path_array = @explode('/',$file_path);
		$name_part = end($file_path_array);
		
		$name_part_len = @strlen($name_part);
		$file_name_array = @explode('.',$name_part);
		$file_ext = @end($file_name_array);
		$ext_len = @strlen($file_ext);
		$name_len = $name_part_len-$ext_len-1;
		
		
		$dirs_len = $file_path_len - $name_part_len;
		$dirs = substr($file_path,0,$dirs_len);
		
		$file_name_srg = substr($name_part,0,15);
		
		$file_name_srg = str_replace(' ', '-', $file_name_srg); // Replaces all spaces with hyphens.
		$file_name_srg = preg_replace('/[^A-Za-z0-9\-)(]/', '', $file_name_srg); // Removes special chars.
		
		$existing_files_number = count(glob($dirs.'*'));
		
		$file_name_srg = $existing_files_number.'.'.$file_name_srg;
		$name = $file_name_srg.'.'.$file_ext;
		$output_file = $dirs.$name;
		
		$dupl = 0;
		while(file_exists($output_file)){
			$dupl++;
			$name = $file_name_srg.$dupl.'.'.$file_ext;
			$output_file = $dirs.$name;
		}	
		return $output_file;
	}
	
	public static function cleanPath($file_path){
		$file_path_len = strlen($file_path);
					
		$file_path_array = @explode('/',$file_path);
		$name_part = end($file_path_array);
		
		$name_part_len = @strlen($name_part);
		
		$file_name_array = @explode('.',$name_part);
		$file_ext = @end($file_name_array);
		$ext_len = @strlen($file_ext);
		$name_len = $name_part_len-$ext_len-1;
		
		//$file_name_srg = substr($name_part,0,$name_len);
		$file_name_srg = substr($name_part,0,15);
		
		$file_name_srg = str_replace(' ', '-', $file_name_srg); // Replaces all spaces with hyphens.
		$file_name_srg = preg_replace('/[^A-Za-z0-9\-)(]/', '', $file_name_srg); // Removes special chars.
		
		$name = $file_name_srg.'.'.$file_ext;
		
		$dirs_len = $file_path_len - $name_part_len;
		
		$dirs = substr($file_path,0,$dirs_len);
		return $dirs.$name;
	}
	public static function cleanName($name_part){
		
		$name_part_len = @strlen($name_part);
		
		$file_name_array = @explode('.',$name_part);
		$file_ext = @end($file_name_array);
		$ext_len = @strlen($file_ext);
		$name_len = $name_part_len-$ext_len-1;
		
		//$file_name_srg = substr($name_part,0,$name_len);
		$file_name_srg = substr($name_part,0,15);
		
		$file_name_srg = str_replace(' ', '-', $file_name_srg); // Replaces all spaces with hyphens.
		$file_name_srg = preg_replace('/[^A-Za-z0-9\-)(]/', '', $file_name_srg); // Removes special chars.
		
		$name = $file_name_srg.'.'.$file_ext;
		return $name;
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
	public function first(){
		$data = $this->data();
		if(isset($data[0])){
			return $data[0];
		}
		return '';
	}	
}
?>