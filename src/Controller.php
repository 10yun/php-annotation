<?php

namespace shiyun\annotation;

use Attribute;
use ReflectionClass;
use Reflector;
use shiyun\annotation\Container;
use shiyun\annotation\config\Config;
use shiyun\annotation\enum\AnnotationEnum;
use shiyun\annotation\tools\StrTools;
use shiyun\annotation\common\GenerateRouter;
use shiyun\annotation\implement\data\Inject;
use shiyun\annotation\implement\request\RouteRequest;


#[Attribute(Attribute::TARGET_CLASS)]
class Controller extends RouteRequest
{

    public AnnotationEnum $hookEnum = AnnotationEnum::Mounted;

    protected Container $container;
    protected Reflector $reflectionClass;

    #[Inject]
    protected Config $config;

    #[Inject]
    protected StrTools $strTools;

    #[Inject]
    protected GenerateRouter $generateRouter;

    protected string $routerConfigKey = 'http';
    protected array $routers = [];

    protected array $domain = [];

    // 定义控制器注解
    public function __construct(
        protected string $rule = '',
        protected string $method = '*',
        protected string $ext = '*',
        protected array $parameter = [],
        protected array $options = []
    ) {
    }

    public function process(Reflector $reflector, &$args): Controller
    {
        $this->reflectionClass = $reflector;
        return $this->getControllerRouter()->initializerControllerMethodRouter();
    }

    public function __make(Container $container, ReflectionClass $reflectionClass)
    {
        $this->container = $container;
        $this->routers = $this->config->getRouters();
    }


    /**
     * 设置控制器路由数据
     * @return $this
     */
    protected function getControllerRouter(): Controller
    {
        $this->rule = $this->generateRouter->getRouterPrefix(
            $this->rule ?: $this->strTools->humpToLower($this->reflectionClass->getShortName())
        );
        $this->domain = $this->generateRouter->getDomain($this->reflectionClass);
        return $this;
    }

    /**
     * 初始化类方法注解
     * @return $this
     */
    protected function initializerControllerMethodRouter(): Controller
    {
        $this->generateRouter->setRouterConfigKey($this->routerConfigKey);
        foreach ($this->reflectionClass->getMethods() as $method) {
            if (!$method->isPublic()) $method->setAccessible(true);
            $router = $this->generateRouter
                ->setParentRule($this->rule)
                ->generateRouter($method, $this->reflectionClass, $this->domain);
            $this->config->setRouters($router);
        }
        return $this;
    }
}
