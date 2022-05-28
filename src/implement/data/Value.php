<?php

namespace shiyun\annotation\implement\data;

use Attribute;
use Reflector;
use shiyun\annotation\enum\AnnotationEnum;
use shiyun\annotation\abstracts\DataAbstract;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Value extends DataAbstract
{

    public AnnotationEnum $hookEnum = AnnotationEnum::beforeCreate;

    public function __construct(protected mixed $default = "", protected string $desc = "")
    {
    }

    public function process(Reflector $reflector, &$args): Reflector
    {
        // TODO: Implement process() method.
        if ($reflector instanceof \ReflectionParameter) {
            $args['parameters'] = $args['parameters'] ?? [];
            $args['parameters'][$reflector->getPosition()] = $this->getValue($reflector, args: $args['parameters']);
        } else {
            $object = $this->getObject($args);
            if (!is_object($object)) return $reflector;
            $reflector->setValue($object, $this->getValue($reflector, $object));
        }
        return $reflector;
    }
}
