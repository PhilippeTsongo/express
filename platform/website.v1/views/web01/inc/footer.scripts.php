
    <script type="text/javascript" src="<?=DNADMIN?>/build/vendor/jquery.qrcode/jquery.qrcode.js"></script>
    <script type="text/javascript" src="<?=DNADMIN?>/build/vendor/jquery.qrcode/qrcode.js"></script>

    <script>
    jQuery('#qrcodeCanvas').qrcode({
        width: 110, height: 110, text : "${CODE_STRING}"
    }); 
    </script>

 <script type="text/javascript">
        var recaptcha_widgets = {};

        function wp_recaptchaLoadCallback() {
            try {
                grecaptcha;
            } catch (err) {
                return;
            }
            var e = document.querySelectorAll ? document.querySelectorAll('.g-recaptcha:not(.wpcf7-form-control)') : document.getElementsByClassName('g-recaptcha'),
                form_submits;

            for (var i = 0; i < e.length; i++) {
                (function(el) {
                    var wid;
                    // check if captcha element is unrendered
                    if (!el.childNodes.length) {
                        wid = grecaptcha.render(el, {
                            'sitekey': '6LfmEKAaAAAAAJGwYMNSdux-yATrkwZcw6GT6N41',
                            'theme': el.getAttribute('data-theme') || 'light'
                        });
                        el.setAttribute('data-widget-id', wid);
                    } else {
                        wid = el.getAttribute('data-widget-id');
                        grecaptcha.reset(wid);
                    }
                })(e[i]);
            }
        }

        // if jquery present re-render jquery/ajax loaded captcha elements
        if (typeof jQuery !== 'undefined')
            jQuery(document).ajaxComplete(function(evt, xhr, set) {
                if (xhr.responseText && xhr.responseText.indexOf('6LfmEKAaAAAAAJGwYMNSdux-yATrkwZcw6GT6N41') !== -1)
                    wp_recaptchaLoadCallback();
            });
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=wp_recaptchaLoadCallback&amp;render=explicit" async defer></script>
    <!-- END recaptcha -->
    <style id='bt-custom-style-inline-css' type='text/css'>
        .btMenuVerticalLeft .btCloseVertical:before,
        .btMenuVerticalRight .btCloseVertical:before {
            background: none;
        }
    </style>
    <script type='text/javascript' src='wp-includes/js/comment-reply.min6a4d.js?ver=6.1.1' id='comment-reply-js'></script>
    <script type='text/javascript' src='wp-content/plugins/contact-form-7/includes/swv/js/index77e1.js?ver=5.6.4' id='swv-js'></script>
    <script type='text/javascript' id='contact-form-7-js-extra'>
        /* <![CDATA[ */
        var wpcf7 = {
            "api": {
                "root": "https:\/\/cargo.bold-themes.com\/transport-company\/wp-json\/",
                "namespace": "contact-form-7\/v1"
            }
        };
        /* ]]> */
    </script>
    <script type='text/javascript' src='wp-content/plugins/contact-form-7/includes/js/index77e1.js?ver=5.6.4' id='contact-form-7-js'></script>
    <script type='text/javascript' src='wp-content/plugins/duracelltomi-google-tag-manager/js/gtm4wp-form-move-tracker34dd.js?ver=1.16.1' id='gtm4wp-form-move-tracker-js'></script>
    <script type='text/javascript' src='https://www.google.com/recaptcha/api.js?render=6LfmEKAaAAAAAJGwYMNSdux-yATrkwZcw6GT6N41&amp;ver=3.0' id='google-recaptcha-js'></script>
    <script type='text/javascript' src='wp-includes/js/dist/vendor/regenerator-runtime.min3937.js?ver=0.13.9' id='regenerator-runtime-js'></script>
    <script type='text/javascript' src='wp-includes/js/dist/vendor/wp-polyfill.min2c7c.js?ver=3.15.0' id='wp-polyfill-js'></script>
    <script type='text/javascript' id='wpcf7-recaptcha-js-extra'>

/* <![CDATA[ */
        var wpcf7_recaptcha = {
            "sitekey": "6LfmEKAaAAAAAJGwYMNSdux-yATrkwZcw6GT6N41",
            "actions": {
                "homepage": "homepage",
                "contactform": "contactform"
            }
        };
        /* ]]> */
    </script>
    <script type='text/javascript' src='wp-content/plugins/contact-form-7/modules/recaptcha/index77e1.js?ver=5.6.4' id='wpcf7-recaptcha-js'></script>
    <script type='text/javascript' id='cargo-set-global-uri-script-js-after'>
        window.BTURI = "https://cargo.bold-themes.com/wp-content/themes/cargo/";
        window.BTAJAXURL = "wp-admin/admin-ajax.html";
        window.bt_text = [];
        window.bt_text.previous = 'previous';
        window.bt_text.next = 'next';
    </script>
    <script src="<?= DNADMIN . _ . 'views' . _ . $main_ . $sub_ . $main_step_folder_ . $sub_step_folder_ . 'scripts/script.js' ?>" type="module"></script>


    <script type='text/javascript' src='wp-includes/js/jquery/ui/core.min3f14.js?ver=1.13.2' id='jquery-ui-core-js'></script>
    <script type='text/javascript' src='wp-includes/js/jquery/ui/datepicker.min3f14.js?ver=1.13.2' id='jquery-ui-datepicker-js'></script>
    <script type='text/javascript' src='wp-includes/js/jquery/ui/mouse.min3f14.js?ver=1.13.2' id='jquery-ui-mouse-js'></script>
    <script type='text/javascript' src='wp-includes/js/jquery/ui/slider.min3f14.js?ver=1.13.2' id='jquery-ui-slider-js'></script>
    <script type='text/javascript' src='wp-content/plugins/bt_cost_calculator/jquery.ui.touch-punch.min6a4d.js?ver=6.1.1' id='bt_touch-punch_js-js'></script>
    <script type='text/javascript' src='wp-content/plugins/cargo/bt_parallax6a4d.js?ver=6.1.1' id='bt_parallax-js'></script>
    <script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBda9LxQ-Wztqsk6aFI7SkcdiypnKTPfiI&amp;ver=6.1.1' id='gmaps_api-js'></script>
    <script type='text/javascript' src='wp-content/plugins/cargo/bt_gmap6a4d.js?ver=6.1.1' id='bt_gmap_init-js'></script>
   


</body>
</html>