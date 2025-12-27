<p align="center">
  <img src="./admin/views/images/logo.png" width=100 />
</p>

<p align="center"><b>emlog</b></p>
<p align="center">Lightweight Open Source CMS</p>

<p align="center">
<a href="https://github.com/emlog/emlog/releases"><img alt="GitHub release" src="https://img.shields.io/github/release/emlog/emlog.svg?style=flat-square&include_prereleases" /></a>
<a href="https://github.com/emlog/emlog/commits"><img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/emlog/emlog.svg?style=flat-square" /></a>

## Main Features

- Markdown Support
- Multi-user Role Management
- Flexible Tags and Categories
- Multimedia Resource Management
- Comprehensive SEO Support
- Built-in API Interface
- Rich Template Themes
- Plugin Extension Ecosystem
- Native AI Support

## Official Website

https://emlog.dev

## Requirements

* PHP 5.6, PHP 7, PHP 8 (Recommended 7.4 or higher)
* MySQL 5.6 or higher, or MariaDB 10.3 or higher
* Recommended Server Environment: Linux + Nginx
* Recommended Browsers: Chrome, Edge

## General Installation

1. [Download the installation package](https://emlog.dev/download), upload all unzipped files to the web root directory of your server, or upload the zip package directly and unzip it online.
2. Visit your domain name in a browser. The program will automatically redirect to the installation page. Follow the prompts to install.
3. The installation process does not create a database, so you need to create one beforehand. Click confirm to install, and the installation will be successful.

## Other Installations

- [Docker Deployment](https://emlog.dev/docs/install/install_docker)

## Quick Deployment with Docker

Use the image `emlog/emlog:pro-latest-php7.4-apache` to quickly start emlog. This image includes the latest version of emlog, Apache service, and necessary extensions, but does not include MySQL. You need to install and create a database separately.

```bash
$ docker run --name emlog-pro -p 8080:80 -d emlog/emlog:pro-latest-php7.4-apache
```

## Docker Compose

1. cp config.sample.php config.php
2. docker network create emlog_network
3. docker-compose up -d
4. http://localhost:8080

## License

Emlog is released under the GNU General Public License v3 (GPLv3) by the Free Software Foundation: [LICENSE](/license.txt)
