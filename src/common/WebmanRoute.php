<?php

/**
 * This file is part of webman-auto-route.
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    十云<author@10yun.com>
 * @copyright 十云<author@10yun.com>
 * @link      https://www.10yun.com/
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace shiyun\annotation\common;

use Attribute;
use FastRoute\RouteParser\Std;
use support\Request;
use Webman\Route as RouteClass;
use Webman\Route\Route as RouteObject;
use shiyun\annotation\Module\OpenAPI;
use shiyun\annotation\Module\OpenAPI\components;
use shiyun\annotation\Module\OpenAPI\externalDoc;
use shiyun\annotation\Module\OpenAPI\info;
use shiyun\annotation\Module\OpenAPI\media;
use shiyun\annotation\Module\OpenAPI\operation;
use shiyun\annotation\Module\OpenAPI\parameter;
use shiyun\annotation\Module\OpenAPI\post;
use shiyun\annotation\Module\OpenAPI\requestBody;
use shiyun\annotation\Module\OpenAPI\response;
use shiyun\annotation\Module\OpenAPI\schema;
use shiyun\annotation\Module\OpenAPI\securityScheme;
use shiyun\annotation\Module\OpenAPI\server;
use shiyun\annotation\Module\OpenAPI\tag;
use shiyun\annotation\Module\Validator;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_METHOD)]
class WebmanRoute
{
    public string   $path   = '';
    protected array $config = [
        'path' => '', 'method' => '', 'operation' => []
    ];

    /**
     * <h2 style="color:#E97230;">注解路由</h2>
     * <a href="https://swagger.io/specification/#operation-object">OpenAPI 规范文档</a>
     *
     * @param string          $route <span style="color:#E97230;">路由 Path</span>
     *
     * @param string          $method <span style="color:#E97230;">路由方法（get, post, put ...）</span>
     *
     * @param array           $middleware <span style="color:#E97230;">路由中间件</span>
     * <a href="https://www.workerman.net/doc/webman#/middleware" style="color:#5A9BF6;">Webman 中间件介绍</a>
     * <pre style="color:#3982F7;">[ MiddleWare::class, ... ]</pre>
     * <hr/>
     *
     * @param null            $openapi <span style="color:#E97230;">是否在 OpenAPI 文档中显示此路由方法(true|false)</span>
     * <hr/>
     *
     * @param parameter       $cookie <span style="color:#E97230;">cookie 参数列表</span>
     * <a href="https://swagger.io/specification/#parameter-object" style="color:#5A9BF6;">规范文档</a>
     * <pre style="color:#3982F7;">['field1', 'field2' => [...], ...]</pre>
     *
     * @param parameter       $header <span style="color:#E97230;">header 参数</span>
     * <a href="https://swagger.io/specification/#parameter-object" style="color:#5A9BF6;">规范文档</a>
     * <pre style="color:#3982F7;">['field1', 'field2' => [...], ...]</pre>
     *
     * @param parameter       $get <span style="color:#E97230;">get 参数 [parameter]</span>
     * <a href="https://swagger.io/specification/#parameter-object" style="color:#5A9BF6;">规范文档</a>
     * <pre style="color:#3982F7;">[
     *    'field1',
     *    'field2' => [
     *        'type'     => 'boolean',
     *        'required' => true,
     *        'schema'   => [...]
     *    ],
     *    ...
     *]</pre>
     *
     * @param post            $post <span style="color:#E97230;">post 参数</span>
     * <a href="https://swagger.io/specification/#schema-object" style="color:#5A9BF6;">规范文档</a>
     * <pre style="color:#3982F7;">[
     *    'field1',
     *    'field2' => [
     *        'type'     => 'boolean',
     *        'required' => true,
     *        'schema'   => [...]
     *    ],
     *    ...
     *]</pre>
     *
     * @param post            $file <span style="color:#E97230;">上传文件参数，将会附加到 post 参数列表</span>
     * <pre style="color:#3982F7;">['field1', 'field2' => [...],]</pre>
     *
     * @param array           $json <span style="color:#E97230;">json 参数</span>
     * <a href="https://swagger.io/specification/#schema-object" style="color:#5A9BF6;">规范文档</a>
     * <pre style="color:#3982F7;">[
     *    'field1',
     *    'field2' => [
     *        'type'     => 'boolean',
     *        'required' => true,
     *        'schema'   => [...]
     *    ],
     *    ...
     *]</pre>
     *
     * @param array           $xml <span style="color:#E97230;">xml 参数，参数列表第一个 item 将作为 root 标签名、</span>
     * <a href="https://swagger.io/specification/#schema-object" style="color:#5A9BF6;">规范文档</a>
     * <pre style="color:#3982F7;">[
     *    'root'   => 'tagName',
     *    'field1',
     *    'field2' => [
     *        'type'     => 'boolean',
     *        'required' => true,
     *        'schema'   => [...]
     *    ],
     *    ...
     *]</pre>
     * <hr/>
     *
     * @param bool            $requireBody <span style="color:#E97230;">requestBody 数据是否必须</span>
     *
     * @param tag             $tags <span style="color:#E97230;">[Operation] 方法所属分组</span>
     * <div style="color:#E97230;">直接给 string 就可以，如果需要添加描述等信息只需要注解一次就会自动注册到全局。</div>
     * <pre style="color:#3982F7;">[
     *    '标签名称',
     *    [
     *        'name'            => '标签名称带描述'
     *        'description'     => '标签描述',
     *        'externalDocs'    => [
     *            'description' => '外部文档描述',
     *            'url'         => '外部文档链接',
     *        ]
     *     ]
     *]</pre>
     *
     * @param string          $summary <span style="color:#E97230;">[Operation] 方法简介</span>
     * <a href="https://swagger.io/specification/#operation-object" style="color:#5A9BF6;">规范文档</a>
     *
     * @param string          $description <span style="color:#E97230;">[Operation] 方法详细说明</span>
     * <a href="https://swagger.io/specification/#operation-object" style="color:#5A9BF6;">规范文档</a>
     *
     * @param externalDoc     $externalDocs <span style="color:#E97230;">[Operation] 方法外部文档</span>
     *<pre style="color:#3982F7;">[
     *    'description' => '文档描述',
     *    'url'         => '文档链接'
     *]</pre>
     *
     * @param string          $operationId <span style="color:#E97230;">[Operation] 方法操作 ID，区分大小写且唯一</span>
     * <a href="https://swagger.io/specification/#operation-object" style="color:#5A9BF6;">规范文档</a>
     *
     * @param parameter       $parameters <span style="color:#E97230;">[Operation] 接受的参数列表</span>
     * <a href="https://swagger.io/specification/#parameter-object" style="color:#5A9BF6;">规范文档</a>
     * <pre style="color:#3982F7;">[
     *    [
     *        'name'        => '参数名称',
     *        'in'          => 'query', // query|path|header|cookie
     *        'description' => '参数描述说明',
     *        'required'    => true,
     *        'deprecated'  => false,
     *    ],
     *    ...
     *]</pre>
     *
     * @param requestBody     $requestBody <span style="color:#E97230;">[Operation] requestBody
     *     参数，上方四个快速设置参数满足不了的需求可以设置原生结构</span>
     * <a href="https://swagger.io/specification/#request-body-object" style="color:#5A9BF6;">标准文档</a>
     *
     * @param response        $responses <span style="color:#E97230;">[Operation] 返回数据示例</span>
     * <a href="https://swagger.io/specification/#responses-object" style="color:#5A9BF6;">规范文档</a>
     * <pre style="color:#3982F7;">[
     *    200 => [
     *        'description' => 'Success',
     *        'headers'     => [
     *            'x-header' => [
     *                'description' => '描述',
     *                'schema' => [
     *                    'type' => 'integer',
     *                    ...
     *                ],
     *            ]
     *        ],
     *    ]
     *]</pre>
     *
     * @param array           $callbacks <span style="color:#E97230;">[Operation] </span>
     * <a href="https://swagger.io/specification/#callback-object" style="color:#5A9BF6;">规范文档</a>
     *
     * @param bool            $deprecated <span style="color:#E97230;">[Operation] 声明此方法是否已被废弃</span>
     *
     * @param array           $security <span style="color:#E97230;">[Operation] 安全声明</span>
     * <a href="https://swagger.io/specification/#security-requirement-object" style="color:#5A9BF6;">规范文档</a>
     *
     * @param server          $servers <span style="color:#E97230;">[Operation] 服务器列表</span>
     * <a href="https://swagger.io/specification/#server-object" style="color:#5A9BF6;">规范文档</a>
     * <hr/>
     *
     * @param operation       $extend <span style="color:#E97230;">[Operation] 扩展选项</span>
     * <a href="https://swagger.io/specification/#operation-object" style="color:#5A9BF6;">规范文档</a>
     * <div style="color:#E97230;">用于扩展方法的选项、也可以用于强制替换方法选项</div>
     *
     * @param string          $g_openapi <span style="color:#E97230;">[OpenAPI] OpenAPI 规范版本  (此行以下参数全局声明一次即可)</span>
     *
     * @param info            $g_info <span style="color:#E97230;">[OpenAPI] 文档信息</span>
     * <pre style="color:#3982F7;">[
     *    'title'          => '项目名称',
     *    'description'    => '项目描述',
     *    'version'        => '0.0.0',
     *    'termsOfService' => 'http://localhost/service.html',
     *    'contact'        => [
     *        'name'  => '联系人',
     *        'url'   => 'http://localhost/contact.html',
     *        'email' => 'example@example.com'
     *    ],
     *    'license'        => [
     *        'name' => 'API许可',
     *        'url'  => 'http://localhost/license.html'
     *    ]
     *]</pre>
     *
     * @param server          $g_servers <span style="color:#E97230;">[OpenAPI] 接口服务器列表</span>
     * <pre style="color:#3982F7;">[
     *    [
     *        'url'         => 'https://development.gigantic-server.com/v1',
     *        'description' => 'Development server'
     *    ],
     *    [
     *        'url'         => 'https://{username}.gigantic-server.com:{port}/{basePath}',
     *        'description' => 'The production API server',
     *        'variables'   => [
     *            'username' => [
     *                'default'     => 'demo',
     *                'description' => 'description'
     *            ],
     *            'port'     => [
     *                'default'     => 'demo',
     *                'enum'        => [
     *                    '8443',
     *                    '443',
     *                ]
     *            ],
     *            'basePath' => [
     *                'default'     => 'v2',
     *            ],
     *        ]
     *    ],
     *    ...
     *]</pre>
     *
     * @param components      $g_components <span style="color:#E97230;">[OpenAPI] 公共组件</span>
     * <a href="https://swagger.io/specification/#components-object" style="color:#5A9BF6;">规范文档</a>
     *
     * @param securityScheme  $g_securitySchemes <span style="color:#E97230;">[OpenAPI] 认证方式声明</span>
     * <a href="https://swagger.io/specification/#security-scheme-object" style="color:#5A9BF6;">规范文档</a>
     *
     * @param array           $g_security <span style="color:#E97230;">[OpenAPI] 全局可选认证方式</span>
     * <a href="https://swagger.io/specification/#security-requirement-object" style="color:#5A9BF6;">规范文档</a>
     *
     * @param tag             $g_tags <span style="color:#E97230;">[OpenAPI] Tag 描述列表</span>
     * <pre style="color:#3982F7;">[
     *    'name'         => '标签名称',
     *    'description'  => '标签描述',
     *    'externalDocs'    => [
     *        'description' => '外部文档描述',
     *        'url'         => '外部文档链接',
     *    ]
     *]</pre>
     *
     * @param externalDoc     $g_externalDocs <span style="color:#E97230;">[OpenAPI] 服务器列表</span>
     * <a href="https://swagger.io/specification/#server-object" style="color:#5A9BF6;">规范文档</a>
     *
     * @param OpenAPI\openapi $g_extend <span style="color:#E97230;">[OpenAPI] 全局扩展选项</span>
     * <a href="https://swagger.io/specification/#openapi-object" style="color:#5A9BF6;">规范文档</a>
     * <div style="color:#E97230;">用于扩展根对象下的选项、也可以用于强制替换全局设置</div>
     *
     * @param null            $validator <span style="color:#E97230;">自定义方法参数验证器，设置后默认验证器将失效</span>
     *
     * @link https://swagger.io/specification/#operation-object Operation 规范
     * @link https://swagger.io/specification/ OpenAPI 标准
     */
    public function __construct(
        protected $route = '',
        protected $method = 'get',
        protected $middleware = [],
        protected $cookie = [],
        protected $header = [],
        protected $get = [],
        protected $post = [],
        protected $file = [],
        protected $json = [],
        protected $xml = [],
        protected $requireBody = false,
        protected $tags = [],
        protected $summary = '',
        protected $description = '',
        protected $externalDocs = [],
        protected $operationId = null,
        protected $parameters = [],
        protected $requestBody = [],
        protected $responses = [],
        protected $callbacks = [],
        protected $deprecated = false,
        protected $security = [],
        protected $servers = [],
        protected $extend = [],

        protected $openapi = null,
        protected $g_openapi = null,
        protected $g_info = [],
        protected $g_servers = [],
        protected $g_components = [],
        protected $g_securitySchemes = [],
        protected $g_security = [],
        protected $g_tags = [],
        protected $g_externalDocs = [],
        protected $g_extend = [],

        protected $Openapi = null,
        protected $Info = [],
        protected $Servers = [],
        protected $Components = [],
        protected $SecuritySchemes = [],
        protected $Security = [],
        protected $Tags = [],
        protected $ExternalDocs = [],
        protected $Extend = [],

        protected $validator = null
    ) {
        $this->g_openapi         = $this->Openapi;
        $this->g_info            = $this->Info;
        $this->g_servers         = $this->Servers;
        $this->g_components      = $this->Components;
        $this->g_securitySchemes = $this->SecuritySchemes;
        $this->g_security        = $this->Security;
        $this->g_tags            = $this->Tags;
        $this->g_externalDocs    = $this->ExternalDocs;
        $this->g_extend          = $this->Extend;


        // 路由路径预处理
        $this->path = (string)preg_replace("/^\.\//", '', $this->route);

        // 路由请求方法
        $this->method = [strtoupper($method)];

        // 响应值
        $this->responses = array_replace_recursive(['default' => ['description' => '']], $this->responses);

        /** 全局设置 */
        count($this->g_info) > 0 && OpenAPI::setInfo($this->g_info);

        count($this->g_tags) > 0 && OpenAPI::setTags($this->g_tags);

        count($this->g_extend) > 0 && OpenAPI::setExtend($this->g_extend);

        count($this->g_servers) > 0 && OpenAPI::setServers($this->g_servers);

        count($this->g_security) > 0 && OpenAPI::setSecurity($this->g_security);

        count($this->g_components) > 0 && OpenAPI::setComponents($this->g_components);

        count($this->g_externalDocs) > 0 && OpenAPI::setExternalDocs($this->g_externalDocs);

        $this->g_openapi && OpenAPI::setOpenAPIVersion($this->g_openapi);

        count($this->g_securitySchemes) > 0 && OpenAPI::setSecuritySchemes($this->g_securitySchemes);
    }
    protected function prepareParams($data, $type = false, &$parameters = [],)
    {
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                if (!isset($item['name'])) {
                    $item['name'] = $key;
                }
                $type && $item['in'] = $type;
            } else {
                $item = ['name' => $item];
                $type && $item['in'] = $type;
            }
            $default      = ['in' => 'query', 'schema' => ['type' => 'string']];
            $item         = array_replace_recursive($default, $item);
            $parameters[] = $item;
        }
    }

    protected function prepareBody($fields, $type = 'post',)
    {
        if (count($fields) == 0) return null;
        //
        $request_type = match ($type) {
            'file' => 'multipart/form-data',
            'json' => 'application/json',
            'xml' => 'application/xml',
            default => 'application/x-www-form-urlencoded'
        };
        $properties   = [];
        $required     = [];
        $xml_root     = 'root';
        if ($type == 'xml') {
            if (isset($fields['root'])) {
                $xml_root = $fields['root'];
                unset($fields['root']);
            } elseif (isset($fields[0]) && $fields[0]) {
                $xml_root = $fields[0];
                unset($fields[0]);
            }
        }
        foreach ($fields as $key => $conf) {
            if (is_array($conf)) {
                if (isset($conf['required'])) {
                    $conf['required'] && $required[] = $key;
                    unset($conf['required']);
                }
                $properties[$key] = $conf;

                // post
                // 携带文件上传字段的话转成 multipart/form-data
                // 因为 webman 框架的 $request->file() 只 支持这种形式的上传
                if (isset($conf['type']) && $conf['type'] == 'file') { // 规范不支持 type = file
                    $conf['type']   = 'string';
                    $conf['format'] = 'binary';
                }
                if ($type == 'post') {
                    if (
                        (isset($conf['format']) && $conf['format'] == 'binary')
                        || count($this->file) > 0
                    ) {
                        $request_type = 'multipart/form-data';
                    }
                }
            } else {
                $properties[$conf] = ['type' => 'string'];
                if ($type == 'file') {
                    $properties[$conf]['format'] = 'binary';
                }
            }
        }
        $body = [
            requestBody::content => [
                $request_type => [
                    media::schema => [
                        schema::properties => $properties,
                        schema::type       => 'object'
                    ]
                ]
            ]
        ];
        count($required) > 0 && $body['content'][$request_type][media::schema]['required'] = $required;
        if ($type == 'xml') {
            $body[requestBody::content][$request_type]['schema']['xml'] = ['name' => $xml_root];
        }
        $this->requestBody = array_replace_recursive(
            $body,
            $this->requestBody
        );
    }
}
