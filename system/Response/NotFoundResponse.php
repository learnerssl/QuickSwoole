<?php

namespace QuickSwoole\Response;

class NotFoundResponse extends RouteResponse
{
    public function response($request, $response, $route)
    {
        $response->header("Content-Type", "text/html; charset=utf-8");
        $response->end('不存在页面，404');
    }
}

