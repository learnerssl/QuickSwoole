<?php

namespace App\Controller;

use QuickSwoole\Controller;

class UserController extends Controller
{
    public function index()
    {
        $this->showMessage('用户中心');
    }
    
    public function loginSubmit()
    {
        $this->showMessage('注册成功！');
    }
}
