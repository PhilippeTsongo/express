<?php
// Global Time settings
$timezone = 'Africa/Khartoum';
$date = new DateTime('now', new DateTimeZone($timezone));
$date->sub(new DateInterval('P0Y0M0DT1H0M0S'));
$clone = clone $date;
$localtime = $date->format('h:i:s a');
$time = $date->format('U');

class Html
{
	public static function html_cut($text, $max_length)
	{
	    $tags   = array();
	    $result = "";

	    $is_open   = false;
	    $grab_open = false;
	    $is_close  = false;
	    $in_double_quotes = false;
	    $in_single_quotes = false;
	    $tag = "";

	    $i = 0;
	    $stripped = 0;

	    $stripped_text = strip_tags($text);

	    while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
	    {
	        $symbol  = $text{$i};
	        $result .= $symbol;

	        switch ($symbol)
	        {
	           case '<':
	                $is_open   = true;
	                $grab_open = true;
	                break;
	           case '"':
	               if ($in_double_quotes)
	                   $in_double_quotes = false;
	               else
	                   $in_double_quotes = true;
	                break;

	            case "'":
	              if ($in_single_quotes)
	                  $in_single_quotes = false;
	              else
	                  $in_single_quotes = true;
	                break;
	            case '/':
	                if ($is_open && !$in_double_quotes && !$in_single_quotes)
	                {
	                    $is_close  = true;
	                    $is_open   = false;
	                    $grab_open = false;
	                }
	                break;
	            case ' ':
	                if ($is_open)
	                    $grab_open = false;
	                else
	                    $stripped++;
	                break;
	            case '>':
	                if ($is_open)
	                {
	                    $is_open   = false;
	                    $grab_open = false;
	                    array_push($tags, $tag);
	                    $tag = "";
	                }
	                else if ($is_close)
	                {
	                    $is_close = false;
	                    array_pop($tags);
	                    $tag = "";
	                }
	                break;
	            default:
	                if ($grab_open || $is_close)
	                    $tag .= $symbol;

	                if (!$is_open && !$is_close)
	                    $stripped++;
	        }

	        $i++;
	    }

	    while ($tags)
	        $result .= "</".array_pop($tags).">";

	    return $result;
	}


	//Print Success Message Style
	public static function Success ($message) {
		echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
				<span aria-hidden=\"true\">&times;</span>
				</button>
				{$message}
			</div>" ;
	}

	//Print Error Message Style
	public static function Danger($message) {
		echo "<div class=\"alert alert-danger alert-dismissible show fade in\" role=\"alert\">
				<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
				<span aria-hidden=\"true\">&times;</span>
				</button>
				{$message}
			</div>" ;
	}  

}
?>
