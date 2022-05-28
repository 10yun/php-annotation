<?php

namespace shiyun\annotation\implement\request;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class RoutePut extends RouteRequest
{
    protected string $method = "PUT";
}
