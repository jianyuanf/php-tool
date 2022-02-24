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

namespace ToolPackage\Tool\Facade;

use ToolPackage\Tool\Helpers\ContextLibrary;

abstract class BaseFacade
{
    abstract protected static function getFacadeClass();

    protected static function createFacade()
    {
        $classInfo = static::getFacadeClass();
        $className = $classInfo[0];
        if (!ContextLibrary::has($className)) {
            if (isset($classInfo[1])) {
                unset($classInfo[0]);
                ContextLibrary::set($className, new $className(...$classInfo));
            } else {
                ContextLibrary::set($className, new $className);
            }
        }
        return ContextLibrary::get($className);
    }

    // 调用实际类的方法
    public static function __callStatic($method, $params)
    {
        return call_user_func_array([static::createFacade(), $method], $params);
    }
}