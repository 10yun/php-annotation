<?php

namespace shiyun\annotation;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\Common\Annotations\Annotation\Target;
use shiyun\annotation\route\Rule;

/**
 * 注册路由
 * @package shiyun\annotation
 * @Annotation
 * @Target({"METHOD","CLASS"})
 */
final class PostMapping extends Rule
{
    /**
     * @Required()
     * @var string
     */
    public $path;

    /**
     * @Required()
     * @var string
     */
    public $value;


    // /**
    //  * @Enum({"POST", "GET", "PUT", "DELETE"})
    //  * @var string
    //  */


    /**
     * 请求类型
     * @Enum({"POST","HEAD"})
     * @var string
     */
    public $method = "POST";

    /**
     * @var array
     */
    public $param;

    public $time;
}
