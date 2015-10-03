<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class TagController extends BaseController
{
    public function _before_del()
    {
        $tag_id = I('tag_id');

        $map['tag_id'] = $tag_id;

        $info = D('ArticleTagMap')->_get($map);

        if ($info) {
            $this->error('还有文章应用此标签,请删除对应文章后再删除');
        } else {
            $this->success('操作成功');
        }
    }
}
