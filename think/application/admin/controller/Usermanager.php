<?php
namespace app\admin\controller;
use think\Controller;
class Usermanager extends Base
{
    function index()
    {
        if(!session('id'))
        {
            $this->redirect("admin/Logon/index");
        }else{
            $this->assign('title',"用户管理");
            return $this->fetch();
        }
    }
}