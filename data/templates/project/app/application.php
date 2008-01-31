<?
/* Vendors */ 
require_once 'Backend-dev/Routes/Routes.php';
require_once 'Backend-dev/Mvc/Mvc.php';


/********************  Application *******************/
/* Models */
#require_once 'models/rBaseModel.php';
#require_once 'models/rUserModel.php';

/* Components, Helpers */
#require_once 'controllers/Flash.php';
#require_once 'controllers/Auth.php';
#require_once 'views/helpers/bDateHelper.php';

/* Controllers */
#require_once 'controllers/application.php';
#require_once 'controllers/rSessionsController.php';
#require_once 'controllers/rUsersController.php';

include B_APP . 'database.php';

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

        include B_APP . 'routes.php';

        $dispatcher->setRoutes($routes);
    }
}
