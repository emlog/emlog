<p align="center">
  <img src="./admin/views/images/logo.png" width=100 />
</p>

<p align="center"><b>emlog</b></p>
<p align="center">快速稳定的轻量级博客及CMS建站系统，打造好用的云端内容管理系统。</p>

<p align="center">
<a href="https://github.com/emlog/emlog/releases"><img alt="GitHub release" src="https://img.shields.io/github/release/emlog/emlog.svg?style=flat-square&include_prereleases" /></a>
<a href="https://github.com/emlog/emlog/commits"><img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/emlog/emlog.svg?style=flat-square" /></a>

## 功能简介

- Markdown编辑器：内置Markdown编辑器，并自动保存，使创作过程更加舒适和高效。
- 多用户角色：支持多种用户角色，同时提供用户注册和登录功能，方便读者和作者的互动。
- 多媒体资源管理器：内置多媒体资源管理器，方便上传、管理图片、音频、视频和文件等各种媒体资源。
- 模板主题：应用商店提供多种模板主题，轻松打造独具个性的站点。
- 插件生态：拥有强大的插件扩展系统，快速扩展站点功能，满足特定需求。
- 强大的SEO功能：支持文章URL自定义、站点及分类页的TDK定制，有助于提升站点在搜索引擎中的可见性。
- 自定义侧边栏管理：提供灵活的侧边栏组件管理。
- 自定义页面：支持创建自定义页面，包括留言板、个人介绍等，帮助你打造更富有个性和功能的站点。
- 标签和分类：文章可轻松归类和标记，提供更好的信息组织和检索功能。

## 快速开始（Docker）

```bash
$ docker run --name emlog-pro -p 8080:80 -d emlog/emlog:pro-latest-php7.4-apache
```

## 环境要求

* PHP5.6、PHP7、PHP8，推荐 PHP7.4
* MySQL5.6及以上，推荐5.6
* 服务器环境推荐：Linux + Nginx

## 安装部署

- [宝塔一键部署](https://www.emlog.net/docs/#/install_bt)
- [1Panel部署](https://www.emlog.net/docs/#/install_1panel)

## Start via `docker-compose`

1. cp config.sample.php config.php
2. docker network create emlog_network
3. docker-compose up
4. http://localhost:8080

## 授权协议

发布Emlog软件所依据的许可证是自由软件基金会的GPLv3(或更高版本)：[LICENSE](/license.txt)
