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
    public function articleManager()
    {
        $categorys=Db::name("blog_category")->select();
        $this->assign("categorys",$categorys);
        $blogs=Db::name("blog")->select();
        $blogCount=count($blogs);  
        $pageIndex="";
        $limit=5;
        for($bg=0;$bg<$blogCount;$bg++)
        {
            if($bg > $limit) break;
            $msgCount=Db::name("blog_msg")->where("blog_id",$blogs[$bg]["blog_id"])->count();
            $blogs[$bg]["msg_num"]=$msgCount;
            if($bg==0)
                $pageIndex=$pageIndex.'<li class="active"><a href="/public/blog/blog/gotoPage/page/'.($bg+1).'.html">'.($bg+1).'</a></li>';
            else 
            $pageIndex=$pageIndex.'<li><a href="/public/blog/blog/gotoPage/page/'.($bg+1).'">'.($bg+1).'</a></li>';
        }        
        $this->assign("blogs",$blogs);
        $this->assign("pageIndex",$pageIndex);
        return $this->fetch("articleManager",["title"=>"管理博文"]);       
    }
    public function gotoPage($page)
    {
        echo $page;
    }
}

