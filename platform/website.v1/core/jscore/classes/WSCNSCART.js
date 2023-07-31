import * as Init from '../init.js';
import { IOSystem } from './IOSystem.js';
import { Redirect } from './Redirect.js';
import { IONotification } from './IONotification.js';
// import {CNSESHOPVIEWSMASTERVIEWS} from '../views/CNSEXPRESSVIEWSMASTERVIEWS.js';

let IOS = new IOSystem();
let RedirectURL = new Redirect();
let IONotif = new IONotification();

export class WSCNSCART {
	constructor(headers) {
		this._KERNEL_ = $('ciphersnc').attr('content');
		this._KERNEL_ = atob(this._KERNEL_);
		this._KERNEL_ = JSON.parse(this._KERNEL_);
		this.DNWEB = this._KERNEL_.KER.KEY09;

		this.APICNSCART = Init.APICNSCART;
		this.APICNSCHECKOUT = Init.APICNSCHECKOUT;
		this.APICNSPAYMENT = Init.APICNSPAYMENT;
		this.headers = {
			"Authorization": "CNS " + this._KERNEL_.KER.KEY01,
			"CNSTOKENBS": this._KERNEL_.KER.KEY02,
			"CNSTOKENREQ": this._KERNEL_.KER.KEY03,
			"CNSTOKENREQID": this._KERNEL_.KER.KEY04,
			"CNSTOKENREQNAME": this._KERNEL_.KER.KEY05,
			"CNSTOKENREQURL": this._KERNEL_.KER.KEY06,
			"CNSTOKENST": this._KERNEL_.KER.KEY07,
			"CNSTOKENSI": ""
		};
	}


	cnsAddCart(nextAction = "") {
		var formID = '#CNSAddToCartForm';
		var cnscartquantity = IOS.inputvl(formID + ' .cnscartquantity');
		var cnscartcta = $(formID).attr("cta");

		let GATEWAY = this.APICNSCART;
		let HEADERS = this.headers;
		HEADERS.CNSTOKENREQ = this._KERNEL_.KER.KEY11;
		let DNWEB_CHECKOUT = this.DNWEB + '/checkout';

		if (nextAction == "CHECKOUT") {
			HEADERS.CNSTOKENREQ = this._KERNEL_.KER.KEY19;
		}

		let BODY = {
			"CTA": cnscartcta,
			"QUANTITY": cnscartquantity
		};


		if (cnscartquantity < 1) {
			setTimeout(function () {
				toastr.options = {
					"positionClass": "toast-top-left",
					"closeButton": true,
					"progressBar": true,
					"showEasing": "swing",
					"timeOut": "6000"
				};
				toastr.success("Incorrect quantity");
			}, 50);
			return false;
		}

		IOS.puthtml(' .CNSAddToCartButton', "Processing Add To Cart Request ...");
		$.ajax({
			url: GATEWAY,
			type: "POST",
			headers: HEADERS,
			data: JSON.stringify(BODY),
			cache: false,
			async: false,
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (dataResponse) {
				var response = (dataResponse);
				IOS.puthtml(' .CNSAddToCartButton', "Add to cart");
				if (response.status == "200") {
					setTimeout(function () {
						toastr.options = {
							"positionClass": "toast-top-left",
							"closeButton": true,
							"progressBar": true,
							"showEasing": "swing",
							"timeOut": "6000"
						};
						toastr.success(response.message);
					}, 50);

					if (nextAction == "CHECKOUT") {
						setTimeout(function () {
							RedirectURL.to(DNWEB_CHECKOUT);
						}, 1000);
					}
				}
				else {
					setTimeout(function () {
						toastr.options = {
							"positionClass": "toast-top-left",
							"closeButton": true,
							"progressBar": true,
							"showEasing": "swing",
							"timeOut": "6000"
						};
						toastr.warning(response.message);
					}, 50);
				}
				return response;
			}
		});
		return false;
	}



	cnsEmptyCart() {
		let GATEWAY = this.APICNSCART;
		let HEADERS = this.headers;
		HEADERS.CNSTOKENREQ = this._KERNEL_.KER.KEY15;
		let BODY = {};
		IOS.puthtml(' .CNSAddToCartButton', "Processing Add To Cart Request ...");
		$.ajax({
			url: GATEWAY,
			type: "POST",
			headers: HEADERS,
			data: JSON.stringify(BODY),
			cache: false,
			async: false,
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (dataResponse) {
				var response = (dataResponse);
				IOS.puthtml(' .CNSAddToCartButton', "Add to cart");
				if (response.status == "200") {
					IONotif.success(response.message);
					WSCNSCART.prototype.cnsRefreshCart();
				}
				else {
					IONotif.error(response.message);
				}
				return response;
			}
		});
		return false;
	}

