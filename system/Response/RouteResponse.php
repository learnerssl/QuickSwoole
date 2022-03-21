<?php

namespace QuickSwoole\Response;

abstract class RouteResponse
{
    public abstract function response($request, $response, $route);
}

