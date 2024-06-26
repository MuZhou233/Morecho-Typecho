## 基础语法

支持常见的 Markdown 语法，或者说[PHP Markdown](http://michelf.ca/projects/php-markdown/)&[PHP Markdown Extra](http://michelf.ca/projects/php-markdown/extra)

## 特有语法

### 任务列表

和[GFM](https://github.github.com/gfm/)中的任务列表相同

```markdown
- [ ] 未完成
- [x] 已完成
```

### 隐藏文字

默认显示为一个黑色色块，鼠标悬停或触屏点击显示内容，使用范围与行内代码相同

```markdown
`[被隐藏的内容]`
```

### KBD

?> 需要启用MorechoCore插件

专门用来显示键盘输入

```
[[Ctrl]]+[[Alt]]+[[Del]]
```

### @用户

在文中和评论区输入`@用户名 `就会自动添加链接，注意用户名后要有空格，用户名最长30个字符

### 代码块标题

在代码块前面按照标题格式添加一行，内容以半角叹号开头，标题会显示在代码块的顶栏位置。标题级别会影响到导航栏的标题排列

```markdown
### !Linux一键优化
    $ sudo dd if=/dev/zero of=/dev/null
```

### 代码块行号

?> 需要启用MorechoCore插件

在代码块开头写数字可以自定义起始行号

```
    ```35
    code
    ```
```

### 特殊引用

?> 需要启用MorechoCore插件

更改引用文本框的样式，共两种

```markdown
> !第一个字符为感叹号，显示红色警告样式
> ?第一个字符为问号，显示紫色提示样式
```

### 卡片

?> 需要启用MorechoCore插件

包含图片的小卡片，可以根据需要放内容。图片只能用一个。

```markdown
> ![](在引用的第一行使用图片即可生成卡片)
> ### 可以使用标题
> 可以使用*行内*样式
```