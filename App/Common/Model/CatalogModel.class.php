<?php
namespace Common\Model;

use Common\Model\BaseModel;

class CatalogModel extends BaseModel
{
    protected $tableName = 'catalog';
    protected $selectFields = 'id,pid,name,title,desc,keywords,index_tpl,list_tpl,article_tpl,is_show,sort';

    //自动验证
    protected $_validate = array(
        array('name', 'require', '请输入栏目名称'),
        array('index_tpl', 'require', '请选择栏目首页模板'),
        array('list_tpl', 'require', '请选择栏目列表页模板'),
        array('article_tpl', 'require', '请选择栏目文章模板'),
    );

    //自动完成
    protected $_auto = array(
        array('ctime', 'now', 1, 'function'),
        array('mtime', 'now', 3, 'function'),
        array('sort', 0, 1, 'string'),
    );
}
