<?php

namespace shiyun\annotation\implement\request;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class RoutePatch extends RouteRequest
{
    protected string $method = "PATCH";
}
