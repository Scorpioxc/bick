<?php
namespace app\admin\model;
use think\Model;
class Admin extends Model
{

	
	public function addAdmin($data)
    { 
        if (empty($data) || !is_array($data)){
            return false;
        }
        if ($data['password']){
            $data['password'] = md5($data['password']);
        }

        $res = $this->save($data);
        //dump($res);die;
        if ($res){
            return true;
        }else{
            return false;
        }
    }

    public function getAdmin()
    {
        return $this::paginate(5);
    }

    public function saveAdmin($data,$adminExist)
    {
        if (!$data['name']){
            return 2; //用户名不能为空
        }

        //如果输入的密码为空  则不修改密码 保持不变
        if (!$data['password']){
            $data['password']=$adminExist['password'];
        }else{

            $data['password'] = md5($data['password']);
        }
        //使用助手函数更新数据
        //$res = db('admin')->update($data);
        //使用模型对象静态方法更新数据
        //AdminModel::update(['name'=>$data['name'],'password'=>$data['password'],'id'=>$data['id']]);
        $res = $this->save(['name'=>$data['name'],'password'=>$data['password']],['id'=>$data['id']]);
        return $res;

    }

    public function delAdmin($id)
    {
        //$this->delete($id);
        if ($this::destroy($id)){
            return 1;
        }else{
            return 2;
        }
    }

    public function login($data){
        $admin=Admin::getByName($data['name']);
        if($admin){
            if($admin['password']==md5($data['password'])){
                session('id', $admin['id']);
                session('name', $admin['name']);
                return 2; //登录密码正确的情况
            }else{
                return 3; //登录密码错误
            }
        }else{
            return 1; //用户不存在的情况
        }
    }

}
