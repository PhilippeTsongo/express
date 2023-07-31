hostname = $('.hostname').val();
showDataTable();



    $(document).ready(function () {
        $('.summernote').summernote();
    });

function showDataTable() {
  loadData();
  // setInterval(function () {
    loadData();
  // }, 2000);
}

function loadData() {
  var form_data = $('#filterForm').serialize();
  $.ajax({
    url: hostname,
    type: "POST",
    cache: false,
    data: form_data,
    success: function (dataResponse) {
      $('.smart-data-table').html(dataResponse);
    }
  });
}

function fetchAccountGroupsByType() {
  var webToken = $('#filterForm #webToken').val();
  var request = $('#filterForm #request-groups').val();
  var account_type = $('#filterForm #filter_account_type').val();

  $.ajax({
    url: hostname,
    type: "POST",
    data: {
      'webToken': webToken,
      'request': request,
      'filter_account_type': account_type,
    },
    success: function (dataResponse) {
      $('#field_account_group').html(dataResponse);
    }
  });
}

function smartModalPopUp(paramType, paramID, paramName){
  var request    = '';
  var webToken   = '';

  var requestType   = '';
  var modalTitle    = '';
  var modalContent  = '';

  btnAction = '';
  
  if(paramType == 'activateModal'){
    requestType   = 'admin-activate';
    modalTitle    = 'Activation Account Administrator';
    modalContent  = '<span class="text-center">Do you really want to activate this administrator '+ paramName +' ?</span>';

    request = 'e2osvszm6xzi/K80YEOTHg';
    webToken= 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Activate Admin Account';
  }

  if(paramType == 'deactivateModal'){
    requestType   = 'admin-deactivate';
    modalTitle    = 'Deactivation Account Administrator';
    modalContent  = '<span class="text-center">Do you really want to deactivate this administrator '+ paramName +' ?</span>';

    request = 'HpPrCvi4x5EIVjQfXxkmcYj8YBWK0gKLK9VIyMpME+c';
    webToken= 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Deactivate Admin Account'; 
  }

  if(paramType == 'resetPasswordModal'){
    requestType   = 'admin-reset-password';
    modalTitle    = 'Reset Account Administrator Password';
    modalContent  = '<span class="text-center">Do you really want to reset account password for '+ paramName +' ?</span>';

    request = '9tvxFQGjr40o1kGH4LVW8GpwAai7fe9BU99PkuVLjK0';
    webToken= 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Reset Admin Account Password'; 
  }

  $('#smartModal .action-form #token').val(paramID);
  $('#smartModal .action-form #request').val(request);
  $('#smartModal .action-form #webToken').val(webToken);
  $('#smartModal .action-form .btn-action').html(btnAction);

  $('#smartModal .modal-title').html(modalTitle);
  $('#smartModal .modal-body').html(modalContent);

  $('.'+paramType).attr('data-target', '#smartModal');
}

function fetchAccountEventsByType() {
  var webToken = $('#filterForm #webToken').val();
  var request = $('#filterForm #request-events').val();
  var account_type = $('#filterForm #filter_account_type').val();
  var account_group = $('#filterForm #filter_account_group').val();

  $.ajax({
    url: hostname,
    type: "POST",
    data: {
      'webToken': webToken,
      'request': request,
      'filter_account_type': account_type,
      'filter_account_group': account_type,
    },
    success: function (dataResponse) {
      $('#field_account_event').html(dataResponse);
    }
  });
}

$('#filterForm').submit(function () {
  showDataTable();
  return false;
});

$(function () {


  $('#SubmitRegisterForm').on('submit', function () {
    var this_form = $(this);
    var form_data = $(this).serialize();

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



});

