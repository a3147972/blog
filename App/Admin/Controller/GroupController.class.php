<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Common\Tools\ArrayHelper;

class GroupController extends BaseController
{
    public function _before_del()
    {
        $id = I('id');

        if ($id == 1) {
            $this->error('默认组不可被删除');
        }
        //检测是否有成员
        $info = D('Admin')->_get(array('group_id' => $id));

        if ($info) {
            $this->error('还有管理员在这个组,请先删除管理员后再删除组');
        }
    }

    /**
     * 开启禁用组
     * @method is_enable
     */
    public function is_enable()
    {
        $is_enable = I('is_enable', 1);
        $id = I('id', '');

        if (empty($id)) {
            $this->error('数据错误');
        }

        $map['id'] = $id;
        $model = D('Group');
        $result = $model->where($map)->setField('is_enable', $is_enable);

        if ($result) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 权限页面
     * @method permission
     * @return [type]     [description]
     */
    public function permission()
    {
        $model = D('Node');
        $node_map['is_enable'] = 1;
        $node_list = $model->_list(array(), 0, 0, '', 'id asc,sort desc');
        $node_list = ArrayHelper::tree($node_list);

        $this->assign('node_list', $node_list);

        //获取组拥有的权限
        $group_id = I('gid');
        $group_node_list = $model->getListByGroupId($group_id);

        $this->assign('group_node_list', $group_node_list);
        $this->display();
    }
}
