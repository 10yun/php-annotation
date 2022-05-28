<?php

namespace shiyun\annotation\implement\swagger;

use Attribute;
use Reflector;
use shiyun\annotation\enum\AnnotationEnum;
use shiyun\annotation\abstracts\AnnotationAbstract;

#[Attribute(Attribute::TARGET_METHOD)]
class ResponseBody extends AnnotationAbstract
{
    public AnnotationEnum $hookEnum = AnnotationEnum::NonExecute;
    /**
     * Swagger 响应参数注解
     * @param Reflector $reflector
     * @param ...$args
     * @return mixed
     */
    public function process(Reflector $reflector, &$args): mixed
    {
        // TODO: Implement process() method.
        return null;
    }
}
