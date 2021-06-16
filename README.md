# luogu-discuss-log
保存洛谷讨论的工具

欢迎Pull Request, 作者保证每周看一次

## todo
- [ ] 帖子列表显示讨论总页数啊

## 代码框架

~~有亿点乱~~

`dist`: 模仿洛谷页面的css以及js

`rownum.php`: 获取数据库行数

`search.php`: 搜索功能

`show.php`: 查看保存的帖子

`save.php`: 保存洛谷帖子, 依赖`get.php`

`get.php`: 获取洛谷帖子

`rank.php`: 帖子排行

`list.php`: 帖子列表

`index.php`: 首页

`footer.php`: 页脚

`config.php`: 数据库配置

`img.php`: 洛谷图床的cdn, 因为洛谷有防盗链

## 自己部署

导入`import.sql`, 更改`config.php`里的密码和用户名数据库为你的, 最后把所有文件传到你的服务器里

推荐使用[OIerbbs cloud](https://idc.oierbbs.fun/)

