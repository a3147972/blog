<?php
namespace Common\Model;

use Think\Model;

class BaseModel extends Model
{
    protected $selectFields = ''; //允许查询字段

    /**
     * 获取单条数据
     * @method _get
     * @param  array $map    查询条件
     * @param  string $field 查询字段
     * @param  string $order 排序规则
     * @return array         返回查询数组
     */
    public function _get($map = array(), $field = '', $order = '')
    {
        $field = empty($field) ? $this->selectFields : $field;
        $order = empty($order) ? $this->pk . ' desc' : $order;
        $info = $this->where($map)->field($field)->order($order)->find();

        return empty($info) ? array() : $info;
    }

    /**
     * 获取多条数据
     * @method _list
     * @param  array   $map       查询条件
     * @param  integer $page      页数
     * @param  integer $page_size 分页条数
     * @param  string  $field     查询字段
     * @param  string  $order     排序条件
     * @return array              查询出的数据
     */
    public function _list($map = array(), $page = 0, $page_size = 10, $field = '', $order = '')
    {
        $field = empty($field) ? $this->selectFields : $field;
        $order = empty($order) ? $this->pk . ' desc' : $order;
        if ($page == 0) {
            $list = $this->where($map)->field($field)->order($order)->select();
        } else {
            $page_index = ($page - 1) * $page_size;
            $list = $this->where($map)->field($field)->order($order)->limit($page_index.','.$page_size)->select();
        }

        return empty($list) ? array() : $list;
    }

    /**
     * 查询数据条数
     * @method count
     * @param  array  $map 查询条件
     * @return int         条数
     */
    public function _count($map = array())
    {
        $count = $this->where($map)->count();

        return empty($count) ? 0 : $count;
    }

    public function getLastId()
    {
        $pk = $this->pk();
        $last_id = $this->order($pk .' desc')->getField($pk);

        $last_id = empty($last_id) ? 0 : $last_id;

        return $last_id;
    }
}
