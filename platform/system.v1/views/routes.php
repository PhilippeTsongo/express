<?php
$sub_ = 'inc/';
$main_step_folder_ = '';
$sub_step_folder_ = '';

require $main_ . $sub_ . 'header' . PL;

if ('admin/' == $main_):
  switch ($url_struc['tree']):

    # Dashboard
    case '':
      $sub_ = 'home/';
      require($main_ . $sub_ . 'dashboard' . PL);
      break;

    case 'dashboard':
      $sub_ = 'home/';
      require($main_ . $sub_ . 'dashboard' . PL);
      break;

    # Admin
    case 'list_admin':
      $sub_ = 'admin/';
      require($main_ . $sub_ . 'admin_list' . PL);
      break;
    
    case 'new_admin':
      $sub_ = 'admin/';
      require($main_ . $sub_ . 'admin_new' . PL);
      break;

    case 'edit_admin':
      $sub_ = 'admin/';
      require($main_ . $sub_ . 'admin_edit' . PL);
      break;

    # Delivery Agent
    case 'agent_list':
      $sub_ = 'delivery_agent/';
      require($main_ . $sub_ . 'list_agent' . PL);
      break;
    
    case 'new_agent':
      $sub_ = 'delivery_agent/';
      require($main_ . $sub_ . 'agent_new' . PL);
      break;

    case 'edit_agent':
      $sub_ = 'delivery_agent/';
      require($main_ . $sub_ . 'agent_edit' . PL);
      break;


    # Prohibited Product
    case 'prohibited_prod_new':
      $sub_ = 'prohibited_products/';
      require($main_ . $sub_ . 'prohibited_product_new' . PL);
      break;
      
    case 'prohibited_prod_edit':
      $sub_ = 'prohibited_products/';
      require($main_ . $sub_ . 'prohibited_product_edit' . PL);
      break;

    # Prohibited Product
    case 'prohibited_prod_list':
      $sub_ = 'prohibited_products/';
      require($main_ . $sub_ . 'prohibited_product_list' . PL);
      break; 

      
    # Item Type
    case 'item_type_new':
      $sub_ = 'item_types/';
      require($main_ . $sub_ . 'item_type_new' . PL);
      break;

    case 'item_type_edit':
      $sub_ = 'item_types/';
      require($main_ . $sub_ . 'item_type_edit' . PL);
      break;
      
    case 'item_type_list':
      $sub_ = 'item_types/';
      require($main_ . $sub_ . 'item_type_list' . PL);
      break; 


    # Ship Units
    case 'ship_unit_new':
      $sub_ = 'unit/';
      require($main_ . $sub_ . 'ship_unit_new' . PL);
      break;

    case 'ship_unit_edit':
      $sub_ = 'unit/';
      require($main_ . $sub_ . 'ship_unit_edit' . PL);
      break;
      
    case 'ship_unit_list':
      $sub_ = 'unit/';
      require($main_ . $sub_ . 'ship_unit_list' . PL);
      break; 

    # Source Country
    case 'new_source_country':
      $sub_ = 'source_country/';
      require($main_ . $sub_ . 'source_country_new' . PL);
      break;

    case 'edit_source_country':
      $sub_ = 'source_country/';
      require($main_ . $sub_ . 'source_country_edit' . PL);
      break;
      
    case 'source_country_list':
      $sub_ = 'source_country/';
      require($main_ . $sub_ . 'source_country_list' . PL);
      break; 


    # Destination Country
    case 'new_destination_country':
      $sub_ = 'destination_country/';
      require($main_ . $sub_ . 'destination_country_new' . PL);
      break;

    case 'edit_destination_country':
      $sub_ = 'destination_country/';
      require($main_ . $sub_ . 'destination_country_edit' . PL);
      break;
      
    case 'destination_country_list':
      $sub_ = 'destination_country/';
      require($main_ . $sub_ . 'destination_country_list' . PL);
      break; 


    # Ship Package
    case 'package_new':
      $sub_ = 'package/';
      require($main_ . $sub_ . 'package_new' . PL);
      break;

    case 'package_edit':
      $sub_ = 'package/';
      require($main_ . $sub_ . 'package_edit' . PL);
      break;
      
    case 'package_list':
      $sub_ = 'package/';
      require($main_ . $sub_ . 'package_list' . PL);
      break; 
      
    # Package Type
    case 'package_type_new':
      $sub_ = 'package_types/';
      require($main_ . $sub_ . 'package_type_new' . PL);
      break; 
    
    case 'package_type_edit':
      $sub_ = 'package_types/';
      require($main_ . $sub_ . 'package_type_edit' . PL);
      break; 

    case 'package_type_list':
      $sub_ = 'package_types/';
      require($main_ . $sub_ . 'package_type_list' . PL);
      break; 

    #  Partners
    case 'partners':
      $sub_ = 'partners/';
      require($main_ . $sub_ . 'partners_list' . PL);
      break;
      
    case 'new_partner':
      $sub_ = 'partners/';
      require($main_ . $sub_ . 'partners_new' . PL);
      break;

    case 'edit_partner':
      $sub_ = 'partners/';
      require($main_ . $sub_ . 'partners_edit' . PL);
      break;

    #  Shipment
    case 'ship_list':
      $sub_ = 'ship/';
      require($main_ . $sub_ . 'ship_list' . PL);
      break;

    # shipment edit
    case 'ship_edit':
      $sub_ = 'ship/';
      require($main_ . $sub_ . 'ship_edit' . PL);
      break;

    case 'ship_detail':
      $sub_ = 'ship/';
      require($main_ . $sub_ . 'ship_detail' . PL);
      break;

    case 'ship_cost':
      $sub_ = 'ship_cost/';
      require($main_ . $sub_ . 'ship_cost' . PL);
      break;

    case 'ship_cost_new':
      $sub_ = 'ship_cost/';
      require($main_ . $sub_ . 'ship_cost_new' . PL);
      break;

    case 'ship_cost_list':
      $sub_ = 'ship_cost/';
      require($main_ . $sub_ . 'ship_cost_list' . PL);
        break;

    case 'ship_cost_item':
      $sub_ = 'ship_cost_item/';
      require($main_ . $sub_ . 'ship_cost_item' . PL);
      break;

    case 'ship_cost_item_new':
      $sub_ = 'ship_cost_item/';
      require($main_ . $sub_ . 'ship_cost_item_new' . PL);
      break;

    case 'ship_cost_item_list':
      $sub_ = 'ship_cost_item/';
      require($main_ . $sub_ . 'ship_cost_item_list' . PL);
      break;

    case 'ship_item':
      $sub_ = 'ship_item/';
      require($main_ . $sub_ . 'ship_item' . PL);
      break;

    case 'ship_item_new':
      $sub_ = 'ship_item/';
      require($main_ . $sub_ . 'ship_item_new' . PL);
      break;

    case 'ship_item_list':
      $sub_ = 'ship_item/';
      require($main_ . $sub_ . 'ship_item_list' . PL);
      break;



    #  Shipment purpose
    case 'ship_purpose_new':
      $sub_ = 'ship_purpose/';
      require($main_ . $sub_ . 'ship_purpose_new' . PL);
      break;

    case 'ship_purpose_edit':
      $sub_ = 'ship_purpose/';
      require($main_ . $sub_ . 'ship_purpose_edit' . PL);
      break;
      
    case 'ship_purpose_list':
      $sub_ = 'ship_purpose/';
      require($main_ . $sub_ . 'ship_purpose_list' . PL);
      break;
       
    #  Customers
    case 'customers':
      $sub_ = 'customers/';
      require($main_ . $sub_ . 'customers_list' . PL);
      break;

      
    # About
    case 'view_about':
      $sub_ = 'about/';
      require($main_ . $sub_ . 'view_about' . PL);
      break;
    
    case 'new_about':
      $sub_ = 'about/';
      require($main_ . $sub_ . 'about_new' . PL);
      break;

    case 'edit_about':
      $sub_ = 'about/';
      require($main_ . $sub_ . 'about_edit' . PL);
      break;
    
    # Article
    case 'list_article':
      $sub_ = 'article/';
      require($main_ . $sub_ . 'article_list' . PL);
      break;
    
    case 'new_article':
      $sub_ = 'article/';
      require($main_ . $sub_ . 'article_new' . PL);
      break;

    case 'edit_article':
      $sub_ = 'article/';
      require($main_ . $sub_ . 'article_edit' . PL);
      break;

    case 'list_article_comments':
      $sub_ = 'article_comments/';
      require($main_ . $sub_ . 'article_comments_list' . PL);
      break;

    # Events
    case 'list_event':
      $sub_ = 'event/';
      require($main_ . $sub_ . 'event_list' . PL);
      break;
    
    case 'new_event':
      $sub_ = 'event/';
      require($main_ . $sub_ . 'event_new' . PL);
      break;

    case 'edit_event':
      $sub_ = 'event/';
      require($main_ . $sub_ . 'event_edit' . PL);
      break;
    
    # Products
    case 'list_product':
      $sub_ = 'product/';
      require($main_ . $sub_ . 'product_list' . PL);
      break;
    
    case 'new_product':
      $sub_ = 'product/';
      require($main_ . $sub_ . 'product_new' . PL);
      break;

    case 'edit_product':
      $sub_ = 'product/';
      require($main_ . $sub_ . 'product_edit' . PL);
      break;

    # Service
    case 'list_service':
      $sub_ = 'service/';
      require($main_ . $sub_ . 'service_list' . PL);
      break;
    
    case 'new_service':
      $sub_ = 'service/';
      require($main_ . $sub_ . 'service_new' . PL);
      break;

    case 'edit_service':
      $sub_ = 'service/';
      require($main_ . $sub_ . 'service_edit' . PL);
      break;
    
    # Team
    case 'list_team':
      $__STATUS__ = '';
      $sub_ = 'team/';
      require($main_ . $sub_ . 'team_list' . PL);
      break;
    
    case 'new_team':
      $sub_ = 'team/';
      require($main_ . $sub_ . 'team_new' . PL);
      break;

    case 'edit_team':
      $sub_ = 'team/';
      require($main_ . $sub_ . 'team_edit' . PL);
      break;

      
    # Mission/ Vision
    case 'list_mission':
      $__STATUS__ = '';
      $sub_ = 'mission/';
      require($main_ . $sub_ . 'mission_list' . PL);
      break;
    
    case 'new_mission':
      $sub_ = 'mission/';
      require($main_ . $sub_ . 'mission_new' . PL);
      break;

    case 'edit_mission':
      $sub_ = 'mission/';
      require($main_ . $sub_ . 'mission_edit' . PL);
      break;
     
      
    # Partner
    case 'list_partner':
      $__STATUS__ = '';
      $sub_ = 'partner/';
      require($main_ . $sub_ . 'partner_list' . PL);
      break;
    
    case 'new_partner':
      $sub_ = 'partner/';
      require($main_ . $sub_ . 'partner_new' . PL);
      break;

    case 'edit_partner':
      $sub_ = 'partner/';
      require($main_ . $sub_ . 'partner_edit' . PL);
      break;
           
    # Testimonial
    case 'list_testimonial':
      $__STATUS__ = '';
      $sub_ = 'testimonial/';
      require($main_ . $sub_ . 'testimonial_list' . PL);
      break;
    
    case 'new_testimonial':
      $sub_ = 'testimonial/';
      require($main_ . $sub_ . 'testimonial_new' . PL);
      break;

    case 'edit_testimonial':
      $sub_ = 'testimonial/';
      require($main_ . $sub_ . 'testimonial_edit' . PL);
      break;
   
               
    # Gallery
    case 'list_gallery':
      $__STATUS__ = '';
      $sub_ = 'gallery/';
      require($main_ . $sub_ . 'gallery_list' . PL);
      break;
    
    case 'new_gallery':
      $sub_ = 'gallery/';
      require($main_ . $sub_ . 'gallery_new' . PL);
      break;

    case 'gallery':
      $sub_ = 'gallery/';
      require($main_ . $sub_ . 'gallery_edit' . PL);
      break;

    # Gallery
    case 'list_contact_us_requests':
      $__STATUS__ = '';
      $sub_ = 'contact_us/';
      require($main_ . $sub_ . 'contact_us_list' . PL);
      break;

    default:
      Redirect::to(DN);
      break;
  endswitch;

endif;
require($main_ . 'inc/footer' . PL);
?>
