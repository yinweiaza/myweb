<?php
namespace app\admin\controller;
use think\Controller;
class Resumemanager extends Base
{
    function index()
    {
        if(!session('id'))
        {
            $this->redirect("admin/Logon/index");
        }else{
            $this->assign('title',"简历管理");
            return $this->fetch();        
        }            
    }    
}