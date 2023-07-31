export class HttpRequest
{
    post(APIURL, APIHEADER, APIBODY, APIMETHOD = "POST", APICACHE = false, APIASYNC = false, APICONTENTTYPE = "application/json; charset=utf-8") {
        let response = false;
        $.ajax({
            type: APIMETHOD,
            url: APIURL,
            headers: APIHEADER,
            cache: APICACHE,
            async: APIASYNC,
            data: (APIBODY),
            // contentType: APICONTENTTYPE,
            success: function (msresponse) {
				response = JSON.parse(msresponse);
            }
        });
        return response;
    }

}