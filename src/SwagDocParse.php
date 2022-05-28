<?php

declare(strict_types=1);

namespace leruge;

use leruge\annotation\Param;
use leruge\annotation\Response;
use leruge\annotation\Route;
use leruge\annotation\Title;

class DocParse
{
    public function index()
    {
        $config = [
            'title' => '文档',
            'version' => '1.0.1',
            "description" => "接口的请求方式目前只有get和post",
            'code_desc' => [
                '1' => '请求成功',
                '0' => '请求失败'
            ],
            'controller' => [],
        ];
        // 递归合并配置
        $config = array_replace_recursive($config, config('doc'));

        $controllerArray = $config['controller'];
        $apiUrlArray = [];
        foreach ($controllerArray as $controller) {
            // 获取反射类
            try {
                $reflectionClass = new \ReflectionClass($controller);
            } catch (\Throwable) {
                continue;
            }
            // 获取类的Title注解
            $classAnnotationArray = $reflectionClass->getAttributes(Title::class);
            // 获取tag
            try {
                $tag = $classAnnotationArray[0]->newInstance()->title;
            } catch (\Throwable) {
                $tag = $controller;
            }
            // 获取当前类的所有公共反射方法
            $reflectionMethodArray = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach ($reflectionMethodArray as $reflectionMethod) {
                // 获取Route注解实例
                $annotationRouteArray = $reflectionMethod->getAttributes(Route::class);
                try {
                    $routeObject = $annotationRouteArray[0]->newInstance();
                } catch (\Throwable) {
                    continue;
                }
                // Route设置url属性以后才会获取其它属性，比如method、title、deprecated等
                if (empty($routeObject->url)) {
                    continue;
                } else {
                    $method = $routeObject->method == 'get' ? 'get' : 'post';
                    $title = $routeObject->title ?: $reflectionMethod->getName();
                    $deprecated = $routeObject->deprecated;
                    // 获取注解参数
                    $annotationParamArray = $reflectionMethod->getAttributes(Param::class);
                    $paramArray = [];
                    foreach ($annotationParamArray as $annotationParam) {
                        $paramObject = $annotationParam->newInstance();
                        if ($paramObject->name) {
                            $paramArray[] = [
                                'name' => $paramObject->name,
                                'in' => 'formData',
                                'description' => $paramObject->desc,
                                'required' => $paramObject->require === true,
                                'type' => $paramObject->type === 'file' ? 'file' : 'string',
                                'default' => $paramObject->default
                            ];
                        }
                    }
                    // 获取注解响应
                    $annotationResponseArray = $reflectionMethod->getAttributes(Response::class);
                    $responseData = [];
                    try {
                        $responseObject = $annotationResponseArray[0]->newInstance();
                        $responseData = $this->handleArrayToSwagger($responseObject->response);
                    } catch (\Throwable) {
                    }
                    // 组装swagger的path
                    $apiUrlArray[$routeObject->url] = [
                        $method => [
                            'tags' => [$tag],
                            'summary' => $title,
                            'deprecated' => $deprecated,
                            'parameters' => $paramArray,
                            'responses' => [
                                'response' => [
                                    'description' => '响应结果',
                                    'schema' => [
                                        'properties' => [
                                            'code' => [
                                                'example' => $config['code_desc']
                                            ],
                                            'msg' => [
                                                'example' => '提示信息'
                                            ],
                                            'time' => [
                                                'example' => '请求时间'
                                            ],
                                            'data' => [
                                                'properties' => $responseData
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ];
                }
            }
        }
        // 组装swagger
        $swaggerData = [
            'swagger' => '2.0',
            'info' => [
                'title' => $config['title'],
                'version' => $config['version'],
                'description' => $config['description']
            ],
            'securityDefinitions' => [
                'JWT' => [
                    'type' => 'apiKey',
                    'description' => 'JWT方式',
                    'name' => 'Authorization',
                    'in' => 'header'
                ]
            ],
            'security' => [
                ['JWT' => []]
            ],
            'paths' => $apiUrlArray
        ];
        $filename = public_path() . 'swagger' . DIRECTORY_SEPARATOR . 'swagger.json';
        file_put_contents($filename, json_encode($swaggerData, JSON_UNESCAPED_UNICODE));
        return redirect('/swagger/index.html');
    }

    // 将响应结果处理成swagger格式
    private function handleArrayToSwagger(mixed $response): array
    {
        $res = [];
        foreach ($response as $k => $v) {
            $res[$k] = $this->handleSwagger($v);
        }
        return $res;
    }

    // 处理swagger
    private function handleSwagger(mixed $data): array
    {
        if (is_array($data)) {
            $res = [];
            foreach ($data as $k => $v) {
                $res[$k] = $this->handleSwagger($v);
            }
            if ($this->isRelateArray($data)) {
                return [
                    'properties' => $res
                ];
            } else {
                return [
                    'items' => $res[0]
                ];
            }
        } else {
            return [
                'example' => $data
            ];
        }
    }

    // 判断是否关联数组
    private function isRelateArray(array $array): bool
    {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }
}
