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
			$countries = Country::genCountry();
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


	public static function country_to_continent($country){
	    $continent = '';
	    if( $country == 'AF' ) $continent = 'Asia';
	    if( $country == 'AX' ) $continent = 'Europe';
	    if( $country == 'AL' ) $continent = 'Europe';
	    if( $country == 'DZ' ) $continent = 'Africa';
	    if( $country == 'AS' ) $continent = 'Oceania';
	    if( $country == 'AD' ) $continent = 'Europe';
	    if( $country == 'AO' ) $continent = 'Africa';
	    if( $country == 'AI' ) $continent = 'North America';
	    if( $country == 'AQ' ) $continent = 'Antarctica';
	    if( $country == 'AG' ) $continent = 'North America';
	    if( $country == 'AR' ) $continent = 'South America';
	    if( $country == 'AM' ) $continent = 'Asia';
	    if( $country == 'AW' ) $continent = 'North America';
	    if( $country == 'AU' ) $continent = 'Oceania';
	    if( $country == 'AT' ) $continent = 'Europe';
	    if( $country == 'AZ' ) $continent = 'Asia';
	    if( $country == 'BS' ) $continent = 'North America';
	    if( $country == 'BH' ) $continent = 'Asia';
	    if( $country == 'BD' ) $continent = 'Asia';
	    if( $country == 'BB' ) $continent = 'North America';
	    if( $country == 'BY' ) $continent = 'Europe';
	    if( $country == 'BE' ) $continent = 'Europe';
	    if( $country == 'BZ' ) $continent = 'North America';
	    if( $country == 'BJ' ) $continent = 'Africa';
	    if( $country == 'BM' ) $continent = 'North America';
	    if( $country == 'BT' ) $continent = 'Asia';
	    if( $country == 'BO' ) $continent = 'South America';
	    if( $country == 'BA' ) $continent = 'Europe';
	    if( $country == 'BW' ) $continent = 'Africa';
	    if( $country == 'BV' ) $continent = 'Antarctica';
	    if( $country == 'BR' ) $continent = 'South America';
	    if( $country == 'IO' ) $continent = 'Asia';
	    if( $country == 'VG' ) $continent = 'North America';
	    if( $country == 'BN' ) $continent = 'Asia';
	    if( $country == 'BG' ) $continent = 'Europe';
	    if( $country == 'BF' ) $continent = 'Africa';
	    if( $country == 'BI' ) $continent = 'Africa';
	    if( $country == 'KH' ) $continent = 'Asia';
	    if( $country == 'CM' ) $continent = 'Africa';
	    if( $country == 'CA' ) $continent = 'North America';
	    if( $country == 'CV' ) $continent = 'Africa';
	    if( $country == 'KY' ) $continent = 'North America';
	    if( $country == 'CF' ) $continent = 'Africa';
	    if( $country == 'TD' ) $continent = 'Africa';
	    if( $country == 'CL' ) $continent = 'South America';
	    if( $country == 'CN' ) $continent = 'Asia';
	    if( $country == 'CX' ) $continent = 'Asia';
	    if( $country == 'CC' ) $continent = 'Asia';
	    if( $country == 'CO' ) $continent = 'South America';
	    if( $country == 'KM' ) $continent = 'Africa';
	    if( $country == 'CD' ) $continent = 'Africa';
	    if( $country == 'CG' ) $continent = 'Africa';
	    if( $country == 'CK' ) $continent = 'Oceania';
	    if( $country == 'CR' ) $continent = 'North America';
	    if( $country == 'CI' ) $continent = 'Africa';
	    if( $country == 'HR' ) $continent = 'Europe';
	    if( $country == 'CU' ) $continent = 'North America';
	    if( $country == 'CY' ) $continent = 'Asia';
	    if( $country == 'CZ' ) $continent = 'Europe';
	    if( $country == 'DK' ) $continent = 'Europe';
	    if( $country == 'DJ' ) $continent = 'Africa';
	    if( $country == 'DM' ) $continent = 'North America';
	    if( $country == 'DO' ) $continent = 'North America';
	    if( $country == 'EC' ) $continent = 'South America';
	    if( $country == 'EG' ) $continent = 'Africa';
	    if( $country == 'SV' ) $continent = 'North America';
	    if( $country == 'GQ' ) $continent = 'Africa';
	    if( $country == 'ER' ) $continent = 'Africa';
	    if( $country == 'EE' ) $continent = 'Europe';
	    if( $country == 'ET' ) $continent = 'Africa';
	    if( $country == 'FO' ) $continent = 'Europe';
	    if( $country == 'FK' ) $continent = 'South America';
	    if( $country == 'FJ' ) $continent = 'Oceania';
	    if( $country == 'FI' ) $continent = 'Europe';
	    if( $country == 'FR' ) $continent = 'Europe';
	    if( $country == 'GF' ) $continent = 'South America';
	    if( $country == 'PF' ) $continent = 'Oceania';
	    if( $country == 'TF' ) $continent = 'Antarctica';
	    if( $country == 'GA' ) $continent = 'Africa';
	    if( $country == 'GM' ) $continent = 'Africa';
	    if( $country == 'GE' ) $continent = 'Asia';
	    if( $country == 'DE' ) $continent = 'Europe';
	    if( $country == 'GH' ) $continent = 'Africa';
	    if( $country == 'GI' ) $continent = 'Europe';
	    if( $country == 'GR' ) $continent = 'Europe';
	    if( $country == 'GL' ) $continent = 'North America';
	    if( $country == 'GD' ) $continent = 'North America';
	    if( $country == 'GP' ) $continent = 'North America';
	    if( $country == 'GU' ) $continent = 'Oceania';
	    if( $country == 'GT' ) $continent = 'North America';
	    if( $country == 'GG' ) $continent = 'Europe';
	    if( $country == 'GN' ) $continent = 'Africa';
	    if( $country == 'GW' ) $continent = 'Africa';
	    if( $country == 'GY' ) $continent = 'South America';
	    if( $country == 'HT' ) $continent = 'North America';
	    if( $country == 'HM' ) $continent = 'Antarctica';
	    if( $country == 'VA' ) $continent = 'Europe';
	    if( $country == 'HN' ) $continent = 'North America';
	    if( $country == 'HK' ) $continent = 'Asia';
	    if( $country == 'HU' ) $continent = 'Europe';
	    if( $country == 'IS' ) $continent = 'Europe';
	    if( $country == 'IN' ) $continent = 'Asia';
	    if( $country == 'ID' ) $continent = 'Asia';
	    if( $country == 'IR' ) $continent = 'Asia';
	    if( $country == 'IQ' ) $continent = 'Asia';
	    if( $country == 'IE' ) $continent = 'Europe';
	    if( $country == 'IM' ) $continent = 'Europe';
	    if( $country == 'IL' ) $continent = 'Asia';
	    if( $country == 'IT' ) $continent = 'Europe';
	    if( $country == 'JM' ) $continent = 'North America';
	    if( $country == 'JP' ) $continent = 'Asia';
	    if( $country == 'JE' ) $continent = 'Europe';
	    if( $country == 'JO' ) $continent = 'Asia';
	    if( $country == 'KZ' ) $continent = 'Asia';
	    if( $country == 'KE' ) $continent = 'Africa';
	    if( $country == 'KI' ) $continent = 'Oceania';
	    if( $country == 'KP' ) $continent = 'Asia';
	    if( $country == 'KR' ) $continent = 'Asia';
	    if( $country == 'KW' ) $continent = 'Asia';
	    if( $country == 'KG' ) $continent = 'Asia';
	    if( $country == 'LA' ) $continent = 'Asia';
	    if( $country == 'LV' ) $continent = 'Europe';
	    if( $country == 'LB' ) $continent = 'Asia';
	    if( $country == 'LS' ) $continent = 'Africa';
	    if( $country == 'LR' ) $continent = 'Africa';
	    if( $country == 'LY' ) $continent = 'Africa';
	    if( $country == 'LI' ) $continent = 'Europe';
	    if( $country == 'LT' ) $continent = 'Europe';
	    if( $country == 'LU' ) $continent = 'Europe';
	    if( $country == 'MO' ) $continent = 'Asia';
	    if( $country == 'MK' ) $continent = 'Europe';
	    if( $country == 'MG' ) $continent = 'Africa';
	    if( $country == 'MW' ) $continent = 'Africa';
	    if( $country == 'MY' ) $continent = 'Asia';
	    if( $country == 'MV' ) $continent = 'Asia';
	    if( $country == 'ML' ) $continent = 'Africa';
	    if( $country == 'MT' ) $continent = 'Europe';
	    if( $country == 'MH' ) $continent = 'Oceania';
	    if( $country == 'MQ' ) $continent = 'North America';
	    if( $country == 'MR' ) $continent = 'Africa';
	    if( $country == 'MU' ) $continent = 'Africa';
	    if( $country == 'YT' ) $continent = 'Africa';
	    if( $country == 'MX' ) $continent = 'North America';
	    if( $country == 'FM' ) $continent = 'Oceania';
	    if( $country == 'MD' ) $continent = 'Europe';
	    if( $country == 'MC' ) $continent = 'Europe';
	    if( $country == 'MN' ) $continent = 'Asia';
	    if( $country == 'ME' ) $continent = 'Europe';
	    if( $country == 'MS' ) $continent = 'North America';
	    if( $country == 'MA' ) $continent = 'Africa';
	    if( $country == 'MZ' ) $continent = 'Africa';
	    if( $country == 'MM' ) $continent = 'Asia';
	    if( $country == 'NA' ) $continent = 'Africa';
	    if( $country == 'NR' ) $continent = 'Oceania';
	    if( $country == 'NP' ) $continent = 'Asia';
	    if( $country == 'AN' ) $continent = 'North America';
	    if( $country == 'NL' ) $continent = 'Europe';
	    if( $country == 'NC' ) $continent = 'Oceania';
	    if( $country == 'NZ' ) $continent = 'Oceania';
	    if( $country == 'NI' ) $continent = 'North America';
	    if( $country == 'NE' ) $continent = 'Africa';
	    if( $country == 'NG' ) $continent = 'Africa';
	    if( $country == 'NU' ) $continent = 'Oceania';
	    if( $country == 'NF' ) $continent = 'Oceania';
	    if( $country == 'MP' ) $continent = 'Oceania';
	    if( $country == 'NO' ) $continent = 'Europe';
	    if( $country == 'OM' ) $continent = 'Asia';
	    if( $country == 'PK' ) $continent = 'Asia';
	    if( $country == 'PW' ) $continent = 'Oceania';
	    if( $country == 'PS' ) $continent = 'Asia';
	    if( $country == 'PA' ) $continent = 'North America';
	    if( $country == 'PG' ) $continent = 'Oceania';
	    if( $country == 'PY' ) $continent = 'South America';
	    if( $country == 'PE' ) $continent = 'South America';
	    if( $country == 'PH' ) $continent = 'Asia';
	    if( $country == 'PN' ) $continent = 'Oceania';
	    if( $country == 'PL' ) $continent = 'Europe';
	    if( $country == 'PT' ) $continent = 'Europe';
	    if( $country == 'PR' ) $continent = 'North America';
	    if( $country == 'QA' ) $continent = 'Asia';
	    if( $country == 'RE' ) $continent = 'Africa';
	    if( $country == 'RO' ) $continent = 'Europe';
	    if( $country == 'RU' ) $continent = 'Europe';
	    if( $country == 'RW' ) $continent = 'Africa';
	    if( $country == 'BL' ) $continent = 'North America';
	    if( $country == 'SH' ) $continent = 'Africa';
	    if( $country == 'KN' ) $continent = 'North America';
	    if( $country == 'LC' ) $continent = 'North America';
	    if( $country == 'MF' ) $continent = 'North America';
	    if( $country == 'PM' ) $continent = 'North America';
	    if( $country == 'VC' ) $continent = 'North America';
	    if( $country == 'WS' ) $continent = 'Oceania';
	    if( $country == 'SM' ) $continent = 'Europe';
	    if( $country == 'ST' ) $continent = 'Africa';
	    if( $country == 'SA' ) $continent = 'Asia';
	    if( $country == 'SN' ) $continent = 'Africa';
	    if( $country == 'RS' ) $continent = 'Europe';
	    if( $country == 'SC' ) $continent = 'Africa';
	    if( $country == 'SL' ) $continent = 'Africa';
	    if( $country == 'SG' ) $continent = 'Asia';
	    if( $country == 'SK' ) $continent = 'Europe';
	    if( $country == 'SI' ) $continent = 'Europe';
	    if( $country == 'SB' ) $continent = 'Oceania';
	    if( $country == 'SO' ) $continent = 'Africa';
	    if( $country == 'ZA' ) $continent = 'Africa';
	    if( $country == 'GS' ) $continent = 'Antarctica';
	    if( $country == 'ES' ) $continent = 'Europe';
	    if( $country == 'LK' ) $continent = 'Asia';
	    if( $country == 'SD' ) $continent = 'Africa';
	    if( $country == 'SR' ) $continent = 'South America';
	    if( $country == 'SJ' ) $continent = 'Europe';
	    if( $country == 'SZ' ) $continent = 'Africa';
	    if( $country == 'SE' ) $continent = 'Europe';
	    if( $country == 'CH' ) $continent = 'Europe';
	    if( $country == 'SY' ) $continent = 'Asia';
	    if( $country == 'TW' ) $continent = 'Asia';
	    if( $country == 'TJ' ) $continent = 'Asia';
	    if( $country == 'TZ' ) $continent = 'Africa';
	    if( $country == 'TH' ) $continent = 'Asia';
	    if( $country == 'TL' ) $continent = 'Asia';
	    if( $country == 'TG' ) $continent = 'Africa';
	    if( $country == 'TK' ) $continent = 'Oceania';
	    if( $country == 'TO' ) $continent = 'Oceania';
	    if( $country == 'TT' ) $continent = 'North America';
	    if( $country == 'TN' ) $continent = 'Africa';
	    if( $country == 'TR' ) $continent = 'Asia';
	    if( $country == 'TM' ) $continent = 'Asia';
	    if( $country == 'TC' ) $continent = 'North America';
	    if( $country == 'TV' ) $continent = 'Oceania';
	    if( $country == 'UG' ) $continent = 'Africa';
	    if( $country == 'UA' ) $continent = 'Europe';
	    if( $country == 'AE' ) $continent = 'Asia';
	    if( $country == 'GB' ) $continent = 'Europe';
	    if( $country == 'US' ) $continent = 'North America';
	    if( $country == 'UM' ) $continent = 'Oceania';
	    if( $country == 'VI' ) $continent = 'North America';
	    if( $country == 'UY' ) $continent = 'South America';
	    if( $country == 'UZ' ) $continent = 'Asia';
	    if( $country == 'VU' ) $continent = 'Oceania';
	    if( $country == 'VE' ) $continent = 'South America';
	    if( $country == 'VN' ) $continent = 'Asia';
	    if( $country == 'WF' ) $continent = 'Oceania';
	    if( $country == 'EH' ) $continent = 'Africa';
	    if( $country == 'YE' ) $continent = 'Asia';
	    if( $country == 'ZM' ) $continent = 'Africa';
	    if( $country == 'ZW' ) $continent = 'Africa';
	    return $continent;
	}
	

	public static function countryCodeToCountry($code) {
	    $code = strtoupper($code);
	    if ($code == 'AF') return 'Afghanistan';
	    if ($code == 'AX') return 'Aland Islands';
	    if ($code == 'AL') return 'Albania';
	    if ($code == 'DZ') return 'Algeria';
	    if ($code == 'AS') return 'American Samoa';
	    if ($code == 'AD') return 'Andorra';
	    if ($code == 'AO') return 'Angola';
	    if ($code == 'AI') return 'Anguilla';
	    if ($code == 'AQ') return 'Antarctica';
	    if ($code == 'AG') return 'Antigua and Barbuda';
	    if ($code == 'AR') return 'Argentina';
	    if ($code == 'AM') return 'Armenia';
	    if ($code == 'AW') return 'Aruba';
	    if ($code == 'AU') return 'Australia';
	    if ($code == 'AT') return 'Austria';
	    if ($code == 'AZ') return 'Azerbaijan';
	    if ($code == 'BS') return 'Bahamas the';
	    if ($code == 'BH') return 'Bahrain';
	    if ($code == 'BD') return 'Bangladesh';
	    if ($code == 'BB') return 'Barbados';
	    if ($code == 'BY') return 'Belarus';
	    if ($code == 'BE') return 'Belgium';
	    if ($code == 'BZ') return 'Belize';
	    if ($code == 'BJ') return 'Benin';
	    if ($code == 'BM') return 'Bermuda';
	    if ($code == 'BT') return 'Bhutan';
	    if ($code == 'BO') return 'Bolivia';
	    if ($code == 'BA') return 'Bosnia and Herzegovina';
	    if ($code == 'BW') return 'Botswana';
	    if ($code == 'BV') return 'Bouvet Island (Bouvetoya)';
	    if ($code == 'BR') return 'Brazil';
	    if ($code == 'IO') return 'British Indian Ocean Territory (Chagos Archipelago)';
	    if ($code == 'VG') return 'British Virgin Islands';
	    if ($code == 'BN') return 'Brunei Darussalam';
	    if ($code == 'BG') return 'Bulgaria';
	    if ($code == 'BF') return 'Burkina Faso';
	    if ($code == 'BI') return 'Burundi';
	    if ($code == 'KH') return 'Cambodia';
	    if ($code == 'CM') return 'Cameroon';
	    if ($code == 'CA') return 'Canada';
	    if ($code == 'CV') return 'Cape Verde';
	    if ($code == 'KY') return 'Cayman Islands';
	    if ($code == 'CF') return 'Central African Republic';
	    if ($code == 'TD') return 'Chad';
	    if ($code == 'CL') return 'Chile';
	    if ($code == 'CN') return 'China';
	    if ($code == 'CX') return 'Christmas Island';
	    if ($code == 'CC') return 'Cocos (Keeling) Islands';
	    if ($code == 'CO') return 'Colombia';
	    if ($code == 'KM') return 'Comoros the';
	    if ($code == 'CD') return 'Congo';
	    if ($code == 'CG') return 'Congo the';
	    if ($code == 'CK') return 'Cook Islands';
	    if ($code == 'CR') return 'Costa Rica';
	    if ($code == 'CI') return 'Cote d\'Ivoire';
	    if ($code == 'HR') return 'Croatia';
	    if ($code == 'CU') return 'Cuba';
	    if ($code == 'CY') return 'Cyprus';
	    if ($code == 'CZ') return 'Czech Republic';
	    if ($code == 'DK') return 'Denmark';
	    if ($code == 'DJ') return 'Djibouti';
	    if ($code == 'DM') return 'Dominica';
	    if ($code == 'DO') return 'Dominican Republic';
	    if ($code == 'EC') return 'Ecuador';
	    if ($code == 'EG') return 'Egypt';
	    if ($code == 'SV') return 'El Salvador';
	    if ($code == 'GQ') return 'Equatorial Guinea';
	    if ($code == 'ER') return 'Eritrea';
	    if ($code == 'EE') return 'Estonia';
	    if ($code == 'ET') return 'Ethiopia';
	    if ($code == 'FO') return 'Faroe Islands';
	    if ($code == 'FK') return 'Falkland Islands (Malvinas)';
	    if ($code == 'FJ') return 'Fiji the Fiji Islands';
	    if ($code == 'FI') return 'Finland';
	    if ($code == 'FR') return 'France';
	    if ($code == 'GF') return 'French Guiana';
	    if ($code == 'PF') return 'French Polynesia';
	    if ($code == 'TF') return 'French Southern Territories';
	    if ($code == 'GA') return 'Gabon';
	    if ($code == 'GM') return 'Gambia the';
	    if ($code == 'GE') return 'Georgia';
	    if ($code == 'DE') return 'Germany';
	    if ($code == 'GH') return 'Ghana';
	    if ($code == 'GI') return 'Gibraltar';
	    if ($code == 'GR') return 'Greece';
	    if ($code == 'GL') return 'Greenland';
	    if ($code == 'GD') return 'Grenada';
	    if ($code == 'GP') return 'Guadeloupe';
	    if ($code == 'GU') return 'Guam';
	    if ($code == 'GT') return 'Guatemala';
	    if ($code == 'GG') return 'Guernsey';
	    if ($code == 'GN') return 'Guinea';
	    if ($code == 'GW') return 'Guinea-Bissau';
	    if ($code == 'GY') return 'Guyana';
	    if ($code == 'HT') return 'Haiti';
	    if ($code == 'HM') return 'Heard Island and McDonald Islands';
	    if ($code == 'VA') return 'Holy See (Vatican City State)';
	    if ($code == 'HN') return 'Honduras';
	    if ($code == 'HK') return 'Hong Kong';
	    if ($code == 'HU') return 'Hungary';
	    if ($code == 'IS') return 'Iceland';
	    if ($code == 'IN') return 'India';
	    if ($code == 'ID') return 'Indonesia';
	    if ($code == 'IR') return 'Iran';
	    if ($code == 'IQ') return 'Iraq';
	    if ($code == 'IE') return 'Ireland';
	    if ($code == 'IM') return 'Isle of Man';
	    if ($code == 'IL') return 'Israel';
	    if ($code == 'IT') return 'Italy';
	    if ($code == 'JM') return 'Jamaica';
	    if ($code == 'JP') return 'Japan';
	    if ($code == 'JE') return 'Jersey';
	    if ($code == 'JO') return 'Jordan';
	    if ($code == 'KZ') return 'Kazakhstan';
	    if ($code == 'KE') return 'Kenya';
	    if ($code == 'KI') return 'Kiribati';
	    if ($code == 'KP') return 'Korea';
	    if ($code == 'KR') return 'Korea';
	    if ($code == 'KW') return 'Kuwait';
	    if ($code == 'KG') return 'Kyrgyz Republic';
	    if ($code == 'LA') return 'Lao';
	    if ($code == 'LV') return 'Latvia';
	    if ($code == 'LB') return 'Lebanon';
	    if ($code == 'LS') return 'Lesotho';
	    if ($code == 'LR') return 'Liberia';
	    if ($code == 'LY') return 'Libyan Arab Jamahiriya';
	    if ($code == 'LI') return 'Liechtenstein';
	    if ($code == 'LT') return 'Lithuania';
	    if ($code == 'LU') return 'Luxembourg';
	    if ($code == 'MO') return 'Macao';
	    if ($code == 'MK') return 'Macedonia';
	    if ($code == 'MG') return 'Madagascar';
	    if ($code == 'MW') return 'Malawi';
	    if ($code == 'MY') return 'Malaysia';
	    if ($code == 'MV') return 'Maldives';
	    if ($code == 'ML') return 'Mali';
	    if ($code == 'MT') return 'Malta';
	    if ($code == 'MH') return 'Marshall Islands';
	    if ($code == 'MQ') return 'Martinique';
	    if ($code == 'MR') return 'Mauritania';
	    if ($code == 'MU') return 'Mauritius';
	    if ($code == 'YT') return 'Mayotte';
	    if ($code == 'MX') return 'Mexico';
	    if ($code == 'FM') return 'Micronesia';
	    if ($code == 'MD') return 'Moldova';
	    if ($code == 'MC') return 'Monaco';
	    if ($code == 'MN') return 'Mongolia';
	    if ($code == 'ME') return 'Montenegro';
	    if ($code == 'MS') return 'Montserrat';
	    if ($code == 'MA') return 'Morocco';
	    if ($code == 'MZ') return 'Mozambique';
	    if ($code == 'MM') return 'Myanmar';
	    if ($code == 'NA') return 'Namibia';
	    if ($code == 'NR') return 'Nauru';
	    if ($code == 'NP') return 'Nepal';
	    if ($code == 'AN') return 'Netherlands Antilles';
	    if ($code == 'NL') return 'Netherlands the';
	    if ($code == 'NC') return 'New Caledonia';
	    if ($code == 'NZ') return 'New Zealand';
	    if ($code == 'NI') return 'Nicaragua';
	    if ($code == 'NE') return 'Niger';
	    if ($code == 'NG') return 'Nigeria';
	    if ($code == 'NU') return 'Niue';
	    if ($code == 'NF') return 'Norfolk Island';
	    if ($code == 'MP') return 'Northern Mariana Islands';
	    if ($code == 'NO') return 'Norway';
	    if ($code == 'OM') return 'Oman';
	    if ($code == 'PK') return 'Pakistan';
	    if ($code == 'PW') return 'Palau';
	    if ($code == 'PS') return 'Palestinian Territory';
	    if ($code == 'PA') return 'Panama';
	    if ($code == 'PG') return 'Papua New Guinea';
	    if ($code == 'PY') return 'Paraguay';
	    if ($code == 'PE') return 'Peru';
	    if ($code == 'PH') return 'Philippines';
	    if ($code == 'PN') return 'Pitcairn Islands';
	    if ($code == 'PL') return 'Poland';
	    if ($code == 'PT') return 'Portugal, Portuguese Republic';
	    if ($code == 'PR') return 'Puerto Rico';
	    if ($code == 'QA') return 'Qatar';
	    if ($code == 'RE') return 'Reunion';
	    if ($code == 'RO') return 'Romania';
	    if ($code == 'RU') return 'Russian Federation';
	    if ($code == 'RW') return 'Rwanda';
	    if ($code == 'BL') return 'Saint Barthelemy';
	    if ($code == 'SH') return 'Saint Helena';
	    if ($code == 'KN') return 'Saint Kitts and Nevis';
	    if ($code == 'LC') return 'Saint Lucia';
	    if ($code == 'MF') return 'Saint Martin';
	    if ($code == 'PM') return 'Saint Pierre and Miquelon';
	    if ($code == 'VC') return 'Saint Vincent and the Grenadines';
	    if ($code == 'WS') return 'Samoa';
	    if ($code == 'SM') return 'San Marino';
	    if ($code == 'ST') return 'Sao Tome and Principe';
	    if ($code == 'SA') return 'Saudi Arabia';
	    if ($code == 'SN') return 'Senegal';
	    if ($code == 'RS') return 'Serbia';
	    if ($code == 'SC') return 'Seychelles';
	    if ($code == 'SL') return 'Sierra Leone';
	    if ($code == 'SG') return 'Singapore';
	    if ($code == 'SK') return 'Slovakia (Slovak Republic)';
	    if ($code == 'SI') return 'Slovenia';
	    if ($code == 'SB') return 'Solomon Islands';
	    if ($code == 'SO') return 'Somalia, Somali Republic';
	    if ($code == 'ZA') return 'South Africa';
	    if ($code == 'GS') return 'South Georgia and the South Sandwich Islands';
	    if ($code == 'ES') return 'Spain';
	    if ($code == 'LK') return 'Sri Lanka';
	    if ($code == 'SD') return 'Sudan';
	    if ($code == 'SR') return 'Suriname';
	    if ($code == 'SJ') return 'Svalbard & Jan Mayen Islands';
	    if ($code == 'SZ') return 'Swaziland';
	    if ($code == 'SE') return 'Sweden';
	    if ($code == 'CH') return 'Switzerland, Swiss Confederation';
	    if ($code == 'SY') return 'Syrian Arab Republic';
	    if ($code == 'TW') return 'Taiwan';
	    if ($code == 'TJ') return 'Tajikistan';
	    if ($code == 'TZ') return 'Tanzania';
	    if ($code == 'TH') return 'Thailand';
	    if ($code == 'TL') return 'Timor-Leste';
	    if ($code == 'TG') return 'Togo';
	    if ($code == 'TK') return 'Tokelau';
	    if ($code == 'TO') return 'Tonga';
	    if ($code == 'TT') return 'Trinidad and Tobago';
	    if ($code == 'TN') return 'Tunisia';
	    if ($code == 'TR') return 'Turkey';
	    if ($code == 'TM') return 'Turkmenistan';
	    if ($code == 'TC') return 'Turks and Caicos Islands';
	    if ($code == 'TV') return 'Tuvalu';
	    if ($code == 'UG') return 'Uganda';
	    if ($code == 'UA') return 'Ukraine';
	    if ($code == 'AE') return 'United Arab Emirates';
	    if ($code == 'GB') return 'United Kingdom';
	    if ($code == 'US') return 'United States of America';
	    if ($code == 'UM') return 'United States Minor Outlying Islands';
	    if ($code == 'VI') return 'United States Virgin Islands';
	    if ($code == 'UY') return 'Uruguay, Eastern Republic of';
	    if ($code == 'UZ') return 'Uzbekistan';
	    if ($code == 'VU') return 'Vanuatu';
	    if ($code == 'VE') return 'Venezuela';
	    if ($code == 'VN') return 'Vietnam';
	    if ($code == 'WF') return 'Wallis and Futuna';
	    if ($code == 'EH') return 'Western Sahara';
	    if ($code == 'YE') return 'Yemen';
	    if ($code == 'XK') return 'Kosovo';
	    if ($code == 'ZM') return 'Zambia';
	    if ($code == 'ZW') return 'Zimbabwe';
	    return 'Unknown Country';
	}

	public static function country() {
        ?>
        <option value="AF">Afghanistan</option>
        <option value="AX">Aland Islands</option>
        <option value="AL">Albania</option>
        <option value="DZ">Algeria</option>
        <option value="AS">American Samoa</option>
        <option value="AD">Andorra</option>
        <option value="AO">Angola</option>
        <option value="AI">Anguilla</option>
        <option value="AQ">Antarctica</option>
        <option value="AG">Antigua and Barbuda</option>
        <option value="AR">Argentina</option>
        <option value="AM">Armenia</option>
        <option value="AW">Aruba</option>
        <option value="AU">Australia</option>
        <option value="AT">Austria</option>
        <option value="AZ">Azerbaijan</option>
        <option value="BS">Bahamas</option>
        <option value="BH">Bahrain</option>
        <option value="BD">Bangladesh</option>
        <option value="BB">Barbados</option>
        <option value="BY">Belarus</option>
        <option value="BE">Belgium</option>
        <option value="BZ">Belize</option>
        <option value="BJ">Benin</option>
        <option value="BM">Bermuda</option>
        <option value="BT">Bhutan</option>
        <option value="BO">Bolivia</option>
        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
        <option value="BA">Bosnia and Herzegovina</option>
        <option value="BW">Botswana</option>
        <option value="BV">Bouvet Island</option>
        <option value="BR">Brazil</option>
        <option value="IO">British Indian Ocean Territory</option>
        <option value="BN">Brunei Darussalam</option>
        <option value="BG">Bulgaria</option>
        <option value="BF">Burkina Faso</option>
        <option value="BI">Burundi</option>
        <option value="KH">Cambodia</option>
        <option value="CM">Cameroon</option>
        <option value="CA">Canada</option>
        <option value="CV">Cape Verde</option>
        <option value="KY">Cayman Islands</option>
        <option value="CF">Central African Republic</option>
        <option value="TD">Chad</option>
        <option value="CL">Chile</option>
        <option value="CN">China</option>
        <option value="CX">Christmas Island</option>
        <option value="CC">Cocos (Keeling) Islands</option>
        <option value="CO">Colombia</option>
        <option value="KM">Comoros</option>
        <option value="CG">Congo</option>
        <option value="CD">Congo, Democratic Republic of</option>
        <option value="CK">Cook Islands</option>
        <option value="CR">Costa Rica</option>
        <option value="CI">Cote D'Ivoire</option>
        <option value="HR">Croatia</option>
        <option value="CU">Cuba</option>
        <option value="CW">Curacao</option>
        <option value="CY">Cyprus</option>
        <option value="CZ">Czech Republic</option>
        <option value="DK">Denmark</option>
        <option value="DJ">Djibouti</option>
        <option value="DM">Dominica</option>
        <option value="DO">Dominican Republic</option>
        <option value="EC">Ecuador</option>
        <option value="EG">Egypt</option>
        <option value="SV">El Salvador</option>
        <option value="GQ">Equatorial Guinea</option>
        <option value="ER">Eritrea</option>
        <option value="EE">Estonia</option>
        <option value="ET">Ethiopia</option>
        <option value="FK">Falkland Islands (Malvinas)</option>
        <option value="FO">Faroe Islands</option>
        <option value="FJ">Fiji</option>
        <option value="FI">Finland</option>
        <option value="FR">France</option>
        <option value="GF">French Guiana</option>
        <option value="PF">French Polynesia</option>
        <option value="TF">French Southern Territories</option>
        <option value="GA">Gabon</option>
        <option value="GM">Gambia</option>
        <option value="GE">Georgia</option>
        <option value="DE">Germany</option>
        <option value="GH">Ghana</option>
        <option value="GI">Gibraltar</option>
        <option value="GR">Greece</option>
        <option value="GL">Greenland</option>
        <option value="GD">Grenada</option>
        <option value="GP">Guadeloupe</option>
        <option value="GU">Guam</option>
        <option value="GT">Guatemala</option>
        <option value="GG">Guernsey</option>
        <option value="GN">Guinea</option>
        <option value="GW">Guinea-Bissau</option>
        <option value="GY">Guyana</option>
        <option value="HT">Haiti</option>
        <option value="HM">Heard Island and McDonald Islands</option>
        <option value="VA">Holy See (Vatican City State)</option>
        <option value="HN">Honduras</option>
        <option value="HK">Hong Kong</option>
        <option value="HU">Hungary</option>
        <option value="IS">Iceland</option>
        <option value="IN">India</option>
        <option value="ID">Indonesia</option>
        <option value="IR">Iran, Islamic Republic of</option>
        <option value="IQ">Iraq</option>
        <option value="IE">Ireland</option>
        <option value="IM">Isle of Man</option>
        <option value="IL">Israel</option>
        <option value="IT">Italy</option>
        <option value="JM">Jamaica</option>
        <option value="JP">Japan</option>
        <option value="JE">Jersey</option>
        <option value="JO">Jordan</option>
        <option value="KZ">Kazakhstan</option>
        <option value="KE">Kenya</option>
        <option value="KI">Kiribati</option>
        <option value="KP">Korea, Democratic People's Republic of</option>
        <option value="KR">Korea, Republic of</option>
        <option value="XK">Kosovo</option>
        <option value="KW">Kuwait</option>
        <option value="KG">Kyrgyzstan</option>
        <option value="LA">Lao People's Democratic Republic</option>
        <option value="LV">Latvia</option>
        <option value="LB">Lebanon</option>
        <option value="LS">Lesotho</option>
        <option value="LR">Liberia</option>
        <option value="LY">Libya</option>
        <option value="LI">Liechtenstein</option>
        <option value="LT">Lithuania</option>
        <option value="LU">Luxembourg</option>
        <option value="MO">Macao</option>
        <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
        <option value="MG">Madagascar</option>
        <option value="MW">Malawi</option>
        <option value="MY">Malaysia</option>
        <option value="MV">Maldives</option>
        <option value="ML">Mali</option>
        <option value="MT">Malta</option>
        <option value="MH">Marshall Islands</option>
        <option value="MQ">Martinique</option>
        <option value="MR">Mauritania</option>
        <option value="MU">Mauritius</option>
        <option value="YT">Mayotte</option>
        <option value="MX">Mexico</option>
        <option value="FM">Micronesia, Federated States of</option>
        <option value="MD">Moldova, Republic of</option>
        <option value="MC">Monaco</option>
        <option value="MN">Mongolia</option>
        <option value="ME">Montenegro</option>
        <option value="MS">Montserrat</option>
        <option value="MA">Morocco</option>
        <option value="MZ">Mozambique</option>
        <option value="MM">Myanmar</option>
        <option value="NA">Namibia</option>
        <option value="NR">Nauru</option>
        <option value="NP">Nepal</option>
        <option value="NL">Netherlands</option>
        <option value="AN">Netherlands Antilles</option>
        <option value="NC">New Caledonia</option>
        <option value="NZ">New Zealand</option>
        <option value="NI">Nicaragua</option>
        <option value="NE">Niger</option>
        <option value="NG">Nigeria</option>
        <option value="NU">Niue</option>
        <option value="NF">Norfolk Island</option>
        <option value="MP">Northern Mariana Islands</option>
        <option value="NO">Norway</option>
        <option value="OM">Oman</option>
        <option value="PK">Pakistan</option>
        <option value="PW">Palau</option>
        <option value="PS">Palestinian Territory, Occupied</option>
        <option value="PA">Panama</option>
        <option value="PG">Papua New Guinea</option>
        <option value="PY">Paraguay</option>
        <option value="PE">Peru</option>
        <option value="PH">Philippines</option>
        <option value="PN">Pitcairn</option>
        <option value="PL">Poland</option>
        <option value="PT">Portugal</option>
        <option value="PR">Puerto Rico</option>
        <option value="QA">Qatar</option>
        <option value="RE">Reunion</option>
        <option value="RO">Romania</option>
        <option value="RU">Russian Federation</option>
        <option value="RW">Rwanda</option>
        <option value="BL">Saint Barthelemy</option>
        <option value="SH">Saint Helena</option>
        <option value="KN">Saint Kitts and Nevis</option>
        <option value="LC">Saint Lucia</option>
        <option value="MF">Saint Martin</option>
        <option value="PM">Saint Pierre and Miquelon</option>
        <option value="VC">Saint Vincent and the Grenadines</option>
        <option value="WS">Samoa</option>
        <option value="SM">San Marino</option>
        <option value="ST">Sao Tome and Principe</option>
        <option value="SA">Saudi Arabia</option>
        <option value="SN">Senegal</option>
        <option value="RS">Serbia</option>
        <option value="CS">Serbia and Montenegro</option>
        <option value="SC">Seychelles</option>
        <option value="SL">Sierra Leone</option>
        <option value="SG">Singapore</option>
        <option value="SX">Sint Maarten</option>
        <option value="SK">Slovakia</option>
        <option value="SI">Slovenia</option>
        <option value="SB">Solomon Islands</option>
        <option value="SO">Somalia</option>
        <option value="ZA">South Africa</option>
        <option value="GS">South Georgia and the South Sandwich Islands</option>
        <option value="SS">South Sudan</option>
        <option value="ES">Spain</option>
        <option value="LK">Sri Lanka</option>
        <option value="SD">Sudan</option>
        <option value="SR">Suriname</option>
        <option value="SJ">Svalbard and Jan Mayen</option>
        <option value="SZ">Swaziland</option>
        <option value="SE">Sweden</option>
        <option value="CH">Switzerland</option>
        <option value="SY">Syrian Arab Republic</option>
        <option value="TW">Taiwan, Province of China</option>
        <option value="TJ">Tajikistan</option>
        <option value="TZ">Tanzania, United Republic of</option>
        <option value="TH">Thailand</option>
        <option value="TL">Timor-Leste</option>
        <option value="TG">Togo</option>
        <option value="TK">Tokelau</option>
        <option value="TO">Tonga</option>
        <option value="TT">Trinidad and Tobago</option>
        <option value="TN">Tunisia</option>
        <option value="TR">Turkey</option>
        <option value="TM">Turkmenistan</option>
        <option value="TC">Turks and Caicos Islands</option>
        <option value="TV">Tuvalu</option>
        <option value="UG">Uganda</option>
        <option value="UA">Ukraine</option>
        <option value="AE">United Arab Emirates</option>
        <option value="GB">United Kingdom</option>
        <option value="US">United States of America</option>
        <option value="UM">United States Minor Outlying Islands</option>
        <option value="UY">Uruguay</option>
        <option value="UZ">Uzbekistan</option>
        <option value="VU">Vanuatu</option>
        <option value="VE">Venezuela</option>
        <option value="VN">Vietnam</option>
        <option value="VG">Virgin Islands, British</option>
        <option value="VI">Virgin Islands, U.s.</option>
        <option value="WF">Wallis and Futuna</option>
        <option value="EH">Western Sahara</option>
        <option value="YE">Yemen</option>
        <option value="ZM">Zambia</option>
        <option value="ZW">Zimbabwe</option>
        <?php
    }
	
}
?> 