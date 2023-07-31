
import * as Init from "../../../../core/jscore/init.js";
import { HttpRequest } from '../../../../core/jscore/classes/HttpRequest.js';
import { Hash } from '../../../../core/jscore/classes/Hash.js';
import { Redirect } from '../../../../core/jscore/classes/Redirect.js';
import { IONotification } from '../../../../core/jscore/classes/IONotification.js';
import { IOSystem } from '../../../../core/jscore/classes/IOSystem.js';
import { Functions } from '../../../../core/jscore/classes/Functions.js';

import { Access } from '../../../../core/jscore/classes/Access.js';
let HASH = new Hash();
//let ACCESS = new Access(HASH.decode( Init.ACCESS ));

let Function = new Functions();
let CORE = new HttpRequest();
let IOS = new IOSystem();
let RedirectURL = new Redirect();
let IONotif = new IONotification();
let AUTH = Init._AUTH_;
let APIHEADERS = { 'Authorization': AUTH };
let CNSIOSystem = new IOSystem();
const hostname = Init.API_USER;

console.log(APIHEADERS);

if (IOS.exists('.smart-data-table'))
  cns_get_list();

if (IOS.exists('.smart-data-info'))
  cns_get_data();



cns_submit_filter_form();
cns_submit_update_form();
cns_submit_creation_form();
cns_submit_action_form();

function cns_get_list() {
  let form_data = $('#FILTERFORM').serialize();
  let index;
  let row_tr_table = `
    <table class="table table-hover table-bordered table-responsive-sm" id="smartTable">
      <thead>
        <tr>
          <th>#</th>
            <th>Name</th>
            <th>Account Type</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Joining Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
      </thead>
    <tbody>
    `;

  let APIBODY = IOS.serializeForm($("#FILTERFORM"));
  let response = CORE.post(Init.API_USER, APIHEADERS, APIBODY);

  if (response.status === 200) {
    let count = 0;
    for (const index in response.data) {
      let data = response.data[index];
      let names = data.firstname + ' ' + data.lastname;
      let token = data.token_auth;
      count++;

      row_tr_table = row_tr_table +
        `
            <tr>
                <td>${count}</td>
                <td>${data.firstname + ' ' + data.lastname}</td>
                <td>${data.account_type}</td>
                <td>${data.email}</td>
                <td>${data.telephone}</td>
                <td>${data.join_date}</td>
                <td> <span class="badge badge-pill badge-${Function.badge_status_bg(data.status)}"> ${data.status} </span> </td>

                <td>
                  <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle">More </button>
                    <ul class="dropdown-menu">

                      <li><a href="${Init.DN}admin/edit/${data.token_id}" class="dropdown-item"> <i class="fa fa-pencil"></i> Edit </a></li>
                      <li><a href="javascript:void(0);" title="Activate" class="dropdown-item activateModal" data-toggle="modal" data-id="${data.token_auth}" data-name="${names}"> <i class="fa fa-check"></i> Acivate </a></li>
                      <li><a href="javascript:void(0);" title="Deactivate" class="dropdown-item deactivateModal" data-toggle="modal" data-id="${data.token_auth}" data-name="${names}"> <i class="fa fa-close"></i> Deactivate </a></li>
                      <li><a href="javascript:void(0);" title="Reset Password" class="dropdown-item resetPasswordModal" data-toggle="modal" data-id="${data.token_auth}" data-name="${names}"> <i class="fa fa-close"></i> Reset Password </a></li>
                    </ul>
                  </div>
                </td>

            </tr>`;
    }
  } else {
  }

  row_tr_table = row_tr_table +
    '</tbody>' +
    '</table>'
    ;

  $('.smart-data-table').html(row_tr_table);

  var dataTable = $('#smartTable').DataTable({
    "pageLength": 50
  });

  $('.smart-data-table tbody').on('click', '.activateModal', function () {
    var paramID = $(this).attr('data-id');
    var paramName = $(this).attr('data-name');
    smartModalPopUp('activateModal', paramID, paramName);
  });

  $('.smart-data-table tbody').on('click', '.deactivateModal', function () {
    var paramID = $(this).attr('data-id');
    var paramName = $(this).attr('data-name');
    smartModalPopUp('deactivateModal', paramID, paramName);
  });

  $('.smart-data-table tbody').on('click', '.resetPasswordModal', function () {
    var paramID = $(this).attr('data-id');
    var paramName = $(this).attr('data-name');
    smartModalPopUp('resetPasswordModal', paramID, paramName);
  });



  return false;
}

