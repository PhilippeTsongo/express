// const DN = 'http://127.0.0.1/cns.express/platform/website.v1/'; //  PLATFORM
const DN = 'http://127.0.0.1:8081/cns.express/platform/website.v1/'; //  PLATFORM
// const DN = 'http://afriexpressglobal.cnsplateforme.com/'; //  PLATFORM


// const APIGATEWAY = 'http://127.0.0.1/cns.express/core/v1/'; 
const APIGATEWAY = 'http://127.0.0.1:8081/cns.express/core/v1/';
// const APIGATEWAY = 'http://197.243.24.119/cns.express/core/v1/'; 


const DNWEB = DN + '';

// const DNCLOUDIMAGE = 'http://127.0.0.1/cns.express/cloud/images/image/';
// const DNCLOUDIMAGE = 'http://127.0.0.1:8081/cns.express/cloud/images/image/';
const DNCLOUDIMAGE = 'http://cloud.cnsplateforme.com/';


// const DNSHIPQR = 'http://127.0.0.1/cns.express/resource/data_system/shipqr/';
// const DNSHIPQR = 'http://127.0.0.:8081/cns.express/resource/data_system/shipqr/';
const DNSHIPQR = 'http://197.243.24.119/cns.express/cloud/images/qr';

const APIUSERACCOUNT = APIGATEWAY + 'account/user';

const API_CLUSTER = APIGATEWAY + 'cns/api/ship/cluster';

const APIAUTHSIGNIN = APIGATEWAY + 'cns/master/api/customer/auth/in';
const APIAUTHSIGNOUT = APIGATEWAY + 'cns/master/api/customer/auth/out';
const APIAUTHSIGNUP = APIGATEWAY + 'cns/master/api/customer/sign/up';

const APICNSEXPRESS = APIGATEWAY + 'cns/master/api/ship';
const APICNSEXPRESSACTION = APIGATEWAY + 'cns/master/api/ship/action';

export {
    DNWEB,
    DNCLOUDIMAGE,

    APIUSERACCOUNT,

    APIAUTHSIGNIN,
    APIAUTHSIGNOUT,
    APIAUTHSIGNUP,

    APICNSEXPRESS,
    APICNSEXPRESSACTION,

    API_CLUSTER,
    DNSHIPQR
}