import * as Init from '../../../../core/corejs/init.js';
const hostname = Init.CTRLUP;

if($('.smart-item-table').length)
  showDataTable();

if($('.registration-form-update').length){
  let _id_ = $('#_id_').val();
  getDataByID(_id_);
}

// $('.summernote').summernote();
if($('.registration-form').length){
  $('.summernote').summernote();
  $('.summernote-mission').summernote();
  $('.summernote-vision').summernote();
}

function showDataTable() {
  loadData();
  // setInterval(function () {
    // loadData();
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
      // $('.smart-data-table').html(dataResponse);

      var response = JSON.parse(dataResponse);
      if (response.status == 1) {
        let company_logo  =  response.data.logo;
        $('.company-image').html( `<img src="${company_logo}" class="img-responsive company-image-style" style="width: 100%;"/>` );

        $('.company-name').html(response.data.name);
        $('.company-email').html(response.data.email);
        $('.company-telephone').html(response.data.telephone);
        $('.company-address').html(response.data.address);

        $('.company-link_facebook').html(response.data.link_facebook);
        $('.company-link_google').html(response.data.link_google);
        $('.company-link_instagram').html(response.data.link_instagram);

        $('.company-link_linkedin').html(response.data.link_linkedin);
        $('.company-link_tweeter').html(response.data.link_tweeter);
        $('.company-link_youtube').html(response.data.link_youtube);

        $('.company-short_description').html(response.data.description_short);
        $('.company-full_description').html(response.data.description);

        $('.company-short_mission').html(response.data.mission_short);
        $('.company-full_mission').html(response.data.mission);

        $('.company-short_vision').html(response.data.vision_short);
        $('.company-full_vision').html(response.data.vision);

        $('.company-short_general_objective').html(response.data.general_objective_short);
        $('.company-full_general_objective').html($.parseHTML(response.data.general_objective));
      }
      else{

      }
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

        $('#about-name').val(response.data.name);
        $('#about-email').val(response.data.email);
        $('#about-telephone').val(response.data.telephone);
        $('#about-address').val(response.data.address);
        $('#about-logo').val(response.data.logo);

        $('#about-facebook_link').val(response.data.link_facebook);
        $('#about-google_link').val(response.data.link_google);
        $('#about-instagram_link').val(response.data.link_instagram);

        $('#about-linkedin_link').val(response.data.link_linkedin);
        $('#about-tweeter_link').val(response.data.link_tweeter);
        $('#about-youtube_link').val(response.data.link_youtube);

        // $('.about-short_description').html(response.data.description_short);
        $('.summernote').html(response.data.description).summernote();

        // console.log( " Summernote :: " + $('.summernote').summernote().html() );

        // $('.about-short_mission').html(response.data.mission_short);
        $('.summernote-mission').html(response.data.mission).summernote();

        // $('.about-short_vision').html(response.data.vision_short);
        $('.summernote-vision').html(response.data.vision).summernote();;

        // $('.about-short_general_objective').html(response.data.general_objective_short);
        $('.summernote-general_objective').html(response.data.general_objective).summernote();;
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


$('#SubmitRegisterForm').on('submit', function () {
    var this_form = $(this);
    // var form_data = $(this).serialize();

    var description = $('.summernote').summernote('code');
    var mission = $('.summernote-mission').summernote('code');
    var vision = $('.summernote-vision').summernote('code');
    var general_objective = $('.summernote-general_objective').summernote('code');

    $('[name="about-description"]').val( description );
    $('[name="about-mission"]').val( mission );
    $('[name="about-vision"]').val( vision );
    $('[name="about-general_objective"]').val( general_objective );

    var form_data = $(this).serialize();

    // form_data = form_data + "&about-description="+description;
    // form_data = form_data + "&about-mission="+mission;
    // form_data = form_data + "&about-vision="+vision;
    // form_data = form_data + "&about-general_objective="+general_objective;

    $.ajax({
        url: hostname,
        type: "POST",
        data: form_data,
        cache: false,
        success: function (dataResponse) {
        
          var response = JSON.parse(dataResponse);
          if (response.status == 1) {

            // $("#SubmitRegisterButton").button('reset');
            // $("#SubmitRegisterForm")[0].reset();
            // $('form.SubmitRegisterForm select').trigger("change");

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


function htmlEscape ( text_input ) {

  return text_input.trim()
      .replace('&', '&')
};

function  htmlUnescape ( text_input ) {

  return text_input.trim()
      .replace('&', '&');
};