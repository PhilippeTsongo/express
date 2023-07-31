<?php
class PageView
{
	private $_db,
			$_data,
			$_pageview_ID,
			$_userID,
			$_count = 0,
			$_errors = false;

	public function __construct($pageview_ID = null){
		$this->_db = DB::getInstance();

		if($pageview_ID){
			$this->_pageview_ID = $pageview_ID;
			$this->get($pageview_ID);
		}
	}

//pageview
	public function insert($fields = array()){


        $time = Config::get('time/seconds');
        $deviceDetection = new Mobile_Detect();
        $fields['device_details'] = $deviceDetection->getUserAgent();
        if($deviceDetection->isMobile()){
            $fields['device'] = 'Mobile';
        }elseif($deviceDetection->isTablet()){
            $fields['device'] = 'Tablet';
        }else{
            $fields['device'] = 'Computer';
        }

        $fields['day_name'] = Dates::get_date_cord("l",$time);
        $fields['day'] = Dates::get_date_cord("d",$time);
        $fields['month'] = Dates::get_date_cord("m",$time);
        $fields['year'] = Dates::get_date_cord("Y",$time);
        $fields['hour'] = Dates::get_date_cord("H",$time);
        $fields['minute'] = Dates::get_date_cord("i",$time);
        $fields['second'] = Dates::get_date_cord("s",$time);


				$fields['user_IP'] = Functions::getUserIP();
        // if($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '127.0.0.1')
				{
            $fields['user_IP'] = Functions::getUserIP();

            $ip_info = Functions::ip_info($fields['user_IP'], "location");
            $ip_info = (object)$ip_info;
            $fields['user_country_code'] =  @$ip_info->country_code;
            $fields['user_country'] = @$ip_info->country;
            $fields['user_city'] = @$ip_info->city;
            $fields['user_latitude'] = @$ip_info->latitude;
            $fields['user_longitude'] = @$ip_info->longitude;
        }
				$fields['c_date'] = $time;

        if(!$this->_db->insert('app_user_logs', $fields)){
          throw new Exception("There was a problem submiting a view.");

        }
	}

// select
	public function select($fields,$sql = null){
		$data = $this->_db->query("SELECT* FROM 'app_user_logs' {$sql}");
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->results();
		}
	}
	public function getFields($fields,$sql = null){
        if(count($fields)){
            $fields_str = DB::arrayToFields($fields);
        }else{
            $fields_str = '*';
        }
		$data = $this->_db->query("SELECT {$fields_str} FROM 'app_user_logs' {$sql}");
		if($data->count()){
			$this->_count = $data->count();
			$this->_data = $data->results();
		}
	}

// Unsub
	public function pageview($email){
		$this->_db->query("UPDATE 'app_user_logs' SET `state`='Deactivated' WHERE `email`= '{$email}'");
	}

    public static function arrayToFields($fields=array()){
		if(count($fields) && !empty($fields[0])){
			$fields = "`".implode("`, `",$fields)."`";
		}else{
			$fields = "*";
		}
		return $fields;
	}


//Delete
	public function delete($id){
		$this->get($id);
		$this->_db->delete('pageview',array('ID','=',$id));
	}

// data
	public function data(){
		return $this->_data;
	}
// first
	public function first(){
		$data = $this->data();
		if(isset($data[0])){
			return $data[0];
		}
		return '';
	}
// count
	public function count(){
		return $this->_count;
	}
}
