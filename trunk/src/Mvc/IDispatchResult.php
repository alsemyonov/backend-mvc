<?php
/**
 * Dispatch result. It is proxy for running requested actions.
 */
interface Backend_Mvc_IDispatchResult
{
    /**
     * Do actions. Returns array of data to View.
     */
    public function run($request, $response);

    /**
     * Returns view object for this request.
     */
    public function createView();
}
?>