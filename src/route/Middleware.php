<?php

namespace shiyun\annotation\route;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * 路由中间件
 * @package shiyun\annotation\route
 * @Annotation
 * @Target({"CLASS","METHOD"})
 */
final class Middleware extends Annotation
{
}
