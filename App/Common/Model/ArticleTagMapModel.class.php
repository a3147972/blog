<?php
namespace Common\Model;

use Common\Model\BaseModel;

class ArticleTagMapModel extends BaseModel
{
    protected $tableName = 'article_tag_map';
    protected $selectFields = 'id,article_id,tag_id';

    /**
     * 新增文章时增加文章和tag对应关系
     * @method insert
     * @param  array $tag_name    tag名称
     * @param  int $article_id    文章id
     * @return bool               成功返回true
     */
    public function insert($tag_id, $article_id)
    {
        $data['tag_id'] = $tag_id;
        $data['article_id'] = $article;

        $result = $this->add($data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}