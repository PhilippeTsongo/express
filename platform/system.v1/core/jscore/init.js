// const DN = 'http://127.0.0.1/cns.express/platform/system.v1/'; // SYSTEM PLATFORM
const DN = 'http://127.0.0.1:8081/cns.express/platform/system.v1/'; // SYSTEM PLATFORM
// const DN = 'http://system.afriexpressglobal.cnsplateforme.com/'; // SYSTEM PLATFORM

// const APIGATEWAY = 'http://127.0.0.1/cns.express/core/v1/'; // API
const APIGATEWAY = 'http://127.0.0.1:8081/cns.express/core/v1/'; // API
// const APIGATEWAY = 'http://197.243.24.119/cns.express/core/v1/';

const DNADMIN = DN + '';


const CTRLWSMASTERLGIN = APIGATEWAY + 'cns/api/account/authentification/in';
const CTRLWSMASTERLGOUT = APIGATEWAY + 'cns/api/account/authentification/out';

const API_USER = APIGATEWAY + 'cns/api/account/b2b/user';
const API_CLUSTER = APIGATEWAY + 'cns/api/ship/cluster';
const API_SHIP = APIGATEWAY + 'cns/api/ship';

const _AUTH_ = $('cns').attr('content');
const _ACCESS_ = $("cnsa").attr("content");

export {
    _AUTH_,
    _ACCESS_,
    DNADMIN,
    DN,

    CTRLWSMASTERLGIN,
    CTRLWSMASTERLGOUT,

    API_USER,
    API_CLUSTER,
    API_SHIP

}