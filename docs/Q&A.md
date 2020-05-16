## 如何让网页自动播放音频

在`_includes/footer.php`文件里倒数第三行`</script>`标签前面加上一行

    $('.music-controls .play').click();

## 如何添加备案号

使用主题的自定义页脚功能

## 某浏览器有 bug

目前主要支持 Chrome Firefox Safari，其他浏览器bug随缘修复，IE浏览器bug不予修复（懒

### 初步的浏览器兼容性排查

*除了特殊标注的皆为 win10最新正式版 + 浏览器最新正式版 + 所谓的极速模式*  
体验基本一致的浏览器：
- Chrome
- Firefox
- Safari
- QQ
- 2345
其他的浏览器：
- Sogou 对DPI缩放支持不好
- 猎豹 对DPI缩放支持不好
- 360 对DPI缩放支持不好，默认使用宋体（丢掉
- 360急速 对DPI缩放支持不好，默认使用宋体，默认字号字重混乱（丢掉
- 傲游 默认使用宋体，默认字重较小（宋体即原罪

### 某些浏览器评论报错

Typecho的锅，某些浏览器的ua太长超过了数据库限制，找到数据库中的`comments`表，将`agent`字段的长度修改为`512`，或者执行SQL指令，将指令中的`typecho`前缀更改成你的前缀
```
ALTER TABLE `typecho_comments` CHANGE `agent` `agent` VARCHAR(512)
```

## 如何更换头像源

在Typecho根目录下的config.inc.php文件中添加下面内容。你会在文件中发现类似于下面这行的内容，添加到它们前后就可以了
```
//更换头像源
define('__TYPECHO_GRAVATAR_PREFIX__', '这里替换成地址');
```
下面几个源都是可用的，如果你知道其他源也可以自己尝试

- http://gravatar.ihuan.me/avatar/
- https://gravatar.proxy.ustclug.org/
- https://cdn.v2ex.com/gravatar/
- http://dn-qiniu-avatar.qbox.me/avatar

## 其他问题

欢迎提问 [GitHub issue](https://github.com/MuZhou233/Morecho-Typecho/issues) [主题发布页](https://mosarin.tech/morecho.html)