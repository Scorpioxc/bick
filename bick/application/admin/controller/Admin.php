<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin as AdminModel;
class Admin extends Controller
{

    public function _initialize()
    {
        if (!session('id') || !session('name')){
            $this->error('您尚未登录系统',url('login/index'));
        }
    }


    public function lst()
    {
        //$res = db('admin')->find();
        //$res = db('admin')->find(2);
        //$res = db('admin')->select();
        //$res = db('admin')->field('name')->select();
        //$res = db('admin')->where('id',1)->select();
        //$res = db('admin')->where(array('id'=>2,'name'=>1))->select();
        //$admin = new AdminModel();
        //$res = $admin->select();
        //$res = AdminModel::where('name',1)->order('id','desc')->column('id,name,password');
       /* $res = AdminModel::getByName(1);
        dump($res);die;
        foreach ($res as $key => $value){
            echo $value -> password;
            echo "<br>";
        }*/
       if (!session('id') || !session('name')){
           $this->error('您尚未登录系统',url('login/index'));
       }

        $admin=new AdminModel();
        $adminRes=$admin->getAdmin();
        //dump($res);die;
        $this->assign('adminRes',$adminRes);
        //dump($res);

	    return view();
    }
	
	public function add()
    { 

        if(request()->isPost()){

            $admin = new AdminModel();

            if($admin->addAdmin(input('post.'))){
                $this->success('添加管理员成功!',url('lst'));
            }else{
                $this->error('添加管理员失败!');
            }
            return;
        }
        return view();
    }
	
	public function edit($id)
    {
        $adminExist=db('admin')->field('id,name,password')->find($id);

        //表单提交入口
        if(request()->isPost()) {

            $data = input('post.');
            $admin = new AdminModel();
            $res = $admin->saveAdmin($data,$adminExist);
            //验证输入的用户名
            if ($res == 2){
                $this->error('管理员用户名不可为空！');
            }


            if ($res !== false){
                $this->success('修改成功!',url('lst'));
            }else{
                $this->error('修改失败!');
            }
            return;
        }

        //页面跳转入口
        if (!$adminExist){
            $this->error('管理员不存在');
        }
        $this->assign('admin',$adminExist);
        return view();
    }

    public function del($id)
    {

        $admin=new AdminModel();
        $delnum=$admin->delAdmin($id);
        if($delnum == '1'){
            $this->success('删除管理员成功！',url('lst'));
        }else{
            $this->error('删除管理员失败！');
        }
    }

    public function logout(){
        session(null);
        $this->success('退出系统成功！',url('login/index'));
    }
}