	cnsRemoveCart(cnscartcta = "") {
		let GATEWAY = this.APICNSCART;
		let HEADERS = this.headers;
		HEADERS.CNSTOKENREQ = this._KERNEL_.KER.KEY14;
		let BODY = {
			"CTA": cnscartcta,
		};
		if (cnscartcta.length < 5) {
			IONotif.error("Some errors occured")
			return false;
		}
		$.ajax({
			url: GATEWAY,
			type: "POST",
			headers: HEADERS,
			data: JSON.stringify(BODY),
			cache: false,
			async: false,
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (dataResponse) {
				var response = (dataResponse);
				if (response.status == "200") {
					IONotif.success(response.message);
					WSCNSCART.prototype.cnsRefreshCart();
				}
				else
					IONotif.error(response.message);
				return response;
			}
		});
		return false;
	}




	cnsUpdateCart(cnscartcta = "", cnscartquantity = 0) {
		let GATEWAY = this.APICNSCART;
		let HEADERS = this.headers;
		HEADERS.CNSTOKENREQ = this._KERNEL_.KER.KEY13;
		let BODY = {
			"CTA": cnscartcta,
			"QUANTITY": cnscartquantity
		};
		if (cnscartcta.length < 5) {
			IONotif.error("Some errors occured")
			return false;
		}
		if(cnscartquantity < 1){
			IONotif.error("Invalid quantity")
			return false;
		}
		$.ajax({
			url: GATEWAY,
			type: "POST",
			headers: HEADERS,
			data: JSON.stringify(BODY),
			cache: false,
			async: false,
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (dataResponse) {
				var response = (dataResponse);
				if (response.status == "200") {
					IONotif.success(response.message);
					WSCNSCART.prototype.cnsRefreshCart();
				}
				else
					IONotif.error(response.message);
				return response;
			}
		});
		return false;
	}

	cnsProceedToCheckout() {
		let GATEWAY = this.APICNSCART;
		let HEADERS = this.headers;
		HEADERS.CNSTOKENREQ = this._KERNEL_.KER.KEY16;
		let DNWEB_CHECKOUT = this.DNWEB + '/checkout';
		let BODY = {};
		$.ajax({
			url: GATEWAY,
			type: "POST",
			headers: HEADERS,
			data: JSON.stringify(BODY),
			cache: false,
			async: false,
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (dataResponse) {
				var response = (dataResponse);
				if (response.status == "200") {
					IONotif.success(response.message);
					setTimeout(function () {
						RedirectURL.to(DNWEB_CHECKOUT);
					}, 1000);
				}
				else
					IONotif.error(response.message);
				return response;
			}
		});
		return false;
	}

	cnsProcessPayment() {
		var formID = '#CNSSubmitPaymentForm';
		var cnspaytelephone = IOS.inputvl(formID + ' #cnspaytelephone');
		var cnspaymode = IOS.inputvl(formID + ' #cnspaymode');

		let GATEWAY = this.APICNSPAYMENT;
		let HEADERS = this.headers;
		HEADERS.CNSTOKENREQ = this._KERNEL_.KER.KEY18;
		let DNWEB_NOTIF_SUCCESS = this.DNWEB + '/pay/success/';

		let BODY = {
			"MSISDN": cnspaytelephone,
			"MODE": "n7frLVDAeaxGA1zclAFvng"
		};

		if (cnspaytelephone.length != 12) {
			IONotif.error("Incorrect telephone");
			return false;
		}
		else if (cnspaymode.length < 8) {
			IONotif.error("Invalid payment mode");
			return false;
		}

		IOS.puthtml(' .CNSSubmitPaymentBtn', "Procing Add To Cart Request ...");
		$.ajax({
			url: GATEWAY,
			type: "POST",
			headers: HEADERS,
			data: JSON.stringify(BODY),
			cache: false,
			async: false,
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (dataResponse) {
				var response = (dataResponse);
				IOS.puthtml(' .CNSSubmitPaymentBtn', "Add to cart");
				if (response.status == "200") 
					IONotif.info(response.message);
				else 
					IONotif.error(response.message);
				return response;
			}
		});
		return false;
	}

	cnsRefreshCart(){
		let CNSESHOPMS = new CNSESHOPVIEWSMASTERVIEWS("");
		CNSESHOPMS.cns_view_section_shop_cart_data(
			{ 
			  "cart_list": ".cns_view_section_shop_cart_list",
			  "cart_total": ".cns_view_section_shop_cart_total",
			  "cart_subtotal": ".cns_view_section_shop_cart_subtotal"
			}
		);
	}

}
