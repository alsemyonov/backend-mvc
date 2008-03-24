<?
/**
 * Abstract view class.
 * @todo Abstract function to get View's content
 */
abstract class Backend_Mvc_View
{
    /**
     * Outputs view contents. May change response headers such as content-type.
     */
    abstract public function show($request, $response);
}
?>