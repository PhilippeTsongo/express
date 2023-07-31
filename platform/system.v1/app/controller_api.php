<?php
require '../core/init.php';
header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/Json');

if (Input::checkInput('request', 'post', 1) && Input::checkInput('webToken', 'post', 1) && Functions::xhrValidation(Input::get('request', 'post')) ):
  $_REQUEST_ = $HASH->decryptAES(Input::get('request', 'post'));
  if ($_REQUEST_):
    switch ($_REQUEST_):

      case 'iccn-api-home-content':
        $_DATA_ABOUT_           = \ICCNWebApiController::getICCNActiveAbout();
        $_DATA_SERVICE_         = \ICCNWebApiController::getICCNActiveServices();
        $_DATA_GALLERY_         = \ICCNWebApiController::getICCNActiveGalleryPhotos();
        $_DATA_TESTIMONIAL_     = \ICCNWebApiController::getICCNActiveTestimonials();

        $_DATA_EVENT_LAST_2_    = \ICCNWebApiController::getICCNActiveEventsLast2();
        $_DATA_ARTICLES_LAST_2_ = \ICCNWebApiController::getICCNActiveArticlesLast2();
        
        $_DATA_EVENT_           = \ICCNWebApiController::getICCNActiveEvents();
        $_DATA_ARTICLES_        = \ICCNWebApiController::getICCNActiveArticles();

        $_DATA_TEAM_            = \ICCNWebApiController::getICCNActiveTeamMembers();
        $_DATA_PARTNERS_        = \ICCNWebApiController::getICCNActivePartners();
        $_DATA_SHOP_            = \ICCNWebApiController::getICCNActiveShopProducts();

        if ( $_DATA_ABOUT_ ):
          $response['status']             = 1;
          $response['message']            = 'Operation success!';
          $response['data']['about']      = $_DATA_ABOUT_;
          $response['data']['service']    = $_DATA_SERVICE_;
          $response['data']['testimonial']= $_DATA_TESTIMONIAL_;
          $response['data']['gallery']    = $_DATA_GALLERY_;

          $response['data']['event_2']    = $_DATA_EVENT_LAST_2_;
          $response['data']['events']     = $_DATA_EVENT_;
          $response['data']['article_2']  = $_DATA_ARTICLES_LAST_2_;
          $response['data']['articles']   = $_DATA_ARTICLES_;

          $response['data']['team']       = $_DATA_TEAM_;
          $response['data']['partner']    = $_DATA_PARTNERS_;
          $response['data']['shop']       = $_DATA_SHOP_;
        else:
          $response['status']  = 0;
          $response['message'] = "No data found";
        endif;
        Json::echo($response);
        break;

      case 'iccn-api-active-article-submit-comment':
        $_FORM_        = \ICCNArticleCommentController::record();
        if ( $_FORM_->ERRORS == false ):
          $response['status']  = 1;
          $response['message'] = 'Success';
        else:
          $response['status']  = 0;
          $response['message'] = "Error";
        endif;
        Json::echo($response);
        break;

      case 'iccn-api-active-contact-submit-request':
        $_FORM_        = \ICCNContactUsController::record();
        if ( $_FORM_->ERRORS == false ):
          $response['status']  = 1;
          $response['message'] = 'Success';
        else:
          $response['status']  = 0;
          $response['message'] = "Error";
        endif;
        Json::echo($response);
        break;

      case 'iccn-api-active-articles':
        $_DATA_ARTICLES_LAST_2_ = \ICCNWebApiController::getICCNActiveArticlesLast2();
        $_DATA_ARTICLES_        = \ICCNWebApiController::getICCNActiveArticles();
        if ( $_DATA_ARTICLES_ ):
          $response['status']  = 1;
          $response['message'] = 'Operation success!';
          $response['data']    = $_DATA_ARTICLES_;
        else:
          $response['status']  = 0;
          $response['message'] = "No data found";
        endif;
        Json::echo($response);
        break;

      case 'iccn-api-active-article-data':
        if(Input::checkInput('_id_', 'post', 1)):
          $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
          $_DATA_ = \ICCNWebApiController::getICCNActiveArticleData($_ID_);
          if ($_DATA_):
            $response['status']  = 1;
            $response['message'] = 'Operation success!';
            $response['data']['article_2']  = $_DATA_ARTICLES_LAST_2_;
           $response['data']['articles']    = $_DATA_ARTICLES_;
          else:
            $response['status']  = 0;
            $response['message'] = $form->ERRORS_SCRIPT;
          endif;
        else:
          $response['status']  = 0;
          $response['message'] = "Param required";
        endif;
        Json::echo($response);
        break;

      
      case 'iccn-api-active-events':
        $_DATA_EVENT_LAST_2_    = \ICCNWebApiController::getICCNActiveEventsLast2();
        $_DATA_ARTICLES_LAST_2_ = \ICCNWebApiController::getICCNActiveArticlesLast2();
        
        $_DATA_EVENT_           = \ICCNWebApiController::getICCNActiveEvents();
        $_DATA_ARTICLES_        = \ICCNWebApiController::getICCNActiveArticles();
        if ( $_DATA_ ):
          $response['status']  = 1;
          $response['message'] = 'Operation success!';
          $response['data']    = $_DATA_;
        else:
          $response['status']  = 0;
          $response['message'] = "No data found";
        endif;
        Json::echo($response);
        break;

      default:
        $response['status'] = 1011;
        $response['message'] = 'INVALID_REQUEST';
        Json::echo($response);
        break;

    endswitch;

  else:
    $response['status'] = 1011;
    $response['message'] = 'INVALID_REQUEST';
    Json::echo($response);
  endif;

endif;
?>
