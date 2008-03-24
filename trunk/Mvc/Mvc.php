<?php
require_once 'PEAR.php';
require_once 'PEAR/Exception.php';

require_once 'Mvc/Autoloader.php';

define(B_ROOT, dirname(__FILE__));

Backend_Mvc_Autoloader::registerClasses(array(
    'Backend_Mvc_Request'=>B_ROOT.'/Mvc/Request.php',
    'Backend_Mvc_Response'=>B_ROOT.'/Mvc/Response.php',
    'Backend_Mvc_RequestDispatcher'=>B_ROOT.'/Mvc/RequestDispatcher.php',
    'Backend_Mvc_RequestDispatcherOnRoutes'=>B_ROOT.'/Mvc/RequestDispatcherOnRoutes.php',
    'Backend_Mvc_RequestDispatcherOnFiles'=>B_ROOT.'/Mvc/RequestDispatcherOnFiles.php',

    'Backend_Mvc_Routes'=>B_ROOT.'/Mvc/Routes.php',

    'Backend_Mvc_Controller'=>B_ROOT.'/Mvc/Controller.php',
//    'Backend_Mvc_Controller_CRUD'=>$root.'/Mvc/Controller/CRUD.php',
//    'Backend_Mvc_Controller_CRUD_Doctrine'=>$root.'/Mvc/Controller/CRUD/Doctrine.php',

    'Backend_Mvc_View'=>B_ROOT.'/Mvc/View.php',
    'Backend_Mvc_View_Template'=>B_ROOT.'/Mvc/View/Template.php',
    'Backend_Mvc_View_Template_Xslt'=>B_ROOT.'/Mvc/View/Template/Xslt.php',
    'Backend_Mvc_View_Json'=>B_ROOT.'/Mvc/View/Json.php',

    'Backend_Mvc_TemplateRenderer'=>B_ROOT.'/Mvc/TemplateRenderer.php',
    'Backend_Mvc_TemplateResolver'=>B_ROOT.'/Mvc/TemplateResolver.php',

    'Backend_Mvc_TemplateRenderer_Xslt'=>B_ROOT.'/Mvc/TemplateRenderer/Xslt.php',

    'Backend_Mvc_Exception'=>B_ROOT.'/Mvc/Exception.php'
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
     * Called before view display.
     */
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

        $this->beforeDispatch($request, $response, $dispatcher);
        $view = $dispatcher->dispatch($request, $response);
        if (!$view) {
            $response->notFound();
            throw new Backend_Mvc_Exception('View was not passed to Backend_Mvc. Page not found?');
        }

        $this->beforeDisplayView($view);
        $view->show($request, $response);

        $response->send();
    }
}
?>