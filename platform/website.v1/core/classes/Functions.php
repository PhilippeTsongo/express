<?php
class Functions
{
    public static function getRequestHeaders() 
    {
		$headers = null;
		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		}
		else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			//print_r($requestHeaders);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}

    public static function active_li_menu($_request = 'request', $_match_01, $_match_02 = false,  $_match_03 = false,  $_match_04 = false,  $_match_05 = false){
        $url_struc['tree'] = Input::get($_request, 'get');
        if($_match_01 == $url_struc['tree'])
            return true;
        else if($_match_02 && $_match_02 == $url_struc['tree'])
        return true;
        else if($_match_03 && $_match_03 == $url_struc['tree'])
            return true;
        else if($_match_04 && $_match_04 == $url_struc['tree'])
            return true;
        else if($_match_05 && $_match_05 == $url_struc['tree'])
            return true;
        return false;
    }

	public static function getBasicAuthValue($headers) 
    {
		return  str_replace("Basic ","",$headers);
	}

	public static function getBearerAuthValue($headers) 
    {
		return  str_replace("Bearer ","",$headers);
	}
    public static function printJSon($str){
        echo json_encode($str);
    }

	public static function json_enc($str){
		return json_encode($str,true);
	}
	
	public static function json_dec($str){
		return json_decode($str,true);
	}
	
	
	public static function print_time_($dt_retr_date){
		$cur_retr_date = Config::get('time/date_time');
		$cur_plit_date = substr($cur_retr_date,5,10);
		$cur_time = substr($cur_retr_date,16,11);
		$cur_day = substr($cur_retr_date,0,3);
		
		$dt_plit_date = substr($dt_retr_date,5,10);
		$dt_time = substr($dt_retr_date,16,11);
		$dt_day = substr($dt_retr_date,0,3);
		
		if($dt_plit_date === $cur_plit_date){
			return '<value title="'.$dt_retr_date.'" style="cursor: pointer">'. 'at '.$dt_time. '</value>';
		}
		if($dt_plit_date < $cur_plit_date){
			return '<value title="'.$dt_retr_date.'" style="cursor: pointer">'. 'on '.$dt_day.' '.$dt_plit_date. '</value>';
		}
		return $dt_retr_date;
	}
	public static function time_past($ref_sec){
		$cur_sec = Config::get('time/timestamp');
		$band = ($cur_sec - $ref_sec)/60;
		$split = explode('.',$band);
		$min = $split[0];
		$sec = $cur_sec - $ref_sec;
		if($band < 1){
			return '<value style="cursor: pointer">'.$sec.'sec ago </value>';
		}elseif($min < 60){
			return '<value style="cursor: pointer">'.$min.'min ago </value>';
		}else{
			$band1 = $min/60;
			$split1 = explode('.',$band1);
			$hour = $split1[0];
			if($hour < 24){
				return '<value style="cursor: pointer">'.$hour.'h ago </value>';
			}else{
				$band2 = $hour/24;
				$split2 = explode('.',$band2); 
				$day = $split2[0];
				if($day < 7){
					return '<value style="cursor: pointer">'.$day.'d ago </value>';
				}else{
					return '<value style="cursor: pointer">'.$day.'d ago </value>';
				}
			}
		}
	}
	
	public static function get_timeago( $ptime )
	{
		$temp = Config::get('time/temp');
		$estimate_time = (double)$temp - (double)$ptime;

		if( $estimate_time < 1 )
		{
			return ' < 1 sec ago';
		}

		$condition = array(
			12 * 30 * 24 * 60 * 60  =>  'year',
			30 * 24 * 60 * 60       =>  'month',
			24 * 60 * 60            =>  'day',
			60 * 60                 =>  'hour',
			60                      =>  'minute',
			1                       =>  'second'
		);

		foreach( $condition as $secs => $str )
		{
			$d = $estimate_time / $secs;

			if( $d >= 1 )
			{
				$r = round( $d );
				return $r . ' ' . $str . ( $r > 1 ? 's' : '' );
			}
		}
	}
	public static function print_F_size($ref_size){
		$size_K = $ref_size/1000;
		if($ref_size < 1000){
			return '<value style="cursor: pointer">'.$ref_size.' B </value>';
		}elseif($ref_size < 1000000){
			return '<value style="cursor: pointer">'.(int)($ref_size/1000).'Kb </value>';
		}elseif($ref_size < 1000000000){
			return '<value style="cursor: pointer">'.(int)($ref_size/1000000).'Mb </value>';
		}elseif($ref_size < 1000000000000){
			return '<value style="cursor: pointer">'.(int)($ref_size/1000000).'Gb </value>';
		}
	}
	public static function getFileIcon($anyfile){
		if($anyfile == 1){
			return 'icon/file_type/img.png';
		}else{
			return 'icon/file_type/file1.png';
		}
	}
	
	
	public static function flashMsg(){
		?>
		<?php 
		$session_exist_success = Session::exists('success');
		if($session_exist_success){
			$session_success = Session::get('success') ;
			if(!empty($session_success)){?>	
					<div class=" alert alert-success" role="alert" onclick="$(this).hide()">
						<div class="row">
							<div class="col-xs-1">
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							</div>
							<div class="col-xs-10">
									<?php echo Session::flash('success');?>
								</div>
							<div class="col-xs-1">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							</div>
						</div>
					</div>
			<?php
			}
		}?>

		<?php 
		$session_exist_errors = Session::exists('errors') ;
		if($session_exist_errors){
			$session_errors = Session::get('errors') ;
			if(!empty($session_errors)){?>	
					<div class=" alert alert-danger" role="alert" onclick="$(this).hide()">
						<div class="row">
							<div class="col-xs-12 col-sm-1">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							</div>
							<div class="col-xs-12 col-sm-10">
								<?php echo Session::flash('errors');?>
							</div>
							<div class="col-xs-12 col-sm-1">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							</div>
						</div>
					</div>
			<?php
			}
		}?>
		<?php
	}
	

