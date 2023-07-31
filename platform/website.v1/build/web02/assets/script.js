import {CNSESHOPVIEWSMASTERVIEWS} from '../../../../core/jscore/views/CNSESHOPVIEWSMASTERVIEWS.js';
import {WSCNSAuthentification} from  '../../../../core/jscore/classes/WSCNSAuthentification.js';

let CNSESHOPAUTH = new WSCNSAuthentification("");
let CNSESHOPMS = new CNSESHOPVIEWSMASTERVIEWS("");


$('#SignInForm').on('submit', function (e) {
    e.preventDefault();
    CNSESHOPAUTH.signin();
    return false;
});

$('#SignUpForm').on('submit', function (e) {
  e.preventDefault();
  CNSESHOPAUTH.signup();
  return false;
});



CNSESHOPMS.cns_view_section_subclassification("._cns_view_section_subclass_home_");

CNSESHOPMS.cns_view_home_section_popular_products("._cns_view_home_section_popular_products_");

CNSESHOPMS.cns_view_footer_section_social_media_company_name_address(
  "._cns_view_footer_section_info_company_", 
  "._cns_view_footer_section_info_address_", 
  "._cns_view_footer_section_social_media_link_"
);

