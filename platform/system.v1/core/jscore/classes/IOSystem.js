export class IOSystem
{
    println(el_key, el_data) {
        $(el_key).html(el_data);
    }

    printvl(el_key, el_data) {
        $(el_key).val(el_data);
    }

    inputvl(el_key) {
        if ($(el_key).length)
            return $(el_key).val();
        return 'Undefined';
    }

    inputattr(el_key, el_attr_key) {
        return $(el_key).attr(el_attr_key);
    }

    putvl(el_key, el_data) {
        return $(el_key).val(el_data);
    }
    
    
    putselect2vl(el_key, el_data) {
        return $(el_key).select2({val: el_data});
    }

    putattr(el_key, el_attr_key, el_data) {
        return $(el_key).attr(el_attr_key, el_data);
    }

    puthtml(el_key, el_data) {
        return $(el_key).html(el_data);
    }

    exists(el_key){
        return $(el_key).length > 0?true:false;
    }

    jsonForm(formID) {
        const formDataObj = {};
        const myFormData = new FormData(formID[0]);
        myFormData.forEach((value, key) => (formDataObj[key] = value));
        return formDataObj;
    }

    serializeForm(formID) {
        const formDataObj = $(formID).serialize();
        return formDataObj;
    }

}