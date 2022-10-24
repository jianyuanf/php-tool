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


namespace ToolPackage\Tool\Facade\Lib;


use ToolPackage\Tool\Facade\BaseFacade;
use ToolPackage\Tool\Helpers\StringLibrary;

/**
 * Class StringFacade
 * @method static filterEmoji(string $str): string
 * @method static filterSpecial(string $str): string
 * @method static strCutRepeat(string $str): string
 * @package ToolPackage\Tool\Facade\Lib
 */
class StringFacade extends BaseFacade
{

    /**
     * @return string[]
     * @author JYF 2022/10/24 16:21
     */
    protected static function getFacadeClass(): array
    {
        return [StringLibrary::class];
    }
}