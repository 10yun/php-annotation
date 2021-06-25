<?php

namespace shiyun\annotation\common;

use shiyun\annotation\route\Rule;
// abstract class Mapping extends AbstractAnnotation

abstract class Mapping
{
    /**
     * @var array
     */
    public $methods;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $options = [];

    public function __construct($value = null)
    {
        if (isset($value['path'])) {
            $this->path = $value['path'];
        }
        if (isset($value['options'])) {
            $this->options = (array) $value['options'];
        }
        // $this->bindMainProperty('path', $value);
    }
}
