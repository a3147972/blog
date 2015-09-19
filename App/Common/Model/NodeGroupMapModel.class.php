<?php
namespace Common\Model;

use Common\Model\BaseModel;

class NodeGroupMapModel extends BaseModel
{
    protected $tableName = 'node_group_map';
    protected $selectFields = 'id,group_id,node_id';
}