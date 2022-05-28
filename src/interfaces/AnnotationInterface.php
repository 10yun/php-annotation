<?php

namespace shiyun\annotation\interfaces;

use Reflector;

interface AnnotationInterface
{
    public function process(Reflector $reflector, &$args): mixed;
}
