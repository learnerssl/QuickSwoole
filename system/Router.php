<?php

namespace QuickSwoole;

use QuickSwoole\Exception\RouteParamException;
use QuickSwoole\Response\NotFoundResponse;

class Router
{
    protected static $routes = [];
    
    protected $namespace = '';
    
    /**
     * 处理路由
     * @param $request
     * @param $response
     */
    public function handle($request, $response)
    {
        $uri = $request->server['request_uri'];
        $route = $this->findRoute($uri);
        if ($route == null) {
            (new NotFoundResponse)->response($request, $response, $route);
            return;
        }
        
        $route_params = new RouteParams();
        $route_params->createResponse($request, $response, $route);
    }
    
    /**
     * 寻找路由
     * @param $uri
     * @return mixed|null
     */
    public function findRoute($uri)
    {
        // 查找规则和方法都匹配的路由
        foreach (self::$routes as $route) {
            if ($route->route == $uri) {
                return $route;
            }
        }
        
        return null;
    }
    
    /**
     * 定义一个 GET 请求路由
     * @param $route
     * @param $controller
     * @throws RouteParamException
     */
    public function get($route, $controller)
    {
        $this->addRoute(RequestMethod::GET, $route, $controller);
    }
    
    /**
     * 定义一个 POST 请求路由
     * @param $route
     * @param $controller
     * @throws RouteParamException
     */
    public function post($route, $controller)
    {
        $this->addRoute(RequestMethod::POST, $route, $controller);
    }
    
    /**
     * 定义一个任意请求皆可的路由
     * @param $route
     * @param $controller
     * @throws RouteParamException
     */
    public function all($route, $controller)
    {
        $this->addRoute(RequestMethod::ALL, $route, $controller);
    }
    
    /**
     * 设置配置参数外部调用方法
     * @param $configs
     * @return $this
     */
    public function setConfig($configs)
    {
        foreach ($configs as $key => $value) {
            $this->createConfig($key, $value);
        }
        
        return $this;
    }
    
    /**
     * 设置参数
     * @param $key
     * @param $value
     */
    protected function createConfig($key, $value)
    {
        switch ($key) {
            case 'namespace':
                $this->namespace = $value;
                break;
        }
    }
    
    /**
     * 路由分组
     * @param $func
     */
    public function group($func)
    {
        $func();
        
        // 执行完成后将参数初始化
        $this->namespace = '';
    }
    
    /**
     * 将路由加入配置数组
     * @param $method
     * @param $route
     * @param $controller
     * @throws RouteParamException
     */
    protected function addRoute($method, $route, $controller)
    {
        $param = new RouteParams();
        
        $param->method = $method;
        $param->route = $route;
        
        // 格式为：控制器@方法名
        $actions = explode('@', $controller);
        
        // 如果不按照规则设置控制器和方法名则抛出异常
        if (count($actions) != 2) {
            throw new RouteParamException('控制器和方法名称错误，应该为：控制器名称@方法名称');
        }
        
        $param->controller = $actions[0];
        $param->action = $actions[1];
        $param->namespace = $this->namespace;
        
        self::$routes[] = $param;
    }
}
