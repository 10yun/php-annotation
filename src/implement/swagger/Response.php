<?php

declare(strict_types=1);

namespace shiyun\annotation;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Response
{
    public function __construct(
        public $response = []
    ) {
    }
}
