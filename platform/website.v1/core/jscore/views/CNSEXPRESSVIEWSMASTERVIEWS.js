import * as Init from '../init.js';
import { WSCNSWEBEXPRESS } from '../classes/WSCNSWEBEXPRESS.js';
import { WSCNSCART } from '../classes/WSCNSCART.js';
import * as CloudPDFInit from '../classes/CloudPDF.js';
import { Hash } from '../classes/Hash.js';
import { IOSystem } from '../classes/IOSystem.js';

let IOS = new IOSystem();


export class CNSEXPRESSVIEWSMASTERVIEWS{
	constructor(name) {
		this.HASH = new Hash();
		this.WSCNSWEB = new WSCNSWEBEXPRESS("123445", "00000000");
		// this.AUTHWSCNSWEB = new WSCNSWEBEXPRESS("123445", "00000000");
		// this.SHIPDATAWSCNSWEB = new WSCNSWEBEXPRESS("123445", "00000000");


		this.WSCNSWEB_HEADERS = this.WSCNSWEB.headers;
		// this.AUTHWSCNSWEB_HEADERS = this.AUTHWSCNSWEB.authheaders;
		// this.SHIPDATAWSCNSWEB_HEADERS = this.SHIPDATAWSCNSWEB.shipdataheaders;

		this.WSCNSWEB_BODY = this.WSCNSWEB.body;
		this.WSCNSRESDATA = this.WSCNSWEB.enginedata();
		// this.AUTHWSCNSRESDATA = this.AUTHWSCNSWEB.authenginedata();
		// this.SHIPDATAWSCNSRESDATA = this.SHIPDATAWSCNSWEB.shipdataenginedata();


		this.CNS_RESDATA_SOURCE_CONTRY = this.WSCNSWEB.get(this.WSCNSRESDATA.data.sourcecountry);
		this.CNS_RESDATA_DESTINATION_CONTRY = this.WSCNSWEB.get(this.WSCNSRESDATA.data.destinationcountry);

		this.CNS_RESDATA_SOURCE_PROVINCE = this.WSCNSWEB.get(this.WSCNSRESDATA.data.province);
		this.CNS_RESDATA_DESTINATION_PROVINCE = this.WSCNSWEB.get(this.WSCNSRESDATA.data.province);

		this.CNS_RESDATA_SOURCE_CITY = this.WSCNSWEB.get(this.WSCNSRESDATA.data.city);
		this.CNS_RESDATA_DESTINATION_CITY = this.WSCNSWEB.get(this.WSCNSRESDATA.data.city);

		this.CNS_RESDATA_SHIP_PURPOSE = this.WSCNSWEB.get(this.WSCNSRESDATA.data.shippurpose);
		this.CNS_RESDATA_SHIP_ITEM_TYPE = this.WSCNSWEB.get(this.WSCNSRESDATA.data.itemtype);

		this.CNS_RESDATA_UNIT = this.WSCNSWEB.get(this.WSCNSRESDATA.data.itemunit);
		this.CNS_RESDATA_PICKUPTYPE_SOURCE = this.WSCNSWEB.get(this.WSCNSRESDATA.data.pickuptype.source);
		this.CNS_RESDATA_PICKUPTYPE_DESTINATION = this.WSCNSWEB.get(this.WSCNSRESDATA.data.pickuptype.destination);

		this.CNS_RESDATA_CURRENCY = this.WSCNSWEB.get(this.WSCNSRESDATA.data.currency);
		this.CNS_RESDATA_LANGUAGE = this.WSCNSWEB.get(this.WSCNSRESDATA.data.language);

		this.CNS_RESDATA_ACCOUNT = this.WSCNSWEB.get(this.WSCNSRESDATA.data.account);
		this.CNS_RESDATA_SHIP_DATA = this.WSCNSWEB.get(this.WSCNSRESDATA.data.account);

		if(this.CNS_RESDATA_ACCOUNT)
		this.CNS_RESDATA_SHIP_DATA_ACCOUNT_SHIP_STATUS = this.WSCNSWEB.get(this.WSCNSRESDATA.data.account.ship_status);

		this.CNS_RESDATA_ACCOUNT_SHIP_ITEM = this.WSCNSWEB.get(this.WSCNSRESDATA.data.item);

		this.DNWEB = this.WSCNSWEB.dnweb();

	}


