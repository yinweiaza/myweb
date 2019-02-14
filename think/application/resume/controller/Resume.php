<?php
namespace app\resume\controller;
use think\Controller;
class Resume extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}