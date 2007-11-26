<?
class Backend_Mvc_Controller_Service
{
    function xmlProxy($req, $res, $args)
    {
        if ($args['source'])
        {
            $xml = DomDocument::load($args['xml']);
        } 

        $view = new Backend_Mvc_View_TemplateXslt();
        return $view->fromXml($xml)->resolve($args['view']);
    }    
}
?>