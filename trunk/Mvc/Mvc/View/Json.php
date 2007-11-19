<?
class Backend_Mvc_View_Json implements Backend_Mvc_IView
{
    function show($request, $response)
    {
        $response->setEncoding('Windows-1251');
        $response->setContentType('');
    }
}
?>