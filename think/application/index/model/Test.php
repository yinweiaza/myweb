<?php
namespace app\index\model;
use think\Model;
class Test extends Model
{
    protected $table = 'test';
    protected $connection = [
        'type'  => 'mysql',
        'hostname' => '127.0.0.1',
        'database' => 'ywdata',
        'username' => 'root',
        'password' => '',
        'hostport' => '3306',
        'charset'  => 'utf8',
        'prefix'   => '',
        'debug'    => True,    
    ];
}
