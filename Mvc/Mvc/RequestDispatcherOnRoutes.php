<?
/**
 * Standard request dispatcher.
 * @todo Each dispatcher should be linked to controller's action prototype.
 * @todo types? vs resolver
 * @todo transfer wants to controller?
 */
class Backend_Mvc_RequestDispatcherOnRoutes extends Backend_Mvc_RequestDispatcher 
{
    /**
     * View classes for different methods.
     */
    protected $viewClasses = array(
        'json'=>'Backend_Mvc_View_Json',
        'html'=>'Backend_Mvc_View_Template_Xslt',
        'rss'=>'Backend_Mvc_View_Rss',
        'xml'=>'Backend_Mvc_View_Xml'
    );

    /**
     * Backend_Mvc_Routes object.
     */
    protected $routes;

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
            'query'=>$request->getQuery(), 
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
                $response->notFound();
                return false;
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
        $method = null;

        if ($args['method']) {
            $methodArg = $args['method'];
            if ($this->viewClasses[$methodArg]) {
                $method = $methodArg;
            }
        }

        $accept = $req->getHeader('Accept');

        if (strpos($accept, 'text/javascript') !== false) {
            $method = 'json';
        }

        if (!$method) $method = 'html';
        $viewClass = $this->viewClasses[$method];

        $view = new $viewClass;
        $view->getRenderer()->setHash($r);

        if (is_callable(array($view->getRenderer(), 'setFileName'))) {
            $view->getRenderer()->setFileName($args['view']);
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

        $action = $item->getAction();
        $controllerClass = $action[0];

        $action = $action[1];
        $controller = new $controllerClass();
        if (!is_callable(array($controller, $action))) {
            throw new Backend_Mvc_Exception('Controller: '.$controller.' action '.$action.' is not callable');
        }

        $result = $controller->$action($request, $response, $params);

        if (($result instanceOf Backend_Mvc_View) || (!$result)) {
            return $result;
        }

        return $this->createView($result, $request, $params);
    }
}
?>