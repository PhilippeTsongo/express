<?php
// Global Time settings
$timezone = 'Africa/Khartoum';
$date = new DateTime('now', new DateTimeZone($timezone));
$date->sub(new DateInterval('P0Y0M0DT1H0M0S'));
$clone = clone $date;
$localtime = $date->format('h:i:s a');
$time = $date->format('U');

class Dates
{
	public static function get($str,  $sec = 0)
	{
		$timezone = 'Africa/Khartoum';
		$date = new DateTime('now', new DateTimeZone($timezone));
		$date->sub(new DateInterval('P0Y0M0DT1H0M0S'));
		$clone = clone $date;
		$localtime = $date->format('h:i:s a');
		$time = $date->format('U');
		$this_date = $clone;
		if ($sec != 0) {
			$this_sec = $sec - $time;
			$this_date->modify("$this_sec sec");
		}
		return $this_date->format($str);
	}

	public static function convTo($format, $time)
	{
		if ($format == 'date') {
			return dates('Y-m-d', $time);
		}
	}

	public static function toDate($format, $time)
	{
		return date($format, $time);
	}

	public static function strToSeconds($str, $format)
	{
		$dt = DateTime::createFromFormat($format, $str);
		$timestamp = $dt->format('U');
		return $timestamp;
	}

