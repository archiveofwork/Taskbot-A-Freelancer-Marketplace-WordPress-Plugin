var googleUser = {};
var auth2 = '';
var loader_html = '<div class="tb-preloader-section"><div class="tb-preloader-holder"><div class="tb-loader"></div></div></div>';
var userProfile = '';

/* Google connect */
var taskbot_gconnect_app = function () {

    /* Google sigin response decode */
    function decodeJwtResponse(token) {
        var base64Url = token.split('.')[1];
        var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        var jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));

        return JSON.parse(jsonPayload);
    }

    /* Google sigin callback */
    function handleCredentialResponse(response) {
        const responsePayload = decodeJwtResponse(response.credential);
        jQuery('body').append(loader_html);
        let login_type = 'google';
        let picture = responsePayload.picture;
        let email = responsePayload.email;
        let id = responsePayload.sub;
        let name = responsePayload.name;

        var dataString = 'security=' + scripts_vars.ajax_nonce + '&login_type=' + login_type + '&picture=' + picture + '&email=' + email + '&id=' + id + '&name=' + name + '&action=taskbot_social_login';
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",

            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {

                    StickyAlert(response.message, response.message_desc, { classList: 'success', autoclose: 5000 });
                    window.location.replace(response.redirect);
                } else {
                    StickyAlert(response.message, response.message_desc, { classList: 'danger', autoclose: 5000 });
                }
            }
        });
    }

    /* Google sigin button load */
    window.onload = function () {
        google.accounts.id.initialize({
            client_id: scripts_vars.gclient_id,
            ux_mode: 'popup',
            cancel_on_tap_outside: false,
            callback: handleCredentialResponse
        });
        google.accounts.id.renderButton(
            document.getElementById("google_signin"),
            {
                type: 'standard',
                theme: "outline",
                size: "large",
                logo_alignment: 'center',
                width: '356px',
                text: 'signin_with',
                shape: 'square'
            },
        );

        google.accounts.id.renderButton(
            document.getElementById("google_signup"),
            {
                type: 'standard',
                theme: "outline",
                size: "large",
                logo_alignment: 'center',
                width: '356px',
                text: 'signin_with',
                shape: 'square'
            },
        );

        google.accounts.id.prompt();
    };

};


if (navigator.cookieEnabled) {
    taskbot_gconnect_app();
}
