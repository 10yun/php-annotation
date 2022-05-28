<?php

declare(strict_types=1);

namespace shiyun\annotation;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(
        public $title = '',
        public $method = 'post',
        public $url = '',
        public $deprecated = false
    ) {
    }
}
