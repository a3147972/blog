<?php
namespace Common\Model;

use Common\Model\BaseModel;
use Common\Tools\ArrayHelper;

class AdminModel extends BaseModel
{
    protected $tableName = 'admin';
    protected $selectFields = 'id,username,password,salt,nickname,group_id';

    /**
     * 登录
     * @method login
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return bool             成功返回用户信息,失败返回false
     */
    public function login($username, $password)
    {
        $this->error = ''; //清空错误信息

        $map['username'] = $username;

        $info = $this->get($map);

        if (empty($info)) {
            $this->error = '用户不存在';
            return false;
        }

        if (md5(md5($password) . $info['salt']) != $info['password']) {
            $this->error = '密码不正确';
            return false;
        }

        if ($info['is_enable'] != 1) {
            $this->error = '此账号已被禁用';
            return false;
        }

        return $info;
    }

    /**
     * 获取单个管理员信息
     * @method get
     * @param  array  $map [description]
     * @return [type]      [description]
     */
    public function get($map = array())
    {
        $info = $this->_get($map);

        if (empty($info)) {
            return false;
        }

        $group_map['group_id'] = $info['group_id'];

        $group_info = D('Group')->_get($group_map);
        $group_info = ArrayHelper::array_key_replace($group_info,array('id','name'),array('group_id','group_name'));
        $info = array_merge($info, $group_info);

        return $info;
    }
}
