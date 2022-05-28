<?php

namespace shiyun\annotation\implement;

use Attribute;
use Reflector;
use shiyun\annotation\abstracts\AnnotationAbstract;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Domain extends AnnotationAbstract
{

    public function __construct(protected array|string $domain = '*', protected array $args = [])
    {
    }

    public function process(Reflector $reflector, &$args): mixed
    {
        // TODO: Implement process() method.
        return null;
    }
}
