


## 路由完整示例

```php
<?php

namespace app\controller;

use support\Request;
use support\Response;
use Throwable;
use shiyun\annotation\Attributes\Route;
use shiyun\annotation\Module\OpenAPI\contact;
use shiyun\annotation\Module\OpenAPI\info;
use shiyun\annotation\Module\OpenAPI\license;
use shiyun\annotation\Module\OpenAPI\media;
use shiyun\annotation\Module\OpenAPI\requestBody;
use shiyun\annotation\Module\OpenAPI\response as res;
use shiyun\annotation\Module\OpenAPI\schema;

class Index {

  #[
    Route('test1',
      Info: [  // 大写字母开头的，或者 g_* 开头的参数一般为 OpenAPI 文档根节
               // 点参数，全项目只需要声明一次，多次声明会被自动覆盖
        info::title          => 'WebmanPress', // 对应的 OpenAPI 节点信息可以使用对应的对象提示
        info::description    => '项目描述',
        info::version        => '0.0.1',
        info::termsOfService => 'http://localhost/service.html',
        info::contact        => [
          contact::name  => 'qnnp',
          contact::url   => 'http://localhost/contact.html',
          contact::email => 'qnnp@qnnp.me'
        ],
        info::license        => [
          license::name => 'MIT License',
          license::url  => 'https://opensource.org/licenses/MIT'
        ],

      ],
      Security: [ // 全局认证声明
        [
          'token' => []
        ]
      ],
      SecuritySchemes: [ // 此项为 components -> securitySchemes 节点参数
        'token' => [
          'type' => 'apiKey',
          'name' => 'Authorization',
          'in'   => 'header',
        ]
      ],
    ),
    Route('/the-test', 'post',
      openapi: true,  // /api/* 下的会自动加进文档、非 /api/* 路径下的需要加入文档可将此项设为 true 
      post: [
        'key' => [
          schema::required => true
        ]
      ],
      requestBody: [
        requestBody::required    => true,
        requestBody::content     => [
          'application/x-www-form-urlencoded' => [
            media::schema => [
              schema::type       => 'object',
              schema::properties => [
                'key' => [
                  schema::type => 'integer'
                ]
              ]
            ]
          ]
        ],
        requestBody::description => 'Body 描述',
      ],
      responses: [
        200 => [
          res::description => 'asd',
          res::content     => [
            'application/json' => [
              media::schema  => [
                schema::properties => [
                  'key' => [
                    schema::type => 'string'
                  ]
                ]
              ],
              media::example => [
                'key' => 'value'
              ],
            ]
          ],
        ]
      ]
    )
  ]
  public function test(
    Request $request
  ): Response {
    return json(['code' => 200, 'message' => 'success', 'data' => 'Hello !']);
  }
}


```

[comment]: <> (Swagger 效果)

[comment]: <> (![]&#40;https://tcs-devops.aliyuncs.com/storage/112416531c7cd9d41915d978281c6f715881?Signature=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJBcHBJRCI6IjVlODQ0MTNlZTEwZjY0NDE0NzZlNzI0YyIsIl9hcHBJZCI6IjVlODQ0MTNlZTEwZjY0NDE0NzZlNzI0YyIsIl9vcmdhbml6YXRpb25JZCI6IiIsImV4cCI6MTYyMDU1MDE5NywiaWF0IjoxNjE5OTQ1Mzk3LCJyZXNvdXJjZSI6Ii9zdG9yYWdlLzExMjQxNjUzMWM3Y2Q5ZDQxOTE1ZDk3ODI4MWM2ZjcxNTg4MSJ9.zM3hbllGTcpj4men06mNBGCur_o1LNudoJvjhu8nZvQ&download=image.png ""&#41;)
