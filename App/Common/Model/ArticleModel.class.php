<?php
namespace Common\Model;

use Common\Model\BaseModel;

class ArticleModel extends BaseModel
{
    protected $tableName = 'article';
    protected $selectFields = 'id,title,writer,source,thumb,content,view_count,status,ctime';

    protected $_validate = array(
        array('title', 'require', '请输入文章标题'),
        array('writer', 'require', '请输入作者'),
        array('source', 'require', '请输入俩预案'),
        array('content', 'require', '请输入文章内容'),
    );

    protected $_auto = array(
        array('ctime', 'now', 1, 'function'),
        array('mtime', 'now', 3, 'function'),
        array('desc', 'auto_desc', 3, 'callback'),
        array('status', 1, 1, 'string'),
    );

    protected function auto_desc()
    {
        $desc = I('post.desc', '');

        if (!empty($desc)) {
            return $desc;
        }

        $content = strip_tags(I('post.content'));
        $desc = msubstr($content, 0, 200);

        return $desc;
    }

    /**
     * 获取单篇文章信息
     * @method get
     * @param  array  $map   查询条件
     * @param  string $field 查询字段
     * @param  string $order 排序规则
     * @return array         查询出的数据
     */
    public function get($map = array(), $field = '', $order = '')
    {
        $info = $this->_get($map, $field, $order);

        if (empty($info)) {
            return array();
        }

        $article_id = $info['id'];

        $flag_list = D('Flag')->getListByArticleId($article_id);
        $tag_list = D('Tag')->getListByArticleId($article_id);

        $info['flag_list'] = $flag_list[$article_id];
        $info['tag_list'] = $tag_list[$article_id];

        return $info;
    }

    /**
     * 获取文章列表
     * @method lists
     * @param  array   $map       查询条件
     * @param  integer $page      页数
     * @param  integer $page_size 每页条数
     * @param  string  $field     查询字段
     * @param  string  $order     排序规则
     * @return array              查询出得数据
     */
    public function lists($map = array(), $page = 0, $page_size = 10, $field = '', $order = '')
    {
        $list = $this->_list($map, $page, $page_size, $field, $order);

        if (empty($list)) {
            return array();
        }
        $article_id = array_column($list, 'id');

        $flag_list = D('Flag')->getListByArticleId($article_id);
        $tag_list = D('Tag')->getListByArticleId($article_id);

        foreach ($list as $_k => $_v) {
            $list[$_k]['flag_list'] = $flag_list[$_v['id']];
            $list[$_k]['tag_list'] = $tag_list[$_v['id']];
        }

        return $list;
    }
}
