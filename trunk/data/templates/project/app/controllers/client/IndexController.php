<?php
class IndexController extends BaseController {
    function index($req, $res, $args) {
        return $this->createView(array(), $args['view'], $req);
    }
}