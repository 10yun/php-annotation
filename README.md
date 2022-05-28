# php-annotation

- 支持php7注释
- 支持php8注解
- 简化版swagger接口文档
- 自动生成 OpenAPI 文档

## php注解

- 修改镜像源  
看需求

```sh
# 取消
composer config -g --unset repos.packagist
# 国外
composer config -g repo.packagist composer https://packagist.phpcomposer.com
# 阿里
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
```

- 引入

```sh
composer require shiyun/php-annotation
```

- 支持路由注解 [查看手册](./docs/路由注解.md)
  
- 支持验证注解
- 支持服务注解



### 1、 添加配置

复制 ` init/config/annotation.php ` 到 项目 `/config/`中

### 2、 注册服务

- 2.1 在 `app/service.php` 中注册 
```php
    \shiyun\annotation\ExtAnnotationService::class,
```


- 2.2 或者 

复制 ` init/ExtAnnotationService.php ` 到 项目 `/app/service/`中  
然后 在 `app/service.php` 中注册 

```php
    \shiyun\annotation\ExtAnnotationService::class,
```



