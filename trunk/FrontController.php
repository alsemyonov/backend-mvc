<?php
require_once 'PEAR.php';
require_once 'PEAR/Exception.php';

/**
 * Front controller class.
 */
abstract class Backend_FrontController
{
    /**
     * Creates request object (factory method).
     */
    protected function createRequest()
    {
        return new Backend_Request();
    }

    /**
     * Creates response object (factory method).
     */
    protected function createResponse()
    {
        return new Backend_Response();
    }

    /**
     * Creates dispatcher object (factory method).
     */
    abstract protected function createDispatcher();

    /**
     * Called before dispatcher starts processing.
     *
     * Here you could set dispatch parameters.
     */
    protected function configureDispatcher(Backend_Request $request, 
                                           Backend_Response $response, 
                                           Backend_RequestDispatcher $dispatcher)
    {
    }

    /**
     * Called after dispatcher ends processing.
     */
    protected function afterDispatch(Backend_View $view, 
                                     Backend_Request $request, 
                                     Backend_Response $response) 
    {
    }

    /**
     * Called before view display.
     */
    protected function configureView(Backend_View $view)
    {
    }

    /** 
     * Called if request dispatching failed.
     */
    protected function dispatchFailed(Backend_Request $request, 
                                      Backend_Response $response)
    {
        header('HTTP/1.1 404 Not Found');
    }

    /**
     * Processes request.
     */
    public function run()
    {
        $request    = $this->createRequest();
        $response   = $this->createResponse();
        $dispatcher = $this->createDispatcher();

        $this->configureDispatcher($request, $response, $dispatcher);
        try {
            $view = $dispatcher->dispatch($request, $response);
        }

        catch(Backend_Exception_PageNotFound $e) {
            $this->dispatchFailed($request, $response);
            throw $e;
        }

        $this->configureView($view, $request, $response);            
        $view->show($request, $response);

        $response->send();
    }
}
?>