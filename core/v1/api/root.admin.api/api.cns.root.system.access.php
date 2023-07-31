<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$HASH = new Hash;
// echo  $HASH->encryptAES('cns-api-root-access-level-task-activate');






# Check Request Method Origin
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

  # Get API Headers 
  $headers = Functions::getRequestHeaders();
  if ($headers):
    $token = Functions::getBearerAuthValue($headers);
    $access_data = CNS_ROOT_AccountController::checkToken($token);

    # Check Valid Token :: Access Data
    if ($access_data):

      if (Input::checkInput('request', 'post', 1) && Input::checkInput('webToken', 'post', 1)):
        // $_REQUEST_ = Input::get('request', 'post');
        $_REQUEST_ = $HASH->decryptAES(Input::get('request', 'post'));

        $_startdate_ = !Input::checkInput('filter-start-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-start-date', 'post')));
        $_enddate_ = !Input::checkInput('filter-end-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-end-date', 'post')));
        $_keyword_ = !Input::checkInput('filter-keyword', 'post', 1) ? "" : Str::data_in(Input::get('filter-keyword', 'post'));

        $_platform_ = !Input::checkInput('ctaplatform', 'post', 1) ? "" : Str::data_in(Input::get('ctaplatform', 'post'));
        $_software_ = !Input::checkInput('ctasoftware', 'post', 1) ? "" : Str::data_in(Input::get('ctasoftware', 'post'));

        $_package_ = !Input::checkInput('ctapackage', 'post', 1) ? "" : Str::data_in(Input::get('ctapackage', 'post'));
        $_b2b_ = !Input::checkInput('ctab2b', 'post', 1) ? "" : Str::data_in(Input::get('ctab2b', 'post'));

        $_level_ = !Input::checkInput('ctalevel', 'post', 1) ? "" : Str::data_in(Input::get('ctalevel', 'post'));
        $_task_ = !Input::checkInput('ctatask', 'post', 1) ? "" : Str::data_in(Input::get('ctatask', 'post'));

        $_filter_condtion_ = "";
        if ($_REQUEST_):
          // echo $_REQUEST_;
          switch ($_REQUEST_):

            case 'cns-api-root-access-level-creation':
              $form = \CNS_AccessController::create_level($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-level-update':
              $form = \CNS_AccessController::edit_level(($access_data));
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-level-list':

              if ($_startdate_ != '')
                $_filter_condtion_ .= " AND cns_views_access_level.creation_datetime >= $_startdate_ ";
              if ($_enddate_ != '')
                $_filter_condtion_ .= " AND cns_views_access_level.creation_datetime <= $_enddate_ ";
              if ($_keyword_ != '')
                $_filter_condtion_ .= " AND (cns_views_access_level.name LIKE  '%$_keyword_%') ";

              if ($_platform_ != ''):
                $_platform_ = $HASH->decryptAES($_platform_);
                $_filter_condtion_ .= " AND cns_views_access_level.cns_platform = $_platform_ ";
              endif;

              if ($_software_ != ''):
                $_software_ = $HASH->decryptAES($_software_);
                $_filter_condtion_ .= " AND cns_views_access_level.cns_platform_product = $_software_ ";
              endif;

              $_LIST_DATA_ = \CNS_AccessController::get_list_access_level($_filter_condtion_);
              if ($_LIST_DATA_):
                $response['status'] = SUCCESS;
                $response['message'] = 'SUCCESS';
                $response['data'] = $_LIST_DATA_;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = 'EMPTY';
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-level-data':
              if (Input::checkInput('_id_', 'post', 1)):
                $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                $_DATA_ = \CNS_AccessController::get_data_access_level($_ID_);
                if ($_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                  $response['data'] = $_DATA_;
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = "EMPTY";
                endif;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = "Required param";
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-level-activate':
              Input::put('update-status', 'post', 'ACTIVE');
              $form = \CNS_AccessController::change_status_level();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-level-deactivate':
              Input::put('update-status', 'post', 'DEACTIVE');
              $form = \CNS_AccessController::change_status_level();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

















            case 'cns-api-root-access-task-creation':
              $form = \CNS_AccessController::create_task($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-task-update':
              $form = \CNS_AccessController::edit_task(($access_data));
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-task-list':

              if ($_startdate_ != '')
                $_filter_condtion_ .= " AND cns_views_access_task.creation_datetime >= $_startdate_ ";
              if ($_enddate_ != '')
                $_filter_condtion_ .= " AND cns_views_access_task.creation_datetime <= $_enddate_ ";
              if ($_keyword_ != '')
                $_filter_condtion_ .= " AND (cns_views_access_task.name LIKE  '%$_keyword_%') ";

              if ($_platform_ != ''):
                $_platform_ = $HASH->decryptAES($_platform_);
                $_filter_condtion_ .= " AND cns_views_access_task.cns_platform = $_platform_ ";
              endif;

              if ($_software_ != ''):
                $_software_ = $HASH->decryptAES($_software_);
                $_filter_condtion_ .= " AND cns_views_access_task.cns_platform_product = $_software_ ";
              endif;

              $_LIST_DATA_ = \CNS_AccessController::get_list_access_task($_filter_condtion_);
              if ($_LIST_DATA_):
                $response['status'] = SUCCESS;
                $response['message'] = 'SUCCESS';
                $response['data'] = $_LIST_DATA_;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = 'EMPTY';
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-task-data':
              if (Input::checkInput('_id_', 'post', 1)):
                $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                $_DATA_ = \CNS_AccessController::get_data_access_task($_ID_);
                if ($_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                  $response['data'] = $_DATA_;
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = "EMPTY";
                endif;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = "Required param";
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-task-activate':
              Input::put('update-status', 'post', 'ACTIVE');
              $form = \CNS_AccessController::change_status_task();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-task-deactivate':
              Input::put('update-status', 'post', 'DEACTIVE');
              $form = \CNS_AccessController::change_status_task();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

























            case 'cns-api-root-access-level-task-creation':
              $form = \CNS_AccessController::create_level_task($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-level-task-update':
              $form = \CNS_AccessController::edit_level_task(($access_data));
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-level-task-list':

              if ($_startdate_ != '')
                $_filter_condtion_ .= " AND cns_views_access_level_task.creation_datetime >= $_startdate_ ";
              if ($_enddate_ != '')
                $_filter_condtion_ .= " AND cns_views_access_level_task.creation_datetime <= $_enddate_ ";
              if ($_keyword_ != '')
                $_filter_condtion_ .= " AND (cns_views_access_level_task.level_name LIKE  '%$_keyword_%' OR cns_views_access_level_task.task_name LIKE  '%$_keyword_%' OR cns_views_access_level_task.b2b_name LIKE  '%$_keyword_%' OR cns_views_access_level_task.b2b_code LIKE  '%$_keyword_%' OR cns_views_access_level_task.cns_package_name LIKE  '%$_keyword_%') ";

              if ($_platform_ != ''):
                $_platform_ = $HASH->decryptAES($_platform_);
                $_filter_condtion_ .= " AND cns_views_access_level_task.cns_platform = $_platform_ ";
              endif;
              if ($_software_ != ''):
                $_software_ = $HASH->decryptAES($_software_);
                $_filter_condtion_ .= " AND cns_views_access_level_task.cns_platform_product = $_software_ ";
              endif;
              if ($_package_ != ''):
                $_package_ = $HASH->decryptAES($_package_);
                $_filter_condtion_ .= " AND cns_views_access_level_task.cns_platform = $_package_ ";
              endif;
              if ($_b2b_ != ''):
                $_b2b_ = $HASH->decryptAES($_b2b_);
                $_filter_condtion_ .= " AND cns_views_access_level_task.cns_b2b = $_b2b_ ";
              endif;
              if ($_level_ != ''):
                $_level_ = $HASH->decryptAES($_level_);
                $_filter_condtion_ .= " AND cns_views_access_level_task.access_level = $_level_ ";
              endif;
              if ($_task_ != ''):
                $_task_ = $HASH->decryptAES($_task_);
                $_filter_condtion_ .= " AND cns_views_access_level_task.access_task = $_task_ ";
              endif;

              $_LIST_DATA_ = \CNS_AccessController::get_list_access_level_task($_filter_condtion_);
              if ($_LIST_DATA_):
                $response['status'] = SUCCESS;
                $response['message'] = 'SUCCESS';
                $response['data'] = $_LIST_DATA_;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = 'EMPTY';
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-level-task-data':
              if (Input::checkInput('_id_', 'post', 1)):
                $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                $_DATA_ = \CNS_AccessController::get_data_access_level_task($_ID_);
                if ($_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                  $response['data'] = $_DATA_;
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = "EMPTY";
                endif;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = "Required param";
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-level-task-activate':
              Input::put('update-status', 'post', 'ACTIVE');
              $form = \CNS_AccessController::change_status_level_task();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-access-level-task-deactivate':
              Input::put('update-status', 'post', 'DEACTIVE');
              $form = \CNS_AccessController::change_status_level_task();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;


              
            default:
              $response['status'] = 1011;
              $response['message'] = 'INVALID_REQUEST';
              Json::echo ($response);
              break;

          endswitch;

        else:
          $response['status'] = 1011;
          $response['message'] = 'INVALID_REQUEST';
          Json::echo ($response);
        endif;

      endif;
    endif;
  endif;
endif;
// endif;
?>