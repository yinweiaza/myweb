<?php

namespace app\blog\controller;
use think\Controller;
use think\Db;
use think\Request;
class Blog extends Controller
{
    public function index()
    {
        $this->assign("title","骑着蜗牛去看海的博客");
        $blogs=Db::name("blog")->select();
        $this->assign('myblogs',$blogs);
        return $this->fetch();
    }
    public function showArticle($id)
    {
        $blog=Db::name("blog")->where("blog_id",$id)->find();
        $this->assign("title",$blog["title"]);
        $this->assign("blogTitle",$blog["title"]);
        $this->assign("content",$blog["content"]);
        $this->assign("postTime",$blog["time"]); 
        $owner=Db::name("admin_user")->where("id",$blog["owner"])->find();
        $this->assign("poster",$owner["user"]);
        $this->assign("watch_num",$blog["watch_num"]);
        $discuss= Db::name("blog_msg")->where("blog_id",$blog["blog_id"])->count();
        $this->assign("discuss",$discuss);
        return $this->fetch("showArticle");
    }
    public function addArticle()
    { 
        $categorys=Db::name("blog_category")->select();    
        
        if( count($categorys) > 0 )
        {
            $this->assign("categorys", $categorys);
        }
        return $this->fetch("add_article",["title"=>"添加新的博文"]);
    }
    public function add_new_category()
    {
        if( Request::instance()->isAjax())
        {
            $requestData = $this->request->post();
            $category=$requestData["newCategory"];
            $descript=$requestData["desc"];
            $maxId= Db::name("blog_category")->max("id");
            Db::name("blog_category")->insert(["id"=>$maxId+1, "category"=>$category]); 
            return json(["category"=>$category]);
        }        
    }
}

