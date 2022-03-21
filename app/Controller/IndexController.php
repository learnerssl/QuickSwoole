<?php

namespace App\Controller;

use QuickSwoole\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->showMessage('网站首页');
    }
    
    public function login()
    {
        $this->showMessage('登录页面');
    }
}
