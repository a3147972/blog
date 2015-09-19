<?php
namespace Admin\Model;

use Admin\Model\BaseModel;

class ArticleFlagMapModel extends BaseModel
{
    protected $tableName = 'article_flag_map';
    protected $selectFields = 'id,article_id,flag_id';

    /**
     * 新增文章同时新增标识对应关系
     * @method insert
     * @param  array $flag_code   标识代码
     * @param  int $article_id    文章id
     * @return bool               返回成功失败
     */
    public function insert($flag_id, $article_id)
    {
        $data['flag_id'] = $flag_id;
        $data['article_id'] = $article_id;
        $data['ctime'] = now();

        $result = D('ArticleTagMap')->add($data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}