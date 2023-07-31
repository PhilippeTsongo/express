export class IOSystem 
{
    println(el_key, el_data){
        $(el_key).html(el_data);
    }
    
    printvl(el_key, el_data){
        $(el_key).val(el_data);
    }

    inputvl(el_key){
        if($(el_key).length)
            return $(el_key).val();
        return '';
    }

    inputattr(el_key, el_attr_key){
        return $(el_key).attr(el_attr_key);
    }

    putvl(el_key, el_data){
        return $(el_key).val(el_data);
    }

    putattr(el_key, el_attr_key, el_data){
        return $(el_key).attr(el_attr_key, el_data);
    }

    puthtml(el_key, el_data){
        return $(el_key).html(el_data);
    }

    exists(el_key){
        return $(el_key).length > 0?true:false;
    }
}