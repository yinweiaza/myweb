<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\BlogModel;
use think\db\Query;
use think\Request;
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
    function addArticle()
    {
        if(!session('id'))
        {
            $this->redirect("admin/Logon/index");
        }else{
            $this->assign('title',"添加博文");           
            return $this->fetch();
        }
    }
    public function modifyBlog($id)
    {
        Db::name("blog")->where('blog_id',$id)->delete();
        $this->assign('title',"所有博文");
        $blogs=Db::name("blog")->select();
        $this->assign('blogs',$blogs);
        return $this->fetch("index");
    }
    
    public function newBlog()
    {
        if (Request::instance()->isAjax())//            
        {     
            $requestData = $this->request->post();
            $title = $requestData["title"];
            $content = $requestData["content"];
            $keywords = $requestData["keywords"];
            $blogId = Db::name("blog")->max("blog_id") + 1;
            $describe = $requestData["describe"];
            Db::name("blog")->insert([
                'blog_id' => $blogId,
                'title' => $title,
                "content" => $content,
                "time" => date('Y-m-d H:i:s', time()),
                'owner' => session('id')
            ]);
            return json("添加成功！");
        }       
    }
}