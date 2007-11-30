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


    function iconvRec($var)
    {
        if (is_array($var)) {
            $new = array();
            foreach ($var as $k => $v) {
                $new[$this->iconvRec($k)] = $this->iconvRec($v);;
            }
            $var = $new;
        } elseif (is_object($var)) {
            $vars = get_class_vars(get_class($var));
            foreach ($vars as $m => $v) {
                $var->$m = $this->iconvRec($v);
            }
        } elseif (is_string($var)) {
            $var = iconv('windows-1251', 'utf-8', $var);
        }
        return $var;
    }

    function show($request, $response)
    {
        $response->setEncoding('UTF-8');
        $response->setContentType('text/javascript');

        $data = json_encode($this->iconvRec($this->getData()));
        $response->out($data);
    }
}
?>