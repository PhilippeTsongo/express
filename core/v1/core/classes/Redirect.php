 <?php
 class Redirect
 {
	public static function to($location = null){
		if($location){
			if(is_numeric($location)){
				switch($location){
					case 404:
						//header('HTTP/1.0 404 Not found');
						die('Sorry! Page not found or Connection problem, Please <br/><a href="index"><button class="btn btn-default">Reload <span class="glyphicon glyphicon-refresh"></button></a> ');
						//exit();
					break;
				}
			}else{
				header('Location: '.$location);
				exit();
			}
		}
	}
 }
 ?>