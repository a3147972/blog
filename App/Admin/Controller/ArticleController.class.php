<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Common\Tools\ArrayHelper;

class ArticleController extends BaseController
{
    /**
     * 新增前置操作,获取所有栏目
     * @method _before_add
     */
    public function _before_add()
    {
        $catalog_list = D('Catalog')->_list(array() , 0 , 10 , '' , 'id asc,sort desc');
        $catalog_list = ArrayHelper::tree($catalog_list);

        $last_id = D('Article')->getLastId();
        $id = $last_id + 1;

        $this->assign('catalog_list', $catalog_list);
        $this->assign('id', $id);   //为文章分配id
    }

    /**
     * 编辑前置操作,获取所有栏目
     * @method _before_edit
     */
    public function _before_edit()
    {
        $this->_before_add();
    }

    /**
     * 删除文章同时删除tag,flag对应关系
     * @method del
     */
    public function del()
    {
        $id = I('id');

        $map['id'] = $id;

        $model = D('Article');

        $model->startTrans();

        $del_result = $model->where($map)->delete();
        $del_flag = D('ArticleFlagMap')->where(array('article_id' => $id))->delete();
        $del_tag = D('ArticleTagMap')->where(array('article_id' => $id))->delete();

        if ($del_result !== false && $del_flag !== false && $del_tag !== false) {
            $model->commit();
            $this->success('删除成功');
        } else {
            $model->rollback();
            $this->error('删除失败');
        }
    }

    /**
     * 新增flag
     */
    public function insertFlag()
    {
        $flag_id = I('flag_id');
        $article_id = I('article_id');

        $result = D('ArticleTagMap')->insert($flag_id, $article_id);

        if ($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 取消Flag和文章的对应关系
     * @method delFlag
     */
    public function delFlag()
    {
        $flag_id = I('flag_id');
        $article_id = I('article_id');

        $map['flag_id'] = $flag_id;
        $map['article_id'] = $article_id;

        $result = D('ArticleTagMap')->where($map)->delete();

        if ($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 新增一个Tag
     * @method insertTag
     */
    public function insertTag()
    {
        $tag_name = I('tag_name');
        $article_id = I('article_id');

        $map['tag_name'] = $tag_name;

        $TagModel = D('Tag');
        $info = $TagModel->_get($map);

        if ($info) {
            $tag_id = $info['id'];
        } else {
            $tag_id = $TagModel->insert($tag_name);

            if ($tag_id == false) {     //新增tag失败则输出错误
                $this->error ($TagModel->getError());
            }
        }

        $data['tag_id'] = $tag_id;
        $data['article_id'] = $article_id;

        $result = D('ArticleTagMap')->add($data);

        if ($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 删除一个Tag
     * @method delTag
     */
    public function delTag()
    {
        $tag_id = I('tag_id');
        $article_id = I('article_id');

        $map['tag_id'] = $tag_id;
        $map['article_id'] = $article_id;

        $result = D('ArticleTagMap')->where($map)->delete();

        if ($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
}