	public static function makeCapcha($fieldname){
        $capcha = substr(md5(rand(1000,9999)),0,4);
        ?>
        <div style="height:30px; width: 100%; overflow: hidden; position: relative; background: #fff">
            <span style="top: 3px; width: 100%; text-align: center;position: absolute; font-size: 20px; font-weight: 700; font-family: 'Roboto-Bold'; color: #000"><?=$capcha?></span>
            <img src="<?=DN?>/img/kcc.jpg" style="opacity: .3; width: 400px; margin-top: -<?=rand(50,120)?>px; margin-left: <?=rand(-200,0)?>px;">
        </div>
        <input type="hidden" name="<?=$fieldname?>" value="<?=$capcha?>" style="width: 0px; height: 0px">
        <?php
    }

    public static function fileUpload($path, $fileName) {
	    $ext    	 = strrchr($fileName['name'], '.');
		$name		 = sha1($fileName['name'].date('YmdHis')).strtolower($ext);
        $tmp_name 	 = $fileName['tmp_name'];
        $dir_picture = $path.$name;
        $valables 	 = array('.docx','.doc','.xls','.xlsx','.pdf','.PDF', '.png', '.PNG', '.jpg', '.jpeg');
		if(in_array(strtolower($ext), $valables)):
            if(move_uploaded_file($tmp_name, $dir_picture)):
                return $name;
            else:
                return false;
            endif;
        else:
        	return false;
    	endif;
	}
    
	public static function getJobTitles($errorstate,$value='',$categ){
        ?>

        <option value=""> [--Select--] </option>
        
            <option value="Chief Executive Officer (CEO)" <?php if($errorstate && $value == 'Chief Executive Officer (CEO)'){ echo 'selected="selected"';}?>>Chief Executive Officer (CEO)</option>

            <option value="Chief Marketing Officer (CMO)" <?php if($errorstate && $value == 'Chief Marketing Officer (CMO)'){ echo 'selected="selected"';}?>>Chief Marketing Officer (CMO)</option>

            <option value="Chief Operating Officer (COO)" <?php if($errorstate && $value == 'Chief Operating Officer (COO)'){ echo 'selected="selected"';}?>>Chief Operating Officer (COO)</option>
            <option value="Chief Technology Officer" <?php if($errorstate && $value == 'Chief Technology Officer'){ echo 'selected="selected"';}?>>Chief Technology Officer</option>
            <option value="Co-Founder" <?php if($errorstate && $value == 'Co-Founder'){ echo 'selected="selected"';}?>>Co-Founder</option>
            <option value="Consultant / Freelancer" <?php if($errorstate && $value == 'Consultant / Freelancer'){ echo 'selected="selected"';}?>>Consultant / Freelancer</option>
            <option value="Creative Director" <?php if($errorstate && $value == 'Creative Director'){ echo 'selected="selected"';}?>>Creative Director</option>
            <option value="Deputy CEO" <?php if($errorstate && $value == 'Deputy CEO'){ echo 'selected="selected"';}?>>Deputy CEO</option>
            <option value="Deputy Director" <?php if($errorstate && $value == 'Deputy Director'){ echo 'selected="selected"';}?>>Deputy Director</option>
            <option value="Director of Operations" <?php if($errorstate && $value == 'Director of Operations'){ echo 'selected="selected"';}?>>Director of Operations</option>
            <option value="Engineer" <?php if($errorstate && $value == 'Engineer'){ echo 'selected="selected"';}?>>Engineer</option>
            <option value="Entrepreneur" <?php if($errorstate && $value == 'Entrepreneur'){ echo 'selected="selected"';}?>>Entrepreneur</option>
            <option value="Executive Director" <?php if($errorstate && $value == 'Executive Director'){ echo 'selected="selected"';}?>>Executive Director</option>
            <option value="Executive President" <?php if($errorstate && $value == 'Executive President'){ echo 'selected="selected"';}?>>Executive President</option>
           <option value="Founder" <?php if($errorstate && $value == 'Founder'){ echo 'selected="selected"';}?>>Founder</option>
            <option value="General Manager" <?php if($errorstate && $value == 'General Manager'){ echo 'selected="selected"';}?>>General Manager</option>
            <option value="Web Developer" <?php if($errorstate && $value == 'Web Developer'){ echo 'selected="selected"';}?>>Web Developer</option>
               
      
            <option value="Other" <?php if($errorstate && $value == 'Other'){ echo 'selected="selected"';}?>>Other </option>
        <?php
	}
    
