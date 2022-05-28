<?php

namespace shiyun\annotation;

use shiyun\annotation\tools\CheckRequestRouter;
use shiyun\annotation\config\Config;
use shiyun\annotation\exceptions\RouterNotFoundException;
use shiyun\annotation\implement\data\Inject;
use shiyun\annotation\params\QueryParameters;

class CheckRule
{

    protected array $router = [];
    protected array $routerList;

    #[Inject]
    protected CheckRequestRouter $checkRequestRouter;

    #[Inject]
    protected Config $config;

    protected string $routerConfigKey = '';

    // 当前请求参数
    protected array $parameters = [];

    /**
     * 获取当前全部路由列表
     * @return array
     */
    public function getRouterList(): array
    {
        if (!empty($this->routerList)) return $this->routerList;
        return $this->routerList = $this->config->getRouters();
    }

    /**
     * 验证当前路由信息
     * @param string $url 请求地址
     * @param string $method 请求方法
     * @param array $param 请求参数
     * @param string $domain 请求域名
     * @return array|bool
     * @throws exceptions\QueryParametersException|RouterNotFoundException
     */
    public function checkRule(string $url = '', string $method = 'get', array $param = [], string $domain = ''): array|bool
    {
        $routerList = $this->getRouterList();
        $this->parameters = $param;

        $this->router = [];
        if (empty($routerList['router'][$this->routerConfigKey])) return $this->router;

        foreach ($routerList['router'][$this->routerConfigKey] as $rule) {
            $this->router = $this->check($rule, $url, $method, $domain);
            if ($this->router) break;
        }

        return $this->router ? $this->bindParam($this->router) : throw new RouterNotFoundException();
    }

    /**
     * 验证当前请求路由信息
     * @param array $ruleAll
     * @param string $url
     * @param string $method
     * @param string $domain
     * @return array|bool
     */
    protected function check(array $ruleAll, string $url, string $method, string $domain): bool|array
    {
        $router = [];
        foreach ($ruleAll as $ruleKey => $rule) {
            if (is_array($rule) && empty($rule['rule'])) {
                // 验证路由
                if (!str_starts_with(ltrim($url, '/'), ltrim($ruleKey, '/'))) {
                    continue;
                }
                $router = $this->check($rule, $url, $method, $domain);
            } else if (is_array($rule)) {
                $router = $this->checkRequestRouter->check(
                    $rule,
                    $url,
                    $method,
                    $domain
                );
            }
            if ($router) return $router;
        }
        return [];
    }
    /**
     * 绑定路由参数
     * @param array $router
     * @return array
     * @throws exceptions\QueryParametersException
     */
    protected function bindParam(array $router): array
    {
        if (count($this->parameters) === 0) return $router;
        return (new GenerateQueryParameters(
            $router,
            $this->routerList,
            $this->parameters
        ))->GenerateParameters();
    }

    /**
     * @param string $routerConfigKey
     * @return CheckRule
     */
    public function setRouterConfigKey(string $routerConfigKey): CheckRule
    {
        $this->routerConfigKey = $routerConfigKey;
        return $this;
    }
}
