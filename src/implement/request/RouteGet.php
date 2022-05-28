<?php

namespace shiyun\annotation\implement\request;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class RouteGet extends RouteRequest
{
    protected string $method = "GET";
}
