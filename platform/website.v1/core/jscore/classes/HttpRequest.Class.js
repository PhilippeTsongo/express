import * as Init from '../init.js';
const hostname = Init.URL_API_MASTER_WS;



export function post(request_data) {
	var response = "Initiated  -- " + request_data.request;
	$.ajax({
	  url: hostname,
	  type: "POST",
	  cache: false,
	  data: request_data,
	  async: true,
	  success: function (dataResponse) {
		response = "Initiated 123489098394098909";
		// response = JSON.parse(dataResponse);
	  }
	});
	return response;
}

export function get(request_data) {
	var form_data = $('#filterForm').serialize();
	$.ajax({
	  url: hostname,
	  type: "GET",
	  cache: false,
	  data: request_data,
	  success: function (dataResponse) {
		var response = JSON.parse(dataResponse);
		return response;
	  }
	});
	return false;
}