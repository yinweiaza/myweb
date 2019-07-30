<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
/**
 * 转换字符编码
 * @param $string
 * @return string
 */
function convertEncoding($string){
    //根据系统进行配置
    $encode = stristr(PHP_OS, 'WIN') ? 'GBK' : 'UTF-8';
    $string = iconv('UTF-8', $encode, $string);
    //$string = mb_convert_encoding($string, $encode, 'UTF-8');
    return $string;
}
// Define a destination
$targetFolder = '/Uploads/Albums'; // Relative to the root and should match the upload folder in the uploader script
$parentFolder = $_SERVER['DOCUMENT_ROOT']. $targetFolder .'/'.$_POST['albumeName'];
$parentFolder = convertEncoding($parentFolder);
if(!is_dir($parentFolder))
    mkdir(iconv("UTF-8", "GBK", $parentFolder),0777,true);
 if (file_exists($_SERVER['DOCUMENT_ROOT'] . $targetFolder .'/'.$_POST['albumeName']. '/'. $_POST['filename'])) {
	echo 1;
} else {
	echo 0;
}
?>