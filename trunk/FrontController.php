<?php
/**
 * Front controller.
 */
abstract class Backend_FrontController
{
    /**
     * Creates and returns request object.
     */
    protected function createRequest()
    {
        return new Backend_Request();
    }

    /**
     * Creates and returns response object.
     */
    protected function createResponse()
    {
        return new Backend_Response();
    }

    /**
     * Creates and returns session object.
     */
    protected function createSession()
    {
        return new Backend_Session();
    }

    /**
     * Dispatches action.
     */
    public function dispatch()
    {   
        $request = $this->createRequest();
        $response = $this->createResponse();
        $session = $this->createSession();

        $this->configure($request, $response, $session);

        list($controller, $action, $args) = $this->getAction($request, $session);
        $controller = new $controller($request, $response, $session);

        $action = array($controller, $action);
        if (is_callable($action)) {
            $view = call_user_func($action, $args);
            $view->show($request, $response, $session);
            $response->send();
        }
    }

    /**
     * Returns controller, action and arguments (parameters) of action.
     */
    abstract public function getAction(Backend_Request $request, Backend_Session $session);

    /**
     * Configures front controller.
     */
    abstract protected function configure(Backend_Request $request, Backend_Response $response, Backend_Session $session);
}