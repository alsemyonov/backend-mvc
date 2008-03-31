<?php
require_once 'PEAR.php';
require_once 'PEAR/Exception.php';

/**
 * Front controller class.
 */
class Backend_FrontController
{
    /**
     * Factory method to create request object.
     */
    protected function createRequest()
    {
        return new Backend_Request();
    }

    /**
     * Factory method to create response object.
     */
    protected function createResponse()
    {
        return new Backend_Response();
    }

    /**
     * Factory method to create request dispatcher.
     *
     * By default, it creates Backend_Mvc_RequestDispatcherOnRoutes.
     */
    protected function createDispatcher()
    {
        return new Backend_RequestDispatcher_Routes();
    }

    /**
     * Called before dispatcher starts processing.
     *
     * Here you could set dispatch parameters.
     */
    protected function beforeDispatch($request, $response, $dispatcher)
    {
    }

    /**
     * Called after dispatcher ends processing.
     */
    protected function afterDispatch($view, $request, $response) 
    {
    }

    /**
     * Called before view display.
     */
    protected function beforeDisplayView($view)
    {
    }

    /** 
     * Called if request dispatching failed.
     */
    protected function dispatchFailed($request, $response)
    {
        header('HTTP/1.1 404 Not Found');
    }

    /**
     * Runs request processing.
     */
    public function run()
    {
        $request = $this->createRequest();
        $response = $this->createResponse();
        $dispatcher = $this->createDispatcher();

        $this->beforeDispatch($request, $response, $dispatcher);
        try {
            $view = $dispatcher->dispatch($request, $response);
        }

        catch(Backend_Exception_PageNotFound $e) {
            $this->dispatchFailed($request, $response);
            throw $e;
        }

        $this->afterDispatch($view, $request, $response);            
        $view->show($request, $response);

        $response->send();
    }
}
?>