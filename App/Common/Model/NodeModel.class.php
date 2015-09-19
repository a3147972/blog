<?php
namespace Common\Model;

use Common\Model\BaseModel;

class NodeModel extends BaseModel
{
    protected $tableName = 'node';
    protected $selectFields = 'id,name,module,function,is_show,is_enable,sort';
    protected $_validate = array(
        array('name', 'require', '请输入节点名称'),
        array('module', 'require', '请输入module'),
        array('function', 'require', '请输入function'),
    );

    protected $_auto = array(
        array('ctime', 'now', 1, 'function'),
        array('mtime', 'now', 3, 'function'),
        array('is_enable', 1, 1, 'string'),
        array('sort', 0, 1, 'string'),
    );

    /**
     * 获取组id拥有的权限
     * @method getListByGroupId
     * @param  int     $group_id 组id
     * @return array             查询到的数据
     */
    public function getListByGroupId($group_id)
    {
        if ($group_id == 1) {   //超级管理员组拥有所有权限
            $node_list = $this->_list();
            return $node_list;
        }

        $map['group_id'] = $group_id;

        $node_list = D('NodeGroupMap')->_list($map);

        $node_id = array_column($node_list, 'node_id');

        $node_map['id'] = array('in', $node_id);

        $node_list = $this->_list($map);

        return $node_list;
    }
}