export class Functions {
    getPhoneOperator(telephone) {
        if (telephone.substr(0, 5) == '25072' || telephone.substr(0, 5) == '25073')
            return 'AIRTELRW';
        if (telephone.substr(0, 5) == '25078' || telephone.substr(0, 5) == '25079')
            return 'MTNRW';
        return false;
    }

    badge_status_bg(status = 'ACTIVE') {
        let badge_status_bg = 'secondary';
        if (status == 'DEACTIVE')
            badge_status_bg = 'danger';
        if (status == 'OFFLINE')
            badge_status_bg = 'danger';
        return badge_status_bg;
    }


    percentage(number, total) {
        let _percentage_ = number * 100;
        _percentage_ /= (total == 0) ? 1 : total;
        return _percentage_ == 100 ? _percentage_ : (number_format(_percentage_));
    }

    clean_null_value(_key_) {
        return (_key_ == null) ? 0 : _key_;
    }

    number_formater(number) {
        return format_number(number, 1, '.', ' ');
    }

    //number_format(42661.55556, 2, ',', ' ');
    format_number(number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

        var nstr = number.toString();
        nstr += '';
        var x = nstr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }

    urlname(name){
        return name.trim().replace(" ", "-");
    }

    qrCodeImg(qrString){
        jQuery('#qrcodeCanvas').qrcode({
            width: 110, height: 110, text : qrString
        }); 
    }

}