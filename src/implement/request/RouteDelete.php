<?php

namespace shiyun\annotation\implement\request;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class RouteDelete extends RouteRequest
{
    protected string $method = "DELETE";
}
