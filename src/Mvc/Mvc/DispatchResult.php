<?
class Backend_Mvc_DispatchResult implements Backend_Mvc_IDispatchResult
{
    private $request;
    private $item;
    private $matches;

    function __construct($item, $matches)
    {
        $this->request = $request;
        $this->item = $item;
        $this->matches = $matches;
    }

    public function run($request, $response)
    {
        $params = array_merge($this->matches, $this->item->getParams());

        foreach($this->item->getActions() as $action)
        {
            $controllerClass = $action[0];
            $action = $action[1];
            $controller = new $controllerClass();
            if (!is_callable(array($controller, $action)));

            $pass2view[] = call_user_func_array(
                array($controller, $action),
                array($this->request, $response, &$context, $params)
            );
        }

        return $pass2view;
    }

    public function createView()
    {
        $view = split(':',$this->item->getView());
        $viewClass = $view[0];
        $rendererClass = $view[1];
        $fileName = $view[2];
        return new $viewClass($renderClass, $fileName);
    }
}
?>