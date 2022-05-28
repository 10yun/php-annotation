<?php

declare(strict_types=1);

namespace shiyun\annotation;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_METHOD)]
class Param
{
    public function __construct(
        public $name = '',
        public $type = 'string',
        public $require = true,
        public $desc = '',
        public $default = ''
    ) {
    }
}
