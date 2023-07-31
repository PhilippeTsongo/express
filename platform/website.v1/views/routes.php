<?php
$sub_ = 'inc/';
$main_step_folder_ = '';
$sub_step_folder_ = '';

require $main_ . $sub_ . 'header' . PL;

# STORE / E-Book
if ('web01/' == $main_):
  switch ($url_struc['tree']):
    # Dashboard
    case '':
      $sub_ = 'home/';
      require($main_ . $sub_ . 'home' . PL);
      break;

    # Dashboard
    case 'home':
    $sub_ = 'home/';
    require($main_ . $sub_ . 'home' . PL);
    break;

    # Client register
    case 'client_register':
      $sub_ = 'client_account/';
      require($main_ . $sub_ . 'register_client' . PL);
      break;
      
    # Client login
    case 'client_login':
      $sub_ = 'client_account/';
      require($main_ . $sub_ . 'login_client' . PL);
      break;
    
    # Client home page with all his ships
    case 'client_home':
      $sub_ = 'client_account/';
      require($main_ . $sub_ . 'home_client' . PL);
      break;

    # Client home page
    case 'detail_ship':
      $sub_ = 'client_account/';
      require($main_ . $sub_ . 'ship_detail' . PL);
      break;

      
      
    # About 
    case 'about_us':
      $sub_ = 'about/';
      require($main_ . $sub_ . 'about' . PL);
      break;

    # contact 
    case 'contact_us':
      $sub_ = 'contact/';
      require($main_ . $sub_ . 'contact' . PL);
      break;

    # blog 
    case 'blog':
      $sub_ = 'blog/';
      require($main_ . $sub_ . 'blog_page' . PL);
      break;

    # blog - Single 
    case 'blog_single':
      $sub_ = 'blog/';
      require($main_ . $sub_ . 'single_blog' . PL);
      break;
      
      
    # Ship 
    case 'create_shipment':
      $sub_ = 'create_ship/';
      require($main_ . $sub_ . 'shipment' . PL);
      break;
    
    # Ship 
    case 'create_shipment_success':
      $sub_ = 'create_ship/';
      require($main_ . $sub_ . 'success' . PL);
      break;

   # Ship 
   case 'track_shipment':
    $sub_ = 'track_shipment/';
    require($main_ . $sub_ . 'shipment_track' . PL);
    break;

    # Contact
    case 'contact':
      $sub_ = 'contact/';
      require($main_ . $sub_ . 'contact' . PL);
      break;

    # conditions
    case 'conditions':
      $sub_ = 'conditions/';
      require($main_ . $sub_ . 'conditions' . PL);
      break;

    # privacy
    case 'privacy':
      $sub_ = 'privacy/';
      require($main_ . $sub_ . 'privacy' . PL);
      break;

    # Contact
    case 'cookie':
      $sub_ = 'cookies/';
      require($main_ . $sub_ . 'cookies' . PL);
      break;

    default:
      Redirect::to(DN);
      break;
  endswitch;
endif;


  require $main_ . 'inc/footer' . PL;
?>