<p align="center">
  <img src="./admin/views/images/logo.png" width=100 />
</p>

<p align="center"><b>emlog</b></p>
<p align="center">轻量开源建站系统</p>

<p align="center">
<a href="https://github.com/emlog/emlog/releases"><img alt="GitHub release" src="https://img.shields.io/github/release/emlog/emlog.svg?style=flat-square&include_prereleases" /></a>
<a href="https://github.com/emlog/emlog/commits"><img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/emlog/emlog.svg?style=flat-square" /></a>

## 主要功能

- Markdown支持
- 多用户角色管理
- 灵活的标签和分类
- 多媒体资源管理
- 全面支持 SEO
- 内置 API 接口
- 丰富的模板主题
- 插件化扩展生态
- 原生支持 AI 功能

## 官网

https://www.emlog.net

## 环境准备

* PHP5.6、PHP7、PHP8，推荐7.4及以上
* MySQL5.6及以上，或者 MariaDB 10.3及以上
* 服务器环境推荐：Linux + nginx
* 服务器推荐：云服务器，如: [阿里云ECS](https://www.aliyun.com/daily-act/ecs/activity_selection?userCode=n4ts9qpa)，[雨云 - KVM](https://www.rainyun.com/MzI2NDkz_)
* 服务器管理面板软件推荐：[宝塔面板](https://www.bt.cn/u/N0UABa) （宝塔支持[一键部署emlog](install_bt.md)，非常方便）
* 浏览器推荐：Chrome、Edge

## 通用安装

1. [下载安装包](https://www.emlog.net/download)，将解压后的所有文件上传到服务器的web根目录，或者直接将zip安装包上传后在线解压。
2. 在浏览器上访问站点域名，程序会自动跳转到安装页面，按照提示安装即可。
3. 安装过程不会创建数据库，需要您事先创建好 ，点击确认安装，安装成功。

## 其他安装

- [宝塔面板一键部署](/install/install_bt.md)
- [1Panel 部署](/install/install_1panel.md)
- [docker 部署](/install/install_docker.md)
- [软路由 iStoreOS 系统部署](https://www.bilibili.com/video/BV1mHpjeGEDu)

## docker快速部署

使用镜像 emlog/emlog:pro-latest-php7.4-apache 快速启动emlog，该镜像包含最新版本emlog、Apache服务、以及必要的扩展，但不包括 MySQL，需要额外安装并创建数据库。

```bash
$ docker run --name emlog-pro -p 8080:80 -d emlog/emlog:pro-latest-php7.4-apache
```

## docker-compose

1. cp config.sample.php config.php
2. docker network create emlog_network
3. docker-compose up -d
4. http://localhost:8080

## 授权协议

发布Emlog软件所依据的许可证是自由软件基金会的GPLv3：[LICENSE](/license.txt)
