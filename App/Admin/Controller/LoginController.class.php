<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    /**
     * 不存在的方法
     * @method _empty
     * @return [type] [description]
     */
    public function _empty()
    {
        if ($this->checkLoginStatus()) {
            redirect(U('Index/index'));
        } else {
            redirect(U('Login/login'));
        }
    }

    /**
     * 登录页
     * @method login
     */
    public function login()
    {
        if ($this->checkLoginStatus()) {
            redirect(U('Index/index'));
        } else {
            $this->display();
        }
    }

    /**
     * 检测登录
     * @method checkLogin
     */
    public function checkLogin()
    {
        if (IS_POST) {
            $username = I('post.username');
            $password = I('post.password');
            $verify = I('post.verify');

            if (empty($username)) {
                $this->error('请输入用户名');
            }
            if (empty($password)) {
                $this->error('请输入密码');
            }

            $model = D('Admin');
            $info = $model->login($username, $password);

            if ($info) {
                session('uid', $info['id']);
                session('nickname', $info['nickname']);
                session('gid', $info['group_id']);

                //获取权限列表
                $node_list = D('Node')->getListByGroupId($info['group_id']);
                session('node_list', $node_list);

                D('LoginLog')->write($username); //写入登录日志
                $redirect = I('post.redirect', U('Index/index'));
                redirect($redirect); //跳转
            } else {
                $this->error($model->getError());
            }
        } else {
            D('LoginLog')->write($username, 0, $password); //写入登录日志
            $this->error('非法请求');
        }
    }

    /**
     * 退出登录
     * @method logout
     */
    public function logout()
    {
        session(null);
        session_regenerate_id(); //重新生成session_id
        redirect(U('Login/login'));
    }

    /**
     * 判断登录状态
     * @method checkLoginStatus
     * @return bool     登录状态返回true,未登录返回false
     */
    public function checkLoginStatus()
    {
        if (session('uid')) {
            return true;
        } else {
            return false;
        }
    }
}
