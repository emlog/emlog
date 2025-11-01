<?php
/*@support tpl_options*/

defined('EMLOG_ROOT') || exit('access denied!');

$options = [
    'TplOptionsNavi' => [
        'type' => 'radio',
        'name' => '息壤主题设置导航',
        'values' => [
            'tpl-basic' => '基础设置',
            'tpl-home' => '首页设置',
            'tpl-footer' => '页脚设置',
        ],
        'description' => '<p>欢迎使用息壤信息咨询服务企业主题！这是一款专为高端企业打造的简约优雅主题。</p>
                         <p>配色方案：黑白灰主色调 + 科技蓝点缀</p>
                         <p>特色功能：深色/浅色模式切换、响应式设计、优雅动效、手风琴式移动端Footer</p>'
    ],

    // ============ 基础设置 ============
    'logo_type' => [
        'labels' => 'tpl-basic',
        'type' => 'radio',
        'name' => 'LOGO显示方式',
        'values' => [
            'text' => '文字（7XR.CN）',
            'image' => '图片',
        ],
        'default' => 'text',
        'description' => '选择使用文字LOGO或上传图片LOGO'
    ],

    'logo_image' => [
        'labels' => 'tpl-basic',
        'type' => 'image',
        'name' => 'LOGO图片',
        'values' => [TEMPLATE_URL . 'images/logo.png'],
        'description' => '推荐尺寸：180x60像素，PNG格式支持透明背景'
    ],

    'nav_links' => [
        'labels' => 'tpl-basic',
        'type' => 'text',
        'name' => '导航链接',
        'multi' => true,
        'default' => "关于|#about\n服务|#services\n价格|#pricing\n作品|#portfolio\n联系|#contact",
        'description' => '每行一个，格式：导航名称|链接地址（支持#锚点和完整URL）'
    ],

    // ============ 首页设置 ============
    'hero_title' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '首屏主标题',
        'default' => '息壤信息咨询服务',
        'description' => '首屏大标题文字'
    ],

    'hero_subtitle' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '首屏副标题',
        'default' => '专业 · 创新 · 领先',
        'description' => '首屏副标题/描述文字'
    ],

    'hero_btn1_text' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '首屏按钮1文字',
        'default' => '了解更多',
        'description' => '首屏第一个按钮的文字'
    ],

    'hero_btn1_link' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '首屏按钮1链接',
        'default' => '#services',
        'description' => '首屏第一个按钮的跳转地址'
    ],

    'hero_btn2_text' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '首屏按钮2文字',
        'default' => '联系我们',
        'description' => '首屏第二个按钮的文字'
    ],

    'hero_btn2_link' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '首屏按钮2链接',
        'default' => '#contact',
        'description' => '首屏第二个按钮的跳转地址'
    ],

    'services_title' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '服务项目区块标题',
        'default' => '我们的服务',
        'description' => '服务项目区块的标题'
    ],

    'advantages_title' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '服务优势区块标题',
        'default' => '我们的优势',
        'description' => '服务优势区块的标题'
    ],

    'faq_title' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '常见问题区块标题',
        'default' => '常见问题',
        'description' => '常见问题区块的标题'
    ],

    'faq_items' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'multi' => true,
        'name' => '常见问题列表',
        'default' => "你们的服务范围是什么？|我们提供营销咨询、域名方案、数字云建和AI工程等全方位信息咨询服务。\n服务周期一般多长？|根据项目复杂度，一般从1周到3个月不等，我们会在项目开始前给出明确的时间规划。\n如何开始合作？|请通过联系方式与我们沟通，我们会安排专业顾问了解您的需求并提供定制化方案。",
        'description' => '每行一个问答，格式：问题|答案'
    ],

    'about_title' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '关于我们区块标题',
        'default' => '关于我们',
        'description' => '关于我们区块的标题'
    ],

    'about_content' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'multi' => true,
        'name' => '关于我们内容',
        'default' => '息壤信息咨询服务致力于为企业提供专业的信息化解决方案。我们拥有资深的技术团队和丰富的行业经验，专注于营销咨询、域名方案、数字云建和AI工程等领域。',
        'description' => '关于我们的详细介绍'
    ],

    'about_btn_text' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '关于我们按钮文字',
        'default' => '了解更多',
        'description' => '关于我们区块的按钮文字'
    ],

    'about_btn_link' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '关于我们按钮链接',
        'default' => '#',
        'description' => '关于我们区块的按钮链接'
    ],

    'join_title' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '加入我们区块标题',
        'default' => '加入我们',
        'description' => '加入我们区块的标题'
    ],

    'join_content' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'multi' => true,
        'name' => '加入我们内容',
        'default' => '我们正在寻找充满激情的人才加入我们的团队。如果您对信息技术充满热情，渴望在创新的环境中成长，欢迎加入息壤。',
        'description' => '加入我们的详细介绍'
    ],

    'join_btn_text' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '加入我们按钮文字',
        'default' => '查看职位',
        'description' => '加入我们区块的按钮文字'
    ],

    'join_btn_link' => [
        'labels' => 'tpl-home',
        'type' => 'text',
        'name' => '加入我们按钮链接',
        'default' => '#',
        'description' => '加入我们区块的按钮链接'
    ],

    // ============ 页脚设置 ============
    'footer_logo_type' => [
        'labels' => 'tpl-footer',
        'type' => 'radio',
        'name' => 'Footer LOGO类型',
        'values' => [
            'text' => '文字',
            'image' => '图片（自动黑白）',
        ],
        'default' => 'text',
        'description' => 'Footer区域的LOGO显示方式'
    ],

    'footer_column1_title' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'name' => 'Footer第1列标题',
        'default' => '产品服务',
        'description' => 'Footer第一列的标题'
    ],

    'footer_column1_links' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'multi' => true,
        'name' => 'Footer第1列链接',
        'default' => "营销咨询|#\n域名方案|#\n数字云建|#\nAI工程|#",
        'description' => '每行一个链接，格式：链接文字|链接地址'
    ],

    'footer_column2_title' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'name' => 'Footer第2列标题',
        'default' => '解决方案',
        'description' => 'Footer第二列的标题'
    ],

    'footer_column2_links' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'multi' => true,
        'name' => 'Footer第2列链接',
        'default' => "企业官网|#\n电商平台|#\n移动应用|#\n数据分析|#",
        'description' => '每行一个链接，格式：链接文字|链接地址'
    ],

    'footer_column3_title' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'name' => 'Footer第3列标题',
        'default' => '关于',
        'description' => 'Footer第三列的标题'
    ],

    'footer_column3_links' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'multi' => true,
        'name' => 'Footer第3列链接',
        'default' => "公司简介|#\n团队成员|#\n新闻动态|#\n联系我们|#contact",
        'description' => '每行一个链接，格式：链接文字|链接地址'
    ],

    'footer_column4_title' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'name' => 'Footer第4列标题',
        'default' => '资源',
        'description' => 'Footer第四列的标题'
    ],

    'footer_column4_links' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'multi' => true,
        'name' => 'Footer第4列链接',
        'default' => "帮助中心|#\n文档中心|#\n开发者|#\n合作伙伴|#",
        'description' => '每行一个链接，格式：链接文字|链接地址'
    ],

    'copyright_text' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'name' => '版权信息',
        'default' => '© 2025 7XR.CN 息壤信息咨询服务. All rights reserved.',
        'description' => '页脚版权信息文字'
    ],

    'help_doc_content' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'multi' => true,
        'name' => '帮助文档内容',
        'default' => '这里是帮助文档的内容。您可以在这里添加详细的帮助信息和使用指南。',
        'description' => '帮助文档弹窗的内容（支持HTML）'
    ],

    'terms_content' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'multi' => true,
        'name' => '服务条款内容',
        'default' => '这里是服务条款的内容。您可以在这里添加详细的服务条款和使用协议。',
        'description' => '服务条款弹窗的内容（支持HTML）'
    ],

    'privacy_content' => [
        'labels' => 'tpl-footer',
        'type' => 'text',
        'multi' => true,
        'name' => '隐私政策内容',
        'default' => '这里是隐私政策的内容。您可以在这里添加详细的隐私保护政策。',
        'description' => '隐私政策弹窗的内容（支持HTML）'
    ],
];
