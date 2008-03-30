<?php
/**
 * Common request dispatcher interface.
 */
abstract class Backend_Mvc_RequestDispatcher
{
    /**
     * Dispatch function.
     *
     * It has request object on input and should return array of Backend_Mvc_IDispatchResult objects.
     */
    abstract public function dispatch($request, $response);
}
?>