	public static function get_timeago($seconds)
	{
		$time = Config::get('time/seconds') - $seconds; // to get the time since that moment
		$time = ($time < 1) ? 1 : $time;
		$tokens = array(
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit)
				continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
		}
	}

	public static function get_daylapsed($seconds, $deadline, $u)
	{

		$time = Config::get('time/seconds') - $seconds; // to get the time since that moment
		$time = ($time < 1) ? 1 : $time;

		if ($u == 'day') {
			$unit = 86400;
		}
		$numberOfUnits = (int)$deadline - floor($time / $unit);
		if ($numberOfUnits > 1) {
			return $numberOfUnits . ' ' . $u . 's';
		}
		elseif ($numberOfUnits < -1) {
			return $numberOfUnits . ' ' . $u . 's';
		}
		else {
			return $numberOfUnits . ' ' . $u;
		}
	}

	public static function get_time_ago_date($time, $until = null)
	{
		$temp = Config::get('time/seconds');
		if ($temp - $time < $until) {
			return '<span class="new">' . Dates::get_timeago($time) . '</span>';
		}
		else {
			return '<span class="old">' . dates('F d, Y', $time) . ' at ' . dates(' H:i A', $time) . '</span>';
		}
	}
	public static function get_en_date($time, $until = null)
	{
		return '<span class="old">' . dates('F, d Y', $time) . ' at ' . dates(' H:i A', $time) . '</span>';
	}
	public static function get_date_cord($cord, $time)
	{
		return dates($cord, $time);
	}
	public static function get_xml_date($time, $until = null)
	{
		return dates('D, d M Y', $time) . ' ' . dates(' H:i A', $time);
	}

	public static function dayName($n, $breif = false)
	{
		$week_dayname_list = array();
		if ($n >= 1 && $n <= 7) {
			if ($breif) {
				$week_dayname_list = array('', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
			}
			else {
				$week_dayname_list = array('', 'Monday', 'Tueday', 'Wednesday', 'Thusday', 'Friday', 'Saturday', 'Sunday');
			}
			return $week_dayname_list[$n];
		}
		return $week_dayname_list[1];
	}

	public static function monthName($n, $breif = false)
	{
		$month_list = array();
		if ($n >= 1 && $n <= 31) {
			if ($breif) {
				$month_list = array('', 'Janv', 'Fevr', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec');
			}
			else {
				$month_list = array('', 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
			}
			return $month_list[$n];
		}
		return $month_list[1];
	}

	public static function idByMonthName($_monthName)
	{
		$month_list = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		return array_search($_monthName, $month_list);
	}

	public static function formatStingDateToDate($_stringDate)
	{
		$Array_ = explode(',', trim($_stringDate));
		$MonthDayAr = explode(' ', trim($Array_[0]));
		$year_ = trim($Array_[1]);
		$day_ = trim($MonthDayAr[1]);
		$monthStr_ = trim($MonthDayAr[0]);
		$month_ = Dates::idByMonthName($monthStr_);
		$month_ = $month_ < 10 ? '0' . $month_ : $month_;
		$day_ = $day_ < 10 ? '0' . $day_ : $day_;
		$DateFormat = $year_ . '-' . $month_ . '-' . $day_;

		return $DateFormat;
	}

	public static function formatStingSDateToDate($_stringDate)
	{
		$Array_ = explode('/', trim($_stringDate));
		$day_ = trim($Array_[0]);
		$month_ = trim($Array_[1]);
		$year_ = trim($Array_[2]);
		$DateFormat = $year_ . '-' . $month_ . '-' . $day_;
		return $DateFormat;
	}

	public static function getAge($dob)
	{
		$dob = date("Y-m-d", $dob);
		$dobObject = new DateTime($dob);
		$nowObject = new DateTime();
		$diff = $dobObject->diff($nowObject);

		return (object)[
			'year' => $diff->y,
			'month' => $diff->m,
			'days' => $diff->d,
		];
	}

	public static function getDatesDiff($start_date, $end_date)
	{
		$start_date = date("Y-m-d h:i:s", strtotime($start_date));
		$end_date = date("Y-m-d h:i:s", strtotime($end_date));
		$start_dateObject = new DateTime($start_date);
		$end_dateObject = new DateTime($end_date);
		$diff = $start_dateObject->diff($end_dateObject);

		return (object)[
			'year' => $diff->y,
			'month' => $diff->m,
			'day' => $diff->d,
			'days' => $diff->days,

			'hours' => $diff->h,
			'minutes' => $diff->i,
			'seconds' => $diff->s,
		];
	}

	public static function dateFormat($date, $format = "Y-m-d")
	{
		return date($format, ($date));
	}

	public static function utc_time($time, $timezone)
	{
		$dateTime = $time;
		$tz_from = $timezone;
		$newDateTime = new DateTime($dateTime, new DateTimeZone($tz_from));
		$newDateTime->setTimezone(new DateTimeZone("UTC"));
		$dateTimeUTC = $newDateTime->format("g:ia");
		echo $dateTimeUTC;
	}

	public static function seconds()
	{
		return time();
	}

	public static function today()
	{
		return time();
	}

	public static function year_months_range_strtotime($_YEAR_ = 2022, $_MONTH_ = 'JAN', $_RANGE_ = 'MIN'){
		$_date_range_['YEARLY']['MIN'] = strtotime( $_YEAR_ . '-01-01' );
		$_date_range_['YEARLY']['MAX'] = strtotime( $_YEAR_ . '-12-31' );

		$_date_range_['JAN']['MIN'] = strtotime( $_YEAR_ . '-01-01' );
		$_date_range_['JAN']['MAX'] = strtotime( $_YEAR_ . '-01-31' );

		$_date_range_['FEB']['MIN'] = strtotime( $_YEAR_ . '-02-01' );
		$_date_range_['FEB']['MAX'] = strtotime( $_YEAR_ . '-02-29' );

		$_date_range_['MAR']['MIN'] = strtotime( $_YEAR_ . '-03-01' );
		$_date_range_['MAR']['MAX'] = strtotime( $_YEAR_ . '-03-31' );

		$_date_range_['APR']['MIN'] = strtotime( $_YEAR_ . '-04-01' );
		$_date_range_['APR']['MAX'] = strtotime( $_YEAR_ . '-04-30' );

		$_date_range_['MAY']['MIN'] = strtotime( $_YEAR_ . '-05-01' );
		$_date_range_['MAY']['MAX'] = strtotime( $_YEAR_ . '-05-31' );

		$_date_range_['JUN']['MIN'] = strtotime( $_YEAR_ . '-06-01' );
		$_date_range_['JUN']['MAX'] = strtotime( $_YEAR_ . '-06-30' );
		
		$_date_range_['JUL']['MIN'] = strtotime( $_YEAR_ . '-07-01' );
		$_date_range_['JUL']['MAX'] = strtotime( $_YEAR_ . '-07-31' );

		$_date_range_['AUG']['MIN'] = strtotime( $_YEAR_ . '-08-01' );
		$_date_range_['AUG']['MAX'] = strtotime( $_YEAR_ . '-08-31' );

		$_date_range_['SEP']['MIN'] = strtotime( $_YEAR_ . '-09-01' );
		$_date_range_['SEP']['MAX'] = strtotime( $_YEAR_ . '-09-30' );

		$_date_range_['OCT']['MIN'] = strtotime( $_YEAR_ . '-10-01' );
		$_date_range_['OCT']['MAX'] = strtotime( $_YEAR_ . '-10-31' );

		$_date_range_['NOV']['MIN'] = strtotime( $_YEAR_ . '-11-01' );
		$_date_range_['NOV']['MAX'] = strtotime( $_YEAR_ . '-11-30' );

		$_date_range_['DEC']['MIN'] = strtotime( $_YEAR_ . '-12-01' );
		$_date_range_['DEC']['MAX'] = strtotime( $_YEAR_ . '-12-31' );

		return $_date_range_[$_MONTH_][$_RANGE_];
	}

	public static function current_year(){
		return date('Y');
	}

	public static function cleanDateFormat($str_date)
	{
		list($year, $month, $day) = explode('-', $str_date);
		$foramted_date = "$day-$month-$year";
		return (string)$foramted_date;
	}

	public static function date_calculation_from_date($_datetime, $_date_differency = '+1 month')
	{
		return strtotime(self::cleanDateFormat(date('Y-m-d', ($_datetime))) . ' +30 days '); 

	}

	public static function date_calculation_from_today($__diff_number_days__ = '-90 days'){
		return strtotime( date('Y-m-d', strtotime($__diff_number_days__)) );
	}

	public static function date_7_days_ago_from_today(){
		return self::date_calculation_from_today('-7 days');
	}

	public static function date_days_range_strtotime($_period_ = 'WEEKLY')
	{
		$_today_ = time();
		$_date_range_['MIN'] = 0;
		$_date_range_['MAX'] = 0;

		if( $_period_ == 'TODAY' ):
			$_date_range_['MIN'] = strtotime( date('Y-m-d') );
			$_date_range_['MAX'] = $_today_;
		endif;

		if( $_period_ == 'WEEKLY' ):
			$_date_range_['MIN'] = self::date_7_days_ago_from_today();
			$_date_range_['MAX'] = $_today_;
		endif;

		if( $_period_ == 'MONTHLY' ):
			$_date_range_['MIN'] = strtotime( date('Y-m').'-01' );
			$_date_range_['MAX'] = strtotime( date('Y-m').'-31' );
		endif;

		if( $_period_ == 'QUARTERLY' ):
			$_month_ = (int) date('m');
			if( $_month_ <= 3):
				$_month_day_first_ = strtotime( date('Y').'-01-01' );
				$_month_day_last_  = strtotime( date('Y').'-03-31' );
			elseif( $_month_ <= 6):
				$_month_day_first_ = strtotime( date('Y').'-04-01' );
				$_month_day_last_  = strtotime( date('Y').'-06-31' );
			elseif( $_month_ <= 9):
				$_month_day_first_ = strtotime( date('Y').'-07-01' );
				$_month_day_last_  = strtotime( date('Y').'-09-31' );
			elseif( $_month_ <= 12):
				$_month_day_first_ = strtotime( date('Y').'-10-01' );
				$_month_day_last_  = strtotime( date('Y').'-12-31' );
			endif;

			$_date_range_['MIN'] = $_month_day_first_;
			$_date_range_['MAX'] = $_month_day_last_;
		endif;

		if( $_period_ == 'YEARLY' ):
			$_date_range_['MIN'] = strtotime( date('Y').'-01-01' );
			$_date_range_['MAX'] = strtotime( date('Y').'-12-31' );
		endif;

		return (Object) $_date_range_;
	}


	public static function timestamp(){
		$now = DateTime::createFromFormat('U.u', microtime(true));
		return $now->format("m-d-Y H:i:s.u");
	}

}
?>
