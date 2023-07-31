<?php
class Country
{
	private static $_country = null;
	private $_db,
			$_data,
			$_errors = array();
	
	public function __construct($country = ''){
		$this->_db = DB::getInstance();
		$this->find($country);
	}

//ADDING A COUNTRY
	public function add($fields = array()){
		if(!$this->_db->insert('country', $fields)){
			throw new Exception("There was a problem adding a country.");
		}
	}

// COUNTRY UPDATE
	public function update($fields = array(),$id = null){
		if(!$this->_db->update('country',$id,$fields)){
			throw new Exception('There was a problem updating');
		}
	}
	
// COUNTRY DELETE
	public function delete($fields = array(),$id = null){
		if(!$this->_db->delete('country',array('id' => $id))){
			throw new Exception('There was a problem updating');
		}
	}

// FIND COUNTRY
	public function find($country = null,$limit = null){
		if(is_numeric($country)){
			$field = 'country_ID';
		}elseif(!empty($country)){
			$field = 'country_name';
		}
		
		if($country){
			$data = $this->_db->get('country', array($field, '=', $country),$limit);
			
		}else{
			echo 'hh';
			$data = $this->_db->query("SELECT* FROM `country`");
		}
		
		if($data->count()){
			$this->_data = $data->results();
			return true;
		}
		return false;
	}
	
	public function exists(){
		return (!empty($this->_data))? true : false;
	}

// DATA COLLECT
	public function data(){
		return $this->_data;
	}
	
// GET COUNTRY
	public static function getCountry($id){
		if(empty($id)==false){
			$countries = Country::getCountry();
			return $countries[$id]['name'];
		}
		return '........................................';
	}
	
// ADD ERRORS NOTIF
	private function addError($error){
		$this->_errors[] = $error;
	}
// ERROR COLLECT
	public function errors(){
		return $this->_errors;
	}
	
