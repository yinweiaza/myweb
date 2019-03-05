<?php
namespace app\admin\controller;
use think\Controller;
class Blogmanager extends Base
{
    function index()
    {
        if(!session('id'))
        {
            $this->redirect("admin/Logon/index");
        }else{
            $this->assign('title',"博客管理");
            return $this->fetch();
        }        
    }    
}