# laravel-paginator

Laravel paginator 自定义分页扩展包

### 安装

```bash
composer require themismin/laravel-paginator

```

### 无需配置直接使用

```php
// 结果会多出一个自定义数据
$custom = 'xxx';
$list = User::customPaginate($custom = null, $perPage = 15, $columns = ['*'], $pageName = 'page', $page = null);
return $list;

// 结果
{
    "custom": "xxx",
    "data": [
        {
            "name": "x1",
            "date": "xxxx-xx-xx"
        },
        {
            "name": "x2",
            "date": "xxxx-xx-xx"
        }
    ],
    "page_size": 15,
    "current": 1,
    "total": 2
}
```