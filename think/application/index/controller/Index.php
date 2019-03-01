<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Test;
class Index extends Controller
{
    public function index()
    {
        $this->assign("title", "骑着去看海的个人主页");
        return $this->fetch();
    }
    public  function test()
    {
        $model_test = new Test;
        $model_test->data([
            'user' => 'yinwei',
            'psw' => '119988'
        ]);
        $model_test->save();

        return "nihao";
    }
}
