<?php

namespace QuickSwoole;

class Controller
{
    protected $request, $response;
    
    protected $route;
    
    public function __construct($request, $response, $route)
    {
        $this->request = $request;
        $this->response = $response;
        $this->route = $route;
    }
    
    public function showMessage($message)
    {
        $this->response->header("Content-Type", "text/html; charset=utf-8");
        $this->response->end($message);
    }
}
