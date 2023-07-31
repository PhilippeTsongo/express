
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
const hostname = Init.API_CLUSTER;

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
            <th>Code</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Telephone</th>
            <th>Email</th>
            <th>Country</th>
        </tr>
      </thead>
    <tbody>
    `;

  let APIBODY = IOS.serializeForm($("#FILTERFORM"));
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);

  if (response.status === 200) {
    let count = 0;
    for (const index in response.data) {
      let data = response.data[index];
      let names = data.name;
      let token = data.token_auth;
      count++;

      row_tr_table = row_tr_table +
        `
            <tr>
                <td>${count}</td>
                <td>${data.firstname}</td>
                <td>${data.lastname}</td>
                <td>${data.telephone}</td>
                <td>${data.email}</td>
                <td>${data.country} - ${data.province} - ${data.city}</td>
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

  $('.smart-data-table tbody').on('click', '.deleteModal', function () {
    var paramID = $(this).attr('data-id');
    var paramName = $(this).attr('data-name');
    smartModalPopUp('deleteModal', paramID, paramName);
  });



  return false;
}

function cns_get_data() {
  let APIBODY = IOS.serializeForm($("#FILTERFORM"));
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);

  if (response.status === 200) {
    let data = response.data;
    IOS.putvl("#partner-name", data.name);
    IOS.putvl("#partner-website", data.website);
    IOS.putvl("#partner-email", data.email);
    IOS.putvl("#partner-address", data.address);
    IOS.putvl("#partner-telephone", data.telephone);
    $('.pmd-textfield').removeClass('pmd-textfield-floating-label');
  } else {
    RedirectURL.to(Init.DN + "partners/edit/0000");
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
    modalTitle = 'Partner Activation';
    modalContent = '<span class="text-center">Do you really want to activate this Partner ' + paramName + ' ?</span>';

    request = 'rwkf0YFC31FVSrOAwy7d+pbcwVuerFhl5jEuLas29qM';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Activate Partner';
    status = "ACTIVE";
  }

  if (paramType == 'deactivateModal') {
    requestType = 'admin-deactivate';
    modalTitle = 'Partner Deactivation';
    modalContent = '<span class="text-center">Do you really want to deactivate this Partner ' + paramName + ' ?</span>';

    request = 'rwkf0YFC31FVSrOAwy7d+uanC26GZE83bi37cDykkOk';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Deactivate Partner';
    status = "DEACTIVATE";
  }

  if (paramType == 'deleteModal') {
    requestType = 'admin-deactivate';
    modalTitle = 'Delete Partner';
    modalContent = '<span class="text-center">Do you really want to delete this Partner ' + paramName + ' ?</span>';

    request = 'rwkf0YFC31FVSrOAwy7d+tUPmek8pPhE5U3SAhtDG6M';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Delete Partner';
    status = "DELETE";
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
    let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
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
    let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
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
    let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
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