function cns_get_data() {
  let APIBODY = IOS.serializeForm($("#FILTERFORM"));
  let response = CORE.post(Init.API_USER, APIHEADERS, APIBODY);

  if (response.status === 200) {
    let data = response.data;
    IOS.putvl("#account-firstname", data.firstname);
    IOS.putvl("#account-lastname", data.lastname);
    IOS.putvl("#account-email", data.email);
    IOS.putvl("#account-telephone", data.telephone);
    $('.pmd-textfield').removeClass('pmd-textfield-floating-label');
  } else {
    RedirectURL.to(Init.DNWEB + "account/level/list");
  }
}

function smartModalPopUp(paramType, paramID, paramName) {
  let request = '';
  let webToken = '';

  let requestType = '';
  let modalTitle = '';
  let modalContent = '';
  let status = "";

  let btnAction = '';

  if (paramType == 'activateModal') {
    requestType = 'admin-activate';
    modalTitle = 'Activation Account';
    modalContent = '<span class="text-center">Do you really want to activate this Account ' + paramName + ' ?</span>';

    request = '1R50cZ7glnrp5f4gC8YXL6l8gd+7YS172LiOmNNwd3Y45fB1wVugFKMT/J0DzqrN';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Activate Account';
    status = "ACTIVE";
  }

  if (paramType == 'deactivateModal') {
    requestType = 'admin-deactivate';
    modalTitle = 'Deactivation Account';
    modalContent = '<span class="text-center">Do you really want to deactivate this Account ' + paramName + ' ?</span>';

    request = '1R50cZ7glnrp5f4gC8YXLx9yqPinwDTQhV+xcar3e3zh28s82bhPxYX/aYjxGhUr';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Deactivate Account';
    status = "Reset Password";
  }


  if (paramType == 'resetPasswordModal') {
    requestType = 'admin-deactivate';
    modalTitle = 'Reset Password';
    modalContent = '<span class="text-center">Do you really want to reset the password of this user ' + paramName + ' ?</span>';

    request = '1R50cZ7glnrp5f4gC8YXL2YpbWr5beOIQkekVucADp6wMwf0Tgx7ST5TOmw/H9Cy';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Reset Password';
    status = "DEACTIVE";
  }

  $('#smartModal .action-form #status').val(status);
  $('#smartModal .action-form #token').val(paramID);
  $('#smartModal .action-form #request').val(request);
  $('#smartModal .action-form #webToken').val(webToken);
  $('#smartModal .action-form .btn-action').html(btnAction);

  $('#smartModal .modal-title').html(modalTitle);
  $('#smartModal .modal-body').html(modalContent);

  $('.' + paramType).attr('data-target', '#smartModal');
}

function closeSmartModalPopUp() {
  $('#smartModal .action-form .btn-close').click();
}

function cns_submit_filter_form() {
  $('#FILTERFORM').on('submit', function () {
    cns_get_list();
    return false;
  });
  // return false;
}


function cns_submit_creation_form() {
  $('#SUBMITCREATIONFORM').on('submit', function () {
    let APIBODY = IOS.serializeForm($(this));
    let response = CORE.post(Init.API_USER, APIHEADERS, APIBODY);
    if (response.status == 200) {
      cleanFormData();
      IONotif.success(response.message);
    } else {
      IONotif.error(response.message);
    }
    return false;
  });
  return false;
}

function cns_submit_update_form() {
  $('#SUBMITUPDATEFORM').on('submit', function () {
    let APIBODY = IOS.serializeForm($(this));
    let response = CORE.post(Init.API_USER, APIHEADERS, APIBODY);
    if (response.status == 200) {
      IONotif.success(response.message);
    } else {
      IONotif.error(response.message);
    }
    return false;
  });
  return false;
}

function cns_submit_action_form() {
  $('#SUBMITACTIONFORM').on('submit', function () {
    let APIBODY = IOS.serializeForm($(this));
    let response = CORE.post(Init.API_USER, APIHEADERS, APIBODY);
    if (response.status == 200) {
      cns_get_list();
      closeSmartModalPopUp();
      IONotif.success(response.message);
    } else {
      IONotif.error(response.message);
    }
    return false;
  });
  return false;
}

function cleanFormData() {
  $("#SUBMITACTIONBUTTON").button('reset');
  $("#SUBMITCREATIONFORM")[0].reset();
  $('form.SUBMITCREATIONFORM select').trigger("change");
}

ac_get_optiosn_list_currency();

function ac_get_optiosn_list_currency(token = "") {
  let APIBODY = { 
    "request": "FY10nm+i292k7sb4MpCBi0BdJ3hpfUpLXqC0PsQRiss", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_USER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select</option>`;

  if (response.status === 200) {
    for (const index in response.data) {
      let data = response.data[index];
      row_tr_table = row_tr_table + `
          <option value="${data.token_auth}" ${token === data.token_auth ? "selected" : ""} >${data.name} </option>`;
    }
  }
  IOS.puthtml("#userType", row_tr_table);
}

