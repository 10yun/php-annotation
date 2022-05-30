<?php

declare(strict_types=1);

namespace shiyun\annotation;

#[\Attribute(\Attribute::TARGET_CLASS)]
class SwagTitle
{
    public function __construct(
        public $title = ''
    ) {
    }
}
