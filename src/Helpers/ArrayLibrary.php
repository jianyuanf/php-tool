<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | Created by PhpStorm.
// +----------------------------------------------------------------------
// | user : JYF
// +----------------------------------------------------------------------
// | blog : blog.jianjiana.cn
// +----------------------------------------------------------------------
// | email: 1749934563@qq.com
// +----------------------------------------------------------------------
// | Date : 2022/2/24
// +----------------------------------------------------------------------

namespace ToolPackage\Tool\Helpers;

class ArrayLibrary
{
    /**
     * 传入$arr二维数组 根据$key分组
     * @param array $arr
     * @param string $key
     * @return array
     * @author JYF 2022/2/24 17:58
     */
    public function arrayGroupBy(array $arr, string $key) : array
    {
        $grouped = array();
        foreach ($arr as $k => $value) {
            $grouped[$value[$key]][$k] = $value;
        }
        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $params = array_merge(array($value), array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $params);
            }
        }
        return $grouped;
    }

    /**
     * 指定键值对数组进行排序
     * @param array $array
     * @param string $keys
     * @param string $sort
     * @return array
     * @author JYF 2022/2/24 17:57
     */
    public function arraySort(array $array,string $keys,string $sort='asc') : array
    {
        $newArr =
        $valArr = array();
        foreach ($array as $key => $value) {
            $valArr[$key] = $value[$keys];
        }
        ($sort == 'asc') ? asort($valArr) : arsort($valArr);
        reset($valArr);
        foreach ($valArr as $key => $value) {
            $newArr[$key] = $array[$key];
        }
        return $newArr;
    }

    /**
     * url 参数解析
     * @param string $url
     * @return array
     * @author JYF 2022/2/24 17:57
     */
    public function convertUrlQuery(string $url) : array
    {
        $arr = parse_url(urldecode($url));
        parse_str($arr['query'],$query_arr);

        $query_arr = array_filter($query_arr);

        foreach ($query_arr as $key => &$value){
            if(is_numeric($value)){
                $value = (int)$value;
            }
        }
        return $query_arr;
    }
}