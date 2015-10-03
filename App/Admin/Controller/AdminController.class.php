<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class AdminController extends BaseController
{
    public function _before_del()
    {
        $id = I('id');

        if ($id == 1) {
            $this->error('默认账号不能被删除');
        }
    }

    /**
     * 新增管理员
     * @method insert
     */
    public function insert()
    {
        if (!IS_POST) {
            $this->error('非法请求');
        }

        $model = D('Admin');

        if (!$model->create()) {
            $this->error($model->getError());
        }

        $salt = uniqid();
        $password = I('post.password');
        $password = md5($password . $salt);

        $model->salt = $salt;
        $model->password = $password;

        $result = $model->add();
        if ($result) {
            $this->success('操作成功', U('Admin/index'));
        } else {
            $this->error('操作失败');
        }
    }
}
