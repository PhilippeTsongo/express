<?php
class Validate
{
	private $_passed = false,
			$_errors = array(),
			$_errorLocation = array(),
			$_db = null,
			$error = '';

	public function __construct(){
		$this->_db = DB::getInstance();
	}
	
	public function check($source, $items = array()){
		foreach($items as $item => $rules){
			$field_name = $items[$item]['name'];
			$field_alt = trim(@$items[$item]['alt']);
			foreach($rules as $rule => $rule_value){
				
				$value = trim(@$source[$item]);
				$value_alt = trim(@$source[$field_alt]);
				
				if($rule === 'required'){
                    
                    if(!isset($items[$item]['alt']) && empty($value)){
					    $this->addError("{$field_name} is required",$item);
                    }elseif(isset($items[$item]['alt']) && $value == 'Other' && empty($value_alt)){
                         $this->addError("{$field_name} is required",$item);
                    }elseif(empty($value)){
                        $this->addError("{$field_name} is required",$item);
                    }
                    
				}else if(!empty($value)){
                    
					switch($rule){
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("MAXLENGTH",$item);
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("LOWLENGTH",$item);
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("MISMATCH",$item);
							}
						break;
						case 'strong_password':
							if($this->valid_pass($value)){
							}else{
								$this->addError("WEAKPASSWORD",$item);
							}
						break;
						case 'unique':
							$tablesArray = explode('|',$rule_value);
							if(count($tablesArray)){
								foreach($tablesArray as $table){
									$check = $this->_db->get(array($item),$table, array($item, '=', $value));
									if($check->count()){
										$this->addError("NOTUNIQUE",$item);
										break;
									}
								}
							}
						break;
						case 'email':				
							if($this->valEmail($value) === false){
								$this->addError("INVALIDEMAIL",$item);
							}
						break;
						case 'string':				
							if(is_numeric($value)){
								$this->addError("NOTSTRING",$item);
							}
						break;
						case 'names':				
							if(is_numeric($value)){
								$this->addError("NOTNAME",$item);
							}
						break;
						case 'hour_min':				
							if(!fr_time_format($value)){
								$this->addError("Time format invalid, please use HH:mm format, Eg: 22:30 <br/>",$item);
							}
						break;
						case 'emailOrPhone':				
							if(filter_var($value, FILTER_VALIDATE_EMAIL) === false){
								$this->addError("{$field_name} is unvalide",$item);
							}
						break;
					}
				}
			}
		}
		if(empty($this->_errors)){
			$this->_passed = true;
		}
		return $this;
	}
	
	public function autoUniqueMaker($table,$item,$value,$middle=''){
		$num = 0;
        $temp_val = $value;
        $result = $this->_db->get(array($item),$table, array($item, '=', $temp_val));
		while($result->count()){
			$num++;
			$temp_val = $value.$middle.$num;
		}
        $value = $temp_val;
        
		return $value;
	}
	
	public static function valEmail($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			return false;
		}
		return true;
	}
	
	function valid_pass($candidate){
	   $r1="/[A-Z]/";  //Uppercase
	   $r2="/[a-z]/";  //lowercase
	   $r3="/[!@#$%^&*()\-_=+{};:,<.>]/";  // whatever you mean by 'special char'
	   $r4="/[0-9]/";  //numbers
		$error = false;
		$error_msg = "Your password misses";
		if(!preg_match($r1,$candidate)){
			$error = true;
			$error_msg .= ", Uppercase";
		}
		if(!preg_match($r2,$candidate)){
			$error = true;
			$error_msg .= ", lowercase";
		}
		if(!preg_match($r4,$candidate) && !preg_match($r3,$candidate)){
			$error = true;
			$error_msg .= ", Numbers ";
		}
		$error_msg .= " Characters";
		
		if($error == true){
			//Session::put("errors",$error_msg);
			return false;
		}else{
			return true;
		}
	}
	
	public static function valTelNum($number, $formats){
		$formats = array('###-###-####', '(###) ###-####', '##########');
		$format = @trim(ereg_replace("[0-9]", "#", $number));
		return (in_array($format, $formats)) ? true : false;
	}
	
	public function addError($error, $location = null){
		$this->_errors[] = $error;
		if(!empty($location)){
			$this->_errorLocation[$location][] = $error;
		}
	}
	
	public function errors(){
		return $this->_errors;
	}
	
	public function errorLocated($location = null){
		if(array_key_exists($location,$this->_errorLocation)){
			return implode(' ',$this->_errorLocation[$location]);
		}
		return false;
	}
	public function getErrorLocation(){
		return $this->_errorLocation;
	}
	
	public function passed(){
		return $this->_passed;
	}
 

}

?>
 