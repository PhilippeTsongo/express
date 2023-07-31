export class VWSmartModal
{
	vw_modal_init()
	{
		let output = `
		
		`;
		return output;
	} 

	vw_modal_generate(action)
	{
		let output = `
		
		`;
		return output;
	}

	vw_modal_buy_airtime(Init, data_array)
	{
		let output = `
			<div class="row">
				<form class="" method="" id="${data_array.form_id}" role="form">
					<div class="col-md-12 text-center">
						<div class="media-29101" style="width: auto;">
							<a href="#" data-target="#modalSlideLeft"
								data-toggle="modal" id="btnFillSizeToggler">
								<img src="${data_array.title_image}"
									style="width: 150px;" alt="Image" class="img-fluid">
							</a>
							<h3>
								<a href="#" data-target="#modalSlideLeft"
									data-toggle="modal" id="btnFillSizeToggler">
									${data_array.title_name}
								</a>
							</h3>
						</div>
					</div>
					<div class="col-md-12"
						style="border: 1px solid lightgrey; text-align: left;">

						<h6>Beneficiary</h6>

						<div class="form-group  form-group-default required">
							<label>Enter ${data_array.operator} Telephone Number</label>
							<input type="email" class="form-control"
								placeholder="ex: +2507" required>
						</div>
						<div class="form-group  form-group-default required">
							<label>Enter Amount (RWF)</label>
							<input type="email" class="form-control"
								placeholder="ex: 100" required>
						</div>

					</div>

					<div class="col-md-12"
						style="border: 1px solid lightgrey; text-align: left; margin-top: 25%;">

						<h6>Payment Method</h6>

						<div class="form-group  form-group-default required">

							<div class="col-sm-12">

								<div class="col-lg-12 col-md-5 col-sm-12 col-xs-12 media-sform-img-box"
									style="padding: 0px; margin; 0px; text-align:left;">
									<input type="radio"
										class="vote011x550x11-payment-method"
										style="cursor: pointer;" checked name="pm"
										value="MOMO">
									<img src="${Init.IMAGE_PAYMENT_METHOD_MTN_MOMO}"
										class="media-sform-img-1" style="width: 30%;"
										alt="">
									<img src="${Init.IMAGE_PAYMENT_METHOD_AIRTEL_MOMO}"
										class="media-sform-img-2" style="width: 35%;"
										alt="">
								</div>

								<!-- <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6"
									style="padding: 0px; margin; 0px; text-align:left;">
									<input type="radio"
										class="vote011x550x11-payment-method"
										style="cursor: pointer;" name="pm" value="BANK">
									<img src="${Init.IMAGE_PAYMENT_METHOD_MASTERCARD}"
										class="media-sform-img-3" style="width: 40%;"
										alt="">
									<img src="${Init.IMAGE_PAYMENT_METHOD_VISA}"
										class="media-sform-img-4" style="width: 40%;"
										alt="">
								</div> -->

							</div>
						</div>
						<div class="form-group  form-group-default required">
							<label>Enter MoMo Telephone Number</label>
							<input type="email" class="form-control"
								placeholder="ex: +2507" required>
						</div>

					</div>
					<div class="col-md-12">

					</div>
					<div class="col-md-12">

					</div>
					<br>
					<button aria-label="" type="submit"
						class="btn btn-primary btn-block btn-cons btn-animated from-left"
						data-dismiss="modal">
						<!-- Pay Now -->
						<span style="padding-top: px;">PAY NOW</span>
						<span class="hidden-block">
							<i class="pg-icon">send</i>
						</span>
					</button>
					<button aria-label="" type="reset"
						class="btn btn-default btn-block"
						data-dismiss="modal">CANCEL</button>

				</form>
			</div>

		`;
		return output;
	}

	vw_modal_buy_electricity(Init, data_array)
	{
		let output = `
			<div class="row">
				<form class="" method="" id="${data_array.form_id}" role="form">
					<div class="col-md-12 text-center">
						<div class="media-29101" style="width: auto;">
							<a href="#" data-target="#modalSlideLeft"
								data-toggle="modal" id="btnFillSizeToggler">
								<img src="${data_array.title_image}"
									style="width: 150px;" alt="Image" class="img-fluid">
							</a>
							<h3>
								<a href="#" data-target="#modalSlideLeft"
									data-toggle="modal" id="btnFillSizeToggler">
									${data_array.title_name}
								</a>
							</h3>
						</div>
					</div>
					<div class="col-md-12"
						style="border: 1px solid lightgrey; text-align: left;">

						<h6>Beneficiary</h6>

						<div class="form-group  form-group-default required">
							<label>Enter Meter Number</label>
							<input type="email" class="form-control"
								placeholder="ex: 0000..." required>
						</div>
						<div class="form-group  form-group-default required">
							<label>Enter Amount (RWF)</label>
							<input type="email" class="form-control"
								placeholder="ex: 100" required>
						</div>

					</div>

					<div class="col-md-12"
						style="border: 1px solid lightgrey; text-align: left; margin-top: 25%;">

						<h6>Payment Method</h6>

						<div class="form-group  form-group-default required">

							<div class="col-sm-12">

								<div class="col-lg-12 col-md-5 col-sm-12 col-xs-12 media-sform-img-box"
									style="padding: 0px; margin; 0px; text-align:left;">
									<input type="radio"
										class="vote011x550x11-payment-method"
										style="cursor: pointer;" checked name="pm"
										value="MOMO">
									<img src="${Init.IMAGE_PAYMENT_METHOD_MTN_MOMO}"
										class="media-sform-img-1" style="width: 30%;"
										alt="">
									<img src="${Init.IMAGE_PAYMENT_METHOD_AIRTEL_MOMO}"
										class="media-sform-img-2" style="width: 35%;"
										alt="">
								</div>

								<!-- <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6"
									style="padding: 0px; margin; 0px; text-align:left;">
									<input type="radio"
										class="vote011x550x11-payment-method"
										style="cursor: pointer;" name="pm" value="BANK">
									<img src="${Init.IMAGE_PAYMENT_METHOD_MASTERCARD}"
										class="media-sform-img-3" style="width: 40%;"
										alt="">
									<img src="${Init.IMAGE_PAYMENT_METHOD_VISA}"
										class="media-sform-img-4" style="width: 40%;"
										alt="">
								</div> -->

							</div>
						</div>
						<div class="form-group  form-group-default required">
							<label>Enter MoMo Telephone Number</label>
							<input type="email" class="form-control"
								placeholder="ex: +2507" required>
						</div>

					</div>
					<div class="col-md-12">

					</div>
					<div class="col-md-12">

					</div>
					<br>
					<button aria-label="" type="submit"
						class="btn btn-primary btn-block btn-cons btn-animated from-left"
						data-dismiss="modal">
						<!-- Pay Now -->
						<span style="padding-top: px;">PAY NOW</span>
						<span class="hidden-block">
							<i class="pg-icon">send</i>
						</span>
					</button>
					<button aria-label="" type="reset"
						class="btn btn-default btn-block"
						data-dismiss="modal">CANCEL</button>

				</form>
			</div>

		`;
		return output;
	}

	vw_modal_buy_ticket(Init, data_array)
	{
		let output = `
			<div class="row">
				<form method="post" class="${data_array.form_id}" role="${data_array.form_id}">
					<div class="col-md-12 text-center" style="padding-right: 0px; padding-left: 0px;">
						<div class="media-29101" style="width: auto;">
							<a href="#" data-target="#modalSlideLeft"
								data-toggle="modal" id="btnFillSizeToggler">
								<img src="${data_array.title_image}"
									style="width: 100% !important; padding: 0px; margin: 0px;" alt="Image" class="img-fluid">
							</a>
							<h3>
								<a href="#" data-target="#modalSlideLeft"
									data-toggle="modal" id="btnFillSizeToggler">
									${data_array.title_name}
								</a>
							</h3>
						</div>
					</div>
					<div class="col-md-12"
						style="border: 1px solid lightgrey; text-align: left;">

						<table class="table table-hovered">
							<tr>
								<td style="width: 5px;">Event: </td>
								<td style="text-align: right;">${data_array.event_name}</td>
							</tr>
							<tr>
								<td style="width:5px;">Price: </td>
								<td style="text-align: right;">RWF ${data_array.ticket_price}</td>
							</tr>
							<tr>
								<td style="width: 5px;">Date: </td>
								<td style="text-align: right;">${data_array.event_date}</td>
							</tr>
							<tr>
								<td style="width: 5px;">Venue: </td>
								<td style="text-align: right;">${data_array.event_place}</td>
							</tr>
						</table>

					</div>

					<div class="col-md-12"
						style="border: 1px solid lightgrey; text-align: left; margin-top: 15%;">

						<h6>Payment Method</h6>

						<div class="form-group  form-group-default required">

							<div class="col-sm-12">

								<div class="col-lg-12 col-md-5 col-sm-12 col-xs-12 media-sform-img-box"
									style="padding: 0px; margin; 0px; text-align:left;">
									<input type="radio"
										class="vote011x550x11-payment-method"
										style="cursor: pointer;" checked name="pm"
										value="MOMO">
									<img src="${Init.IMAGE_PAYMENT_METHOD_MTN_MOMO}"
										class="media-sform-img-1" style="width: 30%;"
										alt="">
									<img src="${Init.IMAGE_PAYMENT_METHOD_AIRTEL_MOMO}"
										class="media-sform-img-2" style="width: 35%;"
										alt="">
								</div>

								<!-- <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6"
									style="padding: 0px; margin; 0px; text-align:left;">
									<input type="radio"
										class="vote011x550x11-payment-method"
										style="cursor: pointer;" name="pm" value="BANK">
									<img src="${Init.IMAGE_PAYMENT_METHOD_MASTERCARD}"
										class="media-sform-img-3" style="width: 40%;"
										alt="">
									<img src="${Init.IMAGE_PAYMENT_METHOD_VISA}"
										class="media-sform-img-4" style="width: 40%;"
										alt="">
								</div> -->

							</div>
						</div>
						<div class="form-group  form-group-default required">
							<label>Enter MoMo Telephone Number</label>
							<input type="text" class="form-control vw-pay-msisdn"
								placeholder="ex: 2507" value="250784700764" required>
							<input type="hidden" class="form-control vw-pay-token"
								placeholder="ex: " value="${data_array.ticket_token}" required>
						</div>

					</div>
					<div class="col-md-12">

					</div>
					<div class="col-md-12">

					</div>
					<br>
					<button aria-label="" type="submit"
						class="btn btn-primary btn-block btn-cons btn-animated from-left">
						<span style="padding-top: px;">PAY NOW</span>
						<span class="hidden-block">
							<i class="pg-icon">send</i>
						</span>
					</button>
					<button aria-label="" type="reset"
						class="btn btn-default btn-block"
						data-dismiss="modal">CANCEL
					</button>

				</form>
			</div>

		`;
		return output;
	}

	vw_modal_sample(){
		let output = `
			<div class="row">
				<form class="" role="form">
					<div class="col-md-12 text-center">
						<div class="media-29101" style="width: auto;">
							<a href="#" data-target="#modalSlideLeft"
								data-toggle="modal" id="btnFillSizeToggler">
								<img src="<?=DNADMIN?>/build/assets/img/home/vw_airtime_mtn.png"
									style="width: 150px;" alt="Image" class="img-fluid">
							</a>
							<h3>
								<a href="#" data-target="#modalSlideLeft"
									data-toggle="modal" id="btnFillSizeToggler">
									Buy MTN Airtime
								</a>
							</h3>
						</div>
					</div>
					<div class="col-md-12"
						style="border: 1px solid lightgrey; text-align: left;">

						<h6>Beneficiary</h6>

						<div class="form-group  form-group-default required">
							<label>Enter MTN Telephone Number</label>
							<input type="email" class="form-control"
								placeholder="ex: +2507" required>
						</div>
						<div class="form-group  form-group-default required">
							<label>Enter Amount (RWF)</label>
							<input type="email" class="form-control"
								placeholder="ex: 100" required>
						</div>

					</div>

					<div class="col-md-12"
						style="border: 1px solid lightgrey; text-align: left; margin-top: 25%;">

						<h6>Payment Method</h6>

						<div class="form-group  form-group-default required">

							<div class="col-sm-12">

								<div class="col-lg-12 col-md-5 col-sm-12 col-xs-12 media-sform-img-box"
									style="padding: 0px; margin; 0px; text-align:left;">
									<input type="radio"
										class="vote011x550x11-payment-method"
										style="cursor: pointer;" checked name="pm"
										value="MOMO">
									<img src="<?=DNADMIN.'/build/assets/img/home/mtnmomo.jpg'?>"
										class="media-sform-img-1" style="width: 30%;"
										alt="">
									<img src="<?=DNADMIN.'/build/assets/img/home/airtelmomo.png'?>"
										class="media-sform-img-2" style="width: 35%;"
										alt="">
								</div>

								<!-- <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6"
									style="padding: 0px; margin; 0px; text-align:left;">
									<input type="radio"
										class="vote011x550x11-payment-method"
										style="cursor: pointer;" name="pm" value="BANK">
									<img src="<?=DNADMIN.'/build/img/home/mastercard.png'?>"
										class="media-sform-img-3" style="width: 40%;"
										alt="">
									<img src="<?=DNADMIN.'/build/img/home/visa.png'?>"
										class="media-sform-img-4" style="width: 40%;"
										alt="">
								</div> -->

							</div>
						</div>
						<div class="form-group  form-group-default required">
							<label>Enter MoMo Telephone Number</label>
							<input type="email" class="form-control"
								placeholder="ex: +2507" required>
						</div>

					</div>
					<div class="col-md-12">

					</div>
					<div class="col-md-12">

					</div>
					<br>
					<button aria-label="" type="submit"
						class="btn btn-primary btn-block btn-cons btn-animated from-left"
						data-dismiss="modal">
						<!-- Pay Now -->
						<span style="padding-top: 7px;">PAY NOW</span>
						<span class="hidden-block">
							<i class="pg-icon">send</i>
						</span>
					</button>
					<button aria-label="" type="button"
						class="btn btn-default btn-block"
						data-dismiss="modal">CANCEL</button>

				</form>
			</div>
		`;
		return output;
	}

}