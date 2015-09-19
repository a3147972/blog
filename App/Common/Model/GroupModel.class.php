<?php
namespace Common\Model;

use Common\Model\BaseModel;

class GroupModel extends BaseModel
{
    protected $tableName = 'group';
    protected $selectFields = 'id,name,remark,is_enable,ctime';
}
