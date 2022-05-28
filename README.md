# php-annotation


**功能**

- php版本 [![Php Version](https://img.shields.io/badge/php-%3E=8.1-brightgreen.svg)](https://secure.php.net/)
- PHP8注解
- 容器 (PSR-11)
- 自定义注解模块
- 注释生成swagger文档
- 接口文档

## 十云 php-annotation 可以做什么

- 为 Webman 项目的控制器提供注解路由功能

- 保留 Webman 路由中间件能力

- 根据注解信息实时生成 [__OpenAPI 3.0__](https://swagger.io/specification/) 文档

- 提供 OpenAPI 规范的输入提示能力

- 自带 [__Swagger UI__](https://swagger.io/tools/swagger-ui/) 提供接口自测、对接

- 根据注解信息自动验证过滤输入信息 ( 1.0.0开始提供 )


刚好，所以就使用注解的特性写一个简易的自动生成接口文档的扩展，使用了JWT，参数只支持form。





## 快速开始

- 安装

```sh
composer require shiyun/php-annotation
```


## 使用说明

1. 安装完成以后会在config目录生成一个 sy-annotation.php 配置文件，如果没有请手动创建
```php
return [
    'title' => '文档',
    'version' => '1.0.1',
    'code_desc' => [
        '1' => '请求成功',
        '0' => '请求失败'
    ],
    // 把需要生成文档的控制器写到这里
    'controller' => [],
    'openapi'=>false,
];
```


## 使用文档


## [__在线文档 (Link)__](https://thoughts.aliyun.com/workspaces/60803fedd61dc1001a37cee9)

[__Webman Auto Route__](https://packagist.org/packages/qnnp/webman-auto-route) 是一个基于 PHP8 注解开发的一个
[__php__](https://www.workerman.net/doc/webman) 扩展组件。
