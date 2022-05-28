# 接口文档
swagger根据注释生成文档的方式使用起来不是很方便，刚好PHP8支持比较简单的注解，所以就使用注解的特性写一个简易的自动生成接口文档的扩展，使用了JWT，参数只支持form。

## 安装
-  `omposer require leruge/doc`

## 使用说明
1. 安装完成以后会在config目录生成一个doc.php配置文件，如果没有请手动创建
```php
[
    'title' => '文档',
    'version' => '1.0.1',
    'code_desc' => [
        '1' => '请求成功',
        '0' => '请求失败'
    ],
    // 把需要生成文档的控制器写到这里
    'controller' => [],
];
```

## 注解使用说明
1. 注解示例
```php
#[Title("登录相关")]
class Login
{
    #[Route(title: "测试接口", method: "post", url: "/admin/demo", deprecated: false)]
    #[Param(name: "phone", type: "string", require: true, desc: "手机号", default: "17000000001")]
    #[Param(name: "file", type: "file", require: true, desc: "文件")]
    #[Response(response: [
        'count' => '总数量',
        'pic' => ['图片数组'],
        'list' => [
            [
                'name' => '姓名',
                'age' => '年龄',
                'a' => [
                    'sex' => '性别'
                ]
            ]
        ],
        'info' => [
            'name' => '姓名'
        ],
    ])]
    public function demo()
    {
        // 处理参数和响应
    }
}
```
2. 注解类目前有4个Title、Route、Param、Response
    1. Title注解类只能用于类，用来说明这个类大概是什么作用，如果不在类上声明，则默认是类名称
    2. Route注解类只能用于方法，必须声明，如果不声明，则方法不会生成文档，目前支持的参数有title(接口说明，不声明则是方法名)、method(请求方式，不声明则为post)、url(请求地址，必须声明，如果不声明则不生成文档)、deprecated(接口是否废弃，不声明则是false)
    3. Param注解类只能用于方法，有参数则声明，没有则不声明，目前参数仅支持form，name(参数名称)、type(仅支持string和file，默认是string)、require(是否必填，默认是true)、desc(参数描述)、default(默认值)
    4. Response注解类只能用于方法，有响应则声明，没有则不声明，支持4种格式
         1. 字符串 `'count' => '总数量'`
         2. 字符串数组 `'pic' = ['图片数组']`
         3. 列表 `['list' => [['name' => 'swk']]]`
         4. 关联数组 `['info' => ['name' => 'swk'']`
   
## 接口访问
- 域名+doc.html

## 联系方式
- email：leruge@163.com
- qq：305530751
- wx：lerage