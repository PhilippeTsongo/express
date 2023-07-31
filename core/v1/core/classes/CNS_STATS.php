<?php
class CNS_STATS
{
	
	/**
	 * @method String clean_null_value()
	 * @package Helper Query Maker - Clean Number Value Null
	 */
	public static function clean_null_value($_key_){
		return ( $_key_ == null)?0:$_key_;
	}

	/**
	 * @method String percentage()
	 * @package Helper Query Maker - Get Percentage
	 */
	public static function percentage($_value_, $_total_){
		$_percentage_ = $_value_ * 100;
		$_percentage_/= ( $_total_ == 0)?1:$_total_;
		return abs ( number_format( $_percentage_ ) );
	}

	/**
	 * @method String percentage()
	 * @package Helper Query Maker - Get Percentage
	 */
	public static function number_format($_number_){
		return number_format( $_number_ );
	}

	/**
	 * @method String query_condition_where_in_current_period()
	 * @package Helper Query Maker - Query SQL Where Matches Period Range
	 */
	public static function query_condition_where_in_current_period( $_period_ = 'TODAY', $_column_ )
	{
		$_date__period_range_ = Dates::date_days_range_strtotime($_period_);
		$_where_query_condition_ = " $_column_ BETWEEN {$_date__period_range_->MIN} AND {$_date__period_range_->MAX} ";
		return $_where_query_condition_;
	}

	/**
	 * @method String query_condition_where_payment_status()
	 * @package Helper Query Maker - Query SQL Where Matches Payment Status
	 */
	public static function query_condition_where_payment_status($_payment_status_ = 'COMPLETED', $_column_){
		$_query_condition_ = " $_column_ = '{$_payment_status_}' ";
		return $_query_condition_;
	}

	/**
	 * @method String query_condition_where_customer_shop_region()
	 * @package Helper Query Maker - Query SQL Where Matches Payment Shop Region
	 */
	public static function query_condition_where_customer_shop_region($_region_id_ = 1, $_column_){
		$_query_condition_ = " (SELECT province_id FROM bboxx_shop WHERE id =  $_column_ ) = $_region_id_ ";
		return $_query_condition_;
	}

	/**
	 * @method String query_condition_where_payment_entry_payment_datetime()
	 * @package Helper Query Maker - Query SQL Where Matches Payment Payment Datetime
	 */
	public static function query_condition_where_finance_operation_datetime($_MONTH_= 'JAN', $_YEAR_){
		$_query_condition_ = " cns_cluster_trace_finance.operation_datetime BETWEEN ". Dates::year_months_range_strtotime($_YEAR_, $_MONTH_, 'MIN') ." AND  ". Dates::year_months_range_strtotime($_YEAR_, $_MONTH_, 'MAX') ." ";
		return $_query_condition_;
	}

	/**
	 * @method String output_trends_in_period()
	 * @package Helper Query Maker - Output In Period @N / @T (@Percentage)
	 */
	public static function output_trends_in_period($_value, $_total, $_currency = '')
	{
		return number_format ( $_value ) . ' / ' . number_format ( $_total ) . ' ( +' . round( self::percentage ( $_value, $_total ) ) . ' % )';
	}

