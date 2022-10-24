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
// | Date : 2022/10/24
// +----------------------------------------------------------------------


namespace ToolPackage\Tool\Helpers;


class StringLibrary
{
    /**
     * 过滤掉emoji表情
     * @param string $str
     * @return string
     * @author JYF 2022/10/24 16:24
     */
    public function filterEmoji(string $str): string
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }

    /**
     * 过滤特殊字符
     * @param string $str
     * @return string
     * @author JYF 2022/10/24 16:24
     */
    public function filterSpecial(string $str): string
    {
        $str = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $str);
        $str = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $str);
        $str = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $str);
        $str = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $str);
        $str = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $str);
        $str = str_replace(array('"', '\''), '', $str);
        return addslashes(trim($str));
    }

    /**
     * 昵称保密处理：某**某
     * @param string $userName
     * @return string
     * @author JYF 2022/10/24 16:25
     */
    public function strCutRepeat(string $userName):string
    {
        $strLen = mb_strlen($userName, 'utf-8');
        if ($strLen && $strLen>=2){
            $firstStr = mb_substr($userName, 0, 1, 'utf-8');
            $lastStr = mb_substr($userName, -1, 1, 'utf-8');
            return $strLen == 2 ? $firstStr . str_repeat('*', $strLen - 1) :
                $firstStr . str_repeat("*", $strLen - 2) . $lastStr;
        }
        return $userName;
    }
}