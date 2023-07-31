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
                      <th>Image Url</th>
                      <th>Date Time</th>
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
            var names  = list[0]['image'];
            var status = list[0]['status'];
            var date_time  = list[0]['date_time'];

            row_tr_table = row_tr_table +
                  `<tr>
                    <td> ${count} </td>
                    <td> ${names} </td>
                    <td> ${date_time} </td>
                    <td> ${status} </td>
                    <td>
                          <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle">More </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item activateModal" data-id="${token_auth}" data-name="${names}"  data-toggle="modal"  > <i class="fa fa-check"></i> Activate</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item deactivateModal" data-id="${token_auth}" data-name="${names}"  data-toggle="modal"  href="#"> <i class="fa fa-remove"></i> Deactivate</a></li>
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
    modalTitle    = 'Activation ICCN Gallery';
    modalContent  = '<span class="text-center">Do you really want to activate this gallery '+ paramName +' ?</span>';

    request = 'wSuH/57y520OkRPT96Vu4bllW62ia3ZXVo0QigcJ+aQ';
    webToken= 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Activate Gallery';
  }

  if(paramType == 'deactivateModal'){
    requestType   = 'admin-deactivate';
    modalTitle    = 'Deactivation ICCN Gallery';
    modalContent  = '<span class="text-center">Do you really want to deactivate this gallery '+ paramName +' ?</span>';

    request = '6CTrLLbKCxCRzOp8ndLljgSUtPZJ7CfCeVsbFYZvsCc';
    webToken= 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Deactivate Gallery'; 
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
    form_data = form_data + "&service-description="+description;

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