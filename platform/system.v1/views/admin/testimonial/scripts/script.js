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
                      <th>Client </th>
                      <th>Profession</th>
                      <th>Testimonial</th>
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
            var profession  = list[0]['profession'];
            var description  = list[0]['description'];

            row_tr_table = row_tr_table +
                  `<tr>
                    <td> ${count} </td>
                    <td> ${names} </td>
                    <td> ${profession} </td>
                    <td> ${description} </td>
                    <td> ${status} </td>
                    <td>
                          <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle">More </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item activateModal" data-id="${token_auth}" data-name="${names}"  data-toggle="modal"  > <i class="fa fa-check"></i> Activate</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item deactivateModal" data-id="${token_auth}" data-name="${names}"  data-toggle="modal"  href="#"> <i class="fa fa-remove"></i> Deactivate</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="${Init.DN}testimonial/edit/${token_id}"> <i class="fa fa-pencil"></i> Edit </a></li>
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
        let company_logo  = Init.DN + 'build/images/' + response.data.logo;
        // $('.about-name').html( `<img src="${company_logo}" class="img-responsive company-image-style" style="width: 100%;"/>` );

        $('#testimonial-name').val(response.data.name);
        $('#testimonial-image').val(response.data.image);
        $('#testimonial-profession').val(response.data.profession);
        $('#testimonial-description').val(response.data.description);


        $('.summernote').html(response.data.description).summernote();
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
    modalTitle    = 'Activation ICCN Testimonial';
    modalContent  = '<span class="text-center">Do you really want to activate this testimonial '+ paramName +' ?</span>';

    request = 'iTg7w3kj+OddOiKFWIDOT2E5LGrKakQSziRnFP1+kFk';
    webToken= 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Activate Testimonial';
  }

  if(paramType == 'deactivateModal'){
    requestType   = 'admin-deactivate';
    modalTitle    = 'Deactivation ICCN Testimonial';
    modalContent  = '<span class="text-center">Do you really want to deactivate this testimonial '+ paramName +' ?</span>';

    request = 'iTg7w3kj+OddOiKFWIDOT07mJO3qlVUQ3qVH825uJiQ';
    webToken= 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Deactivate Testimonial'; 
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
    var this_form   = $(this);
    var description = $('.summernote').summernote('code');
    // var form_data = $(this).serialize();
    var form_data = new FormData(this);
    form_data.append('service-description', description);
    // form_data = form_data + "&service-description="+description;

    form_data
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
            $('.summernote').summernote('code', '<p><br></p>');

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
    form_data = form_data + "&service-description="+description;

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