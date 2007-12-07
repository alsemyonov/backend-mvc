<?
// @todo !!! Encoding
class Backend_Mvc_View_JsonDk extends Backend_Mvc_View_Json
{
    protected $data;
    protected $JHR;
    
    function __construct() {
        $this->JHR =& new JsHttpRequest('utf-8');
    }

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
        $GLOBALS['_RESULT'] = $this->getData();
    }
}
?>