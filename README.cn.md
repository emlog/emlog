<p align="center">
  <img src="https://emlogstore.oss-cn-beijing.aliyuncs.com/img/logo.png" width=100 />
</p>
<p align="center">
	<a href="https://github.com/emlog/emlog/releases/latest"><img src="https://img.shields.io/github/v/release/emlog/emlog?logo=github" alt="GitHub release" /></a>
	<a href="https://www.emlog.net/docs/#/"><img src="https://img.shields.io/badge/docsify-%E8%AF%A6%E7%BB%86%E4%BD%BF%E7%94%A8%E6%96%87%E6%A1%A3-brightgreen" alt="Document" /></a>
  <a href="#"><img src="https://img.shields.io/badge/QQ%20%E7%BE%A4-460197406-red" alt="QQ群" /></a>
</p>
<p align="center">
  中文 | <a href="./README.en.md">English</a>
</p>

# emlog

一款基于PHP和MySQL的功能强大的博客及内容知识管理系统，追求快速、稳定、简单、舒适的建站体验。

## 功能简介

* Markdown编辑器
* 多屏幕尺寸适配，兼容pc和移动端设备
* 一键式更换模板，方便快捷打造个性站点
* 支持强大的插件扩展功能，随意选择实用的插件，让你的站点无限可能
* 支持日志URL自定义，链接样式更适合SEO
* 清爽的日志撰写页面、配以自动保存，书写博文更加舒适无忧
* 日志草稿箱功能，方便保存你未完成的日志
* 灵活的侧边栏组件(widgets)管理，轻松组合、自定义你喜欢的组件
* 自定义页面，轻松创建留言板、导航条、个人介绍等页面
* 多人联合撰写，后台轻松管理多个撰写人
* 支持灵活的标签(tag)分类，以及传统分类方式
* 资源（图片、视频、文件）上传和管理
* 上传的图片可以随意直观的嵌入到日志内容里，让你的日志图文并茂
* 站点数据备份/恢复功能

## 文档

[简体中文](https://www.emlog.net/docs/#/install)

## 安装包

[下载pro安装包](https://www.emlog.net/download)

## 更新记录

[changelog](https://www.emlog.net/docs/#/changelog)

## 环境要求

* PHP5.6、PHP7、PHP8，推荐 PHP7.4
* MySQL5.6及以上，推荐5.6 ，高配服务器（2G内存及以上）推荐5.7
* 服务器环境推荐：Linux + nginx
* 服务器面板软件推荐：宝塔面板
* 浏览器推荐：Chrome

## 安装说明

1. 将解压后的所有文件上传到服务器或者虚拟主机的web根目录，也可以将zip压缩包上传后在线解压。
2. 在浏览器上访问事先解析好的域名，程序会自动跳转到emlog安装页面，按照提示安装即可。
3. 安装过程不会创建数据库，需要您事先创建好 ,点击确认安装，安装成功。

## Docker

1. cp config.sample.php config.php
2. docker network create emlog_network
3. docker-compose up
4. http://localhost:8080

## 特别感谢

[![JetBrains](https://raw.githubusercontent.com/kainonly/ngx-bit/main/resource/jetbrains.svg)](https://www.jetbrains.com/)

Thanks for non-commercial open source development authorization by JetBrains

## 授权协议

发布Emlog软件所依据的许可证是自由软件基金会的GPLv3(或更高版本)：[LICENSE](/license.txt)
