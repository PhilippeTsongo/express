<?php
require '../core/init.php';
// echo $HASH->encryptAES('iccn-contact-us-request-state-declined');
// echo Hash::encryptToken(12);

if (Input::checkInput('request', 'post', 1) && Input::checkInput('webToken', 'post', 1)  && Functions::xhrValidation(Input::get('request', 'post'))):
  $_REQUEST_ = $HASH->decryptAES(Input::get('request', 'post'));
  if ($_REQUEST_):
    switch ($_REQUEST_):

      case 'iccn-article-comments-list':
        if( Input::checkInput('token', 'post', 1) ):
          $_ID_   = Hash::decryptToken( Input::get('token', 'post') );
          $_DATA_ = \ICCNArticleCommentController::getListArticleComments($_ID_);
          $_ARTICLE_DATA_ = \ICCNArticleController::getArticleDetailByID($_ID_);
          if ($_DATA_):
            $response['status']  = 1;
            $response['message'] = 'Operation success!';
            $response['data']    = $_DATA_;
            $response['data_article']    = $_ARTICLE_DATA_;
          else:
            $response['status']  = 0;
            $response['message'] = 'Empty data';
          endif;
        else:
          $response['status']  = 0;
          $response['message'] = 'Empty';
        endif;
        Json::echo($response);
        break;

      case 'iccn-article-comments-activate': 
        Input::put('article-status', 'post', 'ACTIVE');
        $form = \ICCNArticleCommentController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-article-comments-deactivate':
        Input::put('article-status', 'post', 'DEACTIVE');
        $form = \ICCNArticleCommentController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-contact-us-request-list':
        $_DATA_ = \ICCNContactUsController::getListContactUs('');
        if ($_DATA_):
          $response['status']  = 1;
          $response['message'] = 'Operation success!';
          $response['data']    = $_DATA_;
        else:
          $response['status']  = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-contact-us-request-state-answered': 
        Input::put('change-status', 'post', 'ANSWERED');
        $form = \ICCNContactUsController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-contact-us-request-state-declined':
        Input::put('change-status', 'post', 'DECLINED');
        $form = \ICCNContactUsController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-admin-list':
        $_DATA_ = \ICCNAccountController::getAccounts('');
        if ($_DATA_):
          $response['status']  = 1;
          $response['message'] = 'Operation success!';
          $response['data']    = $_DATA_;
        else:
          $response['status']  = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-admin-new':
        $form = \ICCNAccountController::create();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-admin-update':
        $form = \ICCNAccountController::edit();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-admin-activate': 
        Input::put('account-status', 'post', 'ACTIVE');
        $form = \ICCNAccountController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-admin-deactivate':
        Input::put('account-status', 'post', 'DEACTIVE');
        $form = \ICCNAccountController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

       case 'iccn-admin-reset-password':
        $form = \ICCNAccountController::resetPassword();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-about-update':
        $form = \ICCNAboutController::updateAbout();
        if ($form->ERRORS == false):
          $response['status']  = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status']  = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'refresh-table-iccn-about':
        $_DATA_ = \ICCNAboutController::getICCNAbout();
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

      case 'iccn-article-list':
        $_DATA_ = \ICCNArticleController::getListArticles('');
        if ($_DATA_):
          $response['status']  = 1;
          $response['message'] = 'Operation success!';
          $response['data']    = $_DATA_;
        else:
          $response['status']  = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-article-data':
        if(Input::checkInput('_id_', 'post', 1)):
          $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
          $_DATA_ = \ICCNArticleController::getArticleyByID($_ID_);
          if ($_DATA_):
            $response['status']  = 1;
            $response['message'] = 'Operation success!';
            $response['data']    = $_DATA_;
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

      case 'iccn-article-new':
        $form = \ICCNArticleController::createArticle('ARTICLE');
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-article-update':
        $form = \ICCNArticleController::edit('ARTICLE');
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-article-activate': 
        Input::put('article-status', 'post', 'ACTIVE');
        $form = \ICCNArticleController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-article-deactivate':
        Input::put('article-status', 'post', 'DEACTIVE');
        $form = \ICCNArticleController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;


      case 'iccn-event-list':
        $_DATA_ = \ICCNArticleController::getListEvents('');
        if ($_DATA_):
          $response['status']  = 1;
          $response['message'] = 'Operation success!';
          $response['data']    = $_DATA_;
        else:
          $response['status']  = 0;
          $response['message'] = 'Empty';
        endif;
        Json::echo($response);
        break;

      case 'iccn-event-data':
        if(Input::checkInput('_id_', 'post', 1)):
          $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
          $_DATA_ = \ICCNArticleController::getEventByID($_ID_);
          if ($_DATA_):
            $response['status']  = 1;
            $response['message'] = 'Operation success!';
            $response['data']    = $_DATA_;
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

      case 'iccn-event-new':
        $form = \ICCNArticleController::createEvent('EVENT');
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-event-update':
        $form = \ICCNArticleController::edit('EVENT');
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-event-activate': 
        Input::put('article-status', 'post', 'ACTIVE');
        $form = \ICCNArticleController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-event-deactivate':
        Input::put('article-status', 'post', 'DEACTIVE');
        $form = \ICCNArticleController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-service-list':
        $_DATA_ = \ICCNServiceController::getListServices('');
        if ($_DATA_):
          $response['status']  = 1;
          $response['message'] = 'Operation success!';
          $response['data']    = $_DATA_;
        else:
          $response['status']  = 0;
          $response['message'] = 'Empty';
        endif;
        Json::echo($response);
        break;

      case 'iccn-service-data':
        if(Input::checkInput('_id_', 'post', 1)):
          $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
          $_DATA_ = \ICCNServiceController::getServiceByID($_ID_);
          if ($_DATA_):
            $response['status']  = 1;
            $response['message'] = 'Operation success!';
            $response['data']    = $_DATA_;
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

      case 'iccn-service-new':
        $form = \ICCNServiceController::create();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-service-update':
        $form = \ICCNServiceController::edit();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-service-activate': 
        Input::put('update-status', 'post', 'ACTIVE');
        $form = \ICCNServiceController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-service-deactivate':
        Input::put('update-status', 'post', 'DEACTIVE');
        $form = \ICCNServiceController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;




      case 'iccn-partner-list':
        $_DATA_ = \ICCNPartnerController::getListPartners('');
        if ($_DATA_):
          $response['status']  = 1;
          $response['message'] = 'Operation success!';
          $response['data']    = $_DATA_;
        else:
          $response['status']  = 0;
          $response['message'] = 'Empty';
        endif;
        Json::echo($response);
        break;

      case 'iccn-partner-data':
        if(Input::checkInput('_id_', 'post', 1)):
          $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
          $_DATA_ = \ICCNPartnerController::getPartnerByID($_ID_);
          if ($_DATA_):
            $response['status']  = 1;
            $response['message'] = 'Operation success!';
            $response['data']    = $_DATA_;
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

      case 'iccn-partner-new':
        $form = \ICCNPartnerController::create();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-partner-update':
        $form = \ICCNPartnerController::edit();
        if ($form->ERRORS == false):
          $response['status'] = 1; 
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-partner-activate': 
        Input::put('update-status', 'post', 'ACTIVE');
        $form = \ICCNPartnerController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-partner-deactivate':
        Input::put('update-status', 'post', 'DEACTIVE');
        $form = \ICCNPartnerController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-team-list':
        $_DATA_ = \ICCNTeamController::getListTeamMembers('');
        if ($_DATA_):
          $response['status']  = 1;
          $response['message'] = 'Operation success!';
          $response['data']    = $_DATA_;
        else:
          $response['status']  = 0;
          $response['message'] = 'Empty';
        endif;
        Json::echo($response);
        break;

      case 'iccn-team-data':
        if(Input::checkInput('_id_', 'post', 1)):
          $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
          $_DATA_ = \ICCNTeamController::getListTeamMemberByID($_ID_);
          if ($_DATA_):
            $response['status']  = 1;
            $response['message'] = 'Operation success!';
            $response['data']    = $_DATA_;
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

      case 'iccn-team-new':
        $form = \ICCNTeamController::create();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-team-update':
        $form = \ICCNTeamController::edit();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

      case 'iccn-team-activate': 
        Input::put('update-status', 'post', 'ACTIVE');
        $form = \ICCNTeamController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;
      
      case 'iccn-team-deactivate':
        Input::put('update-status', 'post', 'DEACTIVE');
        $form = \ICCNTeamController::changeStatus();
        if ($form->ERRORS == false):
          $response['status'] = 1;
          $response['message'] = 'Operation success!';
        else:
          $response['status'] = 0;
          $response['message'] = $form->ERRORS_SCRIPT;
        endif;
        Json::echo($response);
        break;

        case 'iccn-testimonial-list':
          $_DATA_ = \ICCNTestimonialController::getListTestimonials('');
          if ($_DATA_):
            $response['status']  = 1;
            $response['message'] = 'Operation success!';
            $response['data']    = $_DATA_;
          else:
            $response['status']  = 0;
            $response['message'] = 'Empty';
          endif;
          Json::echo($response);
          break;
  
        case 'iccn-testimonial-data':
          if(Input::checkInput('_id_', 'post', 1)):
            $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
            $_DATA_ = \ICCNTestimonialController::getListTestimonialByID($_ID_);
            if ($_DATA_):
              $response['status']  = 1;
              $response['message'] = 'Operation success!';
              $response['data']    = $_DATA_;
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
  
        case 'iccn-testimonial-new':
          $form = \ICCNTestimonialController::create();
          if ($form->ERRORS == false):
            $response['status'] = 1;
            $response['message'] = 'Operation success!';
          else:
            $response['status'] = 0;
            $response['message'] = $form->ERRORS_SCRIPT;
          endif;
          Json::echo($response);
          break;
        
        case 'iccn-testimonial-update':
          $form = \ICCNTestimonialController::edit();
          if ($form->ERRORS == false):
            $response['status'] = 1;
            $response['message'] = 'Operation success!';
          else:
            $response['status'] = 0;
            $response['message'] = $form->ERRORS_SCRIPT;
          endif;
          Json::echo($response);
          break;
  
        case 'iccn-testimonial-activate': 
          Input::put('update-status', 'post', 'ACTIVE');
          $form = \ICCNTestimonialController::changeStatus();
          if ($form->ERRORS == false):
            $response['status'] = 1;
            $response['message'] = 'Operation success!';
          else:
            $response['status'] = 0;
            $response['message'] = $form->ERRORS_SCRIPT;
          endif;
          Json::echo($response);
          break;
        
        case 'iccn-testimonial-deactivate':
          Input::put('update-status', 'post', 'DEACTIVE');
          $form = \ICCNTestimonialController::changeStatus();
          if ($form->ERRORS == false):
            $response['status'] = 1;
            $response['message'] = 'Operation success!';
          else:
            $response['status'] = 0;
            $response['message'] = $form->ERRORS_SCRIPT;
          endif;
          Json::echo($response);
          break;
  
        case 'iccn-shop-product-list':
          $_DATA_ = \ICCNProductController::getListShopProducts('');
          if ($_DATA_):
            $response['status']  = 1;
            $response['message'] = 'Operation success!';
            $response['data']    = $_DATA_;
          else:
            $response['status']  = 0;
            $response['message'] = 'Empty';
          endif;
          Json::echo($response);
          break;
  
        case 'iccn-shop-product-data':
          if(Input::checkInput('_id_', 'post', 1)):
            $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
            $_DATA_ = \ICCNProductController::getShopProductByID($_ID_);
            if ($_DATA_):
              $response['status']  = 1;
              $response['message'] = 'Operation success!';
              $response['data']    = $_DATA_;
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
  
        case 'iccn-shop-product-new':
          $form = \ICCNProductController::create();
          if ($form->ERRORS == false):
            $response['status'] = 1;
            $response['message'] = 'Operation success!';
          else:
            $response['status'] = 0;
            $response['message'] = $form->ERRORS_SCRIPT;
          endif;
          Json::echo($response);
          break;
        
        case 'iccn-shop-product-update':
          $form = \ICCNProductController::edit();
          if ($form->ERRORS == false):
            $response['status'] = 1;
            $response['message'] = 'Operation success!';
          else:
            $response['status'] = 0;
            $response['message'] = $form->ERRORS_SCRIPT;
          endif;
          Json::echo($response);
          break;
  
        case 'iccn-shop-product-activate': 
          Input::put('update-status', 'post', 'ACTIVE');
          $form = \ICCNProductController::changeStatus();
          if ($form->ERRORS == false):
            $response['status'] = 1;
            $response['message'] = 'Operation success!';
          else:
            $response['status'] = 0;
            $response['message'] = $form->ERRORS_SCRIPT;
          endif;
          Json::echo($response);
          break;
        
        case 'iccn-shop-product-deactivate':
          Input::put('update-status', 'post', 'DEACTIVE');
          $form = \ICCNProductController::changeStatus();
          if ($form->ERRORS == false):
            $response['status'] = 1;
            $response['message'] = 'Operation success!';
          else:
            $response['status'] = 0;
            $response['message'] = $form->ERRORS_SCRIPT;
          endif;
          Json::echo($response);
          break;
  
         case 'iccn-gallery-list':
            $_DATA_ = \ICCNGalleryController::getListGalleryPhotos('');
            if ($_DATA_):
              $response['status']  = 1;
              $response['message'] = 'Operation success!';
              $response['data']    = $_DATA_;
            else:
              $response['status']  = 0;
              $response['message'] = 'Empty';
            endif;
            Json::echo($response);
            break;
    
          case 'iccn-gallery-data':
            if(Input::checkInput('_id_', 'post', 1)):
              $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
              $_DATA_ = \ICCNGalleryController::getGalleryPhotoByID($_ID_);
              if ($_DATA_):
                $response['status']  = 1;
                $response['message'] = 'Operation success!';
                $response['data']    = $_DATA_;
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
    
          case 'iccn-gallery-new':
            $form = \ICCNGalleryController::create();
            if ($form->ERRORS == false):
              $response['status'] = 1;
              $response['message'] = 'Operation success!';
            else:
              $response['status'] = 0;
              $response['message'] = $form->ERRORS_SCRIPT;
            endif;
            Json::echo($response);
            break;
          
          case 'iccn-gallery-update':
            $form = \ICCNGalleryController::edit();
            if ($form->ERRORS == false):
              $response['status'] = 1;
              $response['message'] = 'Operation success!';
            else:
              $response['status'] = 0;
              $response['message'] = $form->ERRORS_SCRIPT;
            endif;
            Json::echo($response);
            break;
    
          case 'iccn-gallery-activate': 
            Input::put('update-status', 'post', 'ACTIVE');
            $form = \ICCNGalleryController::changeStatus();
            if ($form->ERRORS == false):
              $response['status'] = 1;
              $response['message'] = 'Operation success!';
            else:
              $response['status'] = 0;
              $response['message'] = $form->ERRORS_SCRIPT;
            endif;
            Json::echo($response);
            break;
          
          case 'iccn-gallery-deactivate':
            Input::put('update-status', 'post', 'DEACTIVE');
            $form = \ICCNGalleryController::changeStatus();
            if ($form->ERRORS == false):
              $response['status'] = 1;
              $response['message'] = 'Operation success!';
            else:
              $response['status'] = 0;
              $response['message'] = $form->ERRORS_SCRIPT;
            endif;
            Json::echo($response);
            break;
    
        case 'iccn-api-home-stats-count':
              $response['status']             = 1;
              $response['message']            = 'Operation success!';
              $response['count']['articles']      = ICCNArticleController::getTotalArticles();
              $response['count']['events']        = ICCNArticleController::getTotalEvents();
              $response['count']['team']      = ICCNArticleController::getTotalTeamMembers();
              $response['count']['product']      = ICCNArticleController::getTotalProducts();
              $response['count']['partner']      = ICCNArticleController::getTotalPartners();
              $response['count']['gallery']      = ICCNArticleController::getTotalGalleryPhotos();
 
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
