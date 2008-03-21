<?php
require_once 'PEAR.php';
require_once 'PEAR/Exception.php';

require_once 'Mvc/Autoloader.php';

$root = dirname(__FILE__);
Mvc_Autoloader::registerClasses(array(
    'Backend_Mvc_Request'=>$root.'/Mvc/Request.php',
    'Backend_Mvc_Response'=>$root.'/Mvc/Response.php',
    'Backend_Mvc_RequestDispatcher'=>$root.'/Mvc/RequestDispatcher.php',
    'Backend_Mvc_RequestDispatcherOnRoutes'=>$root.'/Mvc/RequestDispatcherOnRoutes.php',
    'Backend_Mvc_RequestDispatcherOnFiles'=>$root.'/Mvc/RequestDispatcherOnFiles.php',

    'Backend_Mvc_Routes'=>$root.'/Mvc/Routes.php',

    'Backend_Mvc_View'=>$root.'/Mvc/View.php',
    'Backend_Mvc_View_Template'=>$root.'/Mvc/View/Template.php',
    'Backend_Mvc_View_TemplateXslt'=>$root.'/Mvc/View/TemplateXslt.php',
    'Backend_Mvc_View_Json'=>$root.'/Mvc/View/Json.php',

    'Backend_Mvc_TemplateRenderer'=>$root.'/Mvc/TemplateRenderer.php',
    'Backend_Mvc_TemplateResolver'=>$root.'/Mvc/TemplateResolver.php',

    'Backend_Mvc_TemplateRenderer_Xslt'=>$root.'/Mvc/TemplateRenderer/Xslt.php'
));

/**
 * Abstract base main class.
 * @package Mvc
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
    protected function beforeDispatch($request, $response, $dispatcher)
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

        $this->beforeDispatch($request, $response, $dispatcher);
        $view = $dispatcher->dispatch($request, $response);
        if (!$view) {
            header('HTTP/1.0 404 Not Found');
            throw new PEAR_Exception('Page not found');
        }

        $this->beforeDisplayView($view);
        $view->show($request, $response);

        $response->send();
    }
}
?>