<?php
namespace Common\Model;

use Common\Model\BaseModel;

class LoginLogModel extends BaseModel
{
    protected $tableName = 'login_log';

    /**
     * 写入登录日志
     * @method write
     * @param  string  $username   用户名
     * @param  integer $is_success 是否登录成功 1-成功 0-失败
     * @param  string  $password   登录失败时记录密码
     * @return bool                写入成功返回true,写入失败返回false
     */
    public function write($username, $is_success = 1, $password = '')
    {
        $data['username'] = $username;
        $data['is_success'] = $is_success;
        $data['password'] = $password;
        $data['client_id'] = get_client_ip(0, true);
        $data['ctime'] = now();

        $result = $this->add($data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}