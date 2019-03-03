<?php
namespace app\admin\controller;
use think\Controller;
class Admin extends Controller
{
	public function index()
	{
		//检测是否已经登录；
		if (!session('id'))    //redirect;
		{
		    $this->redirect('admin/Logon/index');
        } else {
            $this->assign('title', "骑着蜗牛去看海的后台");
            return $this->fetch();		    
		}

	}	
}