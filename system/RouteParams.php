<?php

namespace QuickSwoole;

use QuickSwoole\Response\NotFoundResponse;

class RouteParams
{
    /**
     * 路由名称
     * @var string
     */
    public $name;
    
    /**
     * 路由匹配规则
     * @var string
     */
    public $route;
    
    /**
     * 命名空间
     * @var string
     */
    public $namespace;
    
    /**
     * 控制器名称
     * @var string
     */
    public $controller;
    
    /**
     * 调用的控制器方法名称
     * @var string
     */
    public $action;
    
    /**
     * 请求方法
     * @var string
     */
    public $method;
    
    public function createResponse($request, $response, $route)
    {
        $this->name = $route->name;
        $this->route = $route->route;
        $this->namespace = $route->namespace;
        $this->controller = $route->controller;
        $this->action = $route->action;
        $this->method = $route->method;
        
        // 判断请求方法是否正确
        if ($this->method != RequestMethod::ALL && $request->server['request_method'] != $this->method) {
            (new NotFoundResponse())->response($request, $response, $this);
            return;
        }
        
        // 判断方法是否存在
        $controllerName = $this->getFullControllerName();
        if (!class_exists($controllerName)) {
            (new NotFoundResponse())->response($request, $response, $this);
        }
        
        $action = $this->action;
        
        // 不存在方法则返回404
        if (!method_exists($controllerName, $action)) {
            (new NotFoundResponse())->response($request, $response, $this);
            return;
        }
        
        // 实例化类
        $controllerObject = new $controllerName($request, $response, $this->name);
        
        // ... 以后的中间件写在这里
        
        // 执行方法
        $controllerObject->$action();
    }
    
    public function getFullControllerName()
    {
        return $this->namespace . $this->controller;
    }
}
