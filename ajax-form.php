<?php
    
    session_start();

  
	require('../src/captcha-session.class.php');
    require('../src/captcha.class.php');

    IconCaptcha::setIconsFolderPath('../assets/icons/');

   
    IconCaptcha::setIconNoiseEnabled(true);

   
<!DOCTYPE HTML>
<html>
    <head>
        <title>Cpatcha Generation through PHP Database</title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <meta name="author" content="Fabian Wennink © <?= date('Y') ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="../assets/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link href="../assets/demo.css" rel="stylesheet" type="text/css">

        <!-- Include IconCaptcha stylesheet -->
        <link href="../assets/css/icon-captcha.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">

            

            <div class="shields">
                <img src="https://img.shields.io/badge/Version-2.5.0-orange.svg?style=flat-square" /> <img src="https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square" />
                <img src="https://img.shields.io/badge/Maintained-Yes-green.svg?style=flat-square" /> <a href="https://paypal.me/nlgamevideosnl" target="_blank"><img src="https://img.shields.io/badge/Donate-PayPal-yellow.svg?style=flat-square" /></a>
            </div>

            <div class="section">

                <!-- Captcha message placeholder -->
                <p class="message"></p>

                <!-- Just a basic HTML form, captcha should ALWAYS be placed WITHIN the <form> element -->
                <h2>Form:</h2>
                <form action="form/ajax-submit.php" method="post">

                    <!-- Element that we use to create the IconCaptcha with -->
                    <div class="captcha-holder"></div>

                    <!-- Submit button to test your IconCaptcha input -->
                    <input type="submit" value="Submit demo captcha" class="btn" >
                </form>
            </div>

            
        </div>

        <a href="../">
            <div class="btn btn-bottom">
                <span>GO BACK</span>
            </div>
        </a>

        
            <div class="corner-ribbon top-left">
                STAR ME ON GITHUB
            </div>
        </a>

        <!-- Include Google Font - Just for demo page -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet">

        <!-- Include jQuery Library -->
        <!--[if lt IE 9]>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
        <![endif]-->

        <!--[if (gte IE 9) | (!IE)]><!-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!--<![endif]-->

        <!--
            Script to submit the form(s) with Ajax.

            NOTE: If you want to use FormData instead of .serialize(), make sure to
            include the inputs 'captcha-idhf' and 'captcha-hf' into your FormData object. Take a
            look at the commented code down below.
        -->
        <script type="text/javascript">
            $('form').submit(function(e) {
                e.preventDefault();

                var form = $(this);

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize()
                }).done(function (data) {
                    $('.message').html(data);
                }).fail(function (data) {
                    console.log('Error: Failed to submit form.')
                });

                // FormData example:

                // var captchaID = form.find('input[name="captcha-idhf"]').val();
                // var captchaIcon = form.find('input[name="captcha-hf"]').val();

                // var formData = new FormData();
                // formData.append( 'captcha-idhf', captchaID );
                // formData.append( 'captcha-hf', captchaIcon );

                // $.ajax({
                //     type: 'POST',
                //     url: form.attr('action'),
                //     data: formData,
                //     processData: false,
                //     contentType: false
                // }).done(function (data) {
                //     $('.message').html(data);
                // }).fail(function (data) {
                //     console.log('Error: Failed to submit form.')
                // });
            });
        </script>

        <!-- Include IconCaptcha script -->
        <script src="../assets/js/icon-captcha.min.js" type="text/javascript"></script>

        <!-- Initialize the IconCaptcha -->
        <script async type="text/javascript">
            $(window).ready(function() {
                $('.captcha-holder').iconCaptcha({
                    theme: ['light', 'dark'], // Select the theme(s) of the Captcha(s). Available: light, dark
                    fontFamily: '', // Change the font family of the captcha. Leaving it blank will add the default font to the end of the <body> tag.
                    clickDelay: 500, // The delay during which the user can't select an image.
                    invalidResetDelay: 3000, // After how many milliseconds the captcha should reset after a wrong icon selection.
                    requestIconsDelay: 1500, // How long should the script wait before requesting the hashes and icons? (to prevent a high(er) CPU usage during a DDoS attack)
                    loadingAnimationDelay: 1500, // How long the fake loading animation should play.
                    hoverDetection: true, // Enable or disable the cursor hover detection.
                    showCredits: 'show', // Show, hide or disable the credits element. Valid values: 'show', 'hide', 'disabled' (please leave it enabled).
                    enableLoadingAnimation: true, // Enable of disable the fake loading animation. Doesn't actually do anything other than look nice.
                    validationPath: '../src/captcha-request.php', // The path to the Captcha validation file.
                    messages: { // You can put whatever message you want in the captcha.
                        header: "Select the image that does not belong in the row",
                        correct: {
                            top: "Great!",
                            bottom: "You do not appear to be a robot."
                        },
                        incorrect: {
                            top: "Oops!",
                            bottom: "You've selected the wrong image."
                        }
                    }
                })
                    .bind('init.iconCaptcha', function(e, id) { // You can bind to custom events, in case you want to execute some custom code.
                        console.log('Event: Captcha initialized', id);
                    }).bind('selected.iconCaptcha', function(e, id) {
                    console.log('Event: Icon selected', id);
                }).bind('refreshed.iconCaptcha', function(e, id) {
                    console.log('Event: Captcha refreshed', id);
                }).bind('success.iconCaptcha', function(e, id) {
                    console.log('Event: Correct input', id);
                }).bind('error.iconCaptcha', function(e, id) {
                    console.log('Event: Wrong input', id);
                });
            });
        </script>
    </body>
</html>