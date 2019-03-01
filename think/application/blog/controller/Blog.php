<?php

namespace app\blog\controller;
use think\Controller;

class Blog extends Controller
{
    public function index()
    {
        $this->assign("title","骑着蜗牛去看海的博客");
        return $this->fetch();
    }
}

