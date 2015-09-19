<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;

class CatalogController extends BaseController
{
    /**
     * 切换栏目显示/隐藏
     * @method status
     */
    public function status()
    {
        $model = D('Catalog');

        $status = I('get.status', 1);
        $id = I('get.id');

        if (empty($id)) {
            $this->error('数据错误');
        }

        $result = $model->where($map)->setField('status', $status);

        if ($result !== false) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
}