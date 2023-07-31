export class Address 
{
    get_list_province(el_key, Init)
    {
        $.ajax({
            url: Init.CTRLADDRESS,
            type: "POST",
            headers: {
                'Authorization': Init._AUTH_
            },
            data: {
                "request": "kNAwT/bWBO5w1En/S8wyojnwiKLmrgUpDhcsujBSu2I",
                "webToken": "FZrp/HEwJwWCrAH303ypUQ",
            },
            success: function (dataResponse) {
                var response = JSON.parse(dataResponse);
                let output = `<option value="">Select</option>`;
                if (response.status == 1) {
                    for(const index in response.data){
                        let data  = response.data[index];

                        output = output +
                            `<option value="${data.token_id}">${data.name}</option>`;
                    }
                }
                $(el_key).html(output);
            }
        });
    }

    get_list_district_by_province(el_key, ref_value, Init)
    {
        $.ajax({
            url: Init.CTRLADDRESS,
            type: "POST",
            headers: {
                'Authorization': Init._AUTH_
            },
            data: {
                "request": "26B5jcKPZy85ldqlyyabVHGYJxUoXxxZR5A/W3KA1w2+GVBqcGeXwE6FBYJdz9ZR",
                "webToken": "FZrp/HEwJwWCrAH303ypUQ",
                "province": ref_value,
            },
            success: function (dataResponse) {
                var response = JSON.parse(dataResponse);
                let output = `<option value="">Select</option>`;
                if (response.status == 1) {
                    for(const index in response.data){
                        let data  = response.data[index];

                        output = output +
                            `<option value="${data.token_id}">${data.name}</option>`;
                    }
                }
                $(el_key).html(output);
            }
        });
    }

    get_list_sector_by_district(el_key, ref_value, Init)
    {
        $.ajax({
            url: Init.CTRLADDRESS,
            type: "POST",
            headers: {
                'Authorization': Init._AUTH_
            },
            data: {
                "request": "fvYOGmxULeNmYcgfkv04Soe3cOIm3RWP5ZoMTQe0WAQFlf9tAQ/pnn1+rtv2Js04",
                "webToken": "FZrp/HEwJwWCrAH303ypUQ",
                "district": ref_value,
            },
            success: function (dataResponse) {
                var response = JSON.parse(dataResponse);
                let output = `<option value="">Select</option>`;
                if (response.status == 1) {
                    for(const index in response.data){
                        let data  = response.data[index];

                        output = output +
                            `<option value="${data.token_id}">${data.name}</option>`;
                    }
                }
                $(el_key).html(output);
            }
        });
    }

    get_list_cell_by_sector(el_key, ref_value, Init)
    {
        $.ajax({
            url: Init.CTRLADDRESS,
            type: "POST",
            headers: {
                'Authorization': Init._AUTH_
            },
            data: {
                "request": "+6FibAbNHak2HmgazDFAXYhMGf37guiGNt034WO7hzmTKpLxwY6XXGrneyGGrFKV",
                "webToken": "FZrp/HEwJwWCrAH303ypUQ",
                "sector": ref_value,
            },
            success: function (dataResponse) {
                var response = JSON.parse(dataResponse);
                let output = `<option value="">Select</option>`;
                if (response.status == 1) {
                    for(const index in response.data){
                        let data  = response.data[index];

                        output = output +
                            `<option value="${data.token_id}">${data.name}</option>`;
                    }
                }
                $(el_key).html(output);
            }
        });
    }


    get_list_village_by_cell(el_key, ref_value, Init)
    {
        $.ajax({
            url: Init.CTRLADDRESS,
            type: "POST",
            headers: {
                'Authorization': Init._AUTH_
            },
            data: {
                "request": "YVFhB0uD4tq+WOULnWUmXg9Rf0juDoytxc4nOI3cEKQZnkRY15TQ14N5favR3PlT",
                "webToken": "FZrp/HEwJwWCrAH303ypUQ",
                "cell": ref_value,
            },
            success: function (dataResponse) {
                var response = JSON.parse(dataResponse);
                let output = `<option value="">Select</option>`;
                if (response.status == 1) {
                    for(const index in response.data){
                        let data  = response.data[index];

                        output = output +
                            `<option value="${data.token_id}">${data.name}</option>`;
                    }
                }
                $(el_key).html(output);
            }
        });
    }

    reset_select_options(el_keys){
        for(const index in el_keys)
            $(el_keys[index]).html(`<option value="">Select</option>`);
    }
}