
# 使用

```php
use shiyun\annotation\Container;
$container = Container::getInstance();

// 新建对象
$container -> make('class', ...$args, call: function ($object) { 
    return $object 
});

// 将已实例化的对象写入容器
$container -> register('class', $obj);

// 获取容器对象
$container -> get('class');

// 验证当前容器是否存在改对象
$container -> has('class');

// 删除容器内对象
$container -> delete('class');

```
