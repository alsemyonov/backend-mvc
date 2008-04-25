<?php
/**
 * Controller base class.
 */
class Backend_Controller
{
    /**
     * Constructor.
     */
    public function __construct(Backend_Request $request, Backend_Response $response, Backend_Session $session)
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
//        $this->configure();
    }

    /**
     * Called from constructor.
     */
//    protected function configure()
//    {
//    }

    /**
     * Respond to application/json request.
     */
    protected function respondJson($data = null) 
    {
        $view = new Backend_View_Json();
        return $view->setData($data);
    }  

    /**
     * Respond to text/xml request.
     */
    protected function respondXml(array $data)
    {
        $view = new Backend_View_Xml();
        return $view->setData($data);
    }

    /**
     * Responds to text/html request.
     */
    protected function respondHtml($class, array $data, $arg, $media = 'file', array $options = array())
    {
        switch(strtolower($class)) {
            case 'xslt':
                $view = new Backend_View_Template_Xslt();
            break;
            default:
                $view = new Backend_View_Template_Php();
            break;
        }

        $view->getRenderer()
            ->setOptions($options)
            ->loadFrom($media, $arg)
            ->setData($data);

        return $view;
    }

    /**
     * Redirects user's browser.
     */
    protected function redirect()
    {
        
    }

    /**
     * Default response handler.
     */
    protected function index($args)
    {
        switch ($this->request->wants()) {
            case 'text/html':
                $this->respondHtml('xslt', array(), B_APP . 'views/index.xsl');
            break;

            case 'application/json':
                $this->respondJson(array());
            break;

            case 'text/xml':
                $this->respondXml(array());
            break;
        }
    }
}
