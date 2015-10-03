<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class NodeController extends BaseController
{
    /**
     * 给组添加权限
     * @method addMap
     */
    public function addMap()
    {
        $node_id = I('node_id');
        $group_id = I('group_id');

        $map['node_id'] = $node_id;
        $map['group_id'] = $group_id;

        $info = D('NodeGroupMap')->_get($map);

        if ($info) {
            $this->success('权限已存在');
            exit();
        }

        $result = D('NodeGroupMap')->add($map);

        if ($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 删除组权限
     * @method delMap
     */
    public function delMap()
    {
        $node_id = I('node_id');
        $group_id = I('group_id');

        $map['node_id'] = $node_id;
        $map['group_id'] = $group_id;

        $result = D('NodeGroupMap')->where($map)->delete();

        if ($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
}
