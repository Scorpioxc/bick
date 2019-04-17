<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin as AdminModel;
class Admin extends Controller
{
    /* $admin = 1;
    public function _initialize()
    {
        global $admin = new AdminModel();
    }*/


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
        $admin=new AdminModel();
        $res=$admin->getAdmin();
        //dump($res);die;
        $this->assign('res',$res);
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
	
	public function edit()
    { 
	  return view();
    }
}
