
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

if (IOS.exists('.smart-data-info-edit'))
cns_get_data_edit();


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
          <th>Description</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
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
                <td>${data.name}</td>
                <td>${data.description}</td>

                <td> <span class="badge badge-pill badge-${Function.badge_status_bg(data.status)}"> ${data.status} </span> </td>

                <td>
                  <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle">More </button>
                    <ul class="dropdown-menu">

                      <li><a href="javascript:void(0);" title="Activate" class="dropdown-item activateModal" data-toggle="modal" data-id="${data.token_auth}" data-name="${names}"> <i class="fa fa-check"></i> Acivate </a></li>
                      <li><a href="javascript:void(0);" title="Deactivate" class="dropdown-item deactivateModal" data-toggle="modal" data-id="${data.token_auth}" data-name="${names}"> <i class="fa fa-close"></i> Deactivate </a></li>
                      <li><a href="javascript:void(0);" title="Delete" class="dropdown-item deleteModal" data-toggle="modal" data-id="${data.token_auth}" data-name="${names}"> <i class="fa fa-trash"></i> Delete </a></li>                      
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

  if (response.status == 200) {

    let data = response.data;

    IOS.puthtml(".company_name", data.company_name);
    IOS.puthtml(".company_email", data.company_email);
    IOS.puthtml(".company_telephone", data.company_telephone);
    IOS.puthtml(".company_address", data.company_address);
    IOS.puthtml(".facebook_link", data.facebook_link);
    IOS.puthtml(".instagram_link", data.instagram_link);
    IOS.puthtml(".tweeter_link", data.tweeter_link);
    IOS.puthtml(".youtube_link", data.youtube_link);

    IOS.puthtml(".company_about", data.about);
    IOS.puthtml(".company_mission", data.mission);
    IOS.puthtml(".company_vision", data.vision);
    IOS.puthtml(".company_value", data.value);
    IOS.puthtml(".company_terms", data.terms);

    $('.pmd-textfield').removeClass('pmd-textfield-floating-label');
  } else {
    RedirectURL.to(Init.DNWEB + "about/view/");
  }
}


function cns_get_data_edit() {
  let APIBODY = IOS.serializeForm($("#FILTERFORM"));
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);

  if (response.status == 200) {

    let data = response.data;

    IOS.putvl(".company_name", data.company_name);
    IOS.putvl(".company_email", data.company_email);
    IOS.putvl(".company_telephone", data.company_telephone);
    IOS.putvl(".company_address", data.company_address);
    IOS.putvl(".facebook_link", data.facebook_link);
    IOS.putvl(".instagram_link", data.instagram_link);
    IOS.putvl(".tweeter_link", data.tweeter_link);
    IOS.putvl(".youtube_link", data.youtube_link);

    IOS.putvl(".company_about", data.about);
    IOS.putvl(".company_mission", data.mission);
    IOS.putvl(".company_vision", data.vision);
    IOS.putvl(".company_value", data.value);
    IOS.putvl(".company_terms", data.terms);

    $('.pmd-textfield').removeClass('pmd-textfield-floating-label');
  } else {
    RedirectURL.to(Init.DNWEB + "about/view/");
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
    modalTitle = 'about of the company Activation';
    modalContent = '<span class="text-center">Do you really want to activate this about of the company ' + paramName + ' ?</span>';

    request = '7nr0EojM+V9sn0MvPty591TO5HaA7Y6qJTCTGbKjPAFTRXx0rMooBNNVD+jWXdai';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Activate about of the company';
    status = "ACTIVE";
  }

  if (paramType == 'deactivateModal') {
    requestType = 'admin-deactivate';
    modalTitle = 'about of the company Deactivation';
    modalContent = '<span class="text-center">Do you really want to deactivate this about of the company ' + paramName + ' ?</span>';

    request = '7nr0EojM+V9sn0MvPty596Lcut4pIE5k0rjYeXyhPVdfN7okAr+YPaN3lrhGUbJk';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Deactivate about of the company';
    status = "DEACTIVATION";
  }

  if (paramType == 'deleteModal') {
    requestType = 'admin-deactivate';
    modalTitle = 'Delete Package Type';
    modalContent = '<span class="text-center">Do you really want to delete this about of the company ' + paramName + ' ?</span>';

    request = 'alNMm410CGavGIzUbnlobzEtz8072p/IzzeG7VjjAXM';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';

    btnAction = 'Delete about of the company';
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
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
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

