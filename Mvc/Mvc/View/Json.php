<?
/**
 * JSON view.
 * @todo Protect from XSS attacks.
 */
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
        $response->setEncoding('utf-8');
//        $response->setContentType('application/json');
        $response->setContentType('text/plain');
        $data = json_encode($this->getData());
        $response->out($data);
    }
}
?>