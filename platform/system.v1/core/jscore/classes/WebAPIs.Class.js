import * as Init from '../init.js';
import * as HttpRequest from './HttpRequest.Class.js';
const hostname = Init.URL_API_MASTER_WS;

export function wsActiveHomeData(){
	let request_data = {
		'request': 'oK3h5UtbqhIwfDjyki8SSxP+9lE+juq1AD/II5/tTvY',
		'webToken': 'FZrp/HEwJwWCrAH303ypUQ'
	};
	let response_data = HttpRequest.post(request_data);
	return response_data;
	if(response_data){
		console.log("_________ 2 SUCCES WEB APIS----");
		console.log("_________ 2 SUCCES WEB APIS----  " + response_data);
		if(response_data.status == 1){
			return response_data.data;
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}