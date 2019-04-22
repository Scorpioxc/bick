<?php
namespace app\admin\controller;
use app\admin\model\Article as ArticleModel;
use app\admin\model\Cate as CateModel;
use think\Request;
class Article extends Common
{


    public function lst()
    {


        $articleRes=db('article')->field('a.*,b.catename')->alias('a')->join('bk_cate b','a.cateid=b.id')->order('a.id desc')->paginate(5);
        //$this->assign('artres',$artres);
        //dump($res);die;
        $this->assign('articleRes',$articleRes);

	    return view();
    }
	
	public function add()
    {
        $article = new ArticleModel();

        if(request()->isPost()){
            $data = input('post.');
        /*//dump($_FILES['thumb']);die;
            $data = input('post.');
            if (!$_FILES['thumb']['error']>0){
                $file = request()->file('thumb');

                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info){
                    $thumb = 'http://www.bick1.com' . DS . 'uploads'.DS.$info->getSaveName();
                    //dump($thumb);die;
                    //$this->success('图片上传成功',url('lst'));
                    $data['thumb'] = $thumb;
                }else{
                    $this->error('图片上传失败');
                }
            }*/

            //dump($_FILES['thumb']['error']);die;

            if($article->save($data)){
                $this->success('添加文章成功！',url('lst'));
            }else{
                $this->error('添加文章失败!');
            }
            return;
        }
        $cate=new CateModel();
        $cateRes=$cate->cateRes();
        $this->assign('cateres',$cateRes);
        return view();
    }
	
	public function edit($id)
    {
        if(request()->isPost()){
            $data=input('post.');

            $article=new ArticleModel;
            $save=$article->update($data);
            if($save){
                $this->success('修改文章成功！',url('lst'));
            }else{
                $this->error('修改文章失败！');
            }
            return;
        }
        $cate=new CateModel();
        $cateres=$cate->cateRes();
        $arts=db('article')->where(array('id'=>input('id')))->find();
        $this->assign(array(
            'cateres'=>$cateres,
            'arts'=>$arts,
        ));
        return view();
    }

    public function del($id)
    {

        $article=new ArticleModel();
        $delnum=$article->delete($id);
        if($delnum == '1'){
            $this->success('删除文章成功！',url('lst'));
        }else{
            $this->error('删除文章失败！');
        }
    }


}
