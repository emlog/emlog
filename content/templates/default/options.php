<?php
/*@support tpl_options*/

/**
 * 模板设置的配置文件
 * 详见官网文档-模板开发：https://www.emlog.net/docs/dev/template
 */

defined('EMLOG_ROOT') || exit('access denied!');

$options = [
    'TplOptionsNavi' => [
        'name'        => _langTpl('tpl_options_navi_name'),
        'values'      => [
            'tpl-head'    => _langTpl('tpl_head'),
            'tpl-home'    => _langTpl('tpl_home'),
            'tpl-article' => _langTpl('tpl_article'),
        ],
        'description' => '' // 设置说明（可选）
    ],
    'logotype'       => [
        'labels'  => 'tpl-head',
        'type'    => 'radio',
        'name'    => _langTpl('logo_type_name'),
        'values'  => [
            '1' => _langTpl('text'),
            '0' => _langTpl('image'),
            '2' => _langTpl('text_image'),
        ],
        'default' => '1',
    ],
    'logoimg'        => [
        'labels'      => 'tpl-head',
        'type'        => 'image',
        'name'        => _langTpl('logo_img_name'),
        'values'      => [
            TEMPLATE_URL . 'images/logo.png',
        ],
        'description' => _langTpl('logo_img_desc')
    ],
    'favicon'        => [
        'labels'      => 'tpl-head',
        'type'        => 'image',
        'name'        => _langTpl('favicon_name'),
        'description' => _langTpl('favicon_desc')
    ],
    'slideShow'      => [
        'labels'      => 'tpl-home',
        'type'        => 'text',
        'name'        => _langTpl('slideshow_name'),
        'multi'       => true,
        'description' => _langTpl('slideshow_desc'),
    ],
    'isShowCover'        => [
        'labels'       => 'tpl-article',
        'type'         => 'checkon',
        'name'         => _langTpl('is_show_cover_name'),
        'values'       => ['1' => '开启'],
        'default'      => '0',
        'description'  => ''
    ],
    'isSideBar'          => [
        'labels'       => 'tpl-article',
        'type'         => 'checkon',
        'name'         => _langTpl('is_sidebar_name'),
        'values'       => ['1' => '开启'],
        'default'      => '0',
        'description'  => ''
    ],
    'isAllowCommentUrl'        => [
        'labels'       => 'tpl-article',
        'type'         => 'checkon',
        'name'         => _langTpl('is_allow_comment_url_name'),
        'values'       => ['1' => '开启'],
        'default'      => '1',
        'description'  => ''
    ],
    /*
    // ==========================================
    // 新增类型演示（参考小风主题选项框架扩展）
    // ==========================================

    // 1. notice - 提醒
    'demo_notice' => [
        'labels'  => 'tpl-demo',
        'type'    => 'notice',
        'style'   => 'info',
        'name'    => '组件演示说明',
        'content' => '本页面演示了模板设置插件新增支持的 10 种选项类型：background（背景）、border（边框）、date（日期）、link（链接）、link_color（超链接颜色）、notice（提醒）、number（数字框）、slider（滑块）、spacing（间距）、submessage（小提醒）。',
    ],

    // 2. submessage - 小提醒
    'demo_submessage' => [
        'labels'  => 'tpl-demo',
        'type'    => 'submessage',
        'style'   => 'success',
        'content' => '小提醒（submessage）：以左侧色条的紧凑形式展示内联提示、注意事项或配置引导。',
    ],

    // 3. number - 数字文本框
    'demo_number' => [
        'labels'      => 'tpl-demo',
        'type'        => 'number',
        'name'        => '分页显示文章数',
        'description' => '数字文本框（number）：支持设置数值上下限（min/max）、步长与后缀单位',
        'min'         => 1,
        'max'         => 100,
        'step'        => 1,
        'unit'        => '篇',
        'default'     => '10',
    ],

    // 4. slider - 滑块
    'demo_slider' => [
        'labels'      => 'tpl-demo',
        'type'        => 'slider',
        'name'        => '列表卡片圆角弧度',
        'description' => '滑块（slider）：拖动滑块或在右侧数字框输入，实时双向联动更新',
        'min'         => 0,
        'max'         => 50,
        'step'        => 1,
        'unit'        => 'px',
        'default'     => '8',
    ],

    // 5. date - 日期（单日期与区间）
    'demo_date' => [
        'labels'      => 'tpl-demo',
        'type'        => 'date',
        'name'        => '单个活动截止日期',
        'description' => '日期组件（date）：单日期选择器，采用写文章页面的日历交互控件',
        'default'     => '2026-12-31',
    ],
    'demo_date_range' => [
        'labels'      => 'tpl-demo',
        'type'        => 'date',
        'name'        => '活动起止时间范围',
        'description' => '日期组件（date）：支持起止范围区间选择（from_to）',
        'from_to'     => true,
        'text_from'   => '开始',
        'text_to'     => '结束',
        'default'     => [
            'from' => '2026-10-01',
            'to'   => '2026-10-31',
        ],
    ],

    // 6. link - 链接
    'demo_link' => [
        'labels'      => 'tpl-demo',
        'type'        => 'link',
        'name'        => '自定义推荐链接',
        'description' => '链接组件（link）：包含链接文字、链接网址以及在新标签页中打开',
        'default'     => [
            'text'   => 'Emlog 官网',
            'url'    => 'https://www.emlog.net',
            'target' => '_blank',
        ],
    ],

    // 7. link_color - 超链接颜色
    'demo_link_color' => [
        'labels'      => 'tpl-demo',
        'type'        => 'link_color',
        'name'        => '超链接多状态颜色',
        'description' => '超链接颜色（link_color）：支持常规、悬浮、激活等多状态色彩配置',
        'color'       => true,
        'hover'       => true,
        'active'      => true,
        'default'     => [
            'color'  => '#1a73e8',
            'hover'  => '#1557b0',
            'active' => '#0d47a1',
        ],
    ],

    // 8. spacing - 间距
    'demo_spacing' => [
        'labels'      => 'tpl-demo',
        'type'        => 'spacing',
        'name'        => '页面容器内边距（Padding）',
        'description' => '间距组件（spacing）：支持独立配置上、右、下、左间距及单位选择',
        'units'       => ['px', '%', 'rem'],
        'default'     => [
            'top'    => '16',
            'right'  => '20',
            'bottom' => '16',
            'left'   => '20',
            'unit'   => 'px',
        ],
    ],

    // 9. border - 边框
    'demo_border' => [
        'labels'      => 'tpl-demo',
        'type'        => 'border',
        'name'        => '卡片边框样式',
        'description' => '边框组件（border）：支持边框粗细、线型样式（实线/虚线/点线等）以及边框颜色',
        'all'         => true,
        'unit'        => 'px',
        'default'     => [
            'all'   => '1',
            'style' => 'solid',
            'color' => '#e2e8f0',
        ],
    ],

    // 10. background - 背景
    'demo_background' => [
        'labels'      => 'tpl-demo',
        'type'        => 'background',
        'name'        => '全局背景配置',
        'description' => '背景组件（background）：支持背景色、背景图上传、平铺模式、对齐位置与附着方式',
        'default'     => [
            'background-color'      => '#f8fafc',
            'background-image'      => '',
            'background-repeat'     => 'no-repeat',
            'background-position'   => 'center center',
            'background-size'       => 'cover',
            'background-attachment' => 'scroll',
        ],
    ],
    */
];
