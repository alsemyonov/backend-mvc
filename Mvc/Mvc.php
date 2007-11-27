<?php
require_once 'PEAR.php';
require_once 'PEAR/Exception.php';

require_once 'Mvc/Request.php';
require_once 'Mvc/Response.php';
require_once 'Mvc/RequestDispatcher.php';
require_once 'Mvc/RequestDispatcherOnRoutes.php';
require_once 'Mvc/RequestDispatcherOnFiles.php';
require_once 'Mvc/Routes.php';
require_once 'Mvc/View.php';
require_once 'Mvc/View/Template.php';
require_once 'Mvc/View/TemplateXslt.php';
require_once 'Mvc/TemplateRenderer.php';
require_once 'Mvc/TemplateRenderer/Xslt.php';
require_once 'Mvc/TemplateRenderer/Php.php';
require_once 'Mvc/TemplateResolver.php';
require_once 'Mvc/Controller/Service.php';

/**
 * Abstract base main class.
 */
class Backend_Mvc
{
    /**
     * Factory method to create request object.
     */
    protected function createRequest()
    {
        return new Backend_Mvc_Request();
    }

    /**
     * Factory method to create response object.
     */
    protected function createResponse()
    {
        return new Backend_Mvc_Response();
    }

    /**
     * Factory method to create request dispatcher.
     *
     * By default, it creates Backend_Mvc_RequestDispatcherOnRoutes.
     */
    protected function createDispatcher()
    {
        return new Backend_Mvc_RequestDispatcherOnFiles();
    }

    /**
     * Called before dispatcher starts processing.
     *
     * Here you could set dispatch parameters.
     */
    protected function beforeDispatch($dispatcher)
    {
    }

    /**
     * Called before dispatch results runs.
     */
    protected function beforeResultRun($result)
    {
    }

    /**
     * Called before view display.
     */
    protected function beforeDisplayView($view)
    {
    }

    /**
     * Runs request processing.
     * @todo Dispatch failed.
     */
    public function run()
    {
        $request = $this->createRequest();
        $response = $this->createResponse();

        $dispatcher = $this->createDispatcher();

        $this->beforeDispatch($dispatcher);
        $view = $dispatcher->dispatch($request, $response);
        if (!$view) throw new PEAR_Exception('Page not found');

        $this->beforeDisplayView($view);
        $view->show($request, $response);

        $response->send();
    }
}
?>