import { CNSEXPRESSVIEWSMASTERVIEWS } from '../../../../core/jscore/views/CNSEXPRESSVIEWSMASTERVIEWS.js';
import { CNSEXPRESSVIEWSMASTERFORM } from '../../../../core/jscore/views/CNSEXPRESSVIEWSMASTERFORM.js';
import * as wizard from '../../../../build/build/assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js';


let CNSXPRESSMS = new CNSEXPRESSVIEWSMASTERVIEWS("");

let CNSXPRESSMSFORM = new CNSEXPRESSVIEWSMASTERFORM("");

CNSXPRESSMS.cns_view_section_source_country('#source-country');

CNSXPRESSMS.cns_view_section_destination_country('#destination-country');

CNSXPRESSMS.cns_view_section_ship_purpose('#ship-purpose');

CNSXPRESSMS.cns_view_section_ship_item_type('.ship-item-type');

CNSXPRESSMS.cns_view_section_ship_item_currency('#ship-item-currency-1');

CNSXPRESSMS.cns_view_section_ship_item_unit('#ship-item-unit-1');

CNSXPRESSMS.cns_view_section_ship_pickup_type_source('.ship-pickup-type-source');

CNSXPRESSMS.cns_view_section_ship_pickup_type_destination('.ship-pickup-type-destination');

$('#source-country').on('change', function () {
  let token = $(this).val();
  CNSXPRESSMS.cns_view_section_source_province('#source-province', token);
});

$('#destination-country').on('change', function () {
  let token = $(this).val();
  CNSXPRESSMS.cns_view_section_destination_province('#destination-province', token);
});

$('#source-province').on('change', function () {
  let token = $(this).val();
  CNSXPRESSMS.cns_view_section_source_city('#source-city', token);
});

$('#destination-province').on('change', function () {
  let token = $(this).val();
  CNSXPRESSMS.cns_view_section_destination_city('#destination-city', token);
});


$('.SUBMITACTION').on('click', function () {
  CNSXPRESSMSFORM.cns_express_submit_ship("#SUBMITCREATIONFORM");
});






$(document).on('click', '#checkAll', function () {
  $(".itemRow").prop("checked", this.checked);
});
$(document).on('click', '.itemRow', function () {
  if ($('.itemRow:checked').length == $('.itemRow').length) {
    $('#checkAll').prop('checked', true);
  } else {
    $('#checkAll').prop('checked', false);
  }
});