	cns_view_section_source_country(el_key) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_SOURCE_CONTRY) {
			for (const index in this.CNS_RESDATA_SOURCE_CONTRY) {
				let data = this.CNS_RESDATA_SOURCE_CONTRY[index];
				output = output + `
				<option value="${data.token_auth}">${data.name}</option>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_section_destination_country(el_key) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_DESTINATION_CONTRY) {
			for (const index in this.CNS_RESDATA_DESTINATION_CONTRY) {
				let data = this.CNS_RESDATA_DESTINATION_CONTRY[index];
				output = output + `
				<option value="${data.token_auth}">${data.name}</option>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_section_source_province(el_key, ctacountry) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_SOURCE_PROVINCE) {
			for (const index in this.CNS_RESDATA_SOURCE_PROVINCE) {
				let data = this.CNS_RESDATA_SOURCE_PROVINCE[index];
				if(data.ctacountry == ctacountry){				
					output = output + `
					<option value="${data.ctaprovince}">${data.name}</option>
					`;
				}
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_section_destination_province(el_key, ctacountry) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_DESTINATION_PROVINCE) {
			for (const index in this.CNS_RESDATA_DESTINATION_PROVINCE) {
				let data = this.CNS_RESDATA_DESTINATION_PROVINCE[index];
				if(data.ctacountry == ctacountry){				
					output = output + `
					<option value="${data.ctaprovince}">${data.name}</option>
					`;
				}
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_section_source_city(el_key, ctaprovince) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_SOURCE_CITY) {
			for (const index in this.CNS_RESDATA_SOURCE_CITY) {
				let data = this.CNS_RESDATA_SOURCE_CITY[index];
				if(data.ctaprovince == ctaprovince){				
					output = output + `
					<option value="${data.ctacity}">${data.name}</option>
					`;
				}
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}
	
	cns_view_section_destination_city(el_key, ctaprovince) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_DESTINATION_CITY) {
			for (const index in this.CNS_RESDATA_DESTINATION_CITY) {
				let data = this.CNS_RESDATA_DESTINATION_CITY[index];
				if(data.ctaprovince == ctaprovince){				
					output = output + `
					<option value="${data.ctacity}">${data.name}</option>
					`;
				}
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_section_ship_purpose(el_key) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_SHIP_PURPOSE) {
			for (const index in this.CNS_RESDATA_SHIP_PURPOSE) {
				let data = this.CNS_RESDATA_SHIP_PURPOSE[index];
				output = output + `
				<option value="${data.ctapurpose}">${data.name}</option>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_section_ship_item_type(el_key) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_SHIP_ITEM_TYPE) {
			for (const index in this.CNS_RESDATA_SHIP_ITEM_TYPE) {
				let data = this.CNS_RESDATA_SHIP_ITEM_TYPE[index];
				output = output + `
				<option value="${data.ctaitemtype}">${data.name}</option>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_section_ship_item_unit(el_key) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_UNIT) {
			for (const index in this.CNS_RESDATA_UNIT) {
				let data = this.CNS_RESDATA_UNIT[index];
				output = output + `
				<option value="${data.ctaitemunit}">${data.name}</option>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}


	cns_view_section_ship_pickup_type_source(el_key) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_PICKUPTYPE_SOURCE) {
			for (const index in this.CNS_RESDATA_PICKUPTYPE_SOURCE) {
				let data = this.CNS_RESDATA_PICKUPTYPE_SOURCE[index];
				output = output + `
				<option value="${data.ctapickuptype}">${data.pickup_type_name}</option>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_section_ship_pickup_type_destination(el_key) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_PICKUPTYPE_DESTINATION) {
			for (const index in this.CNS_RESDATA_PICKUPTYPE_DESTINATION) {
				let data = this.CNS_RESDATA_PICKUPTYPE_DESTINATION[index];
				output = output + `
				<option value="${data.ctapickuptype}">${data.pickup_type_name}</option>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_section_ship_item_currency(el_key) {
		let output = `<option value="">Select</option>`;
		if (this.CNS_RESDATA_CURRENCY) {
			for (const index in this.CNS_RESDATA_CURRENCY) {
				let data = this.CNS_RESDATA_CURRENCY[index];
				output = output + `
				<option value="${data.ctacurrency}">${data.name}</option>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}




	cns_view_b2c_ship_lists(el_key_array) {
		let row_tr_table = `
		<table class="table table-bordered table-striped table-responsive">
			<thead class="thead-dark" style="background-color: none;">

				<tr>
					<th scope="col" rowspan="2" class="text-center">#</th>
					<th scope="col" rowspan="2" class="text-center">Ship label</th>
					<th scope="col" rowspan="2" class="text-center"> Number of items</th>
					<th scope="col" rowspan="2" class="text-center"> Date</th>
					<th scope="col" colspan="5" class="text-center"> Destination</th>
					<th scope="col" rowspan="2" class="text-center"> Status</th>
					<th scope="col" rowspan="2" colspan="2" class="text-center"> Action</th>
				</tr>
				<tr>
					<th scope="col">First name</th>
					<th scope="col">Last name</th>
					<th scope="col">Country</th>
					<th scope="col">Province</th>
					<th scope="col">City</th>
					

				</tr>
				
			</thead>
			<tbody>
		`;		  

		if (this.CNS_RESDATA_ACCOUNT) {
			let count = 0;

			for (const index in this.CNS_RESDATA_ACCOUNT.ships) {
				let ship = this.CNS_RESDATA_ACCOUNT.ships[index];
				count++;

				row_tr_table = row_tr_table + `
				<tr>
					<td> ${count}</td>
					<td> ${ship.ship_label}</td>
					<td> ${ship.ship_item_count}</td>
					<td> ${ship.creation_datetime}</td>
					<td> ${ship.destination_firstname}</td>
					<td> ${ship.destination_lastname}</td>
					<td> ${ship.destination_country}</td>
					<td> ${ship.destination_province}</td>
					<td> ${ship.destination_city}</td>
					
					<td> ${ship.status}</td>

					<td>
						<a target="_blank" style="background-color: #000; padding: 4px; border-radius: 5px; color: white;" href="${Init.DNWEB}ship/docs/${ship.ctiship}"> <span class="fa fa-pdf"></span> Print</a>
						</td>
						<td>
						<a style="background-color: #0B60A9; padding: 4px; border-radius: 5px; color: white;" href="${Init.DNWEB}ship/detail/${ship.ctiship}"> Detail</a>
					</td>

				</tr>
				`;
			}
		}
		else {
		}
		row_tr_table + 
		`</tbody>
		</table>`;
		
		$(el_key_array).html(row_tr_table);
		return false;
	}
	

	cns_view_b2c_ship_data() {
		if (this.CNS_RESDATA_SHIP_DATA) {
			
				let data = this.CNS_RESDATA_SHIP_DATA.ship;

				IOS.puthtml(".source_firstname", 'First name: ' + data.source_firstname);
				IOS.puthtml(".source_lastname", 'Last name: ' + data.source_lastname);
				IOS.puthtml(".source_email", 'Email: ' + data.source_email);
				IOS.puthtml(".source_telephone", 'Telephone: ' + data.source_telephone);
				IOS.puthtml(".source_address_1", 'Address 1: ' + data.source_address_1);
				IOS.puthtml(".source_address_2", 'Adress 2: ' + data.source_address_2);

				IOS.puthtml(".source_country", 'Country: ' + data.source_country);
				IOS.puthtml(".source_province", 'Province: ' + data.source_province);
				IOS.puthtml(".source_city", 'City: ' + data.source_city);

				IOS.puthtml(".source_company_status", 'Company Status: ' + data.source_company_status);
				IOS.puthtml(".source_company_name",  'Company name: ' + data.source_company_name);

				IOS.puthtml(".source_pickup_type", 'Pick up Type: ' + data.source_pickup_type);
				IOS.puthtml(".source_pickup_location", 'Pick up Location: ' + data.source_pickup_location);
				IOS.puthtml(".source_pickup_instruction", 'Pick up Instruction: ' + data.source_pickup_instruction);

				IOS.puthtml(".destination_firstname", 'First name: ' + data.destination_firstname);
				IOS.puthtml(".destination_lastname", 'Last name: ' + data.destination_lastname);
				IOS.puthtml(".destination_email", 'Email ' + data.destination_email);
				IOS.puthtml(".destination_telephone", 'Telephone: ' + data.destination_telephone);
				IOS.puthtml(".destination_address_1", 'Address 1: ' + data.destination_address_1);
				IOS.puthtml(".destination_address_2", 'Adress 2: ' + data.destination_address_2);


				IOS.puthtml(".destination_country", 'Country: ' + data.destination_country);
				IOS.puthtml(".destination_province", 'Province: ' + data.destination_province);
				IOS.puthtml(".destination_city", 'City: ' + data.destination_city);

				IOS.puthtml(".destination_company_status", 'Company Status: ' + data.destination_company_status);
				IOS.puthtml(".destination_company_name", 'Company name: ' + data.destination_company_name);

				IOS.puthtml(".destination_pickup_type", 'Pick up Type: ' + data.destination_pickup_type);
				IOS.puthtml(".sdestination_pickup_location", 'Pick up Location: ' + data.destination_pickup_location);
				IOS.puthtml(".destination_pickup_instruction", 'Pick up Instruction: ' + data.destination_pickup_instruction);

				IOS.puthtml(".ship_label",  data.ship_label);
				IOS.puthtml(".ship_status", data.status);
				IOS.puthtml(".status", data.status);

				IOS.puthtml(".ship_description", data.ship_description);

				IOS.puthtml(".ship_purpose", data.ship_purpose);
				IOS.puthtml(".ship_item_type", data.ship_description);
				IOS.puthtml(".ship_cost", data.ship_cost);
				IOS.puthtml(".code", 'code: ' + data.code);

				
				IOS.puthtml(".shipqrcode", `<img src="${Init.DNSHIPQR}/${data.code}.png" />`);
				

				IOS.puthtml(".source_firstname_lastname", data.source_firstname + ' ' + data.source_lastname);
				IOS.puthtml(".creation_datetime", 'Created: ' + data.creation_datetime);

				$('.pmd-textfield').removeClass('pmd-textfield-floating-label');
				
		}else {
			// RedirectURL.to(Init.DNWEB + "/my_account");	
		}
	}



	cns_view_b2c_ship_item_lists(el_key_array) {
		let row_tr_table = `
		
		<table class="table table-responsive table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Quantity</th>
				<th>Dimension</th>
				<th>Value</th>
				<th>Weight</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
		`;		  

		if (this.CNS_RESDATA_ACCOUNT_SHIP_ITEM) {
			let count = 0;

			for (const index in this.CNS_RESDATA_ACCOUNT_SHIP_ITEM) {
				let data = this.CNS_RESDATA_ACCOUNT_SHIP_ITEM[index];
				count++;
			
				row_tr_table = row_tr_table + `
				<tr>
					<td> ${count}</td>
					<td> ${data.name}</td>
					<td> ${data.quantity + ' ' + data.unit}</td>
					<td> ${data.dimension}</td>
					<td> ${data.value + ' ' + data.currency}</td>
					<td> ${data.weight}</td>
					<td> ${data.description}</td>
				</tr>
				`;
			}
		}
		else {
		}
		row_tr_table + 
		`</tbody>
		</table>`;
		
		$(el_key_array).html(row_tr_table);
		return false;
	}








	cns_view_track_ship_status(el_key) {
		let output = ``;
		let data_count = 0;

		if (this.CNS_RESDATA_SHIP_DATA_ACCOUNT_SHIP_STATUS) {
			for (const index in this.CNS_RESDATA_SHIP_DATA_ACCOUNT_SHIP_STATUS) {
				data_count++;
				let data = this.CNS_RESDATA_SHIP_DATA_ACCOUNT_SHIP_STATUS[index];

				let inverted = (data_count % 2 === 0)? 'timeline-inverted': '';

				let font_icon = '';
				let font_color = '';

				let status = data.current_status;

				if(data.status === status)
				font_icon = 'glyphicon glyphicon-check';

				if(data.status === 'APPROVED' || data.status === 'ARRIVED' || data.status === 'COMPLETED' || data.status === 'DELIVERED')
				font_color = 'success';

				if(data.status === 'ASSIGNED' || data.status === 'TRAVELLING' || data.status === 'AT SOURCE AIRPORT' || data.status === 'AT SOURCE AIRPORT' || data.status === 'ARRIVED AT DESTINATION AIRPORT' || data.status === 'INITIATED' )
				font_color = 'info';

				if(data.status === 'REJECTED' || data.status === 'AIRPLAN CANCELLED' || data.status === 'DELIVERY REJECTED' || data.status === 'DELIVERY FAILURE' || data.status === 'DELIVERY CANCELLED')
				font_color = 'danger';

				output = output + `

				<li class="${inverted}">
					<div class="timeline-badge ${font_color}"><i class="${font_icon}"></i></div>
					<div class="timeline-panel">
						<div class="timeline-heading">
							<h4 class="timeline-title"> ${data.status} </h4>
							<p><small class="text-muted"><i class="glyphicon glyphicon-calendar"></i>${data.creation_datetime}</small></p>
						</div>
						<div class="timeline-body">
							<p>${data.comment}</p>
						</div>
					</div>
				</li>
				`;
			
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

}