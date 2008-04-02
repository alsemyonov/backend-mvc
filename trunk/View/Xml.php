<?
// @todo !!! Encoding?
/**
 * XML view.
 */
class Backend_Mvc_View_Xml extends Backend_Mvc_View
{
    protected $data;
    protected $rootElement = 'root';

    function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    function getData()
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        $xml .= '<'.$this->rootElement.'>';
        $xml .= Backend_Mvc_TemplateRenderer_Xslt::asXml($this->data);
        $xml .= '</'.$this->rootElement.'>';

        return $xml;
    }

    function show($request, $response)
    {
        $response->setEncoding('UTF-8');
        $response->setContentType('text/xml');

        $response->out($this->getData());
    }
}
?>