<?php

namespace shiyun\annotation\route;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * 注入模型
 * @package shiyun\annotation\route
 * @Annotation
 * @Target({"METHOD"})
 */
final class Model extends Annotation
{
    /**
     * @var string
     */
    public $var = 'id';

    /**
     * @var boolean
     */
    public $exception = true;
}
