<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | Created by PhpStorm.
// +----------------------------------------------------------------------
// | user : JYF
// +----------------------------------------------------------------------
// | blog : 
// +----------------------------------------------------------------------
// | email: jianjian.fan@qq.com
// +----------------------------------------------------------------------
// | Date : 2024/5/11
// +----------------------------------------------------------------------


namespace ToolPackage\Tool\Facade\Lib;


use ToolPackage\Tool\Facade\BaseFacade;
use ToolPackage\Tool\Helpers\MoneyLibrary;

/**
 * Class MoneyFacade
 * @method static dePriceFormat(string $price) : string
 * @method static enPriceFormat(string $price) : string
 * @method static dePriceGoToZeroFormat(string $price) : string
 * @package ToolPackage\Tool\Facade\Lib
 */
class MoneyFacade extends BaseFacade
{
    /**
     * @return string[]
     * @author JYF 2024/5/11 9:51
     */
    protected static function getFacadeClass(): array
    {
        return [MoneyLibrary::class];
    }
}