	public static function getArrays(){	
		$countries = array();
		$countries[] = array("code"=>"AF","name"=>"Afghanistan","d_code"=>"+93","icon"=>"Afghanistan.png");
		$countries[] = array("code"=>"AL","name"=>"Albania","d_code"=>"+355","icon"=>"Albania.png");
		$countries[] = array("code"=>"DZ","name"=>"Algeria","d_code"=>"+213","icon"=>"Algeria.png");
		$countries[] = array("code"=>"AS","name"=>"American Samoa","d_code"=>"+1","icon"=>"American_Samoa.png");
		$countries[] = array("code"=>"AD","name"=>"Andorra","d_code"=>"+376","icon"=>"Andorra.png");
		$countries[] = array("code"=>"AO","name"=>"Angola","d_code"=>"+244","icon"=>"Angola.png");
		$countries[] = array("code"=>"AI","name"=>"Anguilla","d_code"=>"+1","icon"=>"Anguilla.png");
		$countries[] = array("code"=>"AG","name"=>"Antigua & Barbuda","d_code"=>"+1","icon"=>"Antigua_Barbuda.png");
		$countries[] = array("code"=>"AR","name"=>"Argentina","d_code"=>"+54","icon"=>"Argentina.png");
		$countries[] = array("code"=>"AM","name"=>"Armenia","d_code"=>"+374","icon"=>"Armenia.png");
		$countries[] = array("code"=>"AW","name"=>"Aruba","d_code"=>"+297","icon"=>"Aruba.png");
		$countries[] = array("code"=>"AU","name"=>"Australia","d_code"=>"+61","icon"=>"Australia.png");
		$countries[] = array("code"=>"AT","name"=>"Austria","d_code"=>"+43","icon"=>"Austria.png");
		$countries[] = array("code"=>"AZ","name"=>"Azerbaijan","d_code"=>"+994","icon"=>"Azerbaijan.png");
		$countries[] = array("code"=>"BH","name"=>"Bahamas","d_code"=>"+973","icon"=>"Bahamas.png");
		$countries[] = array("code"=>"BH","name"=>"Bahrain","d_code"=>"+973","icon"=>"Bahrain.png");
		$countries[] = array("code"=>"BD","name"=>"Bangladesh","d_code"=>"+880","icon"=>"Bangladesh.png");
		$countries[] = array("code"=>"BB","name"=>"Barbados","d_code"=>"+1","icon"=>"Barbados.png");
		$countries[] = array("code"=>"BY","name"=>"Belarus","d_code"=>"+375","icon"=>"Belarus.png");
		$countries[] = array("code"=>"BE","name"=>"Belgium","d_code"=>"+32","icon"=>"Belgium.png");
		$countries[] = array("code"=>"BZ","name"=>"Belize","d_code"=>"+501","icon"=>"Belize.png");
		$countries[] = array("code"=>"BJ","name"=>"Benin","d_code"=>"+229","icon"=>"Benin.png");
		$countries[] = array("code"=>"BM","name"=>"Bermuda","d_code"=>"+1","icon"=>"Bermuda.png");
		$countries[] = array("code"=>"BT","name"=>"Bhutan","d_code"=>"+975","icon"=>"Bhutan.png");
		$countries[] = array("code"=>"BO","name"=>"Bolivia","d_code"=>"+591","icon"=>"Bolivia.png");
		$countries[] = array("code"=>"BA","name"=>"Bosnia and Herzegovina","d_code"=>"+387","icon"=>"Bosnia_Herzegovina.png");
		$countries[] = array("code"=>"BW","name"=>"Botswana","d_code"=>"+267","icon"=>"Botswana.png");
		$countries[] = array("code"=>"BR","name"=>"Brazil","d_code"=>"+55","icon"=>"Brazil.png");
		$countries[] = array("code"=>"IO","name"=>"British Indian Ocean Territory","d_code"=>"+246","icon"=>"british_indian_ocean_territory.png");
		$countries[] = array("code"=>"VG","name"=>"British Virgin Islands","d_code"=>"+1","icon"=>"British_Virgin_Islands.png");
		$countries[] = array("code"=>"BN","name"=>"Brunei","d_code"=>"+673","icon"=>"Brunei.png");
		$countries[] = array("code"=>"BG","name"=>"Bulgaria","d_code"=>"+359","icon"=>"Bulgaria.png");
		$countries[] = array("code"=>"BF","name"=>"Burkina Faso","d_code"=>"+226","icon"=>"Burkina_Faso.png");
		$countries[] = array("code"=>"MM","name"=>"Burma Myanmar" ,"d_code"=>"+95","icon"=>"Burma_Myanmar.png");
		$countries[] = array("code"=>"BI","name"=>"Burundi","d_code"=>"+257","icon"=>"Burundi.png");
		$countries[] = array("code"=>"KH","name"=>"Cambodia","d_code"=>"+855","icon"=>"Cambodia.png");
		$countries[] = array("code"=>"CM","name"=>"Cameroon","d_code"=>"+237","icon"=>"Cameroon.png");
		$countries[] = array("code"=>"CA","name"=>"Canada","d_code"=>"+1","icon"=>"Canada.png");
		$countries[] = array("code"=>"CV","name"=>"Cape Verde","d_code"=>"+238","icon"=>"Cape_Verde.png");
		$countries[] = array("code"=>"KY","name"=>"Cayman Islands","d_code"=>"+1","icon"=>"Cayman_Islands.png");
		$countries[] = array("code"=>"CF","name"=>"Central African Republic","d_code"=>"+236","icon"=>"Central_African_Republic.png");
		$countries[] = array("code"=>"TD","name"=>"Chad","d_code"=>"+235","icon"=>"Chad.png");
		$countries[] = array("code"=>"CL","name"=>"Chile","d_code"=>"+56","icon"=>"Chile.png");
		$countries[] = array("code"=>"CN","name"=>"China","d_code"=>"+86","icon"=>"China.png");
		$countries[] = array("code"=>"CO","name"=>"Colombia","d_code"=>"+57","icon"=>"Colombia.png");
		$countries[] = array("code"=>"KM","name"=>"Comoros","d_code"=>"+269","icon"=>"Comoros.png");
		$countries[] = array("code"=>"CK","name"=>"Cook Islands","d_code"=>"+682","icon"=>"Cook_Islands.png");
		$countries[] = array("code"=>"CR","name"=>"Costa Rica","d_code"=>"+506","icon"=>"Costa_Rica.png");
		$countries[] = array("code"=>"CI","name"=>"Cote d'Ivoire" ,"d_code"=>"+225","icon"=>"Cote_d_Ivoire.png");
		$countries[] = array("code"=>"HR","name"=>"Croatia","d_code"=>"+385","icon"=>"Croatia.png");
		$countries[] = array("code"=>"CU","name"=>"Cuba","d_code"=>"+53","icon"=>"Cuba.png");
		$countries[] = array("code"=>"CY","name"=>"Cyprus","d_code"=>"+357","icon"=>"Cyprus.png");
		$countries[] = array("code"=>"CZ","name"=>"Czech Republic","d_code"=>"+420","icon"=>"Czech_Republic.png");
		$countries[] = array("code"=>"CD","name"=>"Democratic Republic of Congo","d_code"=>"+243","icon"=>"Congo_Kinshasa.png");
		$countries[] = array("code"=>"DK","name"=>"Denmark","d_code"=>"+45","icon"=>"Denmark.png");
		$countries[] = array("code"=>"DJ","name"=>"Djibouti","d_code"=>"+253","icon"=>"Djibouti.png");
		$countries[] = array("code"=>"DM","name"=>"Dominica","d_code"=>"+1","icon"=>"Dominica.png");
		$countries[] = array("code"=>"DO","name"=>"Dominican Republic","d_code"=>"+1","icon"=>"Dominican_Republic.png");
		$countries[] = array("code"=>"EC","name"=>"Ecuador","d_code"=>"+593","icon"=>"Ecuador.png");
		$countries[] = array("code"=>"EG","name"=>"Egypt","d_code"=>"+20","icon"=>"Egypt.png");
		$countries[] = array("code"=>"SV","name"=>"El Salvador","d_code"=>"+503","icon"=>"El_Salvador.png");
		$countries[] = array("code"=>"GQ","name"=>"Equatorial Guinea","d_code"=>"+240","icon"=>"Equatorial_Guinea.png");
		$countries[] = array("code"=>"ER","name"=>"Eritrea","d_code"=>"+291","icon"=>"Eritrea.png");
		$countries[] = array("code"=>"EE","name"=>"Estonia","d_code"=>"+372","icon"=>"Estonia.png");
		$countries[] = array("code"=>"ET","name"=>"Ethiopia","d_code"=>"+251","icon"=>"Ethiopia.png");
		$countries[] = array("code"=>"FK","name"=>"Falkland Islands","d_code"=>"+500","icon"=>"Falkland_Islands.png");
		$countries[] = array("code"=>"FO","name"=>"Faroe Islands","d_code"=>"+298","icon"=>"Faroes.png");
		$countries[] = array("code"=>"FM","name"=>"Federated States of Micronesia","d_code"=>"+691","icon"=>"Micronesia.png");
		$countries[] = array("code"=>"FJ","name"=>"Fiji","d_code"=>"+679","icon"=>"Fiji.png");
		$countries[] = array("code"=>"FI","name"=>"Finland","d_code"=>"+358","icon"=>"Finland.png");
		$countries[] = array("code"=>"FR","name"=>"France","d_code"=>"+33","icon"=>"France.png");
		$countries[] = array("code"=>"GF","name"=>"French Guiana","d_code"=>"+594","icon"=>"");
		$countries[] = array("code"=>"PF","name"=>"French Polynesia","d_code"=>"+689","icon"=>"");
		$countries[] = array("code"=>"GA","name"=>"Gabon","d_code"=>"+241","icon"=>"Gabon.png");
		$countries[] = array("code"=>"GE","name"=>"Georgia","d_code"=>"+995","icon"=>"Georgia.png");
		$countries[] = array("code"=>"DE","name"=>"Germany","d_code"=>"+49","icon"=>"Germany.png");
		$countries[] = array("code"=>"GH","name"=>"Ghana","d_code"=>"+233","icon"=>"Ghana.png");
		$countries[] = array("code"=>"GI","name"=>"Gibraltar","d_code"=>"+350","icon"=>"Gibraltar.png");
		$countries[] = array("code"=>"GR","name"=>"Greece","d_code"=>"+30","icon"=>"Greece.png");
		$countries[] = array("code"=>"GL","name"=>"Greenland","d_code"=>"+299","icon"=>"Greenland.png");
		$countries[] = array("code"=>"GD","name"=>"Grenada","d_code"=>"+1","icon"=>"Grenada.png");
		$countries[] = array("code"=>"GP","name"=>"Guadeloupe","d_code"=>"+590","icon"=>"Guadeloupe.png");
		$countries[] = array("code"=>"GU","name"=>"Guam","d_code"=>"+1","icon"=>"Guam.png");
		$countries[] = array("code"=>"GT","name"=>"Guatemala","d_code"=>"+502","icon"=>"Guademala.png");
		$countries[] = array("code"=>"GN","name"=>"Guinea","d_code"=>"+224","icon"=>"Guinea.png");
		$countries[] = array("code"=>"GW","name"=>"Guinea-Bissau","d_code"=>"+245","icon"=>"Guinea_Bissau.png");
		$countries[] = array("code"=>"GY","name"=>"Guyana","d_code"=>"+592","icon"=>"Guyana.png");
		$countries[] = array("code"=>"HT","name"=>"Haiti","d_code"=>"+509","icon"=>"Haiti.png");
		$countries[] = array("code"=>"HN","name"=>"Honduras","d_code"=>"+504","icon"=>"Honduras.png");
		$countries[] = array("code"=>"HK","name"=>"Hong Kong","d_code"=>"+852","icon"=>"Hong_Kong.png");
		$countries[] = array("code"=>"HU","name"=>"Hungary","d_code"=>"+36","icon"=>"Hungary.png");
		$countries[] = array("code"=>"IS","name"=>"Iceland","d_code"=>"+354","icon"=>"Iceland.png");
		$countries[] = array("code"=>"IN","name"=>"India","d_code"=>"+91","icon"=>"India.png");
		$countries[] = array("code"=>"ID","name"=>"Indonesia","d_code"=>"+62","icon"=>"Indonesia.png");
		$countries[] = array("code"=>"IR","name"=>"Iran","d_code"=>"+98","icon"=>"Iran.png");
		$countries[] = array("code"=>"IQ","name"=>"Iraq","d_code"=>"+964","icon"=>"Iraq.png");
		$countries[] = array("code"=>"IE","name"=>"Ireland","d_code"=>"+353","icon"=>"Ireland.png");
		$countries[] = array("code"=>"IL","name"=>"Israel","d_code"=>"+972","icon"=>"Israel.png");
		$countries[] = array("code"=>"IT","name"=>"Italy","d_code"=>"+39","icon"=>"Italy.png");
		$countries[] = array("code"=>"JM","name"=>"Jamaica","d_code"=>"+1","icon"=>"Jamaica.png");
		$countries[] = array("code"=>"JP","name"=>"Japan","d_code"=>"+81","icon"=>"Japan.png");
		$countries[] = array("code"=>"JO","name"=>"Jordan","d_code"=>"+962","icon"=>"Jordan.png");
		$countries[] = array("code"=>"KZ","name"=>"Kazakhstan","d_code"=>"+7","icon"=>"Kazakhstan.png");
		$countries[] = array("code"=>"KE","name"=>"Kenya","d_code"=>"+254","icon"=>"Kenya.png");
		$countries[] = array("code"=>"KI","name"=>"Kiribati","d_code"=>"+686","icon"=>"Kiribati.png");
		$countries[] = array("code"=>"XK","name"=>"Kosovo","d_code"=>"+381","icon"=>"Kosovo.png");
		$countries[] = array("code"=>"KW","name"=>"Kuwait","d_code"=>"+965","icon"=>"Kuwait.png");
		$countries[] = array("code"=>"KG","name"=>"Kyrgyzstan","d_code"=>"+996","icon"=>"Kyrgyzstan.png");
		$countries[] = array("code"=>"LA","name"=>"Laos","d_code"=>"+856","icon"=>"Laos.png");
		$countries[] = array("code"=>"LV","name"=>"Latvia","d_code"=>"+371","icon"=>"Latvia.png");
		$countries[] = array("code"=>"LB","name"=>"Lebanon","d_code"=>"+961","icon"=>"Lebanon.png");
		$countries[] = array("code"=>"LS","name"=>"Lesotho","d_code"=>"+266","icon"=>"Lesotho.png");
		$countries[] = array("code"=>"LR","name"=>"Liberia","d_code"=>"+231","icon"=>"Liberia.png");
		$countries[] = array("code"=>"LY","name"=>"Libya","d_code"=>"+218","icon"=>"Libya.png");
		$countries[] = array("code"=>"LI","name"=>"Liechtenstein","d_code"=>"+423","icon"=>"Liechtenstein.png");
		$countries[] = array("code"=>"LT","name"=>"Lithuania","d_code"=>"+370","icon"=>"Lithuania.png");
		$countries[] = array("code"=>"LU","name"=>"Luxembourg","d_code"=>"+352","icon"=>"Luxembourg.png");
		$countries[] = array("code"=>"MO","name"=>"Macau","d_code"=>"+853","icon"=>"Macau.png");
		$countries[] = array("code"=>"MK","name"=>"Macedonia","d_code"=>"+389","icon"=>"Macedonia.png");
		$countries[] = array("code"=>"MG","name"=>"Madagascar","d_code"=>"+261","icon"=>"Madagascar.png");
		$countries[] = array("code"=>"MW","name"=>"Malawi","d_code"=>"+265","icon"=>"Malawi.png");
		$countries[] = array("code"=>"MY","name"=>"Malaysia","d_code"=>"+60","icon"=>"Malaysia.png");
		$countries[] = array("code"=>"MV","name"=>"Maldives","d_code"=>"+960","icon"=>"Maldives.png");
		$countries[] = array("code"=>"ML","name"=>"Mali","d_code"=>"+223","icon"=>"Mali.png");
		$countries[] = array("code"=>"MT","name"=>"Malta","d_code"=>"+356","icon"=>"Malta.png");
		$countries[] = array("code"=>"MH","name"=>"Marshall Islands","d_code"=>"+692","icon"=>"Marshall_Islands.png");
		$countries[] = array("code"=>"MQ","name"=>"Martinique","d_code"=>"+596","icon"=>"Martinique.png");
		$countries[] = array("code"=>"MR","name"=>"Mauritania","d_code"=>"+222","icon"=>"Mauritania.png");
		$countries[] = array("code"=>"MU","name"=>"Mauritius","d_code"=>"+230","icon"=>"Mauritius.png");
		$countries[] = array("code"=>"YT","name"=>"Mayotte","d_code"=>"+262","icon"=>"Mayotte.png");
		$countries[] = array("code"=>"MX","name"=>"Mexico","d_code"=>"+52","icon"=>"Mexico.png");
		$countries[] = array("code"=>"MD","name"=>"Moldova","d_code"=>"+373","icon"=>"Moldova.png");
		$countries[] = array("code"=>"MC","name"=>"Monaco","d_code"=>"+377","icon"=>"Monaco.png");
		$countries[] = array("code"=>"MN","name"=>"Mongolia","d_code"=>"+976","icon"=>"Mongolia.png");
		$countries[] = array("code"=>"ME","name"=>"Montenegro","d_code"=>"+382","icon"=>"Montenegro.png");
		$countries[] = array("code"=>"MS","name"=>"Montserrat","d_code"=>"+664","icon"=>"Montserrat.png");
		$countries[] = array("code"=>"MA","name"=>"Morocco","d_code"=>"+212","icon"=>"Morocco.png");
		$countries[] = array("code"=>"MZ","name"=>"Mozambique","d_code"=>"+258","icon"=>"Mozambique.png");
		$countries[] = array("code"=>"NA","name"=>"Namibia","d_code"=>"+264","icon"=>"Namibia.png");
		$countries[] = array("code"=>"NR","name"=>"Nauru","d_code"=>"+674","icon"=>"Nauru.png");
		$countries[] = array("code"=>"NP","name"=>"Nepal","d_code"=>"+977","icon"=>"Nepal.png");
		$countries[] = array("code"=>"NL","name"=>"Netherlands","d_code"=>"+31","icon"=>"Netherlands.png");
		$countries[] = array("code"=>"AN","name"=>"Netherlands Antilles","d_code"=>"+599","icon"=>"Netherlands_Antilles.png");
		$countries[] = array("code"=>"NC","name"=>"New Caledonia","d_code"=>"+687","icon"=>"New_Caledonia.png");
		$countries[] = array("code"=>"NZ","name"=>"New Zealand","d_code"=>"+64","icon"=>"New_Zealand.png");
		$countries[] = array("code"=>"NI","name"=>"Nicaragua","d_code"=>"+505","icon"=>"Nicaragua.png");
		$countries[] = array("code"=>"NE","name"=>"Niger","d_code"=>"+227","icon"=>"Niger.png");
		$countries[] = array("code"=>"NG","name"=>"Nigeria","d_code"=>"+234","icon"=>"Nigeria.png");
		$countries[] = array("code"=>"NU","name"=>"Niue","d_code"=>"+683","icon"=>"Niue.png");
		$countries[] = array("code"=>"NF","name"=>"Norfolk Island","d_code"=>"+672","icon"=>"Norfolk_Island.png");
		$countries[] = array("code"=>"KP","name"=>"North Korea","d_code"=>"+850","icon"=>"North_Korea.png");
		$countries[] = array("code"=>"MP","name"=>"Northern Mariana Islands","d_code"=>"+1","icon"=>"Northern_Mariana_Islands.png");
		$countries[] = array("code"=>"NO","name"=>"Norway","d_code"=>"+47","icon"=>"Norway.png");
		$countries[] = array("code"=>"OM","name"=>"Oman","d_code"=>"+968","icon"=>"Oman.png");
		$countries[] = array("code"=>"PK","name"=>"Pakistan","d_code"=>"+92","icon"=>"Pakistan.png");
		$countries[] = array("code"=>"PW","name"=>"Palau","d_code"=>"+680","icon"=>"Palau.png");
		$countries[] = array("code"=>"PS","name"=>"Palestine","d_code"=>"+970","icon"=>"Palestine.png");
		$countries[] = array("code"=>"PA","name"=>"Panama","d_code"=>"+507","icon"=>"Panama.png");
		$countries[] = array("code"=>"PG","name"=>"Papua New Guinea","d_code"=>"+675","icon"=>"Papua_New_Guinea.png");
		$countries[] = array("code"=>"PY","name"=>"Paraguay","d_code"=>"+595","icon"=>"Paraguay.png");
		$countries[] = array("code"=>"PE","name"=>"Peru","d_code"=>"+51","icon"=>"Peru.png");
		$countries[] = array("code"=>"PH","name"=>"Philippines","d_code"=>"+63","icon"=>"Philippines.png");
		$countries[] = array("code"=>"PL","name"=>"Poland","d_code"=>"+48","icon"=>"Poland.png");
		$countries[] = array("code"=>"PT","name"=>"Portugal","d_code"=>"+351","icon"=>"Portugal.png");
		$countries[] = array("code"=>"PR","name"=>"Puerto Rico","d_code"=>"+1","icon"=>"Puerto_Rico.png");
		$countries[] = array("code"=>"QA","name"=>"Qatar","d_code"=>"+974","icon"=>"Qatar.png");
		$countries[] = array("code"=>"CG","name"=>"Republic of the Congo","d_code"=>"+242","icon"=>"Congo_Brazzaville.png");
		$countries[] = array("code"=>"RE","name"=>"Reunion" ,"d_code"=>"+262","icon"=>"Reunion.png");
		$countries[] = array("code"=>"RO","name"=>"Romania","d_code"=>"+40","icon"=>"Romania.png");
		$countries[] = array("code"=>"RU","name"=>"Russian Federation","d_code"=>"+7","icon"=>"Russian_Federation.png");
		$countries[] = array("code"=>"RW","name"=>"Rwanda","d_code"=>"+250","icon"=>"Rwanda.png");

		$countries[] = array("code"=>"BL","name"=>"Saint Barthélemy" ,"d_code"=>"+590","icon"=>"");
		$countries[] = array("code"=>"SH","name"=>"Saint Helena","d_code"=>"+290","icon"=>"");

		$countries[] = array("code"=>"KN","name"=>"Saint Kitts and Nevis","d_code"=>"+1","icon"=>"St_Kitts_Nevis.png");

		$countries[] = array("code"=>"MF","name"=>"Saint Martin","d_code"=>"+590","icon"=>"");
		$countries[] = array("code"=>"PM","name"=>"Saint Pierre and Miquelon","d_code"=>"+508","icon"=>"");

		$countries[] = array("code"=>"VC","name"=>"Saint Vincent and the Grenadines","d_code"=>"+1","icon"=>"St_Vincent_the_Grenadines.png");
		$countries[] = array("code"=>"WS","name"=>"Samoa","d_code"=>"+685","icon"=>"Samoa.png");
		$countries[] = array("code"=>"SM","name"=>"San Marino","d_code"=>"+378","icon"=>"San_Marino.png");
		$countries[] = array("code"=>"ST","name"=>"Sao Tome and Principe" ,"d_code"=>"+239","icon"=>"Sao_Tome_Principe.png");
		$countries[] = array("code"=>"SA","name"=>"Saudi Arabia","d_code"=>"+966","icon"=>"Saudi_Arabia.png");
		$countries[] = array("code"=>"SN","name"=>"Senegal","d_code"=>"+221","icon"=>"Senegal.png");
		$countries[] = array("code"=>"RS","name"=>"Serbia","d_code"=>"+381","icon"=>"Serbia.png");
		$countries[] = array("code"=>"SC","name"=>"Seychelles","d_code"=>"+248","icon"=>"Seyshelles.png");
		$countries[] = array("code"=>"SL","name"=>"Sierra Leone","d_code"=>"+232","icon"=>"Sierra_Leone.png");
		$countries[] = array("code"=>"SG","name"=>"Singapore","d_code"=>"+65","icon"=>"Singapore.png");
		$countries[] = array("code"=>"SK","name"=>"Slovakia","d_code"=>"+421","icon"=>"Slovakia.png");
		$countries[] = array("code"=>"SI","name"=>"Slovenia","d_code"=>"+386","icon"=>"Slovenia.png");
		$countries[] = array("code"=>"SB","name"=>"Solomon Islands","d_code"=>"+677","icon"=>"Solomon_Islands.png");
		$countries[] = array("code"=>"SO","name"=>"Somalia","d_code"=>"+252","icon"=>"Somalia.png");

		$countries[] = array("code"=>"ZA","name"=>"South Africa","d_code"=>"+27","icon"=>"South_Afriica.png");
		$countries[] = array("code"=>"KR","name"=>"South Korea","d_code"=>"+82","icon"=>"South_Korea.png");
		$countries[] = array("code"=>"ES","name"=>"Spain","d_code"=>"+34","icon"=>"Spain.png");
		$countries[] = array("code"=>"LK","name"=>"Sri Lanka","d_code"=>"+94","icon"=>"Sri_Lanka.png");
		$countries[] = array("code"=>"LC","name"=>"St. Lucia","d_code"=>"+1","icon"=>"Saint_Lucia.png");
		$countries[] = array("code"=>"SD","name"=>"Sudan","d_code"=>"+249","icon"=>"Sudan.png");
		$countries[] = array("code"=>"SR","name"=>"Suriname","d_code"=>"+597","icon"=>"Suriname.png");
		$countries[] = array("code"=>"SZ","name"=>"Swaziland","d_code"=>"+268","icon"=>"Swaziland.png");
		$countries[] = array("code"=>"SE","name"=>"Sweden","d_code"=>"+46","icon"=>"Sweden.png");
		$countries[] = array("code"=>"CH","name"=>"Switzerland","d_code"=>"+41","icon"=>"Switzerland.png");
		$countries[] = array("code"=>"SY","name"=>"Syria","d_code"=>"+963","icon"=>"Syria.png");
		$countries[] = array("code"=>"TW","name"=>"Taiwan","d_code"=>"+886","icon"=>"Taiwan.png");
		$countries[] = array("code"=>"TJ","name"=>"Tajikistan","d_code"=>"+992","icon"=>"Tajikistan.png");
		$countries[] = array("code"=>"TZ","name"=>"Tanzania","d_code"=>"+255","icon"=>"Tanzania.png");
		$countries[] = array("code"=>"TH","name"=>"Thailand","d_code"=>"+66","icon"=>"Thailand.png");

		$countries[] = array("code"=>"BS","name"=>"The Bahamas","d_code"=>"+1","icon"=>"");
		$countries[] = array("code"=>"GM","name"=>"The Gambia","d_code"=>"+220","icon"=>"Gambia.png");

		$countries[] = array("code"=>"TL","name"=>"Timor-Leste","d_code"=>"+670","icon"=>"Timor_Leste.png");
		$countries[] = array("code"=>"TG","name"=>"Togo","d_code"=>"+228","icon"=>"Togo.png");
		$countries[] = array("code"=>"TK","name"=>"Tokelau","d_code"=>"+690","icon"=>"tokelau.png");
		$countries[] = array("code"=>"TO","name"=>"Tonga","d_code"=>"+676","icon"=>"Tonga.png");
		$countries[] = array("code"=>"TT","name"=>"Trinidad and Tobago","d_code"=>"+1","icon"=>"Trinidad_Tobago.png");
		$countries[] = array("code"=>"TN","name"=>"Tunisia","d_code"=>"+216","icon"=>"Tunisia.png");
		$countries[] = array("code"=>"TR","name"=>"Turkey","d_code"=>"+90","icon"=>"Turkey.png");
		$countries[] = array("code"=>"TM","name"=>"Turkmenistan","d_code"=>"+993","icon"=>"Turkmenistan.png");
		$countries[] = array("code"=>"TC","name"=>"Turks and Caicos Islands","d_code"=>"+1","icon"=>"Turks_and_Caicos_Islands.png");
		$countries[] = array("code"=>"TV","name"=>"Tuvalu","d_code"=>"+688","icon"=>"Tuvalu.png");
		$countries[] = array("code"=>"UG","name"=>"Uganda","d_code"=>"+256","icon"=>"Uganda.png");
		$countries[] = array("code"=>"UA","name"=>"Ukraine","d_code"=>"+380","icon"=>"Ukraine.png");
		$countries[] = array("code"=>"AE","name"=>"United Arab Emirates","d_code"=>"+971","icon"=>"United_Arab_Emirates.png");
		$countries[] = array("code"=>"GB","name"=>"United Kingdom","d_code"=>"+44","icon"=>"United_Kingdom.png");
		$countries[] = array("code"=>"US","name"=>"United States","d_code"=>"+1","icon"=>"United_States_of_America.png");
		$countries[] = array("code"=>"UY","name"=>"Uruguay","d_code"=>"+598","icon"=>"Uruguay.png");
		$countries[] = array("code"=>"VI","name"=>"US Virgin Islands","d_code"=>"+1","icon"=>"Virgin_Islands_US.png");
		$countries[] = array("code"=>"UZ","name"=>"Uzbekistan","d_code"=>"+998","icon"=>"Uzbekistan.png");
		$countries[] = array("code"=>"VU","name"=>"Vanuatu","d_code"=>"+678","icon"=>"Vanutau.png");
		$countries[] = array("code"=>"VA","name"=>"Vatican City","d_code"=>"+39","icon"=>"Vatican_City.png");
		$countries[] = array("code"=>"VE","name"=>"Venezuela","d_code"=>"+58","icon"=>"Venezuela.png");
		$countries[] = array("code"=>"VN","name"=>"Vietnam","d_code"=>"+84","icon"=>"Vietnam.png");
		$countries[] = array("code"=>"WF","name"=>"Wallis and Futuna","d_code"=>"+681","icon"=>"Wallis_and_Futuna.png");
		$countries[] = array("code"=>"YE","name"=>"Yemen","d_code"=>"+967","icon"=>"Yemen.png");
		$countries[] = array("code"=>"ZM","name"=>"Zambia","d_code"=>"+260","icon"=>"Zambia.png");
		$countries[] = array("code"=>"ZW","name"=>"Zimbabwe","d_code"=>"+263","icon"=>"Zimbabwe.png");
		
		return $countries;
	}
	
	public static function getValArrays(){	
		
		$countries[] = array("code"=>"DZ","name"=>"Algeria","d_code"=>"+213","icon"=>"Algeria.png");
		$countries[] = array("code"=>"CD","name"=>"Democratic Republic of Congo","d_code"=>"+243","icon"=>"Congo_Kinshasa.png");
		$countries[] = array("code"=>"KE","name"=>"Kenya","d_code"=>"+254","icon"=>"Kenya.png");
		$countries[] = array("code"=>"RW","name"=>"Rwanda","d_code"=>"+250","icon"=>"Rwanda.png");
        $countries[] = array("code"=>"TZ","name"=>"Tanzania","d_code"=>"+255","icon"=>"Tanzania.png");
		$countries[] = array("code"=>"UG","name"=>"Uganda","d_code"=>"+256","icon"=>"Uganda.png");
		
		return $countries;
	}
	
	
}
?> 