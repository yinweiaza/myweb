<?php
namespace app\admin\controller;
use think\Controller;
class Photomanager extends Base
{
    function index()
    {
        if(!session('id'))
        {
            $this->redirect("admin/Logon/index");
        }else{
            $this->assign('title',"相册管理");
            return $this->fetch();    
        }
        
    }
    
}