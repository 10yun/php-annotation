<?php

namespace shiyun\annotation\implement\request;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class RoutePost extends RouteRequest
{
    protected string $method = "POST";
}
