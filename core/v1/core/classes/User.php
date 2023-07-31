<?php
class User
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

		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');

		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);
				if($this->find_user($user)){
					$this->_isLoggedIn = true;
				}else{
				 //logout
				}
			}
		}else{
			$this->find_user($user);
		}
	}

	# USER GENERATE MEMBER CODE
	public function generateCode(){
		$data   = $this->_db->query("SELECT id FROM app_users ORDER BY id DESC LIMIT 1");
		$lastID = 0;
		if($data->count()):
			$lastID = $data->first()->id;
		endif;
		$newID		= $lastID+1;
		$Str = 'MSG-';
		$Str.= ($newID>=0 && $newID<10)?'000':($newID<100?'00':($newID<1000?'0':''));
		$Str.= $newID;
		return $Str;
	}

  # USER CREATE AN ACCOUNT
	public function insert($fields = array()){
		if(!$this->_db->insert('app_users', $fields)){
			throw new Exception("There was a problem creating an account.");
		}
	}

  # USER DATA UPDATE
	public function update($fields = array(),$id = null){
		if(!$this->_db->update('app_users',$id,$fields)){
			throw new Exception('There was a problem updating');
		}
	}

// USER DATA UPDATE
	public function recoverPassword($fields = array(),$id = null){

		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}else{
			//Admin Of A group Came Update
		}

		if(!$this->_db->update('app_users',$id,$fields)){
			throw new Exception('There was a problem updating');
		}
	}

// FIND USER
	public function find($user = null){
		if($user){
			$limit = "";
			$hit = false;
			if(is_numeric($user)){
				$field = 'id';
				$data = $this->_db->get('app_users', array($field, '=', $user));
				if($data->count()){
					$this->_data = $data->first();
					$hit = true;
				}
			}else if(filter_var($user, FILTER_VALIDATE_EMAIL) == true){
				$field = 'email';
				$data = $this->_db->get('app_users', array($field, '=', $user), $limit);
				if($data->count()){
					$this->_data = $data->first();
					$hit = true;
				}
			}else{
				$userClass = new User();
				$userClass->select("WHERE `username` = '{$user}' LIMIT 1");
				if($userClass->count()){
					$this->_data = $userClass->first();
					$hit = true;
				}
			}

			if($hit == false){
				if($this->findUserByPhone($user)){
					return true;
				}
			}else{
				return true;
			}
		}
		return false;
	}

// FIND USER
	public function find_user($user = null,$fields = array()){
		$table = "app_users";
		if($user){
			$hit = false;
			if(is_numeric($user)){
				$field = 'id';
				$data = $this->_db->get($fields,$table, array($field, '=', $user));
				if($data->count()){
					$this->_data = $data->first();
					$hit = true;
				}
			}elseif(filter_var($user, FILTER_VALIDATE_EMAIL) == true){
				$field = 'email';
				$data = $this->_db->get($fields,$table, array($field, '=', $user));
				if($data->count()){
					$this->_data = $data->first();
                    $hit = true;
				}
			}
			else{
				// $field = 'username';
				$field = 'email';
				$data = $this->_db->get($fields,$table, array($field, '=', $user));
				if($data->count()){
					$this->_data = $data->first();
					$hit = true;
				}
			}

			if($hit == true){
				return true;
			}
		}
		return false;
	}

// FIND USER
	public function findUserByPhone($user = null){
		if($user){
			$userClass = new User();
			$userClass->select("WHERE `telephone`='{$user}' LIMIT 1");
			if($userClass->count()){
				$this->_data = $userClass->first();
				return true;
			}
		}
		return false;
	}

    public function isCurrentSession($user_ID){
        $id = Session::get(Config::get('session/session_name'));
        if($user_ID == $id ){
            return true;
        }
        return false;

    }

	// select
	public function select($sql = null, $params=array()){
		$data = $this->_db->query("SELECT* FROM `app_users` {$sql}", $params);
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->results();
		}
	}

	// Select
	public function selectQuery($sql,$params=array()){
		$data = $this->_db->query($sql,$params);
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->results();
		}
	}

