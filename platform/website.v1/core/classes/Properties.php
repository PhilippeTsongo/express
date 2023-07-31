<?php
/**
 * Properties Settings class
 * This Class is used for Properties Settings Related:
 * (Change Preferred Language : Initialy[French, English]
 * i18n of Each String Ouptut in the Software using JSON Properties.json
 * @author Ezechiel Kalengya Ezpk [ ezechielkalengya@gmail.com ]
 */
class Properties
{
	private $readJson;
	private $Prop;
	private $Software_Language;
	function __construct($lang='')
	{
		$this->readJson = Config::get('root/json_properties');
		$this->Prop=$this->parseJson();
		$lang=$lang?$lang:$this->selectedLang();
		$this->Software_Language=$lang;
	}

	private function parseJson(){
		$jsonData=file_get_contents(''.$this->readJson);
		$json=json_decode($jsonData,true);
		//return the decoded to php array from json
		return $json;
	}

	public function selectedLang(){
		$key=$this->string_key("software-lang");
		if($key)  foreach($this->Prop['properties'][$key] as $key=>$value) return $value['lang'];
	  else return 'fr-lang';
	}

	private function string_key($map_word){
		foreach($this->Prop['properties'] as $key => $value):
			if(key($this->Prop['properties'][$key])==$map_word): return $key;
		  else: false;
			endif;
		endforeach;
	}

	/**
	 * Returns the i18n String Output setted in properties.json Depending on the selected Lang
	 * @param string name of the string key setted in properties.json
	 */
	public function string($map_word){
		$key=$this->string_key($map_word);
		if($key)  foreach($this->Prop['properties'][$key] as $key=>$value) return $value[$this->Software_Language];
	  else return 'fr-lang';
	}

	/**
	 * Returns the i18n String Output setted in properties.json Depending on the selected Lang
	 * @param string name of the string key setted in properties.json
	 */
	public function words_old($map_word){
		$array    = $this->regroupRecognizedWords($map_word);
		$array    = explode(' ', $array);
		$results  = array();
		if(!empty($array)):
			foreach($array as $key => $value):
				$results[] = $this->string(strtolower($value))=='fr-lang'?$value:$this->string(strtolower($value));
			endforeach;
		endif;
		return implode(' ', $results);
	}

	/**
	 * Returns the i18n String Output setted in properties.json Depending on the selected Lang
	 * @param string name of the string key setted in properties.json
	 */
	public function translate($map_word){
		$array    = $this->regroupRecognizedWords($map_word);
		$array    = explode(' ', $array);
		$results  = array();
		if(!empty($array)):
			foreach($array as $key => $value):
				$results[] = $this->string(strtolower($value))=='fr-lang'?$value:$this->string(strtolower($value));
			endforeach;
		endif;
		return implode(' ', $results);
	}

		
	/**
	 * Returns the i18n String Output setted in properties.json Depending on the selected Lang
	 * @param string name of the string key setted in properties.json
	 */
	public function translate_old($map_word){
		$map_word = str_replace(['  ', '   '], ' ', $map_word);
		$array    = explode(' ', trim($map_word));
		$array    = implode('-', $array);
		$array    = strtolower($array);
		$array    = str_replace(['--'], '', $array);
		$results  = array();
		if(!empty($array)):
			$results[] = $this->string(strtolower($array))=='fr-lang'?$map_word:$this->string(strtolower($array));
		endif;
		return empty(implode(' ', $results))?$map_word:implode(' ', $results);
	}

