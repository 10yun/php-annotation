<?php

namespace shiyun\annotation;

/**
 * 注册路由
 * @package topthink\annotation
 * @Annotation
 * @Target({"METHOD","CLASS"})
 */
final class PostMapping
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
