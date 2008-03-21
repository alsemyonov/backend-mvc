<?
/**
 * Standard request dispatcher.
 * @todo Each dispatcher should be linked to controller's action prototype.
 */
class Backend_Mvc_RequestDispatcherOnRoutes extends Backend_Mvc_RequestDispatcher
{
    protected $routes;

    public function setRoutes($routes)
    {
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
            'jsonQuery'=>$request->getJsonQuery(),
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
        if (!is_callable(array($controller, $action)));

        $result = $controller->$action($request, $response, $params);

        return $result;
    }
}
?>