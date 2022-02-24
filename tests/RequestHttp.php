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

use ToolPackage\Tool\Http\Request;

class RequestHttp
{
    public static function testGet()
    {
        $request = new Request();
        return $request->setUrl('http://www.baidu.com')->get();
    }
}

var_dump(RequestHttp::testGet());