var count = $(".itemRow").length;
$(document).on('click', '#addRows', function () {

  count++;
  var htmlRows = '';

  htmlRows += `

                                <tr>
                                  <td class="item-check-box">
                                    <input class="itemRow" type="checkbox">
                                  </td>
                                  <td>
                                    <div class="bg-grey pr-3 pl-3 pt-3">
                                      <div class="row clearfix">
                                       
                                        <div class="col-sm-3">
                                          <div class="form-group form-group-default required">
                                            <label>Item Name</label>
                                            <input type="text" name="ship-item-name" id="ship-item-name-${count}" placeholder="Item Name"
                                              required class="form-control" autocomplete="off">
                                          </div>
                                        </div>
                                        <div class="col-sm-3">
                                          <div class="form-group form-group-default required">
                                            <label>Quantity</label>
                                            <input type="text" name="ship-item-quantity" id="ship-item-quantity-${count}" placeholder="Quantity"
                                              required class="form-control" autocomplete="off">
                                          </div>
                                        </div>
                                        <div class="col-sm-3">
                                          <div class="form-group form-group-default required">
                                            <label>Item Unit</label>
                                            <select type="text" name="ship-item" id="ship-item-unit-${count}"
                                              class="form-control fancified ship-item-unit" required>
                                              <option value="">Select</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-sm-3">
                                          <div class="form-group form-group-default required">
                                            <label>Item Value</label>
                                            <input type="number" name="ship-item-price" id="ship-item-price-${count}" placeholder="Item value"
                                              required class="form-control" autocomplete="off">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row clearfix">
                                        <div class="col-sm-3">
                                          <div class="form-group form-group-default required">
                                            <label>Value Currency</label>
                                            <select id="ship-item-currency-${count}" name="ship-item-currency" required
                                              class="form-control fancified">
                                              <option value="">Currency</option>

                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-sm-3">
                                          <div class="form-group form-group-default required">
                                            <label>Item Weight(KG)</label>
                                            <input type="number" name="ship-item-weight" id="ship-item-weight-${count}" placeholder="Weight(Kg)"
                                              required class="form-control quantity" autocomplete="off">
                                          </div>
                                        </div>
                                        <div class="col-sm-3">
                                          <div class="form-group form-group-default required">
                                            <label>Item dimension</label>
                                            <input type="text" name="ship-item-dimension" id="ship-item-dimension-${count}"
                                              placeholder="Ex: 100x100(cm)" required class="form-control quantity"
                                              autocomplete="off">
                                          </div>
                                        </div>
                                        <div class="col-sm-3">
                                          <div class="form-group form-group-default required">
                                            <label>Item Description</label>
                                            <textarea type="text" id="ship-item-description-${count}" name="ship-item-description" required class="form-control"
                                              data-rule="required"
                                              placeholder="Item Description(In english)"></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </td>

                                </tr>
`;



  $('#invoiceItemP').append(htmlRows);

  CNSXPRESSMS.cns_view_section_ship_item_currency('#ship-item-currency-' + count);

  CNSXPRESSMS.cns_view_section_ship_item_unit('#ship-item-unit-' + count);

  $("[id^='stock-quantity']").on('input', function () {
    calculateTotal();
  });

  $("[id^='stock-purchase_unit_price']").on('input', function () {
    calculateTotal();
  });

  $("[id^='stock-product']").on('input', function () {
    calculateTotal();
  });

});
$(document).on('click', '#removeRows', function () {
  $(".itemRow:checked").each(function () {
    $(this).closest('tr').remove();
  });
  $('#checkAll').prop('checked', false);
  calculateTotal();
});
$(document).on('blur', "[id^=stock-quantity-]", function () {
  calculateTotal();
});
$(document).on('blur', "[id^=stock-purchase_unit_price-]", function () {
  calculateTotal();
});
$(document).on('blur', "#taxRate", function () {
  calculateTotal();
});
$(document).on('blur', "#amountPaid", function () {
  var amountPaid = $(this).val();
  var totalAftertax = $('#totalAftertax').val();
  if (amountPaid && totalAftertax) {
    totalAftertax = totalAftertax - amountPaid;
    $('#amountDue').val(totalAftertax);
  } else {
    $('#amountDue').val(totalAftertax);
  }
});
$(document).on('click', '.deleteInvoice', function () {
  var id = $(this).attr("id");
  if (confirm("Are you sure you want to remove this?")) {
    $.ajax({
      url: "action.php",
      method: "POST",
      dataType: "json",
      data: { id: id, action: 'delete_invoice' },
      success: function (response) {
        if (response.status == 200) {
          $('#' + id).closest("tr").remove();
        }
      }
    });
  } else {
    return false;
  }
});

$("[id^='stock-quantity']").on('input', function () {
  calculateTotal();
});

$("[id^='stock-purchase_unit_price']").on('input', function () {
  calculateTotal();
});


function calculateTotal() {
  var totalAmount = 0;
  $("[id^='stock-purchase_unit_price-']").each(function () {
    var id = $(this).attr('id');
    id = id.replace("stock-purchase_unit_price-", '');
    var price = $('#stock-purchase_unit_price-' + id).val();
    var quantity = $('#stock-quantity-' + id).val();
    if (!quantity) {
      quantity = 1;
    }

    if ($('#stock-product-' + id).val() != 0) {
      var total = price * quantity;
      totalAmount += total;
    }
    $('#stock-purchase_total_price-' + id).val(parseFloat(total));

  });
  $('#subTotal').html(parseFloat(totalAmount));
  $('#generalTotal').html(parseFloat(totalAmount));
  // var taxRate = $("#taxRate").val();
  // var subTotal = $('#subTotal').val();	
  // if(subTotal) {
  // 	var taxAmount = subTotal*taxRate/100;
  // 	$('#taxAmount').val(taxAmount);
  // 	subTotal = parseFloat(subTotal)+parseFloat(taxAmount);
  // 	$('#totalAftertax').val(subTotal);		
  // 	var amountPaid = $('#amountPaid').val();
  // 	var totalAftertax = $('#totalAftertax').val();	
  // 	if(amountPaid && totalAftertax) {
  // 		totalAftertax = totalAftertax-amountPaid;			
  // 		$('#amountDue').val(totalAftertax);
  // 	} else {		
  // 		$('#amountDue').val(subTotal);
  // 	}
  // }
}






























