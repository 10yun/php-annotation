<?php

namespace shiyun\annotation\implement\swagger;

use Attribute;
use Reflector;
use shiyun\annotation\abstracts\AnnotationAbstract;
use shiyun\annotation\enum\AnnotationEnum;

#[Attribute(Attribute::TARGET_METHOD)]
class RequestParameters extends AnnotationAbstract
{

    public AnnotationEnum $hookEnum = AnnotationEnum::NonExecute;

    public function process(Reflector $reflector, &$args): mixed
    {
        // TODO: Implement process() method.
        return null;
    }
}
