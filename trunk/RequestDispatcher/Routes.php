<?
/**
 * Standard request dispatcher.
 * @todo Each dispatcher should be linked to controller's action prototype.
 * @todo types? vs resolver
 * @todo transfer wants to controller?
 * @todo setViewTypeClass?
 */
class Backend_RequestDispatcher_Routes extends Backend_RequestDispatcher 
{
    /**
     * Backend_Mvc_Routes object.
     */
    protected $routes;

    /**
     * View classes for different methods.
     */
    protected $viewClasses = array(
        'application/json'=>'Backend_View_Json',
        'text/html'=>'Backend_View_Template_Xslt',
        'text/rss'=>'Backend_View_Rss',
        'text/xml'=>'Backend_View_Xml'
    );

    /**
     * Attaches routes to dispatcher.
     */
    public function setRoutes($routes) {
        $this->routes = $routes;
    }

    /**
     * Returns array to use with Backend_Routes::find(). 
     * If you want to use extra arguments such as session values or request headers, 
     * you should override this function.
     *
     * @returns array Backend_Routes::find() arguments.
     */
    public function getRoutesArgs($request)
    {
        return array(
            'host'=>$request->getHost(),
            'port'=>$request->getPort(),
            'request'=>$request->getRequest(), 
            'headers'=>$request->getHeaders(),
            'method'=>$request->getMethod(),
            'ip'=>$request->getRemoteAddr()
        );
    }

    /**
     * Returns view if request has dispatched and false if request is not dispatched.
     *
     * @returns list Result objects and view object or false.
     */
    public function dispatch($request, $response)
    {
        $matches = array();
        $item = $this->routes->find($request->getPath(), &$matches, $this->getRoutesArgs($request));
        if (!$item) {
            $item = $this->routes->find('/404/', &$matches, $this->getRoutesArgs($request));
            if (!$item) {
                throw new Backend_Exception_PageNotFound();
            }
        }

        return $this->run($item, $matches, $request, $response);
    }

    /**
     * Sets view type class.
     */
    public function setViewTypeClass($type, $class) 
    {
        $this->viewClasses[$type] = $class;
    }

    /**
     * Creates view. View type depends on extension, routes parameter and accept parameter.
     */
    function createView($r, $req, $args) {
        $mime = $req->wants();
        $viewClass = $this->viewClasses[$mime];
        $view = new $viewClass;

        if (is_callable(array($view, 'getRenderer'))) {
            $view->getRenderer()->setData($r);
            $view->getRenderer()->loadFromFile($args['view']);
        } else {
            $view->setHash($r);
        }

        return $view;
    }

    /**
     * Do actions. Returns View.
     * @todo controller class provider.
     */
    protected function run($item, $matches, $request, $response)
    {
        $params = array_merge($matches, $item->getParams());
        $pass2view = array();

        $controllerClass = $params['controller'];
        $action = $params['action'];
        if ($controllerClass && !$action) {
            $action = 'index';
        }

        if (!$controllerClass) {
            throw new Backend_Exception('Controller class is empty');
        }

        $controller = new $controllerClass();
        if (!is_callable(array($controller, $action))) {
            throw new Backend_Exception('Controller: '.$controllerClass.' action '.$action.' is not callable');
        }

        $result = $controller->$action($request, $response, $params, $request->getRequest());

        if (($result instanceOf Backend_View) || (!is_array($result))) {
            return $result;
        }

// !!!
        if (!$params['view']) {
            $params['view'] = str_replace($controllerClass, 'Controller', '').'_'.$action.'.xsl';
        }

        return $this->createView($result, $request, $params);
    }
}
?>