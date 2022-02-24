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

require_once __DIR__ . '/../vendor/autoload.php';
use \ToolPackage\Tool\Facade\Lib\ArrayFacade;

class ArrayLibrary
{
    public static function arrayGroupBy()
    {
        return ArrayFacade::arrayGroupBy([['comment_id'=>120],['comment_id'=>120],['comment_id'=>12]],'comment_id');
    }
}
var_dump(ArrayLibrary::arrayGroupBy());