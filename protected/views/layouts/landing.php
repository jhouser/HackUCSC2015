<?php /* @var $this Controller */ ?>
<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="en">

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/landing.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <!-- google+ sign in button config -->
        <meta name="google-signin-clientid" content="1019880111828-rih5k3iugp8k1p7ha550uofhec3cj0jd.apps.googleusercontent.com" />
        <meta name="google-signin-cookiepolicy" content="single_host_origin" />
        <meta name="google-signin-callback" content="signinCallback" />
        <meta name="google-signin-requestvisibleactions" content="https://schema.org/AddAction" />
        <script src="https://apis.google.com/js/client:platform.js?onload=render" async defer>

        </script>
        <script>
            /* Executed when the APIs finish loading */
            function render() {

                // Additional params
                var additionalParams = {
                    'theme': 'dark',
                    'scope': 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/calendar',
                };

                gapi.signin.render('start-button', additionalParams);
            }
            function signinCallback(authResult) {
                delete authResult['g-oauth-window'];
                if (authResult['status']['signed_in']) {
                    // Update the app to reflect a signed in user
                    // Hide the sign-in button now that the user is authorized, for example:
                    $.ajax({
                        url: '',
                        type: 'POST',
                        data: {authResult: authResult},
                        success: function(data) {
                            setTimeout(function(){
                                window.location = data;
                            },2000);
                        }
                    });
                    document.getElementById('signinButton').setAttribute('style', 'display: none');

                } else {
                    // Update the app to reflect a signed out user
                    // Possible error values:
                    //   "user_signed_out" - User is signed-out
                    //   "access_denied" - User denied access to your app
                    //   "immediate_failed" - Could not automatically log in the user
                    console.log('Sign-in state: ' + authResult['error']);
                }
            }
        </script>
    </head>
    <body>


        <div id="gSignInWrapper">
            <div id="start-button" onlclick="return false;">
                <img style = "border:0px;" src = "images/hopscotch_start.png" onmouseover = "this.src = 'images/hopscotch_start_toggle.png'" onmouseout = "this.src = 'images/hopscotch_start.png';" alt = "Button" / >
            </div>
        </div>
    </body>
</html>
