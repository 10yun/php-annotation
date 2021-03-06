<?php

namespace shiyun\annotation\implement\data;

use Attribute;
use Reflector;
use shiyun\annotation\Container;
use shiyun\annotation\abstracts\DataAbstract;
use shiyun\annotation\exceptions\InvokeClassException;
use shiyun\annotation\exceptions\InvokeFunctionException;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
class FilterArg extends DataAbstract
{

    public function __construct(
        protected mixed $called,
        protected array $calledParams = [],
        protected string $name = ''
    ) {
    }

    public function process(Reflector $reflector, &$args): mixed
    {
        // TODO: Implement process() method.
        $object = $reflector instanceof \ReflectionParameter ? null : $this->getObject($args);
        $value = $this->getValue($reflector, $object, $args);

        if ($reflector instanceof \ReflectionProperty) {
            $reflector->setValue($object, $this->called($value));
            return $reflector->getValue($object);
        } else {
            $index = $reflector->getPosition();
            return $args[$index] = $this->called($args[$index] ?: '');
        }
    }

    /**
     * @param $closure
     * @return mixed
     * @throws InvokeFunctionException|InvokeClassException
     */
    protected function called($closure): mixed
    {
        $container = Container::getInstance();
        // 验证是否为闭包
        if ($closure instanceof \Closure || function_exists($closure))
            return $container->invokeFunction($closure, [$this->calledParams]);

        // 验证是否为类
        $closure = explode('@', $closure);
        if (count($closure) < 2 || !class_exists($closure[0])) return null;

        return $container->invoke($closure, [$this->calledParams]);
    }
}
