import * as Init from '../../../../core/corejs/init.js';
const hostname = Init.CTRLUP;

if($('.smart-data-table').length)
  showDataTable();

if($('.registration-form-update').length){
  let _id_ = $('#_id_').val();
  getDataByID(_id_);
}

if($('.registration-form').length){
  $('.summernote').summernote();
}

function showDataTable() {
  loadData();
}

function loadData() {
  var form_data = $('#filterForm').serialize();
  $.ajax({
    url: hostname,
    type: "POST",
    cache: false,
    data: form_data,
    success: function (dataResponse) {
      var response = JSON.parse(dataResponse);
      var row_tr_table = '';
      row_tr_table = row_tr_table + 
            `<table id="smartTable" class="table table-bordered table-striped table-hover table-responsive-sm">
              <thead>
                  <tr>
                      <th>No.</th>
                      <th>Product Name</th>
                      <th>Price</th>
                      <th>Image</th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>`;

      if (response.status == 1) {

        var index, len, list;
        var count = 0;

        var listItems   = (response.data);
        for ( index = 0, len = listItems.length; index < len; index++ ) {
            list = $(listItems[index]);
            count++;

            var token_auth = list[0]['token_auth'];
            var token_id   = list[0]['token_id'];
            var names  = list[0]['name'];
            var status = list[0]['status'];
            var price  = list[0]['price'];
            var currency = list[0]['currency'];
            var image  = list[0]['image'];

            row_tr_table = row_tr_table +
                  `<tr>
                    <td> ${count} </td>
                    <td> ${names} </td>
                    <td> ${price}  ${currency} </td>
                    <td> ${image} </td>
                    <td> ${status} </td>
                    <td>
                          <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle">More </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item activateModal" data-id="${token_auth}" data-name="${names}"  data-toggle="modal"  > <i class="fa fa-check"></i> Activate</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item deactivateModal" data-id="${token_auth}" data-name="${names}"  data-toggle="modal"  href="#"> <i class="fa fa-remove"></i> Deactivate</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="${Init.DN}product/edit/${token_id}"> <i class="fa fa-pencil"></i> Edit </a></li>
                            </ul>
                          </div>
                    </td>
                  </tr>`                   
            ;
        }
      }
      else{

      }
        row_tr_table = row_tr_table + 
            '</tbody>'+
          '</table>'
        ;  

        $('.smart-data-table').html(row_tr_table);

        $('#smartTable').DataTable({});

        $('.activateModal').on('click', function(){
          var paramID   = $(this).attr('data-id');
          var paramName = $(this).attr('data-name');
          smartModalPopUp('activateModal', paramID, paramName);
        });
          
        $('.deactivateModal').on('click', function(){
          var paramID   = $(this).attr('data-id');
          var paramName = $(this).attr('data-name');
          smartModalPopUp('deactivateModal', paramID, paramName);
        });
          
        $('.resetPasswordModal').on('click', function(){
          var paramID   = $(this).attr('data-id');
          var paramName = $(this).attr('data-name');
          smartModalPopUp('resetPasswordModal', paramID, paramName);
        });
    }
  });
}

function getDataByID(_id_) {
  var form_data = $('#filterForm').serialize();
  $.ajax({
    url: hostname,
    type: "POST",
    cache: false,
    data: form_data,
    success: function (dataResponse) {
      // $('.smart-data-table').html(dataResponse);

      var response = JSON.parse(dataResponse);
      if (response.status == 1) {

        $('#product-name').val(response.data.name);
        $('#product-image').val(response.data.image);
        $('#product-price').val(response.data.price);
        $('#product-currency').val(response.data.currency);

      }
      else{

      }
    }
  });
}


function smartModalPopUp(paramType, paramID, paramName){
  var request    = '';
  var webToken   = '';

  var requestType   = '';
  var modalTitle    = '';
  var modalContent  = '';

  var btnAction = '';
  
  if(paramType == 'activateModal'){
    requestType   = 'admin-activate';
    modalTitle    = 'Activation ICCN Partner';
    modalContent  = '<span class="text-center">Do you really want to activate this product '+ paramName +' ?</span>';

    request = 'h4mjdHjuCoU1Z0Wi/WN4b/kQFHqzR9u/3GMJwVqcsNk';
    webToken= 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Activate Partner';
  }

  if(paramType == 'deactivateModal'){
    requestType   = 'admin-deactivate';
    modalTitle    = 'Deactivation ICCN Partner';
    modalContent  = '<span class="text-center">Do you really want to deactivate this product '+ paramName +' ?</span>';

    request = 'h4mjdHjuCoU1Z0Wi/WN4bwP/CF2xi7flbQTF4zDy+kQ';
    webToken= 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Deactivate Partner'; 
  }

  $('#smartModal .action-form #token').val(paramID);
  $('#smartModal .action-form #request').val(request);
  $('#smartModal .action-form #webToken').val(webToken);
  $('#smartModal .action-form .btn-action').html(btnAction);

  $('#smartModal .modal-title').html(modalTitle);
  $('#smartModal .modal-body').html(modalContent);

  $('.'+paramType).attr('data-target', '#smartModal');
}

$('#filterForm').submit(function () {
  showDataTable();
  return false;
});

$('#SubmitRegisterForm').on('submit', function () {
    var this_form = $(this);
    var form_data = $(this).serialize();

    var description = $('.summernote').summernote('code');
    form_data = form_data + "&partner-description="+description;

    $.ajax({
        url: hostname,
        type: "POST",
        data: form_data,
        cache: false,
        success: function (dataResponse) {
        
          var response = JSON.parse(dataResponse);
          if (response.status == 1) {

            $("#SubmitRegisterButton").button('reset');
            $("#SubmitRegisterForm")[0].reset();
            $('form.SubmitRegisterForm select').trigger("change");
            $('.summernote').html('Description...').summernote();

            setTimeout(function () {
                toastr.options = {
                    "positionClass": "toast-top-right",
                    "closeButton": true,
                    "progressBar": true,
                    "showEasing": "swing",
                    "timeOut": "6000"
                };
                toastr.success(response.message);
            }, 50);

          }
          else {
            setTimeout(function () {
                toastr.options = {
                    "positionClass": "toast-top-right",
                    "closeButton": true,
                    "progressBar": true,
                    "showEasing": "swing",
                    "timeOut": "6000"
                };
                toastr.warning(response.message);
            }, 50);
          }
        }
    });
    return false;
});

$('#ActionForm').on('submit', function () {
    var this_form = $(this);
    var form_data = $(this).serialize();

    var description = $('.summernote').summernote('code');
    form_data = form_data + "&partner-description="+description;

    $.ajax({
        url: hostname,
        type: "POST",
        data: form_data,
        cache: false,
        success: function (dataResponse) {
          var response = JSON.parse(dataResponse);
          if (response.status == 1) {
            showDataTable();
            setTimeout(function () {
                toastr.options = {
                    "positionClass": "toast-top-right",
                    "closeButton": true,
                    "progressBar": true,
                    "showEasing": "swing",
                    "timeOut": "6000"
                };
                toastr.success(response.message);
            }, 50);
            $('#smartModal .action-form .btn-close').click();
          }
          else {
            setTimeout(function () {
                toastr.options = {
                    "positionClass": "toast-top-right",
                    "closeButton": true,
                    "progressBar": true,
                    "showEasing": "swing",
                    "timeOut": "6000"
                };
                toastr.warning(response.message);
            }, 50);
          }
        }
    });
    return false;
});