<?php
namespace Common\Model;

use Common\Model\BaseModel;

class GroupModel extends BaseModel
{
    protected $tableName = 'group';
    protected $selectFields = 'id,name,remark,is_enable,ctime';

    protected $_validate = array(
        array('name', 'require', '请输入组名称'),
    );

    protected $_auto = array(
        array('ctime', 'now', 1, 'function'),
        array('mtime', 'now', 3, 'function'),
    );
}
