<?php
namespace app\contact\controller;
use think\Controller;
class Contact extends Controller
{
    public function index()
    {
        $this->assign("title", "请给骑着蜗牛去看海留言!");
        return $this->fetch();
    }
}