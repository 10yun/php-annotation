<?php

declare(strict_types=1);

namespace shiyun\annotation;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Title
{
    public function __construct(
        public $title = ''
    ) {
    }
}
