<?php
namespace app\admin\controller;
use app\admin\model\Article as ArticleModel;
use app\admin\model\Cate as CateModel;

class Article extends Common
{


    public function lst()
    {

        if(request()->isPost()){
            dump(input('post.'));die;

            return;
        }
        $articleRes=db('article')->field('a.*,b.catename')->alias('a')->join('bk_cate b','a.cateid=b.id')->order('a.id desc')->paginate(5);
        //$this->assign('artres',$artres);
        //dump($res);die;
        $this->assign('articleRes',$articleRes);

	    return view();
    }
	
	public function add()
    { 

        if(request()->isPost()){

            $article = new ArticleModel();

            if($article->save(input('post.'))){
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
