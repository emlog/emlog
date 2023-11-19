## Emlog Pro模板设置插件使用文档

> 模板支持自定义设置功能，为模板提供更丰富的设置功能。

在模板目录里放入 *options.php* 文件，内容格式如下即可，可以任意增加设置项：

开头注释不可以删除或更改，参考如下

```php
<?php
/*@support tpl_options*/

!defined('EMLOG_ROOT') && exit('access denied!');

$options = [
    'TplOptionsNavi'   => [
        'type'         => 'radio',
        'name'         => '定义设置项标签页名称',
        'values'       => [
            'tpl-head' => '头部设置',
        ],
        'description'  => '<p>模板：晨 <br>欢迎使用这款简约的模板，目前仅支持设置头部logo</p>'
    ],
    'sale_qq'          => [
        'labels'       => 'tpl-head',
        'type'         => 'text',
        'name'         => 'QQ咨询',
      	'multi'        => 'true',
        'values'       => ['12345678'],
    ],
    'logotype'         => [
        'labels'       => 'tpl-head',
        'type'         => 'radio',
        'name'         => 'LOGO显示模式',
        'values'       => [
            '1' => '文字',
            '0' => '图片',
        ],
        'default'      => '1',
    ],
    'logoimg'          => [
        'labels'       => 'tpl-head',
        'type'         => 'image',
        'name'         => 'LOGO上传',
        'values'       => [
            TEMPLATE_URL . 'images/logo.png',
        ],
        'description'  => '上传LOGO图片。'
    ],
    'index_sort_list' => [
        'labels'       => 'modules',
        'type'         => 'sort',
        'name'         => '分类多选',
        'multi'        => 'true',
        'description'  => ''
    ],
    'index_page_list' => [
        'labels'       => 'modules',
        'type'         => 'page',
        'name'         => '页面多选',
        'multi'        => 'true',
        'description'  => ''
    ],
     'styles-lazyopts' => [
        'labels'       => 'styles',
        'type'         => 'checkbox',
        'name'         => '图像异步懒加载',
        'values'       => [
            'view'   => '浏览量',
            'comnum' => '评论数量',
            'agree'  => '点赞数量',
        ],
        'default' => array('view', 'comnum'),
        'description' => '',
    ),
    'index_tag'        => [
        'labels'       => 'tpl-head',
        'type'         => 'checkon',
        'name'         => '首页是否显示标签列表',
        'values'       => ['1' => '开启'],
        'default'      => '1',
        'description'  => '点击设置开关，蓝色为开。'
    ],
    'index_post_list'  => [
        'labels'       => 'tpl-head',
        'type'         => 'select',
        'name'         => '搜索文章',
        'new'          => 'NEW',
        'pattern'      => 'post',
        'description'  => ''
    ],
    'index_cate_list'  => [
        'labels'       => 'tpl-head',
        'type'         => 'select',
        'name'         => '搜索分类',
        'new'          => 'NEW',
        'pattern'      => 'cate',
        'description'  => ''
    ],
    'index_page_list'  => [
        'labels'       => 'tpl-head',
        'type'         => 'select',
        'name'         => '搜索页面',
        'new'          => 'NEW',
        'pattern'      => 'page',
        'description'  => ''
    ],
    'index_block_list' => [
        'labels'       => 'tpl-head',
        'type'         => 'block',
        'name'         => '拖动多内容块',
        'new'          =>  'NEW',
        'description'  => ''
    ],
];
```



### options.php里，每个元素都该写什么？

如上所示，*$options*数组里，key为设置项的id，而value是一个数组，数组里包含若干个元素。其中type属性和name属性必选，name是设置项名字，而type用来指定设置项的类型，支持的类型如下：

- radio: 单选按钮
- checkbox: 复选按钮
- checkon: 开关
- text: 文本
- image: 图片
- page: 页面
- sort: 分类
- tag: 标签
- select: 搜索选择
- block: 多内容块

1. 对于所有类型，default属性用于指定默认值，当没有指定default时，使用values里第一个值，若都没有指定，则会使用奇怪的默认值。
2. 对于radio和chexkbox类型，values属性用来设置各个按钮的值和显示名称。
3. 除sort外，均可以指定depend为sort，表示该选项可以根据不同的分类设置不同的值，当指定depend为sort时，可选unsorted属性，为true时，表示包括未分类，为false不包括，默认为true。
4. sort和page可设置multi属性为true，表示多选。
5. (可选) description属性用于描述该选项。
6. 若type为text，可设置multi属性为true，表示多行文本，即input和textarea的区别，可选属性rich用以支持富文本，若设置该值，将加载编辑器。
7. 若type为sort、page或者tag，且设置了多选，默认值将为空，否则将为第一个该类型的值。
8. 对于类型**select**，pattern属性是**必填项**，可以填入：(1). post  (2).cate  (3).page。分别依次对应文章、分类、页面。
9. (可选) 上述**所有类型**均支持 *new* 属性，即会在设置项名称后显示提醒徽标，效果可见默认模板。该属性值随意填写，如：NEW、新等。若为空或不填写将不显示。

### 模板里如何调用设置项

插件提供简单方法  _g($key) 或 _em($key)，来获取设置

以_g($key)为例如：

- 使用_g('sidebar')来获取侧边栏的设置，取到的值将为0或者1，
- 使用_g('sortIcon')来获取分类icon的全部设置，以分类id为key的数组，
- 使用_g('sortIcon.1')来获取分类id为1（如果存在）的sortIcon。需要注意的是，对于类型为page的，将取到页面id，类型为sort的，将取到分类id，类型为tag的，将取到标签名。

若不传递参数，即使用 _g() 方法将获取到所有设置项，对于老的模板迁移来的，可以用extract( _g() );来代替原来的加载option文件。