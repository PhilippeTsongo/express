import * as Init from '../init.js';
import * as JQuery from './JQuery.js';

export class WSCNSWEBEXPRESS {

	constructor(headers, authheader, dataheader, body) {

		this._KERNEL_ = $('ciphersnc').attr('content');
		this._KERNEL_ = atob(this._KERNEL_);
		this._KERNEL_ = JSON.parse(this._KERNEL_);
		this.DNWEB = this._KERNEL_.KER.KEY09;

		this.headers = {
			"Authorization": "CNS " + this._KERNEL_.KER.KEY01,
			"CNSTOKENBS": this._KERNEL_.KER.KEY02,
			"CNSTOKENREQ": this._KERNEL_.KER.KEY03,
			"CNSTOKENREQID": this._KERNEL_.KER.KEY04,
			"CNSTOKENREQNAME": this._KERNEL_.KER.KEY05,
			"CNSTOKENREQURL": this._KERNEL_.KER.KEY06,
			"CNSTOKENST": this._KERNEL_.KER.KEY07
		},

		this.body = {
			"LOCATION": {
				"COUNTRY": 0,
				"CITY": 0,
				"PROVINCE": 0,
				"ADDRESS": ""
			},
			"META": {
				"CURRENCY": "",
				"LANGUAGE": ""
			},
			"CLASSIFICATION": {
				"CLASS": 9,
				"SUBCLASS": 0
			},
			"SEARCH": {
				"CATEGORY": "",
				"KEYWORD": "",
				"DATE01": "",
				"DATE02": ""
			}
		}
	}

	enginedata() {
		let response = false;
		$.ajax({
			url: Init.APICNSEXPRESS,
			type: "POST",
			headers: this.headers,
			data: JSON.stringify(this.body),
			async: false,
			success: function (dataResponse) {
				response = (dataResponse);
			}
		});
		return response;
	}

	// authenginedata() {
	// 	let response = false;
	// 	$.ajax({
	// 		url: Init.APICNSEXPRESS,
	// 		type: "POST",
	// 		headers: this.authheaders,
	// 		data: JSON.stringify(this.body),
	// 		async: false,
	// 		success: function (dataResponse) {
	// 			response = (dataResponse);
	// 		}
	// 	});
	// 	return response;
	// }

	// shipdataenginedata() {
	// 	let response = false;
	// 	$.ajax({
	// 		url: Init.APICNSEXPRESS,
	// 		type: "POST",
	// 		headers: this.shipdataheaders,
	// 		data: JSON.stringify(this.body),
	// 		async: false,
	// 		success: function (dataResponse) {
	// 			response = (dataResponse);
	// 		}
	// 	});
	// 	return response;
	// }

	get(value) {
		return value ? value : null;
	}

	urlname(name) {
		return name.trim().replaceAll(" ", "-");
	}

	dnweb(name) {
		return this.DNWEB;
	}

	submitform(BODYDATA){
		let response = false;
		$.ajax({
			url: Init.APICNSEXPRESSACTION,
			type: "POST",
			headers: (this.headers),
			data: JSON.stringify(BODYDATA),
			async: false,
			success: function (dataResponse) {
				response = (dataResponse);
			}
		});
		return response;
	}

}