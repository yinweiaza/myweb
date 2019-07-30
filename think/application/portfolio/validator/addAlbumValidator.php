<?php
namespace app\portfolio\validator;
use think\Validate;
class AddAlbumValidator extends Validate{
    protected $rule=[
        'name'=>'require|max:25'
    ];
    protected $message = [
        'name.require' => '名称必须',
        'name.max' => '名称最多不能超过25个字符',
        ];
}