    public static function errorPage($number){
        if($number == 404){
			include 'views/errors/404'.P;
        }else{
			include 'views/errors/404'.P;
        }
        echo '<div class="clearfix"></div>';
    }
    
    public static function getStateCol($state){
        switch($state){
            case 'Activate':
            case 'Activated':
                return '#4093D0';
            break; 
            case 'Attend':
            case 'Attended':
                return '#00a65a';
            break;   
            case 'Pending':
                return 'orange';
            break;   
            case 'Deactivate':
            case 'Deactivated':
                return '#999';
            break;    
        }
    }
    
    
    public static function getUserIP(){
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }
	
    public static function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode,
                            "latitude" => @$ipdat->geoplugin_latitude,
                            "longitude" => @$ipdat->geoplugin_longitude,
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                    case "latitude":
                        $output = @$ipdat->geoplugin_latitude;
                        break;
                    case "longitude":
                        $output = @$ipdat->geoplugin_longitude;
                        break;
                }
            }
        }
        return $output;
    }
    
    public static function generateStrongPassword($length = 6, $add_dashes = false, $available_sets = 'luds'){
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach($sets as $set){
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }
    
    public static function discount($amount_gross,$discount){
        return $amount_gross-$amount_gross*$discount/100;
    }

    public static function getSessionState($ID, $strlen = 'short'){
        if($strlen == 'short')
            return $ID?'On':'Off';
        return $ID?'Online':'Offline';
    }

    public static function getStatusLabel($_status_){
        $_status_label_ = 'label-warning';

        if($_status_ == 'COMPLETED'):
            $_status_label_ = 'label-success';
            $_status_ = 'Completed';

        elseif($_status_ == 'USED'):
            $_status_label_ = 'label-success';
            $_status_ = 'Used';

        elseif($_status_ == 'APPROVED'):
            $_status_label_ = 'label-success';
            $_status_ = 'Approved';

        elseif($_status_ == 'ACTIVE'):
            $_status_label_ = 'label-success';
            $_status_ = 'Active';

        elseif($_status_ == 'DEACTIVE'):
            $_status_label_ = 'label-warning';
            $_status_ = 'Deactive';

        elseif($_status_ == 'ACCEPTED'):
            $_status_label_ = 'label-info';
            $_status_ = 'Accepted';

        elseif($_status_ == 'DENIED'):
            $_status_label_ = 'label-danger';
            $_status_ = 'Denied';

        elseif($_status_ == 'EXPIRED'):
            $_status_label_ = 'label-default';
            $_status_ = 'Expired';
        
        elseif($_status_ == 'BLOCKED'):
            $_status_label_ = 'label-default';
            $_status_ = 'Blocked';

        elseif($_status_ == 'DELETED'):
            $_status_label_ = 'label-danger';
            $_status_ = 'Deleted';

        elseif($_status_ == 'PENDING'):
            $_status_label_ = 'label-primary';
            $_status_ = 'Pending';

        else:
            $_status_label_ = 'label-info';
            $_status_ = 'Pending';
        endif;

        return (Object)[
            'status' => $_status_,
            'label'  => $_status_label_
        ];
    }

    public static function smartModal(){
        ?>
        <!-- Action Smart Modal -->
        <div class="modal fade" id="smartModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title">Modal Title</h4>
                        <small></small>
                    </div>
                    <form class="form-group action-form" id="ActionForm" method="post" >
                        <div class="modal-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Modal Label</label>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="_id_" id="token" value="">
                            <input type="hidden" name="request" id="request" value="">
                            <input type="hidden" name="webToken" id="webToken" value="">
                            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-action">Action</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
        <!-- End Action Smart Modal -->
        <?php
    }

    public static function smartModalBeta(){
        ?>
        <!-- Action Smart Modal -->
        <div class="modal pmd-modal fade text-center delete-modal" id="smartModal" tabindex="-1" role="dialog" aria-labelledby="delete_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <i class="material-icons md-danger pmd-icon-circle bg-danger pmd-icon-md"><strong>error_outline</strong></i>
                    </div>
                    <form class="form-group action-form" id="ActionForm" method="post" >

                        <h2 class="modal-title">Are you sure?</h2>
                        <div class="modal-body">
                            <p>Do you really want to delete the unit details? <br/> This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer" style="    border-top: 1px solid #80808024; padding-bottom: 0%; padding-top: 2%;" > 
                            <input type="hidden" name="_id_" id="token" value="">
                            <input type="hidden" name="request" id="request" value="">
                            <input type="hidden" name="webToken" id="webToken" value="">
                            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-action">Action</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Action Smart Modal -->
        <?php
    }
	
}
?>