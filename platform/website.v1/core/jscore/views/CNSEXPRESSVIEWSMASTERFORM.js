import * as Init from '../init.js';
import { WSCNSWEBEXPRESS } from '../classes/WSCNSWEBEXPRESS.js';
import { IOSystem } from '../classes/IOSystem.js';

export class CNSEXPRESSVIEWSMASTERFORM {
	constructor(name) {
		this.WSCNSWEB = new WSCNSWEBEXPRESS("123445", "00000000");
		this.WSCNSWEB_HEADERS = this.WSCNSWEB.headers;
		this.WSCNSWEB_BODY = this.WSCNSWEB.body;
		this.WSCNSRESDATA = this.WSCNSWEB.enginedata();

		this.CNS_RESDATA_CURRENCY = this.WSCNSWEB.get(this.WSCNSRESDATA.data.currency);
		this.CNS_RESDATA_LANGUAGE = this.WSCNSWEB.get(this.WSCNSRESDATA.data.language);

		this.DNWEB = this.WSCNSWEB.dnweb();
	}

	cns_express_submit_ship(el_key) {
		let IOS = new IOSystem();
		let REDIR = this.DNWEB;
		let RESTATUS = false;
		let BODYDATA = {
			"DATA": {
				"source_company_name": IOS.inputvl('#source_company'),
				"source_firstname": IOS.inputvl('#source_firstname'),
				"source_lastname": IOS.inputvl('#source_lastname'),
				"source_country": IOS.inputvl('#source-country'),
				"source_province": IOS.inputvl('#source-province'),
				"source_city": IOS.inputvl('#source-city'),
				"source_address_1": IOS.inputvl('#source_address_1'),
				"source_address_2": IOS.inputvl('#source_address_2'),
				"source_email": IOS.inputvl('#source_email'),
				"source_telephone": IOS.inputvl('#source_telephone'),
				"source_pickup_type": IOS.inputvl('#source_pickup_type'),
				"source_pickup_location": IOS.inputvl('#source_pickup_location'),
				"source_pickup_instruction": IOS.inputvl('#source_pickup_instruction'),

				"destination_company_name": IOS.inputvl('#destination_company'),
				"destination_firstname": IOS.inputvl('#destination_firstname'),
				"destination_lastname": IOS.inputvl('#destination_lastname'),
				"destination_country": IOS.inputvl('#destination-country'),
				"destination_province": IOS.inputvl('#destination-province'),
				"destination_city": IOS.inputvl('#destination-city'),
				"destination_address_1": IOS.inputvl('#destination_address_1'),
				"destination_address_2": IOS.inputvl('#destination_address_2'),
				"destination_email": IOS.inputvl('#destination_email'),
				"destination_telephone": IOS.inputvl('#destination_telephone'),
				"destination_pickup_type": IOS.inputvl('#destination_pickup_type'),
				"destination_pickup_location": IOS.inputvl('#destination_pickup_location'),
				"destination_pickup_instruction": IOS.inputvl('#destination_pickup_instruction'),

				"ship_label": IOS.inputvl('#ship_label'),
				"ship_description": IOS.inputvl('#ship_description'),
				"ship_purpose": IOS.inputvl('#ship-purpose'),
				"ship_item_type": IOS.inputvl('#ship_item_type'),

				"ship_additional_detail": IOS.inputvl('#ship_additional_detail'),
				"ship_short_description": IOS.inputvl('#ship_short_description'),
				"invoice_number": IOS.inputvl('#invoice_number'),
				"invoice_description": IOS.inputvl('#invoice_description'),
				"SHIPITEMS": CNSEXPRESSVIEWSMASTERFORM.prototype.formTableShipItems()
			}
		};

		let RESPONSE = this.WSCNSWEB.submitform(BODYDATA);
		let formID = '';
		if (RESPONSE.status == "200") {
			RESTATUS = true;
			$(formID + ' .notif').removeClass('notif-lg-error');
			$(formID + ' .notif').removeClass('notif-lg-info');
			$(formID + ' .notif').removeClass('hidden');
			$(formID + ' .notif').addClass('notif-lg-success');
			IOS.puthtml(formID + ' .notif', RESPONSE.message);

			setTimeout(function () { window.location = REDIR + '/shipment/success/' + RESPONSE.ctiship }, 1000);
		}
		else {
			$(formID + ' .notif').removeClass('notif-lg-success');
			$(formID + ' .notif').removeClass('notif-lg-info');
			$(formID + ' .notif').removeClass('hidden');
			$(formID + ' .notif').addClass('notif-lg-error');
			IOS.puthtml(formID + ' .notif', RESPONSE.message);
		}
		return RESTATUS;
	}

	formTableShipItems() {
		var data = [];
		$('table tr').each(function (index) {
			if (index !== 0) {
				let itemname = $(this).find('input[name^="ship-item-name"]').val();
				let itemquantity = $(this).find('input[name^="ship-item-quantity"]').val();
				let itemunit = $(this).find('select[name^="ship-item-unit"]').val();
				let itemvalue = $(this).find('input[name^="ship-item-price"]').val();
				let itemcurrency = $(this).find('select[name^="ship-item-currency"]').val();
				let itemweight = $(this).find('input[name^="ship-item-weight"]').val();
				let itemdimension = $(this).find('input[name^="ship-item-dimension"]').val();
				let itemdescription = $(this).find('textarea[name^="ship-item-description"]').val();

				data.push({
					"itemname": itemname,
					"itemquantity": itemquantity,
					"itemunit": itemunit,
					"itemvalue": itemvalue,
					"itemcurrency": itemcurrency,
					"itemweight": itemweight,
					"itemdimension": itemdimension,
					"itemdescription": itemdescription
				});
			}
		});
		return data;
	}

}



