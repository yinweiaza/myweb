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
        $category = Db::name("blog_category")->select();
        $this->assign("allCategories", $category);
        $this->assign('myblogs',$blogs);
        return $this->fetch();
    }
    
    public function showCategory($id)
    {
        $blogs = [];
        if($id == -1)
        {
            $blogs=Db::name("blog")->select();            
        }else{
            $blogs = Db::name("blog")->where("class", $id)->select();
        }
        return json($blogs);
    }
    
    /**
     * 编写指定的博文；
     * @param unknown $id
     */
    public function editArticle($id)
    {
        
    }
    
    /**
     * 发布博文；
     */
    public function releaseArticle()
    {
        $request = $this->request->post();
        $maxId = findNewId("blog", "blog_id");        
        $title = $request["title"];
        $content=$request["content"];
        $category = $request["myCatalog"][0];        
        Db::name("blog")->insert(["blog_id"=>$maxId, "title"=>$title, "content"=>$content, "class"=>$category, "watch_num"=>0, "time"=>getCurDateTime()]);
        return json("发布成功");  
//         return json($category);
    }
    
    /**
     * 展示指定博文；
     * @param unknown $id
     * @return mixed|string
     */
    public function showArticle($id)
    {
        $blog=Db::name("blog")->where("blog_id",$id)->find();
        Db::name("blog")->where("blog_id", $id)->update(["watch_num" => $blog["watch_num"]+1]);
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
    
    /**
     * 删除指定博文；
     * @param unknown $id
     */
    public function deleteArticle($id)
    {
        //删除评论；
        Db::name("blog_msg")->where("blog_id",$id)->delete();
        //删除博文；
        Db::name("blog")->where("blog_id", $id)->delete();
    }
    
    /**
     * 添加新博文；
     * @return mixed|string
     */
    public function addArticle()
    { 
        $categorys=Db::name("blog_category")->select();    
        
        if( count($categorys) > 0 )
        {
            $this->assign("categorys", $categorys);
        }
        return $this->fetch("add_article",["title"=>"添加新的博文"]);
    }
    
    /**
     * 添加新类别；
     * @return \think\response\Json
     */
    public function add_new_category()
    {
        if( Request::instance()->isAjax())
        {
            $requestData = $this->request->post();
            $category=$requestData["newCategory"];
            if(Db::name("blog_category")->where("category", $category)->find())
                return json("该类别已经存在");
            $descript=$requestData["desc"];
            $maxId= findNewId("blog_category", "id");
            Db::name("blog_category")->insert(["id"=>$maxId, "category"=>$category]); 
            return json(["category"=>$category, "id"=>$maxId]);
        }             
    }
    
    public function showForEditCategory()
    {
        $allCategoryData =  Db::name("blog_category")->select();
        for($idx = 0; $idx < count($allCategoryData); $idx++)
        {
            $tmpBlog = Db::name("blog")->where("class", $allCategoryData[$idx]["id"])->select();
            $allCategoryData[$idx]["blogNum"] = count($tmpBlog);
        }
        $this->assign("categories", $allCategoryData);
        $this->assign("title", "编辑分类");
        return $this->fetch("editCategory");
    }
    
    /**
     * 删除指定的分类；
     * @param unknown $categoryId
     * @return \think\response\Json
     */
    public function deleteCategory($categoryId)
    {
        $blogId = -1;
        if (Db::name("blog")->where("class", $categoryId)->find()) {
            $blogId = Db::name("blog")->where("class", $categoryId)->value("blog_id");
            Db::name("blog")->where("class", $categoryId)->delete(); // 指定类别的所有的博文；、
        }
        
        if (Db::name("blog_category")->where("id", $categoryId)->find()) {            
            Db::name("blog_category")->where("id", $categoryId)->delete();
        }        
        
        if( $blogId != -1){
            Db::name("blog_msg")->where("blog_id")->delete();
        }        
        return json("删除成功");
    }
    
    /**
     * 博文管理；
     * @return mixed|string
     */
    public function articleManager()
    {
        $categorys=Db::name("blog_category")->select();
        $this->assign("categorys",$categorys);          //所有类别；
        $limit=5;
        
        $blogs=Db::name("blog")->limit(0,$limit)->select();      //所有博客；
        $blogCount=count(Db::name("blog")->select()); 
        
        $pageIndex="";
        
        for($bg=0;$bg<count($blogs); $bg++)
        {            
            $msgCount=Db::name("blog_msg")->where("blog_id",$blogs[$bg]["blog_id"])->count();
            $blogs[$bg]["msg_num"]=$msgCount; 
            $category = Db::name("blog_category")->where("id", $blogs[$bg]["class"])->value("category");
            $blogs[$bg]["category"]=$category;
        }        
        $totalPage = ceil($blogCount/$limit);
        for($page = 1; $page <= $totalPage; $page++)
        {
            if($page == 1 )
                $pageIndex=$pageIndex.'<li class="active"><a href="/public/blog/page/'.$page.'">'.$page.'</a></li>';
            else
                $pageIndex=$pageIndex.'<li><a href="/public/blog/page/'.$page.'">'.$page.'</a></li>';
        }
        $this->assign("blogs",$blogs);
        $this->assign("pageIndex",$pageIndex);
        return $this->fetch("articleManager",["title"=>"管理博文"]);       
    }
    
    /**
     * 翻页；
     * @param unknown $page
     */
    public function gotoPage($id)
    {
        $categorys=Db::name("blog_category")->select();
        $this->assign("categorys",$categorys);          //所有类别；
        $limit = 5;
        $blogs = Db::name("blog")->limit(($id-1) * $limit, $limit)->select();
        $blogCount=count(Db::name("blog")->select()); 
        $totalPage = ceil($blogCount/$limit);
        $pageIndex="";
        for($bg=0;$bg<count($blogs); $bg++)
        {
            $msgCount=Db::name("blog_msg")->where("blog_id",$blogs[$bg]["blog_id"])->count();
            $blogs[$bg]["msg_num"]=$msgCount;
            $category = Db::name("blog_category")->where("id", $blogs[$bg]["class"])->value("category");
            $blogs[$bg]["category"]=$category;
        }  
        for($page = 1; $page <= $totalPage; $page++)
        {
            if($page == $id )
                $pageIndex=$pageIndex.'<li class="active"><a href="/public/blog/page/'.$page.'">'.$page.'</a></li>';
            else
                $pageIndex=$pageIndex.'<li><a href="/public/blog/page/'.$page.'">'.$page.'</a></li>';
        }
        $this->assign("blogs",$blogs);
        $this->assign("pageIndex",$pageIndex);
        return $this->fetch("articleManager",["title"=>"管理博文"]);  
    }
}

