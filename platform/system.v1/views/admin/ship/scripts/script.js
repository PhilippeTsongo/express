
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
const hostname = Init.API_SHIP;

// console.log(APIHEADERS);

if (IOS.exists('.smart-data-table'))
  cns_get_list();

if (IOS.exists('.smart-data-info-edit'))
  cns_get_data_edit();

if (IOS.exists('.smart-data-info'))
  cns_get_data();

  
if (IOS.exists('.smart-data-table-items'))
cns_get_item_list();

cns_submit_filter_form();
cns_submit_update_form();
cns_submit_creation_form();
cns_submit_action_form();

//get ships list
function cns_get_list() {
  let form_data = $('#FILTERFORM').serialize();
  let index;
  let row_tr_table = `
    <table class="table table-hover table-bordered table-responsive-sm" id="smartTable">
      <thead>
        <tr>
            <th rowspan="2"> #</th>     
            <th rowspan="2" class="text-center"> Code</th>
            <th colspan="2" class="text-center">SOURCE</th>
            <th colspan="2" class="text-center">DESTINATION</th>
            <th rowspan="2" class="text-center"> Status</th>
            <th rowspan="2" class="text-center"> Action</th>
        </tr>
        <tr>
            <th class="text-center">Names</th>
            <th class="text-center">Address</th>
            <th class="text-center">Names</th>
            <th class="text-center">Address</th>
           
        </tr>
      </thead>
    <tbody>
    `;

  let APIBODY = IOS.serializeForm($("#FILTERFORM"));
  let response = CORE.post(Init.API_SHIP, APIHEADERS, APIBODY);

  if (response.status === 200) {

    let count = 0;
    for (const index in response.data) {
      let data = response.data[index];
      let names = data.ship_label;
      let token = data.token_auth;
      count++;

      row_tr_table = row_tr_table +
        `
            <tr>
                <td>${ count } </td>
                <td>${data.code}</td>
                <td>${data.source_firstname + ' - ' + data.source_lastname}</td>
                <td>${data.source_country + ' - ' + data.source_province + ' - ' + data.source_city}</td>

                <td>${data.destination_firstname + ' - ' + data.destination_lastname}</td>
                <td>${data.destination_country + ' - ' + data.destination_province + ' - ' + data.destination_city}</td>
                <td> <span class="badge badge-pill badge-${Function.badge_status_bg(data.status)}"> ${data.status} </span> </td>
                <td>
                  <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle">More </button>
                    <ul class="dropdown-menu">
                      <li><a href="${Init.DN}/ship/detail/${data.token_id}" class="dropdown-item"> <i class="fa fa-eye"></i> View detail </a></li>
                      <li><a href="${Init.DN}ship/edit/${data.token_id}" class="dropdown-item" title="Edit shipment"> <i class="far fa-edit"></i> Edit </a></li>
                    </ul>
                  </div>

                  <div class="btn-group m-t-sm">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle">change status </button>
                        <ul class="dropdown-menu">`;

                        if(data.status == 'INITIATED')
                        row_tr_table = row_tr_table +
                          `
                            <li><a href="javascript:void(0);" title="Approved" class="dropdown-item ApprovedModal" data-toggle="modal" data-stage="INITIATION" data-status="Approved" data-id="${data.token_auth}" data-name="${names}" > <i class="fa fa-check"></i> Approved </a></li>
                            <li><a href="javascript:void(0);" title="Rejected" class="dropdown-item RejectedModal" data-toggle="modal" data-stage="INITIATION" data-id="${data.token_auth}" data-status="Rejected" data-name="${names}"> <i class="fa fa-close"></i> Rejected </a></li>
                          `;

                          if(data.status == 'APPROVED')
                            row_tr_table = row_tr_table +
                            `
                              <li><a href="javascript:void(0);" title="At Source Airport" class="dropdown-item SourceAirportModal" data-toggle="modal" data-stage="SOURCE RECEPTION" data-id="${data.token_auth}" data-status="At Source Airport" data-name="${names}" > <i class="fa fa-close"></i>At Source Airport </a></li>
                              <li><a href="javascript:void(0);" title="Delayed At Source Airport" class="dropdown-item DelayedSoureAirportModal" data-toggle="modal" data-stage="SOURCE RECEPTION" data-id="${data.token_auth}" data-status="Delay At Source Airport" data-name="${names}" > <i class="fa fa-close"></i> Delayed At Source Airport </a></li>                            
                            `;  
                          
                          if(data.status == 'AT SOURCE AIRPORT' || data.status == 'DELAY AT SOURCE AIRPORT')
                            row_tr_table = row_tr_table +
                            `
                              <li><a href="javascript:void(0);" title="Air Plane Cancelled" class="dropdown-item AirPlaneCancelledModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="SOURCE RECEPTION" data-status="AirPlane Cancelled" data-name="${names}" > <i class="fa fa-close"></i> AirPlane Cancelled </a></li>
                              <li><a href="javascript:void(0);" title="Travelling" class="dropdown-item TravellingModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="TRAVELLING" data-status="Travelling" data-name="${names}" > <i class="fa fa-close"></i> Travelling </a></li>
                            `;

                          if(data.status == 'AIRPLANE CANCELLED')
                            row_tr_table = row_tr_table +
                            `
                              <li><a href="javascript:void(0);" title="Travelling" class="dropdown-item TravellingModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="TRAVELLING" data-status="Travelling" data-name="${names}" > <i class="fa fa-close"></i> Travelling </a></li>
                            `;

                          if(data.status == 'TRAVELLING')
                          row_tr_table = row_tr_table +
                          `
                            <li><a href="javascript:void(0);" title="Arrived at Destination Airport" class="dropdown-item ArrivedDestinationAirportModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="DESTINATION ARRIVAL" data-status="Arrived at Destination Airport" data-name="${names}" > <i class="fa fa-close"></i> Arrived at Destination Airport </a></li>
                          `; 
                          if(data.status == 'ARRIVED AT DESTINATION AIRPORT')
                            row_tr_table = row_tr_table +
                            `  
                              <li><a href="javascript:void(0);" title="Assigned" class="dropdown-item AssignedModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="DESTINATION ARRIVAL" data-status="Assigned" data-name="${names}" > <i class="fa fa-close"></i> Assigned To Delivery Agent</a></li>
                              <li><a href="javascript:void(0);" title="Delivery Rejected" class="dropdown-item DeliveryRejectedModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="DESTINATION ARRIVAL" data-status="Delivery Rejected" data-name="${names}" > <i class="fa fa-close"></i> Delivery Rejected </a></li>
                              <li><a href="javascript:void(0);" title="Delivery Cancelled" class="dropdown-item DeliveryCancelledModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="DESTINATION ARRIVAL" data-status="Delivery Cancelled" data-name="${names}" > <i class="fa fa-close"></i> Delivery Cancelled </a></li>
                              <li><a href="javascript:void(0);" title="Delivery Failure" class="dropdown-item DeliveryFailedModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="DESTINATION ARRIVAL" data-status="Delivery Failure" data-name="${names}" > <i class="fa fa-close"></i> Delivery Failure </a></li>
                            `;  
                          if(data.status == 'ASSIGNED TO THE DELIVERY AGENT')
                            row_tr_table = row_tr_table +
                            `
                              <li><a href="javascript:void(0);" title="Arrived" class="dropdown-item ArrivedModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="DESTINATION ARRIVAL" data-status="Arrived" data-name="${names}" > <i class="fa fa-close"></i> Arrived </a></li>
                            `;  
                          if(data.status == 'ARRIVED')
                            row_tr_table = row_tr_table +
                            `
                              <li><a href="javascript:void(0);" title="Delivered" class="dropdown-item DeliveryModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="DESTINATION ARRIVAL" data-status="Delivered" data-name="${names}" > <i class="fa fa-close"></i> Delivered </a></li>
                              <li><a href="javascript:void(0);" title="Completed" class="dropdown-item CompletedModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="DESTINATION ARRIVAL" data-status="Completed" data-name="${names}" > <i class="fa fa-close"></i> Completed </a></li>
                            `;
                            
                          if(data.status == 'DELIVERED')
                          row_tr_table = row_tr_table +
                          `
                            <li><a href="javascript:void(0);" title="Completed" class="dropdown-item CompletedModal" data-toggle="modal" data-id="${data.token_auth}" data-stage="DESTINATION ARRIVAL" data-status="Completed" data-name="${names}" > <i class="fa fa-close"></i> Completed </a></li>
                          `;   


                          if(data.status == 'REJECTED' || data.status == 'DELIVERY REJECTED' || data.status == 'DELIVERY CANCELLED' || data.status == 'DELIVERY FAILURE')
                            row_tr_table = row_tr_table +
                            `
                              <li><a href="javascript:void(0);" title="Initate" class="dropdown-item InitiatedModal" data-toggle="modal" data-stage="INITIATION" data-status="Initiated" data-id="${data.token_auth}" data-name="${names}" > <i class="fa fa-check"></i> Initiated </a></li>
                            `;
                          row_tr_table = row_tr_table +
                            `
                        </ul>
                    </div>
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

  // var dataTable = $('#smartTable').DataTable({
  //   "pageLength": 50
  // });

  $('.smart-data-table tbody').on('click', '.InitiatedModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('InitiatedModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.ApprovedModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');
    
    smartModalPopUp('ApprovedModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.RejectedModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('RejectedModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.SourceAirportModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('SourceAirportModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.DelayedSoureAirportModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('DelayedSoureAirportModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.AirPlaneCancelledModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');
    
    smartModalPopUp('AirPlaneCancelledModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.TravellingModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('TravellingModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.ArrivedDestinationAirportModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('ArrivedDestinationAirportModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.AssignedModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('AssignedModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.DeliveryRejectedModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('DeliveryRejectedModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.DeliveryCancelledModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('DeliveryCancelledModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.DeliveryFailedModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('DeliveryFailedModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.ArrivedModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('ArrivedModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.DeliveryModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('DeliveryModal', paramID, paramName, paramStatus, paramStage);
  });

  $('.smart-data-table tbody').on('click', '.CompletedModal', function () {
    var paramID = $(this).attr('data-id');
    var paramStatus = $(this).attr('data-status');
    var paramName = $(this).attr('data-name');
    var paramStage = $(this).attr('data-stage');

    smartModalPopUp('CompletedModal', paramID, paramName, paramStatus, paramStage);
  });


  return false;
}

//get ships items list
function cns_get_item_list() {
  let form_data = $('#FILTERFORM').serialize();
  let index;
  let row_tr_table = `
    <table class="table table-hover table-bordered table-responsive-sm" id="smartTable">
      <thead>
        <tr>
          <th>#</th>
          <th>Item Name</th>
          <th>Qunatity</th>
          <th>Item Unit</th>
          <th>Item Value</th>
          <th>Currency</th>
          <th>Item Weight(kg)</th>
          <th>Item Dimension(ex: 50cm x 10cm)</th>
          <th>Item Description</th>
        </tr>
      </thead>
    <tbody>
    `;

  let APIBODY = IOS.serializeForm($("#FILTERFORM"));
  let response = CORE.post(Init.API_SHIP, APIHEADERS, APIBODY);

  if (response.status === 200) {

    let count = 0;
    for (const index in response.data.items) {
      let data = response.data.items[index];
      let names = data.name;
      let token = data.token_auth;

      count++;

      row_tr_table = row_tr_table +
        `
          <tr>
            <td class="item-check-box">
            <input class="itemRow" type="checkbox">
            </td>
            <td>
              <input type="text" id="item_name" value="${names}" class="form-control" id="iship-item-name-1" name="ship-item-name">
            </td>
            <td>
              <input type="text" id="item_quantity" value="${data.quantity}" class="form-control" id="ship-item-quantity-1" name="ship-item-quantity">
            </td>
          
            <td>
              <select type="text" class="form-control" required id="hip-item-unit-1" name="hip-item-unit">
                <option value=""  >${data.unit}</option>
                `;

                  for (const index in response.data.units) {
                    let data = response.data.units[index];
                  
                    row_tr_table = row_tr_table +
                    `
                    <option value=""  >${data.name}</option>

                    ` 
                  };
                row_tr_table = row_tr_table +
                `  
              </select>
            </td>
         
            <td><input type="text" class="form-control" id="ship-item-price-1" name="ship-item-price" ></td>

            <td>
              <select type="text" class="form-control" required id="ship-item-currency-1" name="ship-item-currency">
                <option value="" disabled selected>${data.currency}</option>
                `;

                  for (const index in response.data.currency) {
                    let data = response.data.currency[index];
                  
                    row_tr_table = row_tr_table +
                    `
                    <option value=""  >${data.name}</option>

                    ` 
                  };
                row_tr_table = row_tr_table +
                `  
              </select>
            </td>

            <td><input type="text" class="form-control" id="ship-item-weight-1" name="ship-item-weight" ></td>

            <td><input type="text" class="form-control" id="ship-item-dimension-1" name="ship-item-dimension" ></td>

            <td><input type="text" class="form-control" id="item_description" name="item_description" ></td>
        
          </tr>`;
    }
  } else {
  }

  row_tr_table = row_tr_table +
    '</tbody>' +
    '</table>'
    ;

  $('.smart-data-table-items').html(row_tr_table);  

  return false;
}


function cns_get_data_edit() {
  let APIBODY = IOS.serializeForm($("#FILTERFORM"));
  let response = CORE.post(Init.API_SHIP, APIHEADERS, APIBODY);

  if (response.status === 200) {
    let data = response.data;
    IOS.puthtml('.code', data.code);

    //source information
    IOS.putvl('.source_firstname', data.source_firstname);
    IOS.putvl('.source_lastname', data.source_lastname);
    IOS.putvl('.source_email', data.source_email);
    IOS.putvl('.source_telephone', data.source_telephone);

    IOS.putvl('.source_country', data.source_country);
    IOS.putvl('.source_province', data.source_province);
    IOS.putvl('.source_city', data.source_city);
    IOS.putvl('.source_address_1', data.source_address_1);
    IOS.putvl('.source_address_2', data.source_address_2);
    IOS.putvl('.source_pickup_type', data.source_pickup_type);
    IOS.putvl('.source_pickup_location', data.source_pickup_location);
    IOS.putvl('.source_pickup_instruction', data.source_pickup_instruction);

    IOS.putvl('.source_company_name', data.source_company_name);

    //destination information
    IOS.putvl('.destination_firstname', data.destination_firstname);
    IOS.putvl('.destination_lastname', data.destination_lastname);
    IOS.putvl('.destination_email', data.destination_email);
    IOS.putvl('.destination_telephone', data.destination_telephone);

    IOS.putvl('.destination_country', data.destination_country);
    IOS.putvl('.destination_province', data.destination_province);
    IOS.putvl('.destination_city', data.destination_city);
    IOS.putvl('.destination_address_1', data.destination_address_1);
    IOS.putvl('.destination_address_2', data.destination_address_2);
    IOS.putvl('.destination_pickup_type', data.destination_pickup_type);
    IOS.putvl('.destination_pickup_location', data.destination_pickup_location);
    IOS.putvl('.destination_pickup_instruction', data.destination_pickup_instruction);

    IOS.putvl('.destination_company_name', data.destination_company_name);

    //ship information
    IOS.putvl('.ship_purpose', data.ship_purpose);
    IOS.putvl('.creation_date', data.creation_datetime);
    IOS.putvl('.ship_label', data.ship_label);
    IOS.putvl('.ship_item_type', data.ship_item_type);
    IOS.putvl('.ship_additional_detail', data.ship_additional_detail);
    IOS.putvl('.ship_description', data.ship_description);
    IOS.putvl('.ship_status', data.status);

    ship_status_list(data.status, data.status_stage_next);

    ac_get_optiosn_list_ship_purpose(data.ship_purpose);
    
    $('.pmd-textfield').removeClass('pmd-textfield-floating-label');
  } else {
    // RedirectURL.to(Init.DN);
  }
}


function cns_get_data() {
  let APIBODY = IOS.serializeForm($("#FILTERFORM"));
  let response = CORE.post(Init.API_SHIP, APIHEADERS, APIBODY);

  if (response.status === 200) {
    let data = response.data;
    IOS.puthtml('.code', data.code);

    //source information
    IOS.println('.source_firstname', data.source_firstname);
    IOS.println('.source_lastname', data.source_lastname);
    IOS.println('.source_email', data.source_email);
    IOS.println('.source_telephone', data.source_telephone);

    IOS.println('.source_country', data.source_country);
    IOS.println('.source_province', data.source_province);
    IOS.println('.source_city', data.source_city);
    IOS.println('.source_address_1', data.source_address_1);
    IOS.println('.source_address_2', data.source_address_2);
    IOS.println('.source_pickup_type', data.source_pickup_type);
    IOS.println('.source_pickup_location', data.source_pickup_location);
    IOS.println('.source_pickup_instruction', data.source_pickup_instruction);

    IOS.println('.source_company_name', data.source_company_name);

    //destination information
    IOS.println('.destination_firstname', data.destination_firstname);
    IOS.println('.destination_lastname', data.destination_lastname);
    IOS.println('.destination_email', data.destination_email);
    IOS.println('.destination_telephone', data.destination_telephone);

    IOS.println('.destination_country', data.destination_country);
    IOS.println('.destination_province', data.destination_province);
    IOS.println('.destination_city', data.destination_city);
    IOS.println('.destination_address_1', data.destination_address_1);
    IOS.println('.destination_address_2', data.destination_address_2);
    IOS.println('.destination_pickup_type', data.destination_pickup_type);
    IOS.println('.destination_pickup_location', data.destination_pickup_location);
    IOS.println('.destination_pickup_instruction', data.destination_pickup_instruction);

    IOS.println('.destination_company_name', data.destination_company_name);

    //ship information
    IOS.println('#ship_purpose', data.ship_purpose);
    IOS.println('.creation_date', data.creation_datetime);
    IOS.println('.ship_label', data.ship_label);
    IOS.println('.ship_item_type', data.ship_item_type);
    IOS.println('.ship_additional_detail', data.ship_additional_detail);
    IOS.println('.ship_description', data.ship_description);
    IOS.println('.ship_status', data.status);

    ship_status_list(data.status, data.status_stage_next);

    ac_get_optiosn_list_ship_purpose(data.ship_purpose);
    
    $('.pmd-textfield').removeClass('pmd-textfield-floating-label');
  } else {
    // RedirectURL.to(Init.DN);
  }
}

function smartModalPopUp(paramType, paramID, paramName, paramStatus, paramStage) {
  let request = '';
  let webToken = '';

  let requestType = '';
  let modalTitle = '';
  let modalContent = '';
  let status = '';
  let status_stage = '';
  let status_comment = '';

  let btnAction = '';


  
  //INITIATED
  if (paramType == 'InitiatedModal') {
    requestType = 'admin-activate';
    modalTitle = 'Approve Shipment';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Initiate Shipment';
    status = "INITIATED";
    status_stage = paramStage;
  }


  //APPROVE
  if (paramType == 'ApprovedModal') {
    requestType = 'admin-activate';
    modalTitle = 'Approve Shipment';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Approve Shipment';
    status = "APPROVED";
    status_stage = paramStage;

  }

  //REJECT
  if (paramType == 'RejectedModal') {
    requestType = 'admin-activate';
    modalTitle = 'Reject Shipment';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Reject Shipment';
    status = "REJECTED";
    status_stage = paramStage;

  }

  
  if (paramType == 'SourceAirportModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment At Source Airport';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Source Airport';
    status = "AT SOURCE AIRPORT";
    status_stage = paramStage;

  }

  if (paramType == 'DelayedSoureAirportModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Delay at Source Airport';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Delay At Source Airport';
    status = "DELAY AT SOURCE AIRPORT";
    status_stage = paramStage;

  }

  if (paramType == 'AirPlaneCancelledModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Airplane Cancelled';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Airplane Cancelled';
    status = "AIRPLANE CANCELLED";
    status_stage = paramStage;

  }

  if (paramType == 'TravellingModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Travelling';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Travelling';
    status = "TRAVELLING";
    status_stage = paramStage;

  }

  if (paramType == 'ArrivedDestinationAirportModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Arriveda At Destination Airport';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Arrived at Destination Airport';
    status = "ARRIVED AT DESTINATION AIRPORT";
    status_stage = paramStage;

  }

  if (paramType == 'AssignedModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Assigned to the Delivery Agent';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Assigned to the Delivery Agent';
    status = "ASSIGNED TO THE DELIVERY AGENT";
    status_stage = paramStage;

  }

  if (paramType == 'DeliveryRejectedModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Delivery Rejected';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Delivery Rejected';
    status = "DELIVERY REJECTED";
    status_stage = paramStage;

  }
  
  if (paramType == 'DeliveryCancelledModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Delivery Cancelled';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Delivery Cancelled';
    status = "DELIVERY CANCELLED";
    status_stage = paramStage;

  }

  if (paramType == 'DeliveryFailedModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Delivery Failed';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Delivery Failed';
    status = "DELIVERY FAILED";
    status_stage = paramStage;

  }

  if (paramType == 'ArrivedModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Arrived';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Shipment Arrived';
    status = "ARRIVED";
    status_stage = paramStage;

  }

  if (paramType == 'DeliveryModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Delivered';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Shipment Delivered';
    status = "DELIVERED";
    status_stage = paramStage;

  }

  if (paramType == 'CompletedModal') {
    requestType = 'admin-activate';
    modalTitle = 'Shipment Completed';
    modalContent = '<span class="text-center">Do you really want to change the status of the shipment: ' + paramName + ' to ' +  paramStatus + ' ?</span>';

    request = 'hWdzbgvdAV5KQpOGLVZSHt2J8dk655dtd+kUD5/Scjo';
    webToken = 'FZrp/HEwJwWCrAH303ypUQ';
    btnAction = 'Shipment Completed';
    status = "COMPLETED";
    status_stage = paramStage;

  }

  $('#smartModal .action-form #status').val(status);
  $('#smartModal .action-form #status-stage').val(status_stage);
  $('#smartModal .action-form #status-comment').val(status_comment);

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
    let response = CORE.post(Init.API_SHIP, APIHEADERS, APIBODY);

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
    let response = CORE.post(Init.API_SHIP, APIHEADERS, APIBODY);

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
    let response = CORE.post(Init.API_SHIP, APIHEADERS, APIBODY);
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


trigger_options();

//function trigger for both source and destination provinces and cities 
function trigger_options(){

  // Source province and source city
  //source province 
  $('#source_country').on('change', function () {
    let token = $(this).val();
    ac_get_optiosn_list_source_province('#source_province', token);
  });

  //source city 
  $('#source_province').on('change', function () {
    let token = $(this).val();
    ac_get_optiosn_list_source_city('#source_city', token);
  });


  //Destination province and city

  //destination province 
  $('#destination_country').on('change', function () {
    let token = $(this).val();
    ac_get_optiosn_list_destination_province('#destination_province', token);
  });

  //destination city 
  $('#destination_province').on('change', function () {
    let token = $(this).val();
    ac_get_optiosn_list_destination_city('#destination_city', token);
  });
}


//source country
ac_get_optiosn_list_source_country();

function ac_get_optiosn_list_source_country(token = "") {
  let APIBODY = { 
    "request": "UrhwOELH0XcVWc7qx0UBzjj6wJSQ+uoD2nmCikrOmSpLMksLsUKvA6f7ysyna9yV", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select the source country</option>`;

  if (response.status === 200) {
    for (const index in response.data) {
      let data = response.data[index];
      row_tr_table = row_tr_table + `
          <option value="${data.token_auth}" ${token === data.token_auth ? "selected" : ""} >${data.name} </option>`;
    }
  }
  IOS.puthtml("#source_country", row_tr_table);
}

//source province
function ac_get_optiosn_list_source_province(el_key, ctacountry) {
  let APIBODY = { 
    "request": "luKY70JDiexGQq5ZPCJF1w5NFiLO6sEBCWU/UOd1joR/qm7bHRsQWR4rQNTYxHEU", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select the source province</option>`;

  if (response.status === 200) {
    for (const index in response.data.province) {
      let data = response.data.province[index];
      if(data.ctacountry == ctacountry){
        row_tr_table = row_tr_table + `
            <option value="${data.ctaprovince}" >${data.name} </option>`;
      }
    }
  }
  $(el_key).html(row_tr_table);
  // IOS.puthtml(el_key, row_tr_table);
}

//source city
function ac_get_optiosn_list_source_city(el_key, ctaprovince) {
  let APIBODY = { 
    "request": "T1SnAtAMZSlWWv8xs+piyBIMbq5nyZBSGg9iPaOpQxQ", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select source city</option>`;

  if (response.status === 200) {
    for (const index in response.data.city) {
      let data = response.data.city[index];
      if(data.ctaprovince == ctaprovince){
        row_tr_table = row_tr_table + `
            <option value="${data.ctacity}" >${data.name} </option>`;
      }
    }
  }
  $(el_key).html(row_tr_table);
  // IOS.puthtml("#source_city", row_tr_table);
}




//destination country
ac_get_optiosn_list_destination_country();

function ac_get_optiosn_list_destination_country(token = "") {
  let APIBODY = { 
    "request": "mE8R6gNsOoTuhCBHhcgAccaHg3rBfYKtMR5O7hDp3cX66K0zvQZSQPKfpJssfDML", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select destination country</option>`;

  if (response.status === 200) {
    for (const index in response.data) {
      let data = response.data[index];
      row_tr_table = row_tr_table + `
          <option value="${data.token_auth}" ${token === data.token_auth ? "selected" : ""} >${data.name} </option>`;
    }
  }
  IOS.puthtml("#destination_country", row_tr_table);
}


//destination province
function ac_get_optiosn_list_destination_province(el_key, ctacountry) {
  let APIBODY = { 
    "request": "luKY70JDiexGQq5ZPCJF1w5NFiLO6sEBCWU/UOd1joR/qm7bHRsQWR4rQNTYxHEU", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select the destination province</option>`;

  if (response.status === 200) {
    for (const index in response.data.province) {
      let data = response.data.province[index];
      if(data.ctacountry == ctacountry){
        row_tr_table = row_tr_table + `
            <option value="${data.ctaprovince}" >${data.name} </option>`;
      }
    }
  }
  $(el_key).html(row_tr_table);
  // IOS.puthtml("#destination_province", row_tr_table);
}

//destination city
function ac_get_optiosn_list_destination_city(el_key, ctaprovince) {
  let APIBODY = { 
    "request": "T1SnAtAMZSlWWv8xs+piyBIMbq5nyZBSGg9iPaOpQxQ", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select the destination city</option>`;

  if (response.status === 200) {
    for (const index in response.data.city) {
      let data = response.data.city[index];
      if(data.ctaprovince == ctaprovince){
        row_tr_table = row_tr_table + `
            <option value="${data.ctacity}" >${data.name} </option>`;
      }
    }
  }
  $(el_key).html(row_tr_table);
  // IOS.puthtml("#destination_city", row_tr_table);
}

//item unit
ac_get_optiosn_list_item_unit();

function ac_get_optiosn_list_item_unit(token = "") {
  let APIBODY = { 
    "request": "ZC/0ITPM2tFpSTofbenjXXpbxt7OXmsuysMESBj64XI", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select the item unit</option>`;

  if (response.status === 200) {
    for (const index in response.data) {
      let data = response.data[index];
      row_tr_table = row_tr_table + `
          <option value="${data.token_auth}" ${token === data.token_auth ? "selected" : ""} >${data.name} </option>`;
    }
  }
  IOS.puthtml("#item_unit", row_tr_table);
}


//item currency
ac_get_optiosn_list_item_currency();

function ac_get_optiosn_list_item_currency(token = "") {
  let APIBODY = { 
    "request": "gSEb+8auOSLRCOMDuTT0zFQfp3RwCDQ6ADUKRNwMm8pdrafPOG2k42/clFCuRVh1", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select the currency</option>`;

  if (response.status === 200) {
    for (const index in response.data) {
      let data = response.data[index];
      row_tr_table = row_tr_table + `
          <option value="${data.token_auth}" ${token === data.token_auth ? "selected" : ""} >${data.name} </option>`;
    }
  }
  IOS.puthtml("#item_currency", row_tr_table);
}


//Source pickup type
ac_get_optiosn_list_source_pickup_type();

function ac_get_optiosn_list_source_pickup_type(token = "") {
  let APIBODY = { 
    "request": "UrhwOELH0XcVWc7qx0UBzkZBPZuKR4wvlEQFFneboY4", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select the source pickup type</option>`;
  
  if (response.status === 200) {
    for (const index in response.data.pickuptype.source) {
      let data = response.data.pickuptype.source[index];
      row_tr_table = row_tr_table + `
          <option value="${data.ctapickuptype}" ${token === data.ctapickuptype ? "selected" : ""} >${data.pickup_type_name} </option>`;
    }
  }
  IOS.puthtml("#source_pickup_type", row_tr_table);
}

//destination pickup type
ac_get_optiosn_list_destination_pickup_type();

function ac_get_optiosn_list_destination_pickup_type(token = "") {
  let APIBODY = { 
    "request": "mE8R6gNsOoTuhCBHhcgAcUGmq5qhDONsVS6NRoTqxfOKBBCLZfqHMTuIOa4s3EBe", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select the destination pickup type</option>`;

  if (response.status === 200) {
    for (const index in response.data.pickuptype.destination) {
      let data = response.data.pickuptype.destination[index];
      row_tr_table = row_tr_table + `
          <option value="${data.ctapickuptype}" ${token === data.ctapickuptype ? "selected" : ""} >${data.pickup_type_name} </option>`;
    }
  }
  IOS.puthtml("#destination_pickup_type", row_tr_table);
}



//ship purpose data option
function ac_get_optiosn_list_ship_purpose(token = "") {
  let APIBODY = { 
    "request": "b1PlkDqTY/uKaZ7kAR/0gM6GYqTV5K2LDYUoNoMo6x0", 
    "webToken": "k7sb4MpCBi0BdJ3hpfUp"
  };
  let response = CORE.post(Init.API_CLUSTER, APIHEADERS, APIBODY);
  let row_tr_table = `<option value="">Select the ship purpose</option>`;

  if (response.status === 200) {
    for (const index in response.data) {
      let data = response.data[index];
      row_tr_table = row_tr_table + `
          <option value="${data.ctapickuptype}" ${token === data.name ? "selected" : ""} >${data.name} </option>`;
    }
  }
  IOS.puthtml(".ship_purpose", row_tr_table);
}



//ship status history on the ship detatil 
function ship_status_list(token = "", next_stage= "") {

  let APIBODY = IOS.serializeForm($("#FILTERFORM"));
  let response = CORE.post(Init.API_SHIP, APIHEADERS, APIBODY);
  let row_tr_table = ``;

  if (response.status === 200) {

    let bg = '';
    let font_img_next = '';
    bg = 'bg bg-warning';
    font_img_next = 'arrow-right';

    if(next_stage.length > 0)

      row_tr_table = row_tr_table + `

        <div class="vertical-timeline-block">
            <div class="vertical-timeline-icon">
                <i class="fa fa-${font_img_next}"></i>
            </div>
            <div class="vertical-timeline-content ${bg}">
                <div class="p-sm">
                    <span class="vertical-date pull-left">
                    
                      <small>This is the next status stage</small> 
                    
                    </span>
                    <br>
                    <h2>${next_stage}</h2>

                </div>
            </div>
          </div>
        
    `;
    else
    row_tr_table = row_tr_table + `

        <div class="vertical-timeline-block">
            status not changed yet. check later after it has been changed.
        </div>

    `;

    for (const index in response.data.logs) {
      let data = response.data.logs[index];

      let bg = '';
      let font_img = '';

      if(token === data.status)
        bg = 'bg bg-primary';
      if(token === 'REJECTED' & token === data.status)
        bg = 'bg bg-danger';
      if(token === 'APPROVED' & token === data.status)
        bg = 'bg bg-success';
      if(token === 'ARRIVED' & token === data.status)
        bg = 'bg bg-success';
      if(token === 'COMPLETED' & token === data.status)
        bg = 'bg bg-success';

      if(token === data.status)

        font_img =  'check';

        row_tr_table = row_tr_table + `
          <div class="vertical-timeline-block">
            <div class="vertical-timeline-icon">
                <i class="fa fa-${font_img}"></i>
            </div>
            <div class="vertical-timeline-content ${bg}">
                <div class="p-sm">
                    <span class="vertical-date pull-right"> <small>${data.creation_datetime}</small> </span>

                    <h2>${data.status}</h2>

                    <p class="text-white">${data.comment}</p>
                </div>
            </div>
          </div>

        `;
    }

  }
  IOS.puthtml(".ship_status_history", row_tr_table);
}



//shipment item





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

