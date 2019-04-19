<?php
namespace app\admin\controller;
use app\admin\model\Cate as CateModel;
class Cate extends Common
{
    protected $beforeActionList = [
        //'first',   //什么都没写 就是执行所有函数之前 都要执行该方法
       // 'second' =>  ['except'=>'hello'],  //除了hello,执行其他函数之前都要执行
        'delChildCate' =>  ['only'=>'del,hi'],  //仅再执行del和hi之前执行delChildCate
    ];


    public function lst()
    {

        $cate=new CateModel();
        if(request()->isPost()){
            $sorts=input('post.');
            foreach ($sorts as $k => $v) {
                $cate->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功！',url('lst'));
            return;
        }
        $cateRes=$cate->cateRes();
        //dump($res);die;
        $this->assign('cateRes',$cateRes);

	    return view();
    }

    public function add()
    {
        $cate=new CateModel();
        if(request()->isPost()){

            $cate = new CateModel();

            if($cate->save(input('post.'))){
                $this->success('添加栏目成功!',url('lst'));
            }else{
                $this->error('添加栏目失败!');
            }
            return;
        }
        $cateRes=$cate->cateRes();
        $this->assign('cateRes',$cateRes);
        return view();
    }

    public function del($id){
        $del=db('cate')->delete(input('id'));
        if($del){
            $this->success('删除栏目成功！',url('lst'));
        }else{
            $this->error('删除栏目失败！');
        }
    }

    public function delChildCate(){
        $cate=new CateModel();
        $cateId = input('id');
        $childIds = $cate->getChildCateId($cateId);
        //dump($childIds);die;
        $del=CateModel::destroy($childIds);

    }

    public function edit($id)
    {
        $cate=new CateModel();
        if(request()->isPost()){
            $data=input('post.');
            $save=$cate->save($data,['id'=>$data['id']]);
            if($save !== false){
                $this->success('修改栏目成功！',url('lst'));
            }else{
                $this->error('修改栏目失败！');
            }
            return;
        }
        $cates=$cate->find($id);
        $cateres=$cate->cateRes();
        $this->assign(array(
            'cateres'=>$cateres,
            'cates'=>$cates,
        ));
        return view();
    }


}
