<?php
/**
 * Base controller class for DispatcherOnRoutes. Using this class as base is optional.
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
            throw new Backend_Mvc_Exception('Page not found: dispatch() could not find corresponding method');
        }
        return $this->$action($req, $res, $args);
    }

    /**
     * Displays empty page.
     */
    function index($req, $res, $args)
    {
        return $this->createView(array(), $req, $args);
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