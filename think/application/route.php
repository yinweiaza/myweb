<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::rule([    
    'resume/:resumeId'=> ['resume/resume/index', ['resumeId'=>'\d+']],
    'blog/:id$' =>['blog/blog/showarticle',['id'=>'\d+']],
    'photo/:id$'=>['portfolio/portfolio/showPhotos',['id'=>'\d+']]
]
);

Route::rule([
    "blog/add"=>"blog/blog/addArticle",
    "blog/manage"=>"blog/blog/articleManager",
    "blog/delete/category/:categoryId"=>["blog/blog/deleteCategory", ['categoryId'=>'\d+']],
    "blog/page/:id"=>["blog/blog/gotoPage",['id'=>'\d+']],
    "blog/delete/:id" =>["blog/blog/deleteArticle",['id'=>'\d+']],
    "blog/addCategory"=>"blog/blog/add_new_category",
    "blog/release"=>"blog/blog/releaseArticle",
    "blog/category/:id"=>"blog/blog/showCategory",    
    "blog/editCategory"=>"blog/blog/showForEditCategory"
]);

Route::rule([
    "photo/deleteAlbums" =>"portfolio/portfolio/deleteAblum",
    "photo/deletePhotos"=>"portfolio/portfolio/deletePhoto"             //ajax post delete the photos;
]);

// Route::group('resume',[
//     'create' =>["resume/resume/newCreate", ['method'=>'post']],
//     'edit/:resumeId'=>["resume/resume/edit",['method'=>'get'],['resumeId'=>'\d+']],
//     'delete/:resumeId'=>["resume/resume/delete",['method'=>'get'], ['resumeId'=>'\d+']]
// ]);
Route::rule([
    "res/create" => "resume/resume/newCreate",                      //新建简历；
    "res/edit/:resumeId"=> ["resume/resume/edit", ['resumeId'=>'\d+']],         //编辑；
    "res/delete/:resumeId"=>["resume/resume/delete",['resumeId'=>'\d+']]         //删除；
]);



Route::rule([
    'admin'=>'admin/admin/index',
    'index'=>'index',
    'blog'=>'blog/blog/index',
    'photo'=>'portfolio/portfolio/index',
    'resume'=>'resume/resume/resume',
    'contact'=>'contact/contact/index'
],'','GET');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
];
