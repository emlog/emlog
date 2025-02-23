<?php
/*
Plugin Name: 小贴士
Version: 3.0
Plugin URL:
Description: 在后台首页展示一句使用小提示，也可作为插件开发的demo。
Author: emlog
Author URL: https://www.emlog.net/author/index/577
*/

defined('EMLOG_ROOT') || exit('access denied!');

$array_tips = [
    '为防文章丢失，emlog会在你书写文章的时候为你自动保存',
    '你可以把你未写完的文章保存到草稿箱里',
    '不使用的插件请及时删除',
    '多逛逛应用商店吧，总会有惊喜',
    '你可以把图片嵌入到内容中，让你的文章图文并茂',
    '你可以在写文章的时候为文章设置访问密码，只让你授予密码的人访问',
    'emlog支持自建页面，并且可以上传照片，为自己做一个图文并茂的自我介绍页吧',
    '新建一个允许发表评论的页面，你会发现其实它还是一个简单的留言板',
    '检查你的站点目录下是否存在安装文件：install.php，有的话请删除它',
    '推荐使用Chrome浏览器，更好的体验emlog',
    '可以用微语笔记来整理碎片文字素材',
    '面朝大海，春暖花开',
    '定期备份你的数据，防止意外丢失',
    '请使用复杂的密码保护后台管理账户',
    '保持插件和主题的更新，以获得最新的功能和安全性',
    '合理使用标签和分类，提高文章的可读性和搜索引擎优化',
    '知者不惑，仁者不忧，勇者不惧',
    '千里之行，始于足下',
    '繁华尽处，寻常是妙处',
    '人生如逆旅，我亦是行人',
    '愿你出走半生，归来仍是少年',
    '希望是附丽于存在的，有存在，便有希望',
    '世上只有一种英雄主义，就是在认清生活真相之后依然热爱生活',
];

function tips_init()
{
    global $array_tips;
    $i = em_rand(0, count($array_tips) - 1);
    $tip = $array_tips[$i];
    echo "<div id=\"tip\"> $tip</div>";
}

addAction('adm_main_top', 'tips_init');

function tips_css()
{
    echo "<style>
    #tip{
        background:url(../content/plugins/tips/icon_tips.gif) no-repeat left 3px;
        padding:3px 18px;
        margin:5px 0px;
        font-size:12px;
        color:#999999;
    }
    </style>\n";
}

addAction('adm_head', 'tips_css');
