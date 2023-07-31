import * as Init from '../../../core/jscore/init.js';
import { IOSystem } from '../../../core/jscore/classes/IOSystem.js';
import { Redirect } from '../../../core/jscore/classes/Redirect.js';
let IOSystem_ = new IOSystem();
let RedirectUrl = new Redirect();
const hostname = Init.CTRLWSMASTERLGIN;

// console.log("Hello Ezk");

signin();


function signin() {
    $('#loginForm').on('submit', function() {
        var username = IOSystem_.inputvl('#username');
        var password = IOSystem_.inputvl('#password');


        $('.notif').removeClass('notif-lg-success');
        $('.notif').removeClass('notif-lg-error');
        $('.notif').addClass('hidden');

        if (username.length < 4) {
            $('.notif').removeClass('notif-lg-success');
            $('.notif').removeClass('hidden');
            $('.notif').addClass('notif-lg-error');
            $('.notif').html('Invalid Email Address.');
            return false;
        }

        if (password.length < 4) {
            $('.notif').removeClass('notif-lg-success');
            $('.notif').removeClass('hidden');
            $('.notif').addClass('notif-lg-error');
            $('.notif').html('Invalid Password.');
            return false;
        }
        var auth = 'Basic ' + btoa(new Date().getTime() + '::' + username + '::' + password + '::CNSPTF.200450');

        $('.notif').removeClass('notif-lg-error');
        $('.notif').removeClass('notif-lg-success');
        $('.notif').removeClass('hidden');
        $('.notif').addClass('notif-lg-info');
        IOSystem_.puthtml('.notif', "Procing Login Request ...");

        $.ajax({
            url: hostname,
            type: "POST",
            headers: {
                'Authorization': auth
            },
            data: {},
            cache: false,
            success: function(dataResponse) {
                
                var response = (dataResponse);
                IOSystem_.puthtml('#login', 'Login');

                if (response.status == 200) {

                    $('.notif').removeClass('notif-lg-error');
                    $('.notif').removeClass('notif-lg-info');
                    $('.notif').removeClass('hidden');
                    $('.notif').addClass('notif-lg-success');
                    IOSystem_.puthtml('.notif', response.message);
                    setTimeout(function() { window.location = 'oauth_/' + btoa(JSON.stringify(response)) }, 1000);
                } else {
                    $('.notif').removeClass('notif-lg-success');
                    $('.notif').removeClass('notif-lg-info');
                    $('.notif').removeClass('hidden');
                    $('.notif').addClass('notif-lg-error');
                    IOSystem_.puthtml('.notif', response.message);
                    return false;
                }
            }
        });
        return false;
    });
}