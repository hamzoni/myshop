(function(){
    var userData = {};
    window.fbAsyncInit = function() {
        return;
        FB.init({
            appId      : 1766792506971778,
            cookie     : true,
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
        checkLoginState();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            if (response.authResponse) {
                FB.api("/me",
                function (response) {
                    if(response && !response.error) get_userData();
                });
            }
        });
    }

    function fbLogoutUser() {
        FB.getLoginStatus(function(response) {
            if (response && response.status === 'connected') {
                FB.logout(function(response) {
                    document.location.reload();
                });
            }
        });
    }

    function get_userData() {
        FB.api('/me?fields=id,first_name,last_name,email,link,gender,locale,picture',
        function(r) {
            userData.oauth_provider = 'facebook';
            userData.oauth_uid = r.id;
            userData.first_name = r.first_name;
            userData.last_name = r.last_name;
            userData.email = r.email;
            userData.gender = r.gender;
            userData.locale = r.locale;
            userData.picture = r.picture.data.url;
            userData.link = r.link;
        });
    }
})();