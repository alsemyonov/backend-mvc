<?
require_once 'Backend-dev/Routes/Routes.php';
require_once 'Backend-dev/Mvc/Mvc.php';

define('BACKEND_MVC_ROUTES_XML', 'config/routes.xml');

class XmlTestSite extends Backend_Mvc
{
    function beforeDispatch($dispatcher)
    {
        $routes = new Backend_Mvc_Routes();

        if (!file_exists(BACKEND_MVC_ROUTES_XML)) throw new PEAR_Exception('Routing map does not exists');
        $map = new SimpleXmlElement(file_get_contents(BACKEND_MVC_ROUTES_XML));

        foreach($map->item as $item)
        {
            $routes->add()
                ->url((string)$item->url)
                ->view((string)$item->view)
                ->action('Backend_Mvc_Controller_Service', 'index');
        }

        $dispatcher->setRoutes($routes);
    }
}


$wbd = new XmlTestSite();
$wbd->run();
?>