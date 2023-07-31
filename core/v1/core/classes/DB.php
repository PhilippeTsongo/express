<?php
class DB
{
	private static $_instance = null;
	private $_pdo,
			$_query,
			$_error = false,
			$_results,
			$_count = 0,
			$_connected = "DB_NOT_CONNECTED";
			
	private function __construct($table_prefix=null){
		try{
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';port='.Config::get('mysql/port') .';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
			if($this->_pdo){
				$this->_connected = "DB_CONNECTED";
			}
		}catch(PDOException $e){}
		$try = 0;
		while(!$this->_pdo){
			$try++;
			if($try<5){
				try{
					$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';port='.Config::get('mysql/port') .';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
				}catch(PDOException $e){}
				if($this->_pdo){
					$this->_connected = "DB_CONNECTED"; // DB Connection Log
				}
			}else{
				Session::put('errors','Sorry! We are facing a connection problem, Please <br/><a href="'.Config::get('url/home').'"><button class="btn btn-default">Refresh <span class="glyphicon glyphicon-refresh"></button></a> ');
				if(Config::get('dev/devMode')){
					die($e->getMessage());
				}else{
					$this->_error = "DB_FAIL";
				}
				break;
			}
		}
	}
	
	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}
	
	public function query($sql, $params = array()){
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;
			if(count($params)){
				foreach($params as $param){
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			if($this->_query->execute()){
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			}else{
				$this->_error = true;
			}
		}
		return $this;
	}
	
	public function action($action, $table, $where = array(), $limit = null){
		if(count($where) === 3){
			$operators = array('=', '!=' , '>', '<', '>=', '<=');
			
			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];
			
			if(in_array($operator,$operators)){
				if(is_numeric($limit)){
					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? LIMIT {$limit}";
				}else{
					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				}
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}
	
	public function get($fields=array(),$table, $where,$limit = null){
        if(is_array($fields)){
            $fields_str = DB::arrayToFields($fields);
        }else{
            $fields_str = '*';
        }
        
		return $this->action("SELECT {$fields_str} ",$table,$where,$limit);
	}
    
	public function getAll($table, $where,$limit = null){
		return $this->action("SELECT * ",$table,$where,$limit);
	}
	
	public function delete($table, $where){
		return $this->action('DELETE ',$table,$where);
	}
	
	public function results(){
		return $this->_results;
	}
	
	public function insert($table, $fields = array()){
		if(count($fields)){
			$keys = array_keys($fields);
			$values = null;
			$x=1;
			
			foreach($fields as $field){
				$values .= '?';
				if($x < count($fields)){
					$values .= ', ';
				}
				$x++;
			}
			$sql = "INSERT INTO {$table} (`". implode('`, `',$keys). "`) VALUES ({$values})";
			if(!$this->query($sql,$fields)->error()){
				return true;
			}
		}
		return false;
	}

	public function update($table, $id, $fields = array()){
		$set = '';
		$x= 1;
		
		$sql = "";
		foreach($fields as $name => $value){
			$set  .= "{$name} = ?";
			if($x < count($fields)){
				$set .= ', ';
			}
			$x++;
		}
		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
		if(!$this->query($sql,$fields)->error()){
			return true;
		}
		return false;
	}
	public function updateMultiple($table, $conditions = array(), $fields = array()){
		$set = '';
		$whereSql='';
		$x= 1;
		
		$sql = "";
		foreach($fields as $name => $value){
			$set  .= "{$name} = ?";
			if($x < count($fields)){
				$set .= ', ';
			}
			$x++;
		}
		if(!empty($conditions)&& is_array($conditions)){
			$whereSql .= ' WHERE ';
			$i = 0;
			foreach($conditions as $key => $value){
				$pre = ($i > 0)?' AND ':'';
				$whereSql .= $pre.$key." = '".$value."'";
				$i++;
			}
		}
		$sql = "UPDATE {$table} SET {$set}  {$whereSql}";
		if(!$this->query($sql,$fields)->error()){
			return true;
		}
		return false;
	}

	
	public static function arrayToFields($fields=array()){
		if(count($fields) && !empty($fields[0])){
			$fields = "`".implode("`, `",$fields)."`";
		}else{
			$fields = "*";
		}
		return $fields;
	}
	
	public function first(){
		$data =  (array) $this->results();
		if(isset($data[0])){
			return $data[0];
		}
		return '';
	}
	
	public function error(){
		return $this->_error;
	}
	
	public function count(){
		return $this->_count;
	}
	
	public function connected(){
		return $this->_connected;
	}
}

?> 