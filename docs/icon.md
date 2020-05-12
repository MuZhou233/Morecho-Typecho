## 图标

前端使用了 [Feather Icon](https://feathericons.com/) 图标库，你可以先去官网查找图标名，再在任意位置添加`<i data-feather="图标名"></i>`即可

## emoji

修改数据库字符集即可正常使用，与主题无关。

修改数据库 charset 为 utf8mb4：
```sql
alter table typecho_comments convert to character set utf8mb4 collate utf8mb4_unicode_ci;
alter table typecho_contents convert to character set utf8mb4 collate utf8mb4_unicode_ci;
alter table typecho_fields convert to character set utf8mb4 collate utf8mb4_unicode_ci;
alter table typecho_metas convert to character set utf8mb4 collate utf8mb4_unicode_ci;
alter table typecho_options convert to character set utf8mb4 collate utf8mb4_unicode_ci;
alter table typecho_relationships convert to character set utf8mb4 collate utf8mb4_unicode_ci;
alter table typecho_users convert to character set utf8mb4 collate utf8mb4_unicode_ci;
```
修改 Typecho 配置文件中数据库定义参数中的 charset 为 utf8mb4：
```php
$db->addServer(array (
    'host'      =>  localhost,
    'user'      =>  '...',
    'password'  =>  '...',
    'charset'   =>  'utf8mb4', //修改这一行
    'port'      =>  ...,
    'database'  =>  '...'
), Typecho_Db::READ | Typecho_Db::WRITE);
```