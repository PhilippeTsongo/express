import * as Init from '../init.js';
import { IOSystem } from './IOSystem.js';
let IOSystem_ = new IOSystem();

export class WSCNSAuthentification {
	constructor(headers) {
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
			"CNSTOKENST": this._KERNEL_.KER.KEY07,
			"CNSTOKENSI": ""
		};
	}

	signin(formID = '#SignInForm') {
		var username = IOSystem_.inputvl(formID + ' #username');
		var password = IOSystem_.inputvl(formID + ' #password');

		let HEADERS = this.headers;
		HEADERS.CNSTOKENSI = btoa(new Date().getTime() + ':' + username + ':' + password).replaceAll("=", "");
		// HEADERS.CNSTOKENSI = btoa(new Date().getTime() + ':' + btoa(firstname) + ':' + password).replaceAll("=", "");


		HEADERS.CNSTOKENSI = btoa(HEADERS.CNSTOKENSI);
		let REDIR = this.DNWEB;

		$(formID + ' .notif').removeClass('notif-lg-success');
		$(formID + ' .notif').removeClass('notif-lg-error');
		$(formID + ' .notif').addClass('hidden');

		if (username.length < 6) {
			$(formID + ' .notif').removeClass('notif-lg-success');
			$(formID + ' .notif').removeClass('hidden');
			$(formID + ' .notif').addClass('notif-lg-error');
			$(formID + ' .notif').html('Invalid Telephone Number.');
			return false;
		}

		if (password.length < 6) {
			$(formID + ' .notif').removeClass('notif-lg-success');
			$(formID + ' .notif').removeClass('hidden');
			$(formID + ' .notif').addClass('notif-lg-error');
			$(formID + ' .notif').html('Invalid Password.');
			return false;
		}

		$(formID + ' .notif').removeClass('notif-lg-error');
		$(formID + ' .notif').removeClass('notif-lg-success');
		$(formID + ' .notif').removeClass('hidden');
		$(formID + ' .notif').addClass('notif-lg-info');
		IOSystem_.puthtml(' .notif', "Procing Login Request ...");

		$.ajax({
			

			url: Init.APIAUTHSIGNIN,
			type: "POST",
			headers: this.headers,
			data: {},
			cache: false,
			async: false,
			success: function (dataResponse) {
				console.log(dataResponse);

				var response = (dataResponse);
				IOSystem_.puthtml('#login', 'Login');
				if (response.status == "200") {
					$(formID + ' .notif').removeClass('notif-lg-error');
					$(formID + ' .notif').removeClass('notif-lg-info');
					$(formID + ' .notif').removeClass('hidden');
					$(formID + ' .notif').addClass('notif-lg-success');
					IOSystem_.puthtml(formID + ' .notif', response.message);

					if(formID == '#MobileSignInForm')
						setTimeout(function () { window.location = '?oauth_=' + btoa(JSON.stringify(response)) + '&oredir_=' + REDIR + '/my_account'  }, 1000);
					else	
						setTimeout(function () { window.location = '?oauth_=' + btoa(JSON.stringify(response)) + '&oredir_=' + btoa(REDIR + '/my_account') }, 2000);
				}
				else {
					$(formID + ' .notif').removeClass('notif-lg-success');
					$(formID + ' .notif').removeClass('notif-lg-info');
					$(formID + ' .notif').removeClass('hidden');
					$(formID + ' .notif').addClass('notif-lg-error');
					IOSystem_.puthtml(formID + ' .notif', response.message);
				}
			}
		});
		return false;
	}

	signup(formID = '#SignUpForm') {
		var firstname = IOSystem_.inputvl(formID + ' .firstname');
		var lastname = IOSystem_.inputvl(formID + ' .lastname');
		var email = IOSystem_.inputvl(formID + ' .email');
		let telephone = IOSystem_.inputvl(formID + ' .telephone');
		var password = IOSystem_.inputvl(formID + ' .password');

		let HEADERS = this.headers;

		HEADERS.CNSTOKENSI = btoa(new Date().getTime() + ':' + btoa(firstname) + ':' + password).replaceAll("=", "");
		
		HEADERS.CNSTOKENSI = btoa(HEADERS.CNSTOKENSI);
		
		let REDIR = this.DNWEB;

		$(formID + ' .notif').removeClass('notif-lg-success');
		$(formID + ' .notif').removeClass('notif-lg-error');
		$(formID + ' .notif').addClass('hidden');

		console.log(HEADERS);
		// alert('hey 5555 - ' +  telephone);

		if (telephone.length != 12) {
			$(formID + ' .notif').removeClass('notif-lg-success');
			$(formID + ' .notif').removeClass('hidden');
			$(formID + ' .notif').addClass('notif-lg-error');
			$(formID + ' .notif').html('Invalid Telephone Number. #1');
			return false;
		}

		if (password.length == 0) {
			$(formID + ' .notif').removeClass('notif-lg-success');
			$(formID + ' .notif').removeClass('hidden');
			$(formID + ' .notif').addClass('notif-lg-error');
			$(formID + ' .notif').html('Password is required!');
			return false;
		}

		if (password.length < 6) {
			$(formID + ' .notif').removeClass('notif-lg-success');
			$(formID + ' .notif').removeClass('hidden');
			$(formID + ' .notif').addClass('notif-lg-error');
			$(formID + ' .notif').html('Invalid Password. Choose strong password!');
			return false;
		}

		let form_data = {
			"firstname": firstname,
			"lastname": lastname,
			"telephone": telephone,
			"email": email,
		};
		
		$(formID + ' .notif').removeClass('notif-lg-error');
		$(formID + ' .notif').removeClass('notif-lg-success');
		$(formID + ' .notif').removeClass('hidden');
		$(formID + ' .notif').addClass('notif-lg-info');
		IOSystem_.puthtml(' .notif', "Procing Sign Up Request ...");

		this.headers.CNSTOKENSI = btoa(new Date().getTime() + ':' + email + ':' + password).replaceAll("=", "");
		this.headers.CNSTOKENSI = btoa(this.headers.CNSTOKENSI);

		$.ajax({
			url: Init.APIAUTHSIGNUP,
			type: "POST",
			headers: this.headers,
			contentType: "application/json; charset=utf-8",
			data: JSON.stringify(form_data),
			cache: false,
			success: function (dataResponse) {
				
				var response = (dataResponse);
				IOSystem_.puthtml('#login', 'Login');
				if (response.status == "200") {
					$(formID + ' .notif').removeClass('notif-lg-error');
					$(formID + ' .notif').removeClass('notif-lg-info');
					$(formID + ' .notif').removeClass('hidden');
					$(formID + ' .notif').addClass('notif-lg-success');
					IOSystem_.puthtml(formID + ' .notif', response.message);
					setTimeout(function () { window.location = '?oauth_=' + btoa(JSON.stringify(response)) + '&oredir_=' + btoa(REDIR + '/my_account') }, 1000);
				}
				else {
					$(formID + ' .notif').removeClass('notif-lg-success');
					$(formID + ' .notif').removeClass('notif-lg-info');
					$(formID + ' .notif').removeClass('hidden');
					$(formID + ' .notif').addClass('notif-lg-error');
					IOSystem_.puthtml(formID + ' .notif', response.message);
					return false;
				}
			}
		});
		return false;
	}


	logout(_AUTH_) {
		$('#oauthlogout').on('click', function () {
			$.ajax({
				url: Init.APIAUTHSIGNOUT,
				type: "GET",
				headers: {
					'Authorization': _AUTH_
				},
				data: {},
				cache: false,
				success: function (dataResponse) {
					var response = (dataResponse);
					if (response.code == "00") {
						// Notification.notify(
						// 	'primary',
						// 	`Logout request done successfully. You are being redirected out!`,
						// 	`Logged Out Successfully`,
						// 	`${Init.IMAGE_LOGOUT}`,
						// 	'Circle',
						// 	8000
						// );
						setTimeout(function () { window.location = 'oauth_/out/' + btoa(JSON.stringify(response)) }, 2000);
					}
					else {
						// Notification.notify(
						// 	'danger',
						// 	`Logout request failed. Try again later`,
						// 	`Logout Request`,
						// 	`${Init.IMAGE_LOGOUT}`,
						// 	'Circle',
						// 	8000
						// );
						return false;
					}
				}
			});
			return false;
		});
	}

	popUpSignIn(){
		$('.cnsclicklinksignin')[0].click();
	}

}