	public function regroupRecognizedWords($map_word){
		$array_rec = array(
			
			'client information' => 'client-information',
			'do you want to' => 'do-you-want-to',
			'reset password' => 'reset-password',
			'first name' => 'first-name',
			'last name' => 'last-name',
			'telephone number' => 'telephone-number',
			'enter your' => 'enter-your',
			'job title'  => 'job-title',
			'job category'  => 'job-category',
			'discounted rate' => 'discounted-rate',
			'accounts list' => 'accounts-list',
			'medicines list' => 'medicines-list',
			'purchases list' => 'purchases-list',
			'sales list' => 'sales-list',
			'invoices list' => 'invoices-list',
			'date of invoice' => 'date-of-invoice',
			'unit list' => 'unit-list',
			'shelf list' => 'shelf-list',
			'category list' => 'category-list',
			'logistics list' => 'logistics-list',
			'new logistic' => 'new-logistic',
			'logistic name' => 'logistic-name',
			'edit logistic' => 'edit-logistic',
			'expenses list' => 'expenses-list',
			'new expense' => 'new-expense',
			'all expenses' => 'all-expenses',
			'expense name' => 'expense-name',
			'expense date' => 'expense-date',
			'expense description' => 'expense-description',
			'bulk record' => 'bulk-record',
			'expire soon' => 'expire-soon',
			'medicines expired' => 'medicines-expired',
			'basic informations' => 'basic-informations',
			'date of joining' => 'date-of-join',
			'account type' => 'account-type',
			'account code' => 'account-code',
			'company name' => 'company-name',
			'company email' => 'company-email',
			'company short name' => 'company-short-name',
			'address information' => 'address-information',
			'social media information' => 'social-media-information',
			'company public email' => 'company-public-email',
			'company public telephone' => 'company-public-telephone',
			'company telephone' => 'company-telephone',
			'company telephone number' => 'company-telephone-number',
			'company type' => 'company-type',
			'online products' => 'online-products',
			'online orders' => 'online-orders',
			'load more' => 'load-more',
			'add more' => 'add-more',
			'account name' => 'account-name',
			'company account' => 'company-account',
			'new medicine' => 'new-medicine',
			'add new medicine' => 'add-new-medicine',
			'medicine information' => 'medicine-information',
			'medicine name' => 'medicine-name',
			'medicine unit' => 'medicine-unit',
			'medicine shelf' => 'medicine-shelf',
			'medicine code' => 'medicine-code',
			'medicine description' => 'medicine-description',
			'all medicines' => 'all-medicines',
			'record bulk medicine' => 'record-bulk-medicine',
			'branch information' => 'branch-information',
			'purchase items information' => 'purchase-items-information',
			'bulk record purchases' => 'bulk-record-purchases',
			'bulk record products' => 'bulk-record-products',
			'unit name' => 'unit-name',
			'shelf name' => 'shelf-name',
			'shelf description' => 'shelf-description',
			'add new shelf' => 'add-new-shelf',
			'products list' => 'products-list',
			'product name' => 'products-name',
			'product unit' => 'products-unit',
			'product category' => 'product-category',
			'categories list' => 'categories-list',
			'sub category' => 'sub-category',
			'sub categories' => 'sub-categories',
			'sub categories list' => 'sub-categories-list',
			'product categories' => 'product-categories',
			'category description' => 'category-description',
			'category name' => 'category-name',
			'sub category name' => 'sub-category-name',
			'add new category' => 'add-new-category',
			'record bulk purchase' => 'record-bulk-purchase',
			'stock status' => 'stock-status',
			'record new purchase' => 'record-new-purchase',
			'new purchase' => 'new-purchase',
			'record purchase' => 'record-purchase',
			'date of stock purchase' => 'date-of-stock-purchase',
			'purchase list' => 'purchase-list',
			'purchase date' => 'purchase-date',
			'invoices list' => 'invoices-list',
			'client name' => 'client-name',
			'client email' => 'client-email',
			'client address' => 'client-address',
			'client telephone' => 'client-telephone',
			'all sales' => 'all-sales',
			'sale code' => 'sale-code',
			'date of sale' => 'date-of-sale',
			'record new sale' => 'record-new-sale',
			'unit price' => 'unit-price',
			'total price' => 'total-price',
			'sub total' => 'sub-total',
			'advanced search' => 'advanced-search',
			'amortization date' => 'amortization-date',
			'ref number' => 'ref-number',
			'cash inputs' => 'cash-inputs',
			'cash output' => 'cash-output',
			'cash balance' => 'cash-balance',
			'available products' => 'available-products',
			'available medicines' => 'available-medicines',
			'online medicines' => 'online-medicines',
			'total medicines' => 'total-medicines',
			'sales this year' => 'sales-this-year',
			'stock status' => 'stock-status',
			'financial statistics' => 'financial-statistics',
			'this graph shows purchases sales benefits of your stock' => 'this-graph-shows-purchases-sales-benefits-of-your-stock',
			'instore and online statistics' => 'instore-and-online-statistics',
			'this graph shows statistics of your online and instore' => 'this-graph-shows-statistics-of-your-online-and-instore',
			'purchases vs sales' => 'purchases-vs-sales',
			'this graph shows financial evolution' => 'this-graph-shows-financial-evolution',
			'top 10 most saled products' => 'top-10-most-saled-products',
			'this is the list of top most saled products' => 'this-is-the-list-of-top-most-saled-products', 
			'view all' => 'view-all',
			'top 10 gold customers' => 'top-10-gold-customers', 
			'this is the list of top gold customers' => 'this-is-the-list-of-top-gold-customers',
			'products category' => 'products-category',
			'sub category' => 'sub-category',
			'new sale' => 'new-sale',
			'invoices list' => 'invoice-list',
			'products finished' => 'products-finished',
			'record purchases' => 'record-purchases',
			'sale invoice information' => 'sale-invoice-information',
			'invoices list' => 'invoices-list',
			'available medicines' => 'available-medicines',
			'members list' => 'members-list',
			'new member' => 'new-member',
			'new cycle' => 'new-cycle',
			'cycles list' => 'cycles-list',
			'cycle duration' => 'cycle-duration',
			'cycle start date' => 'cycle-start-date',
			'new contribution' => 'new-contribution',
			'contribution amount' => 'contribution-amount',
			'contributions list' => 'contributions-list',
			'payback list' => 'payback-list',
			'new payback' => 'new-payback',
			'notifications list' => 'notifications-list',
			'loan amount' => 'loan-amount',
			'loan minimum amount' => 'loan-minimum-amount',
			'loan maximum amount' => 'loan-maximum-amount',
			'loan interest rate' => 'loan-interest-rate',
			'loans list' => 'loans-list',
			'new loan' => 'new-loan',
			'frequency of meeting' => 'frequency-of-meeting',
			'meeting type' => 'meeting-type',
			'venue of meeting' => 'venue-of-meeting',
			'meeting start time' => 'meeting-start-time', 
			'delay penalty' => 'delay-penalty',
			'unjustify absence penalty' => 'unjustify-absence-penalty',
			'edit contribution' => 'edit-contribution',
			'edit loan' => 'edit-loan',
			'payback amount' => 'payback-amount',
			'save payback' => 'save-payback',
			'edit payback' => 'edit-payback',
			'welcome to' => 'welcome-to',
			'cns-store' => 'cns-store',
			'remember me' => 'remember-me',
			'forgot password' => 'forgot-password',
			'confirm password' => 'confirm-password',
			"don't have an account" => 'dont-have-an-account',
			'create your business account' => 'create-your-business-account',
			'this platform allows you to deal with your inventory as well as your employee section guiding you in getting a general view of your business level.' => 'this-platform-allows-you-to-deal-with-your-inventory-as-well-as-your-employee-section-guiding-you-in-getting-a-general-view-of-your-business-level.',
			'on time techinical support for 24h/7days. if you have an issue, drop us a line on' => 'on-time-techinical-support-for-24h/7days.-if-you-have-an-issue,-drop-us-a-line-on',
			'representative information' => 'representative-information',
			'representative first name' => 'representative-firstname',
			'representative last name' => 'representative-lastname',
			'representative email' => 'representative-email',
			'representative telephone' => 'representative-telephone',
			'your cns eshop website' => 'your-cns-eshop-website',
			'platform information' => 'platform-information',
			'cns store account' => 'cns-store-account',
			'get access through the management system and manage your business safely.' => 'get-access-through-the-management-system-and-manage-your-business-safely.',
			'already registered' => 'already-registered',
			'sign in' => 'sign-in',
			'one account with powerful services for your great and valuable customers.' => 'one-account-with-powerful-services-for-your-great-and-valuable-customers.',
			'automatic inventory management software reduces lead times, increases efficiency and improves customer satisfaction. this helps maintain a competitive edge and generate more revenue over time.' => 'automatic-inventory-management-software-reduces-lead-times,-increases-efficiency-and-improves-customer-satisfaction.-this-helps-maintain-a-competitive-edge-and-generate-more-revenue-over-time.',

		);
		foreach($array_rec As $recognized_key => $recognized_value)
			if(strpos(strtolower($map_word), strtolower($recognized_key)) !== false)
				$map_word = str_replace($recognized_key, $recognized_value, strtolower($map_word));
		
		return $map_word;
	}
	
	/**
	 * Returns the i18n String Output setted in properties.json Depending on the selected Lang
	 * @param string name of the string key setted in properties.json
	 */
	public function content($map_word){
		$array    = explode(' ', trim($map_word));
		$array    = 'content-'.implode('-', $array);
		$array    = strtolower($array);
		$array    = str_replace(['--'], '', $array);
		$results  = array();
		if(!empty($array)):
			$results[] = $this->string(strtolower($array))=='fr-lang'?$map_word:$this->string(strtolower($array));
		endif;
		return empty(implode(' ', $results))?'':implode(' ', $results);
	}
	

	/**
	 * Returns true or false if selected Language has changed
	 * @param string new_value lange ex. fr-lang, eng-lang
	 */
	public function changeLang($new_value){
		$key=$this->string_key("software-lang");
		$data = $this->Prop;
		if($key):
			$data['properties'][$key]['software-lang']['lang']=$new_value;
			$newJsonString = json_encode($data);
			if(file_put_contents($this->readJson, $newJsonString)) return true; else false;
		else: return false;
		endif;
	}

}



?>
