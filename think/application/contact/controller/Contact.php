<?php
namespace app\contact\controller;
use think\Controller;
class Contact extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}