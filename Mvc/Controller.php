<?php
/**
 * Base controller class for DispatcherOnRoutes. Using this class as base is optional BUT
 * in any class method prototypes should be like this controller index method AND
 * all action() handlers should be public, helper functions and other should be private.
 *
 * @todo Implement view-by-extension.
 * @todo Backend_Mvc_IHashView
 * @todo Kill accept, and make extension accept
 */
class Backend_Mvc_Controller
{
    /**
     * Action dispatch method. Receives action name from routes argument.
     */
    function dispatch($req, $res, $args)
    {      
        $action = strtolower($args['action']);
        if (!$action) $action = array_pop($req->getPathParts());

        if (!method_exists($this, $action)) {
            $res->notFound();
            throw new Backend_Mvc_Exception('Page not found: dispatch() could not find method for '.$action.' in controller '.get_class($this));
        }
        return $this->$action($req, $res, $args, $req->getQuery());
    }

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
    static function auth($realm) {
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
    }

}