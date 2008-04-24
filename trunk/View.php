<?
/**
 * Abstract view class.
 */
abstract class Backend_View
{
    /**
     * Outputs view contents. May change response headers such as content-type.
     */
    abstract public function show(Backend_Request $request, Backend_Response $response);
}
?>