	/**
	 * @method stats int cns_stats_store_dashboard_count_total_partner_ship_customers_users()
	 * @package Get Count ship express 
	 */
	public static function cns_express_stats_dashboard_count_total( $_filter_condtion_ = "")
	{
		$CNSROOTShipTable = new \CNS_SHIP();
		// $ClusterTable = new \CNS_SHIP_CLUSTER();
		// $AccountTable = new \CNS_B2B_USERS_Account();

		$CNSROOTShipTable->selectQuery(
		"SELECT COUNT(cns_express_ship.id) as total_ships,

			(SELECT COUNT(cns_express_ship.id) as active_ships FROM cns_express_ship WHERE cns_express_ship.status = 'APPROVED') as approved_ships,

			(SELECT COUNT(cns_express_ship.id) as active_ships FROM cns_express_ship WHERE cns_express_ship.status = 'INITIATED') as initiated_ships,

			(SELECT COUNT(cns_b2c_customer.id) as total_customer FROM cns_b2c_customer WHERE cns_b2c_customer.status != 'DELETED') as total_customer,					

			(SELECT COUNT(cns_express_partners.id) as total_partners FROM cns_express_partners WHERE cns_express_partners.status != 'DELETED') as total_partners,


			(SELECT COUNT(cns_cluster_account_b2b_users.id) as total_user FROM cns_cluster_account_b2b_users WHERE cns_cluster_account_b2b_users.status != 'DELETED') as total_user


		FROM cns_express_ship WHERE cns_express_ship.status != 'DELETED';
		");

		if ($CNSROOTShipTable->count()):
			$_DATA_ = array();
			$list_ = $CNSROOTShipTable->first();

			$list_->total_ships	= self::clean_null_value( $list_->total_ships );

			$list_->pc_approved_ships	= self::percentage( $list_->approved_ships, $list_->total_ships );
		
			$list_->pc_initiated_ships	= self::percentage( $list_->initiated_ships, $list_->total_ships );

			$list_->total_customer = self::clean_null_value( $list_->total_customer );

			$list_->total_partners	= self::clean_null_value( $list_->total_partners );

			$list_->total_user = self::clean_null_value( $list_->total_user );

			$_DATA_ = (Array) $list_;
			return $_DATA_;
		endif;
		return false;
	}


	/**
	 * @method stats int cns_stats_store_dashboard_5_last_ship()
	 * @package Get Count Total Products 
	 */
	public static function cns_stats_express_dashboard_5_last_ship($_filter_condtion_ = "")
	{
		$CNS_STATS = new \CNS_CLUSTER_Data();
		$today = Dates::today();
		$CNS_STATS->selectQuery("SELECT cns_express_ship.id as token_id, code, 
		(SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_express_ship.source_country ORDER BY id DESC LIMIT 1) as source_country, 
		(SELECT name FROM cns_data_country WHERE cns_data_country.id = cns_express_ship.destination_country ORDER BY id DESC LIMIT 1) as destination_country, status 
		FROM cns_express_ship ORDER BY cns_express_ship.id DESC LIMIT 0,5");
		
		if ($CNS_STATS->count()):
			$_DATA_ = array();
			$HASH 	= new \Hash();

			foreach( $CNS_STATS->data() As $list_ ):
				$list_->token_id   		  = Hash::encryptToken($list_->token_id);
				
				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}


	/**
	 * @method stats int cns_stats_store_dashboard_count_total_stock_products()
	 * @package Get Count Total Products 
	 */
	public static function cns_stats_store_dashboard_count_total_finance( $_SQL_CONDITIONS_ = "")
	{
		$CNS_STATS = new \CNS_CLUSTER_Data();
		$today = Dates::today();
		$CNS_STATS->selectQuery("SELECT SUM(total_price) as total_money_purchase, 

		(SELECT SUM(total_price) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = 'STOCK_SALE'  $_SQL_CONDITIONS_) AS total_money_sales, 
		
		(SELECT SUM(benefice) as total_money_purchase FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = 'STOCK_SALE'  $_SQL_CONDITIONS_) AS total_money_benefits,
		
		(SELECT SUM(total_price) as total_money_purchase FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND (operation_type = 'EXPENSE' OR operation_type = 'LOGISTIC_PURCHASE') $_SQL_CONDITIONS_ ) AS total_money_expenses 
		
		FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = 'STOCK_PURCHASE' $_SQL_CONDITIONS_ ");
		
		if ($CNS_STATS->count()):
			$_DATA_ = array();
			$HASH 	= new \Hash();
			$list_  = $CNS_STATS->first();
			$list_->total_money_sales   		 = self::clean_null_value( $list_->total_money_sales );
			$list_->total_money_purchase   	 = self::clean_null_value( $list_->total_money_purchase );
			$list_->total_money_benefits = self::clean_null_value( $list_->total_money_benefits );
			$list_->total_money_expenses  = self::clean_null_value( $list_->total_money_expenses );
			$list_->total_money_debts  = 0; //self::clean_null_value( $list_->total_money_debts );
			
			$_DATA_ 			 = (Array) $list_;
			return $_DATA_;
		endif;
		return false;
	}

	/**
	 * @method stats int cns_stats_store_dashboard_count_total_stock_products()
	 * @package Get Count Total Products 
	 */
	public static function cns_expresstats_store_dashboard_count_website_visits( $_SQL_CONDITIONS_ = "")
	{
		$CNS_STATS = new \CNS_CLUSTER_Data();
		$today = Dates::today();
		$CNS_STATS->selectQuery("SELECT SUM(total_price) as total_count_visits
		FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = 'STOCK_PURCHASE' $_SQL_CONDITIONS_ ");
		
		if ($CNS_STATS->count()):
			$_DATA_ = array();
			$HASH 	= new \Hash();
			$list_  = $CNS_STATS->first();
			$list_->total_count_visits  		 = 0;
			$list_->total_count_visits_this_year   	 = 0;
			$list_->total_count_visits_this_month = 0;
			$list_->total_count_visits_today  = 0;
			$list_->total_count_visits_yesterday  = 0;
			
			$_DATA_ 			 = (Array) $list_;
			return $_DATA_;
		endif;
		return false;
	}

	

	/**
	 * @method stats int cns_stats_store_dashboard_count_total_stock_products()
	 * @package Get Count Total Products 
	 */
	public static function cns_stats_store_dashboard_list_top_customers( $_SQL_CONDITIONS_ = "", $_SQL_LIMIT_)
	{
		$CNS_STATS = new \CNS_CLUSTER_Data();
		$today = Dates::today();
		$CNS_STATS->selectQuery("SELECT id as token_id, count(*) as total_top, SUM(number_items) AS total_items, client_name as customer_name, client_email as customer_email, client_telephone as customer_telephone, 
		(SELECT SUM(number_items) AS total_count FROM cns_store_stock_sale_invoice WHERE client_telephone = customer_telephone $_SQL_CONDITIONS_ ) AS total_items_purchased, 
		(SELECT SUM(total_price) AS total_count FROM cns_store_stock_sale_invoice WHERE client_telephone = customer_telephone $_SQL_CONDITIONS_ ) AS total_money_purchased 
		FROM cns_store_stock_sale_invoice where status != 'DELETED' AND client_telephone != '' $_SQL_CONDITIONS_ GROUP BY client_telephone DESC ORDER BY total_top DESC $_SQL_LIMIT_ ");
		
		if ($CNS_STATS->count()):
			$_DATA_ = array();
			$HASH 	= new \Hash();

			foreach( $CNS_STATS->data() As $list_ ):
				$list_->token_id   		  = Hash::encryptToken($list_->token_id);
				$list_->total_items_purchased   = self::clean_null_value( $list_->total_items_purchased );
				$list_->total_money_purchased   = self::clean_null_value( $list_->total_money_purchased );
				$list_->total_orders = 0;

				$_DATA_[] 			 = (Array) $list_;
			endforeach;
			return $_DATA_;
		endif;
		return false;
	}

	/**
	 * @method stats int cns_stats_store_dashboard_web_visits_over_year()
	 * @package Get Online Web Visits Over Year
	 */
	public static function cns_stats_store_dashboard_web_visits_over_year( $_SQL_CONDITIONS_ = "")
	{
		$CNS_STATS = new \CNS_CLUSTER_Data();
		$today = Dates::today();
		$CNS_STATS->selectQuery("SELECT SUM(total_price) as total_count
		FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = 'STOCK_PURCHASE' $_SQL_CONDITIONS_ ");
		
		if ($CNS_STATS->count()):
			$_DATA_ = array();
			$HASH 	= new \Hash();
			$list_  = $CNS_STATS->first();
			$list_->total_count  = 0;
			$list_->total_01   	 = 0;
			$list_->total_02   	 = 0;
			$list_->total_03   	 = 0;
			$list_->total_04   	 = 0;
			$list_->total_05   	 = 0;
			$list_->total_06   	 = 0;
			$list_->total_07   	 = 0;
			$list_->total_08   	 = 0;
			$list_->total_09   	 = 0;
			$list_->total_10   	 = 0;
			$list_->total_11   	 = 0;
			$list_->total_12   	 = 0;
			
			$_DATA_ 			 = (Array) $list_;
			return $_DATA_;
		endif;
		return false;
	}


	/**
	 * @method stats int cns_stats_store_dashboard_online_orders_over_year()
	 * @package Get Online Orders Over Year Stats
	 */
	public static function cns_stats_store_dashboard_online_orders_over_year( $_SQL_CONDITIONS_ = "")
	{
		$CNS_STATS = new \CNS_CLUSTER_Data();
		$today = Dates::today();
		$CNS_STATS->selectQuery("SELECT SUM(total_price) as total_count
		FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = 'STOCK_PURCHASE' $_SQL_CONDITIONS_ ");
		
		if ($CNS_STATS->count()):
			$_DATA_ = array();
			$HASH 	= new \Hash();
			$list_  = $CNS_STATS->first();
			$list_->total_count  = 0;
			$list_->total_01   	 = 0;
			$list_->total_02   	 = 0;
			$list_->total_03   	 = 0;
			$list_->total_04   	 = 0;
			$list_->total_05   	 = 0;
			$list_->total_06   	 = 0;
			$list_->total_07   	 = 0;
			$list_->total_08   	 = 0;
			$list_->total_09   	 = 0;
			$list_->total_10   	 = 0;
			$list_->total_11   	 = 0;
			$list_->total_12   	 = 0;
			
			$_DATA_ 			 = (Array) $list_;
			return $_DATA_;
		endif;
		return false;
	}

	/**
	 * @method stats int cns_stats_store_dashboard_money_finance_over_year()
	 * @package Get Money Finance Over Year Stats
	 */
	public static function cns_stats_store_dashboard_money_finance_over_year( $_YEAR_, $_OPERATION_TYPE_, $_SQL_CONDITIONS_ = "")
	{
		$CNS_STATS = new \CNS_CLUSTER_Data();
		$_SUM_COLUMN_MONEY_ = $_OPERATION_TYPE_ == "STOCK_SALE_BENEFICE"? "benefice" : "total_price";
		$_OPERATION_TYPE_ = $_OPERATION_TYPE_ == "STOCK_SALE_BENEFICE"? "STOCK_SALE" : $_OPERATION_TYPE_;

		$CNS_STATS->selectQuery("SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_count,

		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('JAN', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_01,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('FEB', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_02,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('MAR', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_03,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('APR', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_04,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('MAY', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_05,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('JUN', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_06,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('JUL', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_07,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('AUG', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_08,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('SEP', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_09,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('OCT', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_10,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('NOV', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_11,
		(SELECT SUM( $_SUM_COLUMN_MONEY_ ) as total_money FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_' AND  ". self::query_condition_where_finance_operation_datetime('DEC', $_YEAR_) ."  $_SQL_CONDITIONS_) AS total_12

		FROM cns_cluster_trace_finance WHERE status != 'DELETED' AND operation_type = '$_OPERATION_TYPE_'  AND  ". self::query_condition_where_finance_operation_datetime('YEARLY', $_YEAR_)  ." $_SQL_CONDITIONS_  ");
		
		if ($CNS_STATS->count()):
			$_DATA_ = array();
			$HASH 	= new \Hash();
			$list_  = $CNS_STATS->first();
			$list_->total_count  = self::clean_null_value( $list_->total_count );
			$list_->total_01   	 = self::clean_null_value( $list_->total_01 );
			$list_->total_02   	 = self::clean_null_value( $list_->total_02 );
			$list_->total_03   	 = self::clean_null_value( $list_->total_03 );
			$list_->total_04   	 = self::clean_null_value( $list_->total_04 );
			$list_->total_05   	 = self::clean_null_value( $list_->total_05 );
			$list_->total_06   	 = self::clean_null_value( $list_->total_06 );
			$list_->total_07   	 = self::clean_null_value( $list_->total_07 );
			$list_->total_08   	 = self::clean_null_value( $list_->total_08 );
			$list_->total_09   	 = self::clean_null_value( $list_->total_09 );
			$list_->total_10   	 = self::clean_null_value( $list_->total_10 );
			$list_->total_11   	 = self::clean_null_value( $list_->total_11 );
			$list_->total_12   	 = self::clean_null_value( $list_->total_12 );
			
			$_DATA_ 			 = (Array) $list_;
			return $_DATA_;
		endif;
		return false;
	}

	public static function cleanDateFormat($str_date)
	{
		list($year, $month, $day) = explode('-', $str_date);
		$foramted_date = "$day-$month-$year";
		return (string)$foramted_date;
	}




}
