<?php
namespace app\portfolio\controller;
use think\Controller;
class Portfolio extends Controller
{
    public function index()
    {
        $this->assign("title", "骑着蜗牛去看海的相册");
        return $this->fetch();
    }
}