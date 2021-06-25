<?php

namespace shiyun\annotation;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\Common\Annotations\Annotation\Target;
use shiyun\annotation\route\Rule;

/**
 * 注册路由
 * @package topshiyun\annotation
 * @Annotation
 * @Target({"METHOD","CLASS"})
 */
final class Route extends Rule
{
    /**
     * @Required()
     * @var string
     */
    public $route;


    // /**
    //  * @Enum({"POST", "GET", "PUT", "DELETE"})
    //  * @var string
    //  */


    /**
     * 请求类型
     * @Enum({"GET","POST","PUT","DELETE","PATCH","OPTIONS","HEAD"})
     * @var string
     */
    public $method = "*";

    /**
     * @var array
     */
    public $param;

    public $time;
}