// USER LOGIN
	public function login($username = null, $password = null, $remember = false){
		$time = Config::get('time/temp');
		if(!$username && !$password && $this->exists()){
			Session::put($this->_sessionName, $this->data()->id);
			$userID = $this->data()->id;

            $userTokenClass = new UserToken();
            $userTokenClass->select(array('id','user_id'),"WHERE `user_id`= ? ",array($userID));
            if(!$userTokenClass->count()){
                $token_hash = Hash::unique();
                $userTokenClass->insert(array('user_id'=>$userID,'hash'=>$token_hash));
            }
		}else{
			$user = $this->find_user($username);
			if($user){
				if($this->data()->password === Hash::make($password, $this->data()->salt)){
					Session::put($this->_sessionName,$this->data()->id);

					$userID = $this->data()->id;

			// 		$userTokenClass = new UserToken();
			// 		$userTokenClass->select(array('id','user_id'),"WHERE `user_id`= ? ",array($userID));
			// 		if(!$userTokenClass->count()){
            // $token_hash = Hash::unique();
			// 			$userTokenClass->insert(array('user_id'=>$userID,'hash'=>$token_hash));
			// 		}
					// Set last login

                    // $pageviewClass = new PageView();
                    // $page_type = 'Logged In';
                    // $page_item_ID = 2;

                    // $grab_info = 'Username: '.$username;

                    // $pageviewClass->insert(array('page_id'=>$page_item_ID,
                    //                      'user_id'=>$userID,
                    //                      'email'=>$username,
                    //                      'type'=>$page_type,
                    //                      'grabbed_info'=>$grab_info));

					return true;

					// $this->addError('Blocked account');
					// return 'Denied';
				}else{
					$this->addError('Wrong Password');
					return 'password';
				}
			}else{
				$this->addError('That username doesn\'t exist');
				return 'username';
			}
		}
		return false;
	}


	public function exists(){
		return (!empty($this->_data))? true : false;
	}

	// SENDING EMAIL
	public function emailTo($from,$to,$subject='',$body='',$headers=''){
		if(Validate::valEmail($from)===true){
			if(Validate::valEmail($to)===true){
				$fname = '';
				$lname = '';
				if($this->find($from)==true){
					$user_data = $this->data();
					$fname = $user_data->firstname;
					$lname = $user_data->lastname;
				}
				if($this->find($to)==true){
					$user_data_to = $this->data();
					$fname_to = $user_data_to->firstname;
					$lname_to = $user_data_to->lastname;
				}


				$message = $body;
				$email_body = $message;

				//SENDING MESSAGE
				@mail($to, $subject,$email_body, $headers);
			}
		}
	}

// USER LOGOUT
	public function logout(){
		$sessionName = Config::get('session/session_name');
		$cookieName = Config::get('remember/cookie_name');
		if(Session::exists($sessionName)){
			$user_ID = Session::get($this->_sessionName);
			$this->_db->delete('user_session',array('user_id','=',$user_ID));
			$this->update(array('account_session'=>'0'),$user_ID);
			Session::delete($this->_sessionName);
			$userTokenClass = new UserToken();
			$userTokenClass->select(array('id','user_id'),"WHERE `user_id`= ? ",array($user_ID));
			if($userTokenClass->count()){
				$usertoken_data = $userTokenClass->first();
				$userTokenClass->delete($usertoken_data->id);
			}
		}
		Cookie::delete($this->_cookieName);
	}

// CHECK USER LOGGED IN
	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}

// DATA COLLECT
	public function data(){
		return $this->_data;
	}
// first
	public function first(){
		$data =  (array) $this->data();
		if(isset($data[0])){
			return $data[0];
		}
		return '';
	}

// DATA COUNT
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
