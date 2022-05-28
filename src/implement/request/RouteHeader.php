<?php

namespace shiyun\annotation\implement\request;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class RouteHeader extends RouteRequest
{
    protected string $method = "HEAD";
}
