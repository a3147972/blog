<?php
namespace Common\Tools;

class ArrayHelper
{
    /**
     * 二维数组替换key(支持一维)
     * @method array_key_replace
     * @param  array         $array   要操作的数据
     * @param  array|string         $old_key 旧的key name
     * @param  array|string         $new_key 新key name
     */
    public static function array_key_replace($array, $old_key, $new_key)
    {
        if (empty($array)) {
            return $array;
        }

        $level = is_array(reset($array)) ? 2 : 1; //判断数组维数

        $old_key = !is_array($old_key) ? array($old_key) : $old_key;
        $new_key = !is_array($new_key) ? array($new_key) : $new_key;
        if (count($old_key) != count($new_key)) {
            return false;
        }

        if ($level === 1) {
            //一维数组
            $keys = array_keys($array);
            $keys = array_combine($keys, $keys);
            $replace_keys = array_combine($old_key, $new_key);
            $keys = array_replace($keys, $replace_keys);
            $values = array_values($array);
            $array = array_combine($keys, $values);
        } else {
            //二维数组
            $keys = array_keys(reset($array));

            $keys = array_combine($keys, $keys);
            $replace_keys = array_combine($old_key, $new_key);
            $keys = array_replace($keys, $replace_keys);
            foreach ($array as $_k => $_v) {
                $values = array_values($array[$_k]);
                $_v = array_combine($keys, $values);
                $array[$_k] = $_v;
            }
        }
        return $array;
    }

    /**
     * 无限极分类
     * @method tree
     * @param  [type]  $array    要处理的数据
     * @param  string  $pid_name 父键名称
     * @param  string  $id_name  主键名称
     * @param  integer $pid      父键开始
     * @param  integer $level    层级
     * @return array            处理后的数据
     */
    public static function tree($array, $pid_name = 'pid', $id_name = 'id', $pid = 0, $level = 0)
    {
        static $list = array();

        foreach ($array as $_k => $_v) {
            if ($_v[$pid_name] == $pid) {
                $list[$_k] = $_v;
                $list[$_k]['_level'] = $level;
                self::tree($array, $pid_name, $id_name, $_v[$id_name], $level + 1);
            }
        }
        return $list;
    }

    /**
     * 两级分类,子类归到child_list里
     * @method child_tree
     * @param  array     $array    要处理的数组
     * @param  string     $pid_name 父键名称
     * @param  string     $id_name  主键名称
     * @param  integer    $pid      父键开始
     * @return array               处理后的数据
     */
    public static function child_tree($array, $pid_name = 'pid', $id_name = 'id')
    {
        static $list = array();

        foreach ($array as $_k => $_v) {
            if ($_v[$pid_name] == 0) {
                $list[$_v[$id_name]] = $_v;
            } else {
                $list[$_v[$pid_name]]['child_list'][] = $_v;
            }
        }
        return $list;
    }

    /**
     * 把数组变为数字key
     * @method array_number_key
     * @param  array           $array 要处理的数组
     * @return array                  处理后的数组
     */
    public static function array_number_key($array)
    {
        $keys = range(0, count($array));
        $array = array_combine($keys, array_values($array));

        return $array;
    }
}
