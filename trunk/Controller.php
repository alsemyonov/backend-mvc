<?php
class Backend_Controller
{
    public function __construct($request, $response, $session)
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
    }

    protected function createView()
    {
        switch($this->request->wants()) {
            case 'text/html':
                return new Backend_View_Template_Xslt();
            break;
            case 'application/json':
                return new Backend_View_Json();
            break;
            case 'text/xml':
                return new Backend_View_Xml();
            break;
            default:
                return new Backend_View_Dump();
            break;
        }
    }
   
    protected function respond($args)
    {
        if ($args['class']) {
            $viewClass = $args['class'];
            $view = new $viewClass;
        } else {
            $view = $this->createView();
        }

        if (is_a($view, 'Backend_View_Template')) {
            if ($args['file']) {
                $view->getRenderer()->loadFromFile($args['file']);
            }
            if ($args['template']) {
                $view->getRenderer()->loadFromString($args['template']);
            }
        }

        $data = is_array($args['data']) ? $args['data'] : array();
        if (is_a($view, 'Backend_View_Json')) {
            $view->setData($data);
        } else {
            $view->getRenderer()->setData($data);
        }

        return $view;
    }

    protected function index($args)
    {
        return $this->respond(array(
            'data'=>array()
        ));
    }
}
