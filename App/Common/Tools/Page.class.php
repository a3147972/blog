<?php
namespace Common\Tools;

class Page
{
    private $count = 0;     //总条数
    private $page_number = 5;   //显示页数
    private $page = 1;      //当前页
    private $page_last = 0;     //最后页数

    /**
     * 初始化
     * @method __construct
     * @param  int      $count       总条数
     * @param  integer     $page        当前页
     * @param  integer     $page_size   每页条数
     * @param  integer     $page_number 显示页数
     */
    public function __construct($count, $page = 1, $page_size = 10, $page_number = 5)
    {
        $this->count = (int)$count;
        $this->page = (int)$page;
        $this->page_number = (int)$page_number;
        $this->page_last = ceil($this->count / (int)$page_size);
    }

    /**
     * 输出分页数组
     * @method show
     * @return array 分页数组
     */
    public function show()
    {
        $list = array();
        //首页
        $first['name'] = 'first';
        $first['page'] = 1;
        $first['status'] = $this->page == 1 ? 'active' : 'nomal';
        array_push($list, $first);

        //第一页
        $index['name'] = 'index';
        $index['page'] = 1;
        $index['status'] = $this->page == 1 ? 'active' : 'nomal';
        array_push($list, $index);

        //分页列表
        $page_list_first = $this->page - (int) ($this->page_number / 2) <= 0 ? 1 : $this->page - (int) ($this->page_number / 2);
        $page_list_last = $page_list_first + ($this->page_number - 1) >= $this->page_last ? $this->page_last : $page_list_first + ($this->page_number - 1);

        for ($i = $page_list_first; $i <= $page_list_last; $i++) {
            $list_temp['name'] = 'list';
            $list_temp['page'] = $i;
            $list_temp['status'] = $this->page == $i ? 'active' : 'nomal';
            array_push($list, $list_temp);
        }

        //下一页
        $next['name'] = 'next';
        $next['page'] = $this->page + 1 >= $this->page_last ? $this->page_last : $this->page + 1;
        $next['status'] = $this->page == $next['page'] ? 'active' : 'nomal';
        array_push($list, $next);

        //最后一页
        $last['name'] = 'last';
        $last['page'] = $this->page_last;
        $last['status'] = $this->page == $this->page_last ? 'avtive' : 'nomal';
        array_push($list, $last);

        return $list;
    }
}
