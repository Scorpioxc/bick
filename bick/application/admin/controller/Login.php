<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin as AdminModel;
class Login extends Controller
{


    public function index()
    {
        if (request()->post()){
            $data = input('post.');
            $admin = new AdminModel();
            $res = $admin->login($data);
            if ($res == 1){
                $this->error("用户名不存在");
            }else if ($res == 2){
                $this->success("登录成功",url('index/index'));
            }else if ($res == 3){
                $this->error("密码错误");
            }

        }
	    return view();
    }
	

}
