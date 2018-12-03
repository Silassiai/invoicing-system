<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 14:54
 * Authenticate
 *
 */

namespace hooks;

use models\ModelUser as ModelUser;

use core\Application as Application;


class Authenticate
{
    CONST COMPANY_LOGO = 'url_to_companylogo.png';
    CONST BTN_COLOR = '#337ab7';

    /**
     * check
     * start session
     * check if user has logged in, show login screen if not logged in
     */
    final public static function check()
    {
        if (isset(Application::$request['logout'])) {
            Application::sessionDestroy(true);
        }

        if (isset(Application::$request['username']) && isset(Application::$request['password'])) {

            //TODO: add user table and uncomment this lines to get the real authentication to work
//            $model_user = new ModelUser();
//            $user = $model_user->checkUserCredentials(
//                Application::$request['username'],
//                md5(Application::$request['password'])
//            );
//
//            if(is_object($user) && $user !== false){
            Application::$sess_ref['user'] = Application::$request['username'];
//            }

        }

        if (!isset(Application::$sess_ref['user'])) {
            self::showLogin();
        }

        self::showLogout();
    }

    public function checkAuth()
    {
        self::check();
    }

    /**
     * showLogin
     * Show login page
     * TODO: this wil be the default login page if not is defined in a controller
     */
    final private static function showLogin()
    {
        ; ?>
        <html>
        <head>
            <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>

            <style>
                body {
                    font-family: 'Open Sans', sans-serif;
                    background: #f8f8f8;
                    margin: 0 auto 0 auto;
                    width: 100%;
                    text-align: center;
                    margin: 20px 0px 20px 0px;
                }

                p {
                    font-size: 12px;
                    text-decoration: none;
                    color: #ffffff;
                }

                h1 {
                    font-size: 1.5em;
                    color: #525252;
                }

                .box {
                    background: white;
                    width: 300px;
                    border-radius: 6px;
                    margin: 150 auto 0 auto;
                    padding: 0px 0px 70px 0px;
                    border: #e8e8e8 4px solid;
                }

                .email {
                    background: #ecf0f1;
                    border: #ccc 1px solid;
                    border-bottom: #ccc 2px solid;
                    padding: 8px;
                    width: 250px;
                    color: #AAAAAA;
                    margin-top: 10px;
                    font-size: 1em;
                    border-radius: 4px;
                }

                .password {
                    border-radius: 4px;
                    background: #ecf0f1;
                    border: #ccc 1px solid;
                    padding: 8px;
                    width: 250px;
                    font-size: 1em;
                }

                .btn {
                    background: <?php echo Authenticate::BTN_COLOR; ?>;
                    padding-top: 10px;
                    padding-bottom: 10px;
                    color: white;
                    border-radius: 4px;
                    margin-top: 20px;
                    margin-bottom: 20px;
                    margin-left: 25px;
                    margin-right: 25px;
                    font-weight: 800;
                    font-size: 1.0em;
                }

                .btn:hover {
                    background: #000000;
                }

                #btn2 {
                    float: left;
                    background: #3498db;
                    width: 125px;
                    padding-top: 5px;
                    padding-bottom: 5px;
                    color: white;
                    border-radius: 4px;
                    border: #2980b9 1px solid;

                    margin-top: 20px;
                    margin-bottom: 20px;
                    margin-left: 10px;
                    font-weight: 800;
                    font-size: 0.8em;
                }

                #btn2:hover {
                    background: #3594D2;
                }

                .company-logo {
                    margin: 20px;
                }

                a {
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
        <form method="post" action="">
            <div class="box">
                <img src="<?php echo Authenticate::COMPANY_LOGO; ?>" class="company-logo">

                <input type="text" name="username" placeholder="gebruiker" onFocus="field_focus(this, 'email');"
                       onblur="field_blur(this, 'email');" class="email"/>

                <input type="password" name="password" placeholder="password" onFocus="field_focus(this, 'email');"
                       onblur="field_blur(this, 'email');" class="email"/>

                <a href="#">
                    <div class="btn">Login</div>
                </a> <!-- End Btn -->

            </div> <!-- End Box -->

        </form>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
        <script>
            function field_focus(field, email) {
                if (field.value == email) {
                    field.value = '';
                }
            }

            function field_blur(field, email) {
                if (field.value == '') {
                    field.value = email;
                }
            }

            //Fade in dashboard box
            $(document).ready(function () {
                $('.box').hide().fadeIn(1000);
            });

            //Stop click event
            $('a').click(function (event) {
                event.preventDefault();
                $('form').submit();
            });
        </script>
        </body>
        </html>
        <?php
        exit;
    }

    /**
     * showLogout
     * add login on top of the screen
     */
    final public static function showLogout()
    {
        ; ?>
        <form method="post" action="<?php echo str_replace('index.php', '', $_SERVER['PHP_SELF']); ?>">
            <input type="hidden" name="logout">
            <input type="submit" value="Log uit">
            </div> <!-- End Box -->
        </form>
        <?php
    }

}