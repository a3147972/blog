<?php
namespace Common\Model;

use Common\Model\BaseModel;

class TagModel extends BaseModel
{
    protected $tableName = 'tag';
    protected $selectFields = 'id,name,is_enable';

    //自动验证
    protected $_validate = array(
        array('name', 'require', '请输入标签名称'),
    );

    //自动完成
    protected $_auto = array(
        array('ctime', 'now', 1, 'function'),
        array('mtime', 'now', 3, 'function'),
        array('is_enable', 1, 1, 'string'),
    );

    /**
     * 新增一个tag
     * @method insert
     * @param  string $tag_name tag名称
     * @return bool             成功返回true,失败返回false
     */
    public function insert($tag_name)
    {
        $data['name'] = $tag_name;

        if (!$this->create($data)) {
            return false;
        }

        $tag_id = $this->add();

        if ($result) {
            return $tag_id;
        } else {
            return false;
        }
    }

    /**
     * 根据文章id获取拥有的标签列表
     * @method getListByArticleId
     * @param  array|int             $article_id 文章id
     * @return array                         查询出的数据
     */
    public function getListByArticleId($article_id)
    {
        $tag_map['article_id'] = array('in', $article_id);
        $tag_id_list = D('ArticleTagMap')->_list($tag_map);

        if (empty($tag_id_list)) {
            return array();
        }
        $tag_id_list = array_column($tag_id_list, 'article_id', 'tag_id');

        $map['id'] = array('in', $tag_id_list);
        $map['is_enable'] = 1;
        $list = $this->_list($map);
        $list = array_column($list, null, 'id');

        foreach ($tag_id_list as $_k => $_v) {
            $tag_id_list[$_k] = $list[$_v];
        }
        return $tag_id_list;
    }
}
