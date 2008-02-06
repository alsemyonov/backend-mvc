<?
/* Vendors */ 
require_once 'Backend-dev/Routes/Routes.php';
require_once 'Backend-dev/Mvc/Mvc.php';


/********************  Application *******************/
/* Components, Helpers */
require_once 'controllers/BaseController.php';
require_once 'controllers/client/IndexController.php';
require_once 'controllers/manager/AjaxControllerBase.php';
require_once 'controllers/manager/ManagerController.php';

include B_APP . 'database.php';

include B_APP . 'config.php';

class Application extends Backend_Mvc
{
    static $db;

    function createDispatcher()
    {
        return new Backend_Mvc_RequestDispatcherOnRoutes();
    }

    function beforeDispatch($request, $response, $dispatcher)
    {
        if (!ini_get('session.auto_start') || strtolower(ini_get('session.auto_start')) == 'off') {
            session_start();
        }

        self::$db = getDsn('development');

        $routes = new Backend_Mvc_Routes();

        include B_APP . 'routes.php';

        $dispatcher->setRoutes($routes);
    }
}
