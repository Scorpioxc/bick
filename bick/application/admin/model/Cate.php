<?php
namespace app\admin\model;
use think\Model;
class Cate extends Model
{

	
	public function cateRes()
    {
        $cateRes=$this->order('sort desc')->select();
        //dump($cateTree);die;
        return $this->sort($cateRes);
    }

   public function sort($data,$pid=0,$level=0){
        static $arr=array();
        foreach ($data as $k => $v) {
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->sort($data,$v['id'],$level+1);
            }
        }
        //dump($arr);die;
        return $arr;
    }

    public function getChildCateId($id){
        $cateRes = $this->select();
        return $this->_getChildrenid($cateRes,$id);
    }

    public function _getChildrenid($cateRes, $pid){
        static $arr=array();
        foreach ($cateRes as $k => $v) {
            if($v['pid'] == $pid){
                $arr[]=$v['id'];
                $this->_getChildrenid($cateRes,$v['id']);
            }
        }

        return $arr;
    }

}
