<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//开启调试模式;
define('APP_DEBUG',True);

// [ 应用入口文件 ]


//绑定当前访问到模块；
switch ($_SERVER['PATH_INFO']){
	case '/admin':
		$module = 'admin/admin/index';		//  模块名/控制器名/方法；
		break;
	case '/index':
		$module = 'index';
		break;
	case '/blog':
		$module = 'blog/blog/index';
		break;
	case '/photo':
		$module = 'portfolio/portfolio/index';
		break;
	case '/resume':
		$module = 'resume/resume/index';
		break;
	case '/contact':
		$module = 'contact/contact/index';
		break;
}
define('BIND_MODULE', $module);


// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
