<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Db;
function findNewId($database, $idName)
{
   $count=count(Db::name($database)->select());
   for($idx = 0; $idx < $count; $idx++)
   {
       if(! Db::name($database)->where($idName, $idx)->find() )
           break;
   }
   return $idx;
}

function getCurDateTime()
{
    return date('Y-m-d H:i:s',time());
}



/**
 * [ tp自带写入日志 -详细]
 * @param  array,string  $log_content [内容]
 * @param  string 　　　　$keyp        [文件名]
 * @return [type]         　　　　　　[description]
 */
function tp_log($log_content,$keyp){
    \think\Log::init(['type' => 'File', 'path' =>ROOT_PATH .'logs'. DS.$keyp.DS]);
    \think\Log::write($log_content);
}


//自己写的简约写入日志

/**
 * [ 写入日志 -简约]
 * @param  array,string  $log_content [内容]
 * @param  string        $keyp        [文件名]
 * @return [type]        　　　　　　　[description]
 */
function pr_log($log_content, $keyp) {
    $log_filename = ROOT_PATH .'logs'.DS .$keyp.DS.date("Ym").DS;
    !is_dir($log_filename) && mkdir($log_filename, 0755, true);
    
    if(is_array($log_content)){
        $log_content = JSONReturn($log_content);
    }
    file_put_contents($log_filename.date("d").'.log', '['.date("Y-m-d H:i:s").']' .PHP_EOL . $log_content . PHP_EOL."------------------------ --------------------------".PHP_EOL, FILE_APPEND);
}
function JSONReturn($result)
{
    return json_encode($result,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
}