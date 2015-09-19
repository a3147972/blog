<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Common\Tools\Page;
use Common\Tools\ArrayHelper;

class IndexController extends BaseController
{
    public function index()
    {
        $this->display();
    }
}