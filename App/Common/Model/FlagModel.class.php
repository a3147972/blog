<?php
namespace Common\Model;

use Common\Model\BaseModel;

class FlagModel extends BaseModel
{
    protected $tableName = 'flag';
    protected $selectFields = 'id,name,code,is_enable';

    protected $_validate = array(
        array('name', 'require', '请输入标识名称'),
        array('code', 'require', '请输入标识代码'),
    );

    //自动完成
    protected $_auto = array(
        array('ctime', 'now', 1, 'function'),
        array('mtime', 'now', 3, 'function'),
        array('is_enable', 1, 1, 'string'),
    );

    /**
     * 根据文章id查询拥有的标识
     * @method getListByArticleId
     * @param  int             $article_id 文章id
     * @return array                       查询出的数组
     */
    public function getListByArticleId($article_id)
    {
        $flag_map['article_id'] = array('in', $article_id);
        $flag_id_list = D('ArticleFlagMap')->_list($flag_map);

        if (empty($flag_id_list)) {
            return array();
        }
        $flag_id_list = array_column($flag_id_list, 'article_id', 'flag_id');

        $map['id'] = array('in', $flag_id_list);
        $map['is_enable'] = 1;
        $list = $this->_list($map);
        $list = array_column($list, null, 'id');

        foreach ($flag_id_list as $_k => $_v) {
            $flag_id_list[$_k] = $list[$_v];
        }
        return $flag_id_list;
    }
}
