<?php

namespace shiyun\annotation\implement\data;

use Attribute;
use ReflectionException;
use Reflector;
use shiyun\annotation\Container;
use shiyun\annotation\enum\AnnotationEnum;
use shiyun\annotation\abstracts\DataAbstract;
use shiyun\annotation\exceptions\ValueException;
use shiyun\annotation\exceptions\InvokeClassException;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
class NotNull extends DataAbstract
{

    public AnnotationEnum $hookEnum = AnnotationEnum::InitializerNonExecute;

    public function __construct(protected mixed $value = "", protected string $error = "")
    {
    }

    /**
     * @param Reflector $reflector
     * @param ...$args
     * @return bool
     * @throws InvokeClassException
     * @throws ReflectionException
     * @throws ValueException
     */
    public function process(Reflector $reflector, &$args): bool
    {
        // TODO: Implement process() method.
        try {
            // 获取初始化值
            $object = $reflector instanceof \ReflectionParameter ? null : $this->getObject($args);

            $args['parameters'] = $args['parameters'] ?? [];
            $value = $this->getValue($reflector, $object, $args['parameters']);

            $type = Container::getInstance()->getParameterType($reflector);
            if (in_array('array', $type) && empty($value)) $this->throw_error($reflector, 403);
            if (!is_null($value) && $value !== '') return true;
            $this->throw_error($reflector, 403);
        } catch (\Error) {
            $this->throw_error($reflector);
        }
    }
}
