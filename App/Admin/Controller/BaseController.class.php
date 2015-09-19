<?php
namespace Admin\Controller;

use Think\Controller;
use Common\Tools\Page;

class BaseController extends Controller
{
    public function _initialize()
    {

    }

    /**
     * 搜索条件,子类可覆盖
     * @method _filter
     */
    protected function _filter()
    {
        return array();
    }

    /**
     * 首页
     * @method index
     */
    public function index()
    {
        $map = method_exists($this, '_filter') ? $this->_filter() : array();
        $page = (int)I('page', 0);
        $page_size = (int)I('page_size', 0);

        $model = D(CONTROLLER_NAME);

        $list = $model->_list($map, $page, $page_size, '', ''); //数据列表
        $count = $model->_count($map);      //总条数
        $page_list = $this->_page($count, $page, $page_size);   //分页数组

        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('page_list', $page_list);
        $this->display();
    }

    /**
     * 分页数组
     * @method _page
     * @param  int  $count       总条数
     * @param  int  $page        当前页
     * @param  int  $page_size   每页条数
     * @param  integer $page_number 显示页数
     * @return array               分页数组
     */
    protected function _page($count, $page = 1, $page_size = 10, $url = '', $page_number = 5)
    {
        $p = new Page($count, $page, $page_size, $page_number);
        $page_list = $p->show();

        $url = empty($url) ? CONTROLLER_NAME .'/'. MODULE_NAME : $url;
        $get = I('get.');

        foreach ($page_list as $_k => $_v) {
            $param = array_merge($get, array('p' => $_v['page'], 'n' => $page_size));
            $page_list[$_k]['url'] = U($url, $param);
        }
        return $page_list;
    }

    /**
     * 新增模板展示
     * @method add
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 新增数据操作
     * @method post
     */
    public function insert()
    {
        if (IS_POST) {
            $model = D(CONTROLLER_NAME);

            if (!$model->create()) {
                $this->error($model->getError());
            }

            $result = $model->add();

            if ($result !== false) {
                $this->success('新增成功', U(CONTROLLER_NAME . '/index'));
            } else {
                $this->error('新增失败');
            }
        } else {
            $this->error('访问被拒绝');
        }
    }

    /**
     * 编辑数据
     * @method edit
     */
    public function edit()
    {
        $model = D(CONTROLLER_NAME);

        $pk = $model->getPk();

        $map[$pk] = (int)I($pk);

        $info = $model->_get($map);

        if ($info) {
            $this->assign('vo', $info);
            $this->display('add');      //使用新增模板
        } else {
            $this->error('非法请求');
        }
    }

    /**
     * 更新数据
     * @method update
     */
    public function update()
    {
        if (IS_POST) {
            $model = D(CONTROLLER_NAME);

            if (!$model->create()) {
                $this->error($model->getError());
            }

            $result = $model->save();

            if ($result) {
                $this->success('更新成功', U(CONTROLLER_NAME . '/index'));
            } else {
                $this->error('更新失败');
            }
        } else {
            $this->error('非法请求');
        }
    }

    public function _empty()
    {
        redirect(U('Index/index'));
    }
}