import {CNSEXPRESSVIEWSMASTERVIEWS} from '../../../../core/jscore/views/CNSEXPRESSVIEWSMASTERVIEWS.js';
import {WSCNSAuthentification} from  '../../../../core/jscore/classes/WSCNSAuthentification.js';
import {Functions} from  '../../../../core/jscore/classes/Functions.js';


let FUNCTIONS = new Functions("");
let CNSEXPRESSAUTH = new WSCNSAuthentification("");
let CNSXPRESSMS = new CNSEXPRESSVIEWSMASTERVIEWS("");

// FUNCTIONS.qrCodeImg("google.com");

$('#SignInForm').on('submit', function (e) {
    e.preventDefault();
    CNSEXPRESSAUTH.signin();
    return false;
});

$('#SignUpForm').on('submit', function (e) {
  e.preventDefault();
  CNSEXPRESSAUTH.signup();
  return false;
});

CNSXPRESSMS.cns_view_b2c_ship_lists('#ship-data-table');

CNSXPRESSMS.cns_view_b2c_ship_data('#ship-detail');

CNSXPRESSMS.cns_view_b2c_ship_item_lists('#ship-item-data-table');


CNSXPRESSMS.cns_view_track_ship_status('#ship_status_timeline');

