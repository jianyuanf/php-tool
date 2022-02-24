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
namespace ToolPackage\Tool\Facade\Lib;

use ToolPackage\Tool\Helpers\ArrayLibrary;
use ToolPackage\Tool\Facade\BaseFacade;

/**
 * Class ArrayFacade
 * @method static arrayGroupBy(array $arr, string $key) : array
 * @method static arraySort(array $array,string $keys,string $sort='asc') : array
 * @method static convertUrlQuery(string $url) : array
 * @package ToolPackage\Tool\Facade\Lib
 */
class ArrayFacade extends BaseFacade
{
    /**
     * @return string[]
     * @author JYF 2022/2/24 17:54
     */
    protected static function getFacadeClass(): array
    {
        return [ArrayLibrary::class];
    }
}