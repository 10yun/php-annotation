<?php

namespace shiyun\annotation\implement\request;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class RouteGroup extends RouteRequest
{
    protected string $method = "*";
}
