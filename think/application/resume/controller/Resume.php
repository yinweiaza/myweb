<?php
namespace app\resume\controller;
use think\Controller;
class Resume extends Controller
{
    public function index()
    {
        $this->assign("title", "骑着蜗牛去看海的简历");
        return $this->fetch();
    }
}