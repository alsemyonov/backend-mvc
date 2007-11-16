<?php
require_once 'Backend/Mvc/Request.php';
require_once 'Backend/Mvc/Response.php';
require_once 'Backend/Mvc/IRequestDispatcher.php';
require_once 'Backend/Mvc/RequestDispatcher.php';
require_once 'Backend/Mvc/Routes.php';
require_once 'Backend/Mvc/IDispatchResult.php';
require_once 'Backend/Mvc/DispatchResult.php';

/**
 * Abstract base main class.
 */
abstract class Backend_Mvc
{
    /**
     * Factory function to create request object.
     */
    protected function createRequest()
    {
        return new Backend_Mvc_Request();
    }

    /**
     * Factory function to create response object.
     */
    protected function createResponse()
    {
        return new Backend_Mvc_Response();
    }

    protected function createDispatcher()
    {
        return new Backend_Mvc_RequestDispatcher();
    }

    abstract protected function beforeDispatch($dispatcher);

    protected function beforeResultRun($result)
    {
    }

    protected function beforeDisplayView($view)
    {
    }

    /**
     * Runs request processing.
     */
    public function run()
    {
        $request = $this->createRequest();
        $response = $this->createResponse();

        $dispatcher = $this->createDispatcher();
        $this->beforeDispatch($dispatcher);

        $result = $dispatcher->dispatch($request);
        $this->beforeResultRun($result);
        $pass = $result->run($request, $response);

        $view = $result->createView();
        $this->beforeDisplayView($view);
        $view->show($pass, $response);

        echo $response->getOutput();
    }
}
?>