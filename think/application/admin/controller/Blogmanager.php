<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\BlogModel;
use think\db\Query;
class Blogmanager extends Base
{
    function index()
    {
        if(!session('id'))
        {
            $this->redirect("admin/Logon/index");
        }else{
            $this->assign('title',"博客管理");
            $blogs=Db::name("blog")->select();
            $this->assign('blogs',$blogs);
            return $this->fetch();
        }
    }
}