<?
class ManagerController extends BaseController
{
    static function auth() {
        $cgiAuth = $_REQUEST['http_authorization'];
        if ($cgiAuth)
        {
            $auth = split( ' ', $cgiAuth);
            $loginPw = split( ':', base64_decode( $auth[1] ) );
            
            $_SERVER[ 'PHP_AUTH_USER' ] = $loginPw[ 0 ];
            $_SERVER[ 'PHP_AUTH_PW' ] = $loginPw[ 1 ];
        }

        if ($_REQUEST['logout']) {
            header('WWW-Authenticate: Basic realm="'.B_AUTH_REALM.'"');
            header('HTTP/1.0 401 Unauthorized');
            die;
        }

        if (!isset($_SERVER['PHP_AUTH_USER'])) 
        {
            header('WWW-Authenticate: Basic realm="'.B_AUTH_REALM.'"');
            header('HTTP/1.0 401 Unauthorized');
            die;
        } else {
            if (($_SERVER['PHP_AUTH_USER'] != B_AUTH_LOGIN) || ($_SERVER['PHP_AUTH_PW'] != B_AUTH_PW))
            {
                header('WWW-Authenticate: Basic realm="'.B_AUTH_REALM.'"');
                header('HTTP/1.0 401 Unauthorized');
                die;
            }
        }
    }

    function index($req, $res, $args) {
        self::auth();
        return $this->createView(array(), $args['view'], $req);
    }
}
?>