<?
// @todo !!! Encoding
class Backend_Mvc_View_Json extends Backend_Mvc_View
{
    protected $data;

    function setHash($data)
    {
        $this->data = $data;
        return $this;
    }

    function getData()
    {
        return $this->data;
    }

    function show($request, $response)
    {
        $response->setEncoding('UTF-8');
        $response->setContentType('text/javascript'); //$response->setContentType('application/x-json');
        $data = json_encode($this->getData());

//        $response->setHeader('X-JSON', $data);
        $response->out($data);
    }
}
?>