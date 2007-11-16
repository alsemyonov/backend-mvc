<?
/**
 * Standard request dispatcher.
 */
class Backend_Mvc_RequestDispatcher implements Backend_Mvc_IRequestDispatcher
{
    protected $routes;

    function setRoutes($routes)
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
            'headers'=>$request->getHeaders(),
            'ip'=>$request->getRemoteAddr()
        );
    }

    /**
     * Returns array of Backend_Mvc_DispatchResult objects and view object.
     *
     * @returns list Result objects and view object or false.
     */
    public function dispatch($request)
    {
        $matches = array();

        $item = $this->routes->find($request->getPath(), &$matches, $this->getRoutesArgs($request));
        if (!$item)
        {
            $e404 = $this->routes->find('/404/', &$matches, $this->getRoutesArgs($request));
            if (!$e404)
            {
                return false;
            }
        }

        return $this->createResult($item, $matches);
    }

    function createResult($item, $matches)
    {
        return new Backend_Mvc_DispatchResult($item, $matches);
    }
}
?>