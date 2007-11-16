<?php
/**
 * Common request dispatcher interface.
 */
interface Backend_Mvc_IRequestDispatcher
{
    /**
     * Dispatch function.
     *
     * It has request object on input and should return array of Backend_Mvc_IDispatchResult objects.
     */
    function dispatch($request);
}
?>