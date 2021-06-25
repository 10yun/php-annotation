# php-annotation

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

支持

| 注解类型        | 类型 | 说明        |
| :-------------- | :--- | :---------- |
| @RequestMapping | 类型 | request注解 |  |
| @getMapping     | 类型 | get注解     |  |
| @postMapping    | 类型 | post注解    |  |
| @putMapping     | 类型 | put注解     |  |


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



