<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserInfoModel;

class UserController{
    public function index(){
        $userModel = new UserModel();
        $userInfoModel = new UserInfoModel();
        $users = $userModel->select('*')->get();
        $userInfos = $userInfoModel->select('*')->get();
        return $users . $userInfos;
    }
}