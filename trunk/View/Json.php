<?
/**
 * JSON view.
 * @todo Protect from XSS attacks.
 */
class Backend_View_Json extends Backend_View
{
    protected $data;

    function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    function getData()
    {
        return $this->data;
    }

    function show(Backend_Request $request, Backend_Response $response)
    {
        $response->setEncoding('utf-8');
        $response->setContentType('application/json');
//        $response->setContentType('text/html');
        $data = json_encode($this->getData());
        $response->out($data);
    }
}
?>