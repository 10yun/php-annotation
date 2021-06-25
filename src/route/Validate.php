<?php

namespace shiyun\annotation\route;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Validate
 * @package shiyun\annotation\route
 * @Annotation
 * @Annotation\Target({"METHOD"})
 */
final class Validate extends Annotation
{
    /**
     * @var string
     */
    public $scene;

    /**
     * @var array
     */
    public $message = [];

    /**
     * @var bool
     */
    public $batch = true;
}
