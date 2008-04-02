<?php
/**
 */
class Backend_Controller
{
    /**
     * Displays empty page.
     */
    function index($req, $res, $args)
    {
        return array();
    }

    /**
     * Default authentification function.
     * Handles http_authorization value if exists.
     * @todo _REQUEST
     * @todo Right logout.
     */
/*    static function auth($realm) {
        if ($_REQUEST['http_authorization']) {
            $cgiAuth = $_REQUEST['http_authorization'];
            if ($cgiAuth)
            {
                $auth = split( ' ', $cgiAuth);
                $loginPw = split( ':', base64_decode( $auth[1] ) );
            
                $_SERVER['PHP_AUTH_USER'] = $loginPw[ 0 ];
                $_SERVER['PHP_AUTH_PW'] = $loginPw[ 1 ];
            }
        }

        if ($_REQUEST['logout']) {
            header('WWW-Authenticate: Basic realm="'.$realm.'"');
            header('HTTP/1.0 401 Unauthorized');
            die;
        }

        if (!isset($_SERVER['PHP_AUTH_USER'])) 
        {
            header('WWW-Authenticate: Basic realm="'.$realm.'"');
            header('HTTP/1.0 401 Unauthorized');
            die;
        } else {
            if (($_SERVER['PHP_AUTH_USER'] != $realm[0]) || ($_SERVER['PHP_AUTH_PW'] != $realm[1]))
            {
                header('WWW-Authenticate: Basic realm="'.$realm.'"');
                header('HTTP/1.0 401 Unauthorized');
                die;
            }
        }
    }*/
}