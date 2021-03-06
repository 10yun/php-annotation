<?php

namespace shiyun\annotation\traits;

use ReflectionNamedType;
use ReflectionFunctionAbstract;
use ReflectionProperty;
use ReflectionParameter;
use Reflector;
use shiyun\annotation\Container;
use shiyun\annotation\exceptions\InvokeClassException;


trait GenerateParameters
{

    /**
     * 生成绑定参数
     * @param ReflectionFunctionAbstract $method
     * @param array $vars
     * @return array
     * @throws InvokeClassException
     */
    public function GenerateBindParameters(ReflectionFunctionAbstract $method, array $vars = []): array
    {
        if (!$vars && $method->getNumberOfParameters() === 0) return [];
        $parameters = $method->getParameters();

        reset($vars);

        $type = key($vars) === 0 ? 1 : 0;
        $args = [];
        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $types = $this->getParameterType($parameter);
            if (count($types) > 0) {
                if (class_exists($types[0]))
                    $args[] = $this->getObjectParam($types[0], $vars);
                elseif (1 == $type && !empty($vars))
                    $args[] = array_shift($vars);
                elseif ($parameter->isDefaultValueAvailable())
                    $args[] = $parameter->getDefaultValue();
                //                else throw new \Error('method '. $method -> getName() .' param miss:' . $name);
            }
        }
        return $args;
    }

    /**
     * 获取方法参数 返回实例化
     * @param string $className
     * @param array $vars
     * @return object
     * @throws InvokeClassException
     */
    public function getObjectParam(string $className, array &$vars): object
    {
        $value = array_shift($vars);
        return $value instanceof $className ? $value : Container::getInstance()->make($className);
    }

    /**
     * 获取参数类型
     * @param ReflectionProperty|ReflectionParameter|Reflector $property
     * @return array
     */
    public function getParameterType(ReflectionProperty|ReflectionParameter|Reflector $property): array
    {
        $type = $property->getType();
        $types = [];
        if ($type instanceof \ReflectionUnionType) {
            $types = array_map(fn ($info): string => $info->getName(), $type->getTypes());
        } else if ($type instanceof ReflectionNamedType) {
            $types[] = $type->getName();
        }
        return $types ?: ['mixed'];
    }
}
