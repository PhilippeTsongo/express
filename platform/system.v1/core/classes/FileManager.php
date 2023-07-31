 <?php
 class FileManager
 {
	
	public static function delete($path){
		if($delete_file = @unlink($path)){
			return true;
		}
		return false;
	}
	public static function getResized($st){
		$pathlidt = explode('/',$st);
		$endLength = strlen(end($pathlidt));
		$startLength = strlen($st)-$endLength;
		$path = substr($st,0,$startLength);
		$pathend = substr($st,$startLength);
		$thispaht = $path.'resized_'.$pathend;
		return $thispaht;
	}
	public static function getSize($n){
		if($n>=500000){
			return round($n/1000000,2) .' Mbts';
		}elseif($n>=1000){
			return round($n/1000000,2) .' Kbts';
		}else{
			return round($n) .' Bts';
		}
	}
	public static function getAllowed($type){
		switch($type){
			case 'photo':
				return array('jpg', 'jpeg', 'gif', 'png','jfif','tif');
			break;
			case 'audio':
				return array('mp3','wav');;
			break;
			case 'video':
				return array('avi', 'mpg', 'mp4');
			break;
			case 'app':
				return array('exe','zip','rar');;
			break;
			case 'doc':
				return array('docx','doc','dot','xlsx','xls','xlt','xlm','ppt','pps','pot','pub','pdf','txt','accdb');
			break;
		}
	}
	public static function fileUp($file,$return_path=false,$tempFile = array()){
		if(!isset($tempFile['action'])){
			$tempFile['action'] = false;
		}else{
			if(!isset($tempFile['tempFor'])){
				$tempFile['tempFor'] = false;
			}
		}
		if(isset($file['name'])){
			$session_user_ID = Session::get(Config::get('session/session_name'));
			$filename = $file['name'];
			$file_extn = get_exten($filename);
			$file_type = $file['type'];
			$file_size = $file['size'];
			$file_temp = $file['tmp_name'];
				
			
			$photo = FileManager::getAllowed('photo');
			$audio = FileManager::getAllowed('audio');
			$video = FileManager::getAllowed('video');
			$app = FileManager::getAllowed('app');
			$doc = FileManager::getAllowed('doc');
			
			$folder = 'media_data'; //break; 
			
			$attach = null;
			$unic_file = $session_user_ID.'.'.substr(md5(dates('U')), -10, 10).'.'.substr(rand(999,9999999999),-10,10);
			if(in_array($file_extn, $photo) === true ){
				$attach = 1;
				$sub = dates("Y-m-d",dates('U'));
				$dir = $folder."/photo/".$sub;
				if(file_exists($dir)){
					$dir = $dir."/";
				}
				else{
					if(mkdir($dir."/",0, 0777)) {
						$dir = $dir."/";
					}
				}
				$file_path = $dir .'.'. $file_extn;
				$file_path_resized = $folder."/photo/resized/".$unic_file.'.' . $file_extn;
			}
			
			if(empty($attach)==false){
				
				$upload = move_uploaded_file($file_temp, $file_path);
				
				if($upload){
					if($tempFile['action'] == true){
						$tempFor = $tempFile['tempFor'];
						$temp_file = new Temp_file();
						$temp_file->delete($session_user_ID,$tempFor,null);
						$array = array(
										'anyfile' => $attach,
										'filename' => $filename,
										'path' => addslashes($file_path),
										'size' => $file_size,
										'tempFor' => $tempFor
									);
						$temp_file->insert($array);
					}
						
					return $file_path;
					
				}else{
					return 'Failed';
				}
			}else{
				return 'FileType';
			}
		}else{
			return 'NotFound';
		}
		return true;
	}

	/*
    function copy_r( $path, $dest ){
        if(is_dir($path) ){
            $objects = scandir($path);
            if(sizeof($objects) > 0 ){
                foreach( $objects as $file ) {
                    if( $file == "." || $file == ".." )
                        continue;
                    // go on
                    if( is_dir( $path.DS.$file ) ){
                        copy_r( $path.DS.$file, $dest.DS.$file );
                    }else{
                        copy( $path.DS.$file, $dest.DS.$file );
                    }
                }
            }
            return true;
        }elseif(is_file($path)){
            return copy($path, $dest);
        }else{
            return false;
        }
    }*/
	public static function copyFile($path,$dest){
		//define('DS', DIRECTORY_SEPARATOR);
		if(is_file($path)){
            return copy($path, $dest);
        }
        return false;
	}
	public static function moveFile($path,$dest){
		if(is_file($path)){
			$path_dest = FileManager::copyFile($path, $dest);
            if($path_dest){
				FileManager::delete($path);
				return true;
			}
        }
        return false;
	}
	
		
	public static function profile_photo_resize($photo_type,$photo_path,$new_photo_path,$free_up_m){
		global $session_user_ID;
		$db = DB::getInstance();
		
		@clearstatcache();	
		$original_size = getimagesize($photo_path);
		$original_width = $original_size[0];
		$original_height = $original_size[1];	
		// Specify The new size
		$main_width = 500; // set the width of the image
		$main_height = $original_height / ($original_width / $main_width);	// this sets the height in ratio									
		//create new image using correct php func
		$src2 = 'none';
		$photo_type = get_exten($photo_path);
		if($photo_type == "gif"){
			$src2 = @imagecreatefromgif($photo_path);
		}elseif($photo_type == "jpeg" || $photo_type == "pjpeg"){
			$src2 = @imagecreatefromjpeg($photo_path);
		}elseif($photo_type == "png"){ 
			$src2 = @imagecreatefrompng($photo_path);
		}
		
		if($src2 === 'none'){
			$src2 = @imagecreatefromjpeg($photo_path);
		}
			//create the new resized image
			$main = @imagecreatetruecolor($main_width,$main_height);
			@imagecopyresampled($main,$src2,0, 0, 0, 0,$main_width,$main_height,$original_width,$original_height);
			//upload new version
			$main_temp = $new_photo_path;
			@imagejpeg($main, $main_temp, 90);
			//chmod($main_temp,0777);
			
			if($free_up_m == '1'){
				//free up memory
				@imagedestroy($src2);
				@imagedestroy($main);
				@imagedestroy($photo_path);
				@unlink($photo_path); // delete the original upload	
			}
		return true;
	}	
	public static function default_photo_resize($photo_type,$photo_path,$new_photo_path,$free_up_m){
		global $session_user_ID;
		$db = DB::getInstance();
		
		@clearstatcache();	
		$resizeTask = false;
		if(filesize($photo_path)>55000){
			$resizeTask = true;
		}
		
		$original_size = getimagesize($photo_path);
		$original_width = $original_size[0];
		$original_height = $original_size[1];	
		// Specify The new size
		$main_width = 500; // set the width of the image
		$main_height = $original_height / ($original_width / $main_width);	// this sets the height in ratio									
		//create new image using correct php func
		if($resizeTask === true){
			$src2 = 'none';
			if(is_numeric($photo_type)){
				if($photo_type==1){ $src2 = @imagecreatefromgif($photo_path);}
				if($photo_type==2){ $src2 = @imagecreatefromjpeg($photo_path);}
				if($photo_type==3){ $src2 = @imagecreatefrompng($photo_path);}
			}else{	
				$type = $photo_type;
				if($photo_type == "image/gif" || $type == 'gif' || $type == 'GIF'){
					$src2 = @imagecreatefromgif($photo_path);
				}elseif($photo_type == "image/jpeg" || $photo_type == "image/pjpeg" || $type == 'jpg' || $type == 'jpeg' || $type == 'JPG' || $type == 'JPEG'){
					$src2 = @imagecreatefromjpeg($photo_path);
				}elseif($photo_type == "image/png" || $type == 'png' || $type == 'PNG'){ 
					$src2 = @imagecreatefrompng($photo_path);
				}
			}
			
			if($src2 === 'none'){
				FileManager::copyFile($photo_path,$new_photo_path);
			}else{
				//create the new resized image
				$main = imagecreatetruecolor($main_width,$main_height);
				@imagecopyresampled($main,$src2,0, 0, 0, 0,$main_width,$main_height,$original_width,$original_height);
				//upload new version
				$main_temp = $new_photo_path;
				@imagejpeg($main, $main_temp, 90);			
			}	
		}else{
			FileManager::copyFile($photo_path,$new_photo_path);
		}
		if($free_up_m == '1'){
			//free up memory
			@imagedestroy($src2);
			@imagedestroy($main);
			@imagedestroy($photo_path);
			@unlink($photo_path); // delete the original upload	
		}
		return true;
	}
 }
 ?>