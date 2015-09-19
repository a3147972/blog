<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;

class FlagController extends BaseController
{
    /**
     * 开启和关闭标识
     * @method is_enable
     */
    public function is_enable()
    {
        $is_enable = I('is_enable', 1);
        $id = I('id', '');

        if (empty($id)) {
            $this->error('数据错误');
        }

        $model = D('Flag');

        $map['id'] = $id;

        $result = $model->where($map)->setField('is_enable', $is_enable);

        if ($result !== false) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    public function _before_del()
    {
        $tag_id = I('flag_id');

        $map['flag_id'] = $tag_id;

        $info = D('ArticleFlagMap')->_get($map);

        if ($info) {
            $this->error('还有文章应用此标识,请删除对应文章后再删除');
        } else {
            $this->success('操作成功');
        }
    }
}