## 注意事项

1. Morecho 主题的开发测试环境为 Typecho1.1、php7.3、MySQL，其他版本应该会正常运作。
1. 必须正确配置伪静态且将网站放在根路径，否则部分链接会出现 404
1. 作者仅仅会测试新版本在 Chrome Firefox Safari 上是否有 bug，如果你对浏览器兼容性要求较高，请谨慎考虑是否使用

## 下载安装

1. 从[发布页面](https://github.com/MuZhou233/Morecho-Typecho/releases)下载最新稳定版压缩包
1. 解压并重命名文件夹名为`Morecho`，放入Typecho主题目录
1. 进入Typecho后台启用并配置主题

### 配套插件

配套插件位于主题文件的plugins文件夹中，将你需要的插件放入Typecho插件目录启用即可，详细介绍点击[配套插件](/plugins)。0.5版本之后强烈建议启用插件。

### 使用Git

如果你熟悉Linux和Git，你也可以使用Git来获取和更新主题，下面的命令仅作参考，**请勿复制**
```bash
~/typecho/usr/themes$ 安装
$ git clone https://github.com/MuZhou233/Morecho-Typecho.git
$ mv Morecho-Typecho Morecho
$ ln -s Morecho/plugins/MorechoCore ../plugins/MorechoCore
```
```bash
~/typecho/usr/themes$ 更新
$ cd Morecho
$ git pull
```

---

更多内容点击侧栏链接查看