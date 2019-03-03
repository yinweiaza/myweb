<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\AdminUserModel;
class Logon extends Controller
{
    protected $yw_admin_users_model;
    function _initialize()
    {
        parent::_initialize();
        $this->yw_admin_users_model = new AdminUserModel();
    }
    function index()
    {
        $this->assign('title', '请登陆!');
        return $this->fetch();
    }
    function logon()
    {
        $postData = $this->request->post();
        $fd = Db::name("admin_user")->where('user', $postData['username'])->find();
        if(empty($fd["psw"]))
        {
            $this->error("该用户名不存在");
        }
        if($fd['psw'] != $postData['password'] )
        {
            $this->error("密码不对");
        }else{
            session('id', $fd['id']);
            session('username', $fd['user']);
            $this->success('成功登陆', 'admin/admin/index');
        }
    }
    
}