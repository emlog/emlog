<?php
/*
Plugin Name: 模板设置
Version: 4.2.13
Plugin URL: https://www.emlog.net/docs/dev/template
Description: 为模板增加丰富的设置功能，详见官网文档-模板开发。
Author: emlog
Author URL: https://www.emlog.net/profiles/cf75dc06
*/

defined('EMLOG_ROOT') || exit('access denied!');

/**
 * 模板设置类
 */
class TplOptions
{

    //插件标识
    const ID = 'tpl_options';
    const NAME = '模板设置';
    const VERSION = '4.2.13';

    //数据表前缀
    private $_prefix = 'tpl_options_';

    //数据表
    private $_tables = array(
        'data',
    );

    //允许上传的文件类型
    private $_imageTypes = array(
        'gif',
        'jpg',
        'jpeg',
        'png'
    );

    //实例
    private static $_instance;

    //是否初始化
    private $_inited = false;

    //模板参数
    private $_templateOptions;

    //从模板读取经过处理的原始设置项
    private $_options;

    //支持的参数类型
    private $_types;

    //数据为数组的类型
    private $_arrayTypes = array();

    //数据库连接实例
    private $_db;

    //插件模板目录
    private $_view;

    //插件前端资源路径
    private $_assets;

    //当前模板
    private $_currentTemplate;

    //页面
    private $_pages;

    //文章
    private $_posts;

    //模板原始设置项缓存
    private $_definedOptionsCache = array();

    /**
     * 单例入口
     * @return TplOptions
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 私有构造函数，保证单例
     */
    private function __construct() {}

    /**
     * 初始化函数
     * @return void
     */
    public function init()
    {
        if ($this->_inited === true) {
            return;
        }
        $this->_inited = true;

        //初始化各个数据表名
        $tables = array();
        foreach ($this->_tables as $name => $table) {
            $tables[$table] = $this->getTableName($table);
        }
        $this->_tables = $tables;

        //初始化模板设置类型
        $this->_types = array(
            'radio'    => array(
                'name'       => _langPlu('radio', 'tpl_options'),
                'allowMulti' => false,
            ),
            'color'    => array(
                'name'       => _langPlu('color', 'tpl_options'),
                'allowMulti' => false,
            ),
            'checkon'  => array(
                'name'       => _langPlu('switch', 'tpl_options'),
                'allowMulti' => false,
            ),
            'checkbox' => array(
                'name'       => _langPlu('checkbox', 'tpl_options'),
                'allowMulti' => true,
            ),
            'text'     => array(
                'name'       => _langPlu('text', 'tpl_options'),
                'allowMulti' => true,
                'allowRich'  => true,
            ),
            'image'    => array(
                'name'       => _langPlu('image', 'tpl_options'),
                'allowMulti' => false,
            ),
            'page'     => array(
                'name'       => _langPlu('page', 'tpl_options'),
                'allowMulti' => true,
            ),
            'sort'     => array(
                'name'        => _langPlu('category', 'tpl_options'),
                'allowMulti'  => true,
                'allowDepend' => true,
            ),
            'tag'      => array(
                'name'       => _langPlu('tag', 'tpl_options'),
                'allowMulti' => true,
            ),
            'select'   => array(
                'name'       => _langPlu('select', 'tpl_options'),
                'allowMulti' => true,
            ),
            'block'    => array(
                'name'       => _langPlu('block', 'tpl_options'),
                'allowMulti' => true,
            ),
            'background' => array(
                'name'       => _langPlu('background', 'tpl_options'),
                'allowMulti' => false,
            ),
            'border' => array(
                'name'       => _langPlu('border', 'tpl_options'),
                'allowMulti' => false,
            ),
            'date' => array(
                'name'       => _langPlu('date', 'tpl_options'),
                'allowMulti' => false,
            ),
            'link' => array(
                'name'       => _langPlu('link', 'tpl_options'),
                'allowMulti' => false,
            ),
            'link_color' => array(
                'name'       => _langPlu('link_color', 'tpl_options'),
                'allowMulti' => false,
            ),
            'notice' => array(
                'name'       => _langPlu('notice', 'tpl_options'),
                'allowMulti' => false,
            ),
            'number' => array(
                'name'       => _langPlu('number', 'tpl_options'),
                'allowMulti' => false,
            ),
            'slider' => array(
                'name'       => _langPlu('slider', 'tpl_options'),
                'allowMulti' => false,
            ),
            'spacing' => array(
                'name'       => _langPlu('spacing', 'tpl_options'),
                'allowMulti' => false,
            ),
            'submessage' => array(
                'name'       => _langPlu('submessage', 'tpl_options'),
                'allowMulti' => false,
            ),
        );
        $this->_arrayTypes = array(
            'checkbox',
            'tag',
            'select',
            'block',
            'background',
            'border',
            'spacing',
            'link',
            'link_color',
        );

        //设置模板目录
        $this->_view = __DIR__ . '/views/';
        $this->_assets = BLOG_URL . 'content/plugins/' . self::ID . '/assets/';

        //注册各个钩子
        $scriptBaseName = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
        if ($scriptBaseName == 'template') {
            addAction('adm_head', function () {
                TplOptions::getInstance()->hookAdminMainTopData();
                TplOptions::getInstance()->hookAdminHead();
            });
            addAction('adm_footer', function () {
                TplOptions::getInstance()->hookAdminFooter();
            });
        }
    }

    /**
     * 输出数据
     * @return void
     */
    public function hookAdminMainTopData()
    {
        $templates = $this->getTemplates();
        $data = array(
            'templates' => $templates,
            'prefix'    => str_replace('_', '-', $this->_prefix),
            'currentTemplate' => Option::get('nonce_templet'),
            'autoOpenSetting' => Input::getIntVar('setting', 0),
            'baseUrl'   => $this->url(),
            'uploadUrl' => $this->url(array(
                "do" => "upload"
            )),
            'lang'      => array(
                'setting' => _langPlu('js_setting', 'tpl_options'),
                'title' => _langPlu('js_title', 'tpl_options'),
                'upload' => _langPlu('js_upload', 'tpl_options'),
                'choose_media' => _langPlu('select', 'tpl_options'),
                'content' => _langPlu('js_content', 'tpl_options'),
                'upload_failed' => _langPlu('js_upload_failed', 'tpl_options'),
                'confirm_delete' => _langPlu('js_confirm_delete', 'tpl_options'),
                'network_error' => _langPlu('js_network_error', 'tpl_options'),
                'not_support' => _langPlu('tpl_no_support', 'tpl_options'),
            ),
        );
        echo sprintf('<script>var tplOptions = %s;</script>', json_encode($data));
    }

    /**
     * 头部，如css文件
     * @return void
     */
    public function hookAdminHead()
    {
        echo sprintf('<link rel="stylesheet" href="%s">', $this->_assets . 'main.css?ver=' . urlencode(self::VERSION . Option::EMLOG_VERSION_TIMESTAMP));
        echo sprintf('<script src="%s"></script>', $this->_assets . 'main.js?ver=' . urlencode(self::VERSION . Option::EMLOG_VERSION_TIMESTAMP));
    }

    /**
     * 底部输出资源媒体库弹窗
     * @return void
     */
    public function hookAdminFooter()
    {
        include View::getAdmView('media_lib');
    }

    /**
     * 获取数据表
     * @param mixed $table 表名缩写，可选，若不设置则返回所有表，否则返回对应表
     * @return mixed 返回数组或字符串
     */
    public function getTable($table = null)
    {
        return $table === null ? $this->_tables : (isset($this->_tables[$table]) ? $this->_tables[$table] : '');
    }

    /**
     * 获取数据表名
     * @param string $table 表名缩写
     * @return string 表全名
     */
    private function getTableName($table)
    {
        return DB_PREFIX . $this->_prefix . $table;
    }

    /**
     * 获取模板参数数据，默认获取当前模板
     * @param mixed $template 模板名称，可选
     * @return array 模板参数
     */
    public function getTemplateOptions($template = null)
    {
        if ($template === null) {
            $template = Template::getCurrentTemplate();
        }
        if (isset($this->_templateOptions[$template])) {
            return $this->_templateOptions[$template];
        }
        $_data = $this->queryAll('data', array(
            'template' => $template,
        ));
        $templateOptions = array();
        $options = $this->getTemplateDefinedOptions($template);
        if ($options === false) {
            $options = array();
        }
        foreach ($_data as $row) {
            extract($row);
            $data = unserialize($data);
            $templateOptions[$name] = $data;
        }
        $unsorted = isset($option['unsorted']) ? $option['unsorted'] : true;
        $sorts = $this->getSorts($unsorted);
        $pages = $this->getPages();
        foreach ($options as $name => $option) {
            if (!is_array($option) || !isset($option['type']) || !isset($this->_types[$option['type']])) {
                unset($options[$name]);
                continue;
            }
            if (!isset($option['name'])) {
                $option['name'] = '';
            }
            if (!isset($templateOptions[$name])) {
                $templateOptions[$name] = $this->getOptionDefaultValue($option, $template);
            }
            $depend = isset($option['depend']) ? $option['depend'] : '';
            if ($depend == 'sort') {
                if (!is_array($templateOptions[$name])) {
                    $templateOptions[$name] = array();
                }
                foreach ($sorts as $sort) {
                    if (!isset($templateOptions[$name][$sort['sid']])) {
                        $templateOptions[$name][$sort['sid']] = $this->getOptionDefaultValue($option, $template);
                    }
                }
            }
            switch ($option['type']) {
                case 'sort':
                case 'page':
                    $varName = $option['type'] . 's';
                    $var = $$varName;
                    if (!$this->isMulti($option) && !isset($var[$templateOptions[$name]])) {
                        $templateOptions[$name] = $this->getOptionDefaultValue($option, $template);
                    }
                    break;
                case 'background':
                    if (is_array($templateOptions[$name]) && !empty($templateOptions[$name]['background-image'])) {
                        $templateOptions[$name]['background-image'] = $this->buildImageUrl($templateOptions[$name]['background-image']);
                    }
                    break;

                default:
                    break;
            }
            if ($option['type'] == 'image') {
                $templateOptions[$name] = $this->buildImageUrl($templateOptions[$name]);
            }
        }
        return $this->_templateOptions[$template] = $templateOptions;
    }

    /**
     * 设置模板参数数据
     * @param string $template 模板名称
     * @param array $options 模板参数
     * @return boolean
     */
    public function setTemplateOptions($template, $options)
    {
        if ($options === array()) {
            return true;
        }
        $data = array();
        foreach ($options as $name => $option) {
            $data[] = array(
                'template' => $template,
                'name'     => $name,
                'depend'   => $option['depend'],
                'data'     => serialize($option['data']),
            );
        }
        return $this->insert('data', $data, true);
    }

    /**
     * 获取所有分类
     * @param boolean $unsorted 是否获取未分类
     * @return array
     */
    private function getSorts($unsorted = false, $is_cate = false)
    {
        $sorts = Cache::getInstance()->readCache('sort');
        if ($unsorted) {
            array_unshift($sorts, array(
                'sid'      => -1,
                'sortname' => _langPlu('uncategorized', 'tpl_options'),
                'lognum'   => 0,
                'children' => array(),
            ));
        }
        if ($is_cate) {
            foreach ($sorts as $sort) {
                $sorts[$sort['sid']] = $this->encode($sort['sortname']);
            }
        }
        return $sorts;
    }

    /**
     * 获取所有标签
     * @return array
     */
    private function getTags()
    {
        $data = $this->queryAll('tag', array(), 'tid,tagname');
        return $data;
    }

    /**
     * 获取所有页面
     * @return array
     */
    private function getPages()
    {
        if ($this->_pages !== null) {
            return $this->_pages;
        }
        $data = $this->queryAll('blog', array(
            'type' => 'page',
            'hide' => 'n',
        ), 'gid, title');
        $pages = array();
        foreach ($data as $page) {
            $pages[$page['gid']] = $this->encode($page['title']);
        }
        return $this->_pages = $pages;
    }

    /**
     * 获取所有文章
     * @return array
     */
    private function getPosts()
    {
        if ($this->_posts !== null) {
            return $this->_posts;
        }
        $data = $this->queryAll('blog', array(
            'type' => 'blog',
            'hide' => 'n',
        ), 'gid, title');
        $posts = array();
        foreach ($data as $post) {
            $posts[$post['gid']] = $this->encode($post['title']);
        }
        return $this->_posts = $posts;
    }

    /**
     * 获取多内容块数据
     * @return array
     */
    private function getBlockData($name)
    {
        $data = $this->queryAll('tpl_options_data', array(
            'name' => $name,
        ), 'data');
        if (!isset($data[0]['data'])) {
            return [];
        }
        return unserialize($data[0]['data']);
    }

    /**
     * 获取数据库连接
     */
    public function getDb()
    {
        if ($this->_db !== null) {
            return $this->_db;
        }
        $this->_db = Database::getInstance();
        return $this->_db;
    }

    /**
     * 从表中查询出所有数据
     * @param string $table 表名缩写
     * @param mixed $condition 字符串或数组条件
     * @return array 结果数据
     */
    private function queryAll($table, $condition = '', $select = '*')
    {
        $table = $this->getTable($table) ? $this->getTable($table) : DB_PREFIX . $table;
        $subSql = $this->buildQuerySql($condition);
        $sql = "SELECT $select FROM `$table`";
        if ($subSql) {
            $sql .= " WHERE $subSql";
        }
        $query = $this->getDb()->query($sql);
        $data = array();
        while ($row = $this->getDb()->fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }

    /**
     * 将数据插入数据表
     * @param string $table 表名缩写
     * @param array $data 数据
     * @return bool 结果数据
     */
    private function insert($table, $data, $replace = false)
    {
        $table = $this->getTable($table);
        $subSql = $this->buildInsertSql($data);
        if ($replace) {
            $sql = "REPLACE INTO `$table`";
        } else {
            $sql = "INSERT INTO `$table`";
        }
        $sql .= $subSql;
        return $this->getDb()->query($sql) !== false;
    }

    /**
     * 根据条件构造WHERE子句
     * @param mixed $condition 字符串或数组条件
     * @return string 根据条件构造的查询子句
     */
    private function buildQuerySql($condition)
    {
        if (is_string($condition)) {
            return $condition;
        }
        $subSql = array();
        foreach ($condition as $key => $value) {
            if (is_string($value)) {
                if (class_exists('mysqli', FALSE)) {
                    $value = $this->getDb()->escape_string($value);
                }
                $subSql[] = "(`$key`='$value')";
            } elseif (is_array($value)) {
                $subSql[] = "(`$key` IN (" . $this->implodeSqlArray($value) . '))';
            }
        }
        return implode(' AND ', $subSql);
    }

    /**
     * 根据数据构造INSERT/REPLACE INTO子句
     * @param array $data 数据
     * @return string 根据数据构造的子句
     */
    private function buildInsertSql($data)
    {
        $subSql = array();
        if (array_key_exists(0, $data)) {
            $keys = array_keys($data[0]);
        } else {
            $keys = array_keys($data);
            $data = array(
                $data
            );
        }
        foreach ($data as $key => $value) {
            $subSql[] = '(' . $this->implodeSqlArray($value) . ')';
        }
        $subSql = implode(',', $subSql);
        $keys = '(`' . implode('`,`', $keys) . '`)';
        $subSql = "$keys VALUES $subSql";
        return $subSql;
    }

    /**
     * 将数组展开为可以供SQL使用的字符串
     * @param array $data 数据
     * @return string 形如('value1', 'value2')的字符串
     */
    private function implodeSqlArray($data)
    {
        return implode(',', array_map(function ($val) {
            if (class_exists('mysqli', FALSE)) {
                $val = $this->getDb()->escape_string($val);
            }
            return "'" . $val . "'";
        }, $data));
    }

    /**
     * 插件设置函数
     * @return void
     */
    public function setting()
    {
        $do = $this->arrayGet($_GET, 'do');
        $template = $this->arrayGet($_GET, 'template');
        $code = $this->arrayGet($_GET, 'code');
        $msg = $this->arrayGet($_GET, 'msg');
        $currentTemplate = Option::get('nonce_templet');
        $targetTemplate = !empty($template) ? $template : $currentTemplate;
        $allTemplate = $this->getTemplates($targetTemplate);
        if ($do != '') {
            if ($do == 'upload' && isset($_FILES['image'])) {
                $file = $_FILES['image'];
                $target = $this->arrayGet($_POST, 'target');
                $template = $this->arrayGet($_POST, 'template');
                $result = $this->upload($template, $file, $target);
                extract($result);
                $src = '';
                if ($path) {
                    $path = substr($path, 3);
                    $src = BLOG_URL . $path;
                }
                ob_clean();
                include $this->view('upload');
                exit;
            }
            emDirect('./template.php?setting=1');
        } elseif ($template !== null) {
            if (!is_dir(TPLS_PATH . $template)) {
                $this->jsonReturn(array(
                    'code' => 1,
                    'msg'  => _langPlu('tpl_not_exist', 'tpl_options'),
                ));
            }
            $options = $this->getTemplateDefinedOptions($template);
            if ($options === false) {
                $this->jsonReturn(array(
                    'code' => 1,
                    'msg'  => _langPlu('tpl_no_support', 'tpl_options'),
                ));
            }
            $this->_currentTemplate = $template;
            $storedOptions = $this->getTemplateOptions($template);
            foreach ($options as $name => &$option) {
                if (!is_array($option) || !isset($option['type']) || !isset($this->_types[$option['type']])) {
                    unset($options[$name]);
                    continue;
                }
                if (!isset($option['name'])) {
                    $option['name'] = '';
                }
                $option['id'] = $name;
                $option['value'] = $storedOptions[$name];
            }
            $this->_options = $options;
            if (!empty($_POST)) {
                $newOptions = array();
                foreach ($_POST as $name => $data) {
                    if (!isset($options[$name])) {
                        continue;
                    }
                    $type = isset($options[$name]['type']) ? $options[$name]['type'] : '';
                    if (in_array($type, array('notice', 'submessage'))) {
                        continue;
                    }
                    $depend = isset($options[$name]['depend']) ? $options[$name]['depend'] : '';
                    $type = isset($options[$name]['type']) ? $options[$name]['type'] : '';
                    switch ($depend) {
                        case 'sort':
                            $sorts = $this->getSorts(true);
                            if (!is_array($data)) {
                                $data = array();
                            }
                            foreach ($sorts as $sort) {
                                $sid = $sort['sid'];
                                if (!isset($data[$sid]) || $this->shouldBeArray($options[$name], $data[$sid])) {
                                    $data[$sid] = $this->getOptionDefaultValue($options[$name], $template);
                                }
                            }
                            break;
                    }
                    if ($this->shouldBeArray($options[$name], $data)) {
                        $data = array();
                    }
                    $newOptions[$name] = array(
                        'depend' => $depend,
                        'data'   => $data,
                    );
                }
                $result = $this->setTemplateOptions($template, $newOptions);
                $code = $result ? 0 : 1;
                $data = array(
                    'template' => $template,
                    'code'     => $result ? 0 : 1,
                    'msg'      => ($result ? _langPlu('save_success', 'tpl_options') : _langPlu('save_failed', 'tpl_options')),
                );
                $this->jsonReturn($data);
            }
            ob_clean();
            include $this->view('setting');
            exit;
        } else {
            emDirect('./template.php?setting=1');
        }
    }

    /**
     * 判断是否本该为数组但不是数组的
     * @param array $option
     * @param mixed $data
     * @return boolean
     */
    private function shouldBeArray($option, $data)
    {
        if (is_array($data)) {
            return false;
        }
        if (in_array($option['type'], $this->_arrayTypes)) {
            return true;
        }
        if (in_array($option['type'], array(
            'sort',
            'page'
        )) && $this->isMulti($option)) {
            return true;
        }
        return false;
    }

    /**
     * 判断是否为多选/多行文本
     * @param array $option
     * @return boolean
     */
    private function isMulti($option)
    {
        return isset($option['multi']) && $option['multi'];
    }

    /**
     * 判断是否为日期格式文本
     * @param array $option
     * @return boolean
     */
    private function isDate($option)
    {
        return isset($option['date']) && $option['date'];
    }

    /**
     * 上传文件
     * @param string $template 模板
     * @param array $file 上传的文件
     * @param string $target 目标
     * @return array 上传结果信息
     */
    private function upload($template, $file, $target)
    {
        $result = array(
            'code' => 0,
            'msg'  => '',
            'name' => $file['name'],
            'size' => $file['size'],
            'path' => '',
        );
        if ($file['error'] == 1) {
            $result['code'] = 100;
            $result['msg'] = _langPlu('file_size_limit', 'tpl_options');
            return $result;
        }

        if ($file['error'] > 1) {
            $result['code'] = 101;
            $result['msg'] = _langPlu('upload_failed', 'tpl_options');
            return $result;
        }
        $extension = getFileSuffix($file['name']);
        if (!in_array($extension, $this->_imageTypes)) {
            $result['code'] = 102;
            $result['msg'] = _langPlu('file_type_error', 'tpl_options');
            return $result;
        }
        $maxSize = defined('UPLOAD_MAX_SIZE') ? constant('UPLOAD_MAX_SIZE') : 2097152;

        if ($file['size'] > $maxSize) {
            $result['code'] = 103;
            $result['msg'] = _langPlu('file_size_limit', 'tpl_options');
            return $result;
        }
        $uploadPath = Option::UPLOADFILE_PATH . self::ID . "/$template/";

        $file_baseName = rtrim(str_replace(array(
            '[',
            ']'
        ), '.', $target), '.');

        $fileName = $file_baseName . '_' . uniqid() . '.' . $extension;
        $exists_files = glob($uploadPath . $file_baseName . '*');
        if (count($exists_files)) {
            unlink($exists_files[0]);
        }

        $attachpath = $uploadPath . $fileName;
        $result['path'] = $attachpath;
        if (!is_dir($uploadPath)) {
            @umask(0);
            $ret = @mkdir($uploadPath, 0777, true);
            if ($ret === false) {
                $result['code'] = 104;
                $result['msg'] = _langPlu('create_dir_failed', 'tpl_options');
                return $result;
            }
        }
        if (@is_uploaded_file($file['tmp_name'])) {
            if (@!move_uploaded_file($file['tmp_name'], $attachpath)) {
                $result['code'] = 105;
                $result['msg'] = _langPlu('dir_not_writable', 'tpl_options');
                return $result;
            }
            @chmod($attachpath, 0777);
        }
        return $result;
    }

    /**
     * 获取设置项的值
     * @param array $option 模板设置项
     * @param array $storedOptions 存储的模板设置项
     * @param string $template
     * @return mixed
     */
    private function getOptionValue(&$option, $storedOptions, $template)
    {
        if (isset($storedOptions[$option['id']])) {
            return $storedOptions[$option['id']];
        }
        return $this->getOptionDefaultValue($option, $template);
    }

    /**
     * 获取模板设置项的值
     * @param array $option 模板设置项
     * @param string $template
     * @return mixed
     */
    private function getOptionDefaultValue(&$option, $template)
    {
        if (isset($option['default']) && !in_array($option['type'], array(
            'page',
            'sort',
            'tag',
            'block'
        ))) {
            $default = $option['default'];
        } else {
            switch ($option['type']) {
                case 'radio':
                    if (!isset($option['values']) || !is_array($option['values'])) {
                        $option['values'] = array(
                            0 => _langPlu('no', 'tpl_options'),
                            1 => _langPlu('yes', 'tpl_options'),
                        );
                    }
                    $default = $this->arrayGet(array_keys($option['values']), 0);
                    break;

                case 'checkbox':
                    if (!isset($option['values']) || !is_array($option['values'])) {
                        $option['values'] = array();
                    }
                    $default = $option['values'];
                    break;
                case 'checkon':
                    $default = $option['values'];
                    break;
                case 'text':
                case 'color':
                case 'image':
                    if (!isset($option['values']) || !is_array($option['values'])) {
                        $option['values'] = array();
                    }
                    $default = reset($option['values']);
                    break;

                case 'page':
                    if (!$this->isMulti($option)) {
                        $pages = $this->getPages();
                        $default = $this->arrayGet(array_keys($pages), 0);
                        break;
                    }
                case 'sort':
                    if (!$this->isMulti($option)) {
                        $sorts = $this->getSorts();
                        $default = $this->arrayGet(array_keys($sorts), 0);
                        break;
                    }
                case 'tag':
                case 'block':
                    $default = array();
                    break;

                case 'number':
                    $default = '';
                    break;

                case 'slider':
                    $default = isset($option['min']) ? (string)$option['min'] : '0';
                    break;

                case 'date':
                    $default = !empty($option['from_to']) ? array('from' => '', 'to' => '') : '';
                    break;

                case 'link':
                    $default = array(
                        'url'    => '',
                        'text'   => '',
                        'target' => '_self',
                    );
                    break;

                case 'link_color':
                    $default = array(
                        'color' => '#1a73e8',
                        'hover' => '#1557b0',
                    );
                    break;

                case 'spacing':
                    $default = array(
                        'top'    => '10',
                        'right'  => '15',
                        'bottom' => '10',
                        'left'   => '15',
                        'unit'   => 'px',
                    );
                    break;

                case 'border':
                    $default = array(
                        'all'   => '1',
                        'style' => 'solid',
                        'color' => '#e2e8f0',
                    );
                    break;

                case 'background':
                    $default = array(
                        'background-color'      => '#ffffff',
                        'background-image'      => '',
                        'background-repeat'     => 'no-repeat',
                        'background-position'   => 'center center',
                        'background-size'       => 'cover',
                        'background-attachment' => 'scroll',
                    );
                    break;

                case 'notice':
                case 'submessage':
                    $default = null;
                    break;

                default:
                    return null;
            }
        }
        return $this->replacePath($default, $template);
    }

    /**
     * 替换设置项里的url
     * @param mixed $value
     * @param string $template
     * @return mixed
     */
    private function replacePath($value, $template)
    {
        $replace = array(
            TEMPLATE_URL => TPLS_URL . $template . '/',
        );
        if (is_string($value)) {
            return strtr($value, $replace);
        }

        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = $this->replacePath($val, $template);
            }
            return $value;
        }

        return $value;
    }

    /**
     * 渲染设置页面的设置项
     * @return void
     */
    private function renderOptions()
    {
        foreach ($this->_options as $option) {
            $methodCamel = 'render' . str_replace('_', '', ucfirst($option['type']));
            $methodDirect = 'render' . ucfirst($option['type']);
            if (method_exists($this, $methodCamel)) {
                $this->$methodCamel($option);
            } elseif (method_exists($this, $methodDirect)) {
                $this->$methodDirect($option);
            }
        }
    }

    /**
     * 渲染模板设置
     * @return void
     */
    private function renderByTpl($option, $tpl, $loopValues = true, $placeholder = true)
    {
        $desc = '';
        $tip = '';
        $is_multi = '';
        if ($this->isMulti($option)) {
            $is_multi = 'is-multi';
        }
        if (!empty($option['description'])) {
            $desc = '<div class="option-description">' . $option['description'] . '</div>';
        }
        if (isset($option['new']) && trim($option['new'])) {
            $tip = '<small class="new-tip">' . trim($option['new']) . '</small>';
        }
        echo '<div class="option ' . @$option['labels'] . '" id="' . $option['id'] . '">';
        echo '<div class="option-name" data-name="' . $this->encode($option['name']) . '" data-id="' . $option['id'] . '">', $this->encode($option['name']) . $tip, $desc, '</div>';
        $depend = isset($option['depend']) ? $option['depend'] : 'none';
        echo sprintf('<div class="option-body depend-%s %s">', $depend, $is_multi);
        switch ($depend) {
            case 'sort':
                $unsorted = isset($option['unsorted']) ? $option['unsorted'] : true;
                $sorts = $this->getSorts($unsorted);
                if (!is_array($option['value'])) {
                    $option['value'] = array();
                }
                echo '<div class="option-sort-tag" data-option-name="', $option['name'], '">';
                echo '<div class="option-sort-tag-left">';
                if (count($sorts) < 1) {
                    foreach ($sorts as $sort) {
                        echo '<div class="option-sort-tag-name">';
                        echo $sort['sortname'];
                        echo '</div>';
                    }
                } else {
                    echo '<select class="option-sort-tag-select">';
                    foreach ($sorts as $sort) {
                        echo sprintf('<option value="%s">%s</option>', $sort['sortname'], $sort['sortname']);
                    }
                    echo '</select>';
                }
                echo '</div>';
                echo '<div class="option-sort-tag-right">';
                foreach ($sorts as $sort) {
                    $sid = $sort['sid'];
                    echo '<div class="option-sort-tag-option">';
                    if (!isset($option['value'][$sid])) {
                        $option['value'][$sid] = $this->getOptionDefaultValue($option, $this->_currentTemplate);
                    }
                    if ($loopValues) {
                        if ($placeholder) {
                            echo sprintf('<input type="hidden" name="%s" value="">', $option['id'] . "[{$sid}]");
                        }
                        foreach ($option['values'] as $value => $label) {
                            echo strtr($tpl, array(
                                '{name}'    => $option['id'] . "[{$sid}]",
                                '{value}'   => $this->encode($value),
                                '{label}'   => $label,
                                '{checked}' => $this->getCheckedString($value, $option['value'][$sid]),
                            ));
                        }
                    } else {
                        echo strtr($tpl, array(
                            '{name}'  => $option['id'] . "[{$sid}]",
                            '{value}' => $this->encode($option['value'][$sid]),
                            '{label}' => '',
                            '{path}'  => $this->getImagePath($option['value'][$sid]),
                            '{rich}'  => $this->getRichString($option),
                        ));
                    }
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
                break;
            case 'tag':
                $tags = $this->getTags();
                if (!is_array($option['value'])) {
                    $option['value'] = array();
                }
                echo '<div class="option-sort-tag" data-option-name="', $option['name'], '">';
                echo '<div class="option-sort-tag-left">';
                if (count($tags) < 1) {
                    foreach ($tags as $tag) {
                        echo '<div class="option-sort-tag-name">';
                        echo $tag['tagname'];
                        echo '</div>';
                    }
                } else {
                    echo '<select class="option-sort-tag-select">';
                    foreach ($tags as $tag) {
                        echo sprintf('<option value="%s">%s</option>', $tag['tagname'], $tag['tagname']);
                    }
                    echo '</select>';
                }
                echo '</div>';
                echo '<div class="option-sort-tag-right">';
                foreach ($tags as $tag) {
                    $tid = $tag['tid'];
                    echo '<div class="option-sort-tag-option">';
                    if (!isset($option['value'][$tid])) {
                        $option['value'][$tid] = $this->getOptionDefaultValue($option, $this->_currentTemplate);
                    }
                    if ($loopValues) {
                        if ($placeholder) {
                            echo sprintf('<input type="hidden" name="%s" value="">', $option['id'] . "[{$tid}]");
                        }
                        foreach ($option['values'] as $value => $label) {
                            echo strtr($tpl, array(
                                '{name}'    => $option['id'] . "[{$tid}]",
                                '{value}'   => $this->encode($value),
                                '{label}'   => $label,
                                '{checked}' => $this->getCheckedString($value, $option['value'][$tid]),
                            ));
                        }
                    } else {
                        echo strtr($tpl, array(
                            '{name}'  => $option['id'] . "[{$tid}]",
                            '{value}' => $this->encode($option['value'][$tid]),
                            '{label}' => '',
                            '{path}'  => $this->getImagePath($option['value'][$tid]),
                            '{rich}'  => $this->getRichString($option),
                        ));
                    }
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
                break;
            case 'select':
                $type = '';
                if ($option['pattern'] == 'post') {
                    $type = _langPlu('post', 'tpl_options');
                    $data = $this->getPosts();
                }
                if ($option['pattern'] == 'cate') {
                    $type = _langPlu('category', 'tpl_options');
                    $data = $this->getSorts(false, true);
                }
                if ($option['pattern'] == 'page') {
                    $type = _langPlu('page', 'tpl_options');
                    $data = $this->getPages();
                }

                echo sprintf('<div class="chosen-container chosen-container-multi %s">', $option['pattern']);
                echo '<ul class="chosen-choices">';
                echo sprintf('<input type="hidden" name="%s" value="">', $option['id']);
                foreach ($option['value'] as $id) {
                    echo strtr($tpl, array(
                        '{title}' => $data[$id],
                        '{name}'  => $option['id'],
                        '{value}' => $this->encode($id),
                    ));
                }
                echo '<li class="search-field ">';
                echo sprintf('<input class="chosen-search-input" data-opt="%s" data-s-name="%s" data-url="%s" type="text" autocomplete="off" placeholder="%s">', $option['pattern'], $option['id'], BLOG_URL, sprintf(_langPlu('search_placeholder', 'tpl_options'), $type, $type));
                echo '</li>';
                echo '</ul>';
                echo '<div class="chosen-drop">';
                echo sprintf('<ul class="chosen-results"><li class="no-results">%s</li></ul>', sprintf(_langPlu('input_placeholder', 'tpl_options'), $type));
                echo '</div>';
                echo '</div>';
                break;
            case 'block':
                $this_data_type = isset($option['pattern']) && $option['pattern'] === 'image' ? 'image' : 'text';
                $titlePlaceholder = $this->encode($this->getBlockPlaceholder($option, 'title'));
                $contentPlaceholder = $this->encode($this->getBlockPlaceholder($option, 'content'));
                echo sprintf('<input type="hidden" name="%s" value="">', $option['id']);
                echo '<div class="tpl-sortable-block">';

                $html = '<div class="tpl-block-item">';
                $html .= '<div class="tpl-block-head">
                            <i class="tpl-block-clone icofont-ui-copy"></i>
                            <i class="tpl-block-remove icofont-close icofont-md"></i>
                          </div>';

                $data = $this->getBlockData($option['id']);
                $tmp_len = empty($data) ? 0 : count($data);
                if ($tmp_len !== 0 && is_array($data)) {
                    $data_len = count($data['title']);
                    for ($i = 0; $i < $data_len; $i++) {
                        $block_title = $this->encode($data['title'][$i]);
                        echo $html;
                        echo sprintf('<h4 class="tpl-block-title"><span class="tpl-block-title-icon icofont-rounded-right"></span><item class="block-title-text">%s</item></h4>', $block_title);
                        echo '<div class="tpl-block-content d-none">';
                        echo strtr($tpl, array(
                            '{title}'               => $option['id'] . '[title][]',
                            '{tvalue}'              => $block_title,
                            '{name}'                => $option['id'] . '[content][]',
                            '{value}'               => $this->encode($data['content'][$i]),
                            '{title_placeholder}'   => $titlePlaceholder,
                            '{content_placeholder}' => $contentPlaceholder,
                        ));
                        echo '</div>';
                        echo '</div>';
                    }
                }

                echo sprintf('<a class="badge badge-success tpl-add-block" data-b-name="%s" data-type="%s" data-url="%s" data-title-ph="%s" data-content-ph="%s"><i class="ri-add-line"></i> %s</a>', $option['id'], $this_data_type, BLOG_URL, $titlePlaceholder, $contentPlaceholder, _langPlu('add', 'tpl_options'));
                echo '</div>';
                echo '<script>
                          $(".tpl-sortable-block").sortable({
                              stop: function () {
                                  block_drag_end()
                            }
                          }).disableSelection()
                      </script>';
                break;
            default:
                if ($loopValues) {
                    if ($placeholder) {
                        echo sprintf('<input type="hidden" name="%s" value="">', $option['id']);
                    }
                    foreach ($option['values'] as $value => $label) {
                        echo strtr($tpl, array(
                            '{name}'    => $option['id'],
                            '{value}'   => $this->encode($value),
                            '{label}'   => $label,
                            '{checked}' => $this->getCheckedString($value, $option['value']),
                        ));
                    }
                } else {
                    echo strtr($tpl, array(
                        '{name}'  => $option['id'],
                        '{value}' => $this->encode($option['value']),
                        '{label}' => '',
                        '{path}'  => $this->getImagePath($option['value']),
                        '{rich}'  => $this->getRichString($option),
                    ));
                }
        }
        echo '</div></div>';
    }

    /**
     * @param mixed $value
     * @param mixed $optionvalue
     * @return string
     */
    private function getCheckedString($value, $optionValue)
    {
        return (is_array($optionValue) && in_array($value, $optionValue)) || $value == $optionValue ? ' checked="checked"' : '';
    }

    /**
     * @param array $option
     * @return string
     */
    private function getRichString($option)
    {
        return isset($option['rich']) && isset($this->_types[$option['type']]['allowRich']) ? ' option-rich-text' : '';
    }

    /**
     * @param string $url
     * @return string
     */
    private function getImagePath($url)
    {
        return str_replace(BLOG_URL, '', $url);
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderRadio($option)
    {
        $tpl = '<div class="tpl-radio"><input id="{name}-{value}" name="{name}" type="radio" value="{value}"{checked}><label class="tpl-radio-label" for="{name}-{value}">{label}</label></div>';

        $this->renderByTpl($option, $tpl);
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderCheckon($option)
    {
        $tpl = '<label class="check-switch"><input type="checkbox" name="{name}" value="1"{checked}><span class="check-slider"></span></label>';
        $this->renderByTpl($option, $tpl);
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderCheckbox($option)
    {
        $tpl = '<label class="vtpl-check"><input type="checkbox" name="{name}[]" value="{value}"{checked}> {label}</label>';
        $this->renderByTpl($option, $tpl);
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderText($option)
    {
        if ($this->isDate($option)) {
            $tpl = '<input type="date" name="{name}" value="{value}">';
        } else if ($this->isMulti($option)) {
            $tpl = '<textarea name="{name}" rows="5" class="option-textarea{rich}">{value}</textarea>';
        } else {
            $tpl = '<input type="text" name="{name}" value="{value}">';
        }
        if (isset($option['pattern']) && trim($option['pattern']) === 'num') {
            $max = '';
            $min = '';
            $limit_html = '';
            $unit_html = isset($option['unit']) && trim($option['unit']) !== '' ? '<span class="tpl-number-input-unit">' . trim($option['unit']) . '</span>' : '';
            if (isset($option['max']) && trim($option['max']) !== '') {
                $max = trim($option['max']);
            }
            if (isset($option['min']) && trim($option['min']) !== '') {
                $min = trim($option['min']);
            }
            if ($max !== '' && $min !== '' && is_numeric($max) && is_numeric($min)) {
                $limit_html = 'oninput="if(value>' . $max . ')value=' . $max . ';if(value<' . $min . ')value=' . $min . '"';
            }
            if ($max !== '' && $min === '' && is_numeric($max)) {
                $limit_html = 'oninput="if(value>' . $max . ')value=' . $max . '"';
            }
            if ($max === '' && $min !== '' && is_numeric($min)) {
                $limit_html = 'oninput="if(value<' . $min . ')value=' . $min . '"';
            }
            $tpl = '<div class="tpl-number-input-item">
                        <input type="number" class="tpl-number-input" placeholder="' . _langPlu('enter_number', 'tpl_options') . '" name="{name}" value="{value}" ' . $limit_html . '>
                        ' . $unit_html . '
                    </div>';
        }
        $this->renderByTpl($option, $tpl, false);
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderSearchSelect($option)
    {
        $tpl = '<li class="search-choice"><span>{title}</span><a class="search-choice-close"><i class="icofont-close"></i></a><input class="d-none" name="{name}[]" type="text" value="{value}"></li>';
        $this->renderByTpl($option, $tpl, false);
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderColor($option)
    {
        $tpl = '<input type="color" name="{name}" value="{value}">';
        $this->renderByTpl($option, $tpl, false);
    }


    /**
     * @param array $option
     * @return void
     */
    private function renderImage($option)
    {
        $tpl = '<div class="tpl-block-upload">
                    <div class="tpl-image-preview">
                        <img src="{value}">
                    </div>
                    <div class="tpl-block-upload-input">
                        <input type="text" name="{name}" value="{value}">
                        <a class="btn btn-outline-primary tpl-select-media" href="#mediaModal" data-toggle="modal" data-target="#mediaModal" data-mode="custom" data-media-type="image" data-btn-text="' . _langPlu('select', 'tpl_options') . '" data-callback="tplOptionsUseMediaImage">' . _langPlu('select', 'tpl_options') . '</a>
                        <label>
                            <a class="btn btn-primary">' . _langPlu('js_upload', 'tpl_options') . '</a>
                            <input class="d-none tpl-image" type="file" name="image" data-url="' . BLOG_URL . '" accept="image/svg+xml,image/webp,image/avif,image/jpeg,image/jpg,image/png,image/gif">
                        </label>
                    </div>
                </div>';
        $this->renderByTpl($option, $tpl, false);
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderBlock($option)
    {
        $tpl = '';
        if (isset($option['pattern']) && trim($option['pattern']) === 'image') {
            $tpl .= '<div class="tpl-block-upload">
                        <input class="block-title-input" type="text" name="{title}" value="{tvalue}" placeholder="{title_placeholder}">
                         <div class="tpl-image-preview">
                            <img src="{value}">
                         </div>
                         <div class="tpl-block-upload-input">
                             <input type="text" name="{name}" value="{value}" placeholder="{content_placeholder}">
                             <a class="btn btn-outline-primary tpl-select-media" href="#mediaModal" data-toggle="modal" data-target="#mediaModal" data-mode="custom" data-media-type="image" data-btn-text="' . _langPlu('select', 'tpl_options') . '" data-callback="tplOptionsUseMediaImage">' . _langPlu('select', 'tpl_options') . '</a>
                             <label>
                                <a class="btn btn-primary">' . _langPlu('js_upload', 'tpl_options') . '</a>
                                <input class="d-none tpl-image" type="file" name="image" data-url="' . BLOG_URL . '" accept="image/svg+xml,image/webp,image/avif,image/jpeg,image/jpg,image/png,image/gif">
                             </label>
                         </div>
                     </div>';
        } else {
            $tpl .= '<input class="block-title-input" type="text" name="{title}" value="{tvalue}" placeholder="{title_placeholder}">';
            if ($this->isMulti($option)) {
                $tpl .= '<textarea rows="5" name="{name}" placeholder="{content_placeholder}">{value}</textarea>';
            } else {
                $tpl .= '<input type="text" name="{name}" value="{value}" placeholder="{content_placeholder}">';
            }
        }
        $option['depend'] = 'block';
        $this->renderByTpl($option, $tpl, false);
    }

    /**
     * 获取 block 类型输入框占位文本
     * @param array $option
     * @param string $field title|content
     * @return string
     */
    private function getBlockPlaceholder($option, $field)
    {
        $default = $field === 'title' ? _langPlu('js_title', 'tpl_options') : _langPlu('js_content', 'tpl_options');
        if (isset($option['placeholder']) && is_array($option['placeholder'])) {
            $value = $this->arrayGet($option['placeholder'], $field, '');
            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }
        $legacyKey = $field . '_placeholder';
        if (isset($option[$legacyKey]) && is_string($option[$legacyKey]) && trim($option[$legacyKey]) !== '') {
            return trim($option[$legacyKey]);
        }
        return $default;
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderPage($option)
    {
        $pages = $this->getPages();
        $option['values'] = $pages;
        if ($this->isMulti($option)) {
            $this->renderCheckbox($option);
        } else {
            $this->renderRadio($option);
        }
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderSort($option)
    {
        if (isset($option['depend']) && $option['depend'] == 'sort') {
            unset($option['depend']);
        }
        $sorts = $this->getSorts();
        $values = array();
        foreach ($sorts as $sid => $sort) {
            $values[$sid] = $sort['sortname'];
        }
        $option['values'] = $values;
        if ($this->isMulti($option)) {
            $this->renderCheckbox($option);
        } else {
            $this->renderRadio($option);
        }
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderSelect($option)
    {
        if (isset($option['pattern']) && (trim($option['pattern']) === 'post' || trim($option['pattern']) === 'cate' || trim($option['pattern']) === 'page')) {
            $option['depend'] = 'select';
            $this->renderSearchSelect($option);
        }
    }

    /**
     * @param array $option
     * @return void
     */
    private function renderTag($option)
    {
        $tags = Cache::getInstance()->readCache('tags');
        $values = array();
        foreach ($tags as $tag) {
            $values[$tag['tagname']] = "{$tag['tagname']} ({$tag['usenum']})";
        }
        $option['values'] = $values;
        $this->renderCheckbox($option);
    }

    /**
     * 渲染提醒条
     * @param array $option
     * @return void
     */
    private function renderNotice($option)
    {
        $style = isset($option['style']) ? $option['style'] : 'info';
        $content = isset($option['content']) ? $option['content'] : (isset($option['name']) ? $option['name'] : '');
        $desc = !empty($option['description']) ? '<div class="vtpl-notice-desc">' . $option['description'] . '</div>' : '';
        $iconMap = array(
            'info'    => 'ri-information-line',
            'success' => 'ri-checkbox-circle-line',
            'warning' => 'ri-error-warning-line',
            'danger'  => 'ri-close-circle-line',
            'normal'  => 'ri-notification-3-line',
        );
        $icon = isset($iconMap[$style]) ? $iconMap[$style] : 'ri-information-line';

        echo '<div class="option ' . (isset($option['labels']) ? $option['labels'] : '') . '" id="' . $option['id'] . '">';
        echo '<div class="vtpl-notice vtpl-notice-' . $this->encode($style) . '">';
        echo '<i class="' . $icon . ' vtpl-notice-icon"></i>';
        echo '<div class="vtpl-notice-content">';
        if (!empty($option['name']) && $content !== $option['name']) {
            echo '<div class="vtpl-notice-title">' . $this->encode($option['name']) . '</div>';
        }
        echo '<div class="vtpl-notice-text">' . $content . '</div>';
        echo $desc;
        echo '</div></div></div>';
    }

    /**
     * 渲染小提醒
     * @param array $option
     * @return void
     */
    private function renderSubmessage($option)
    {
        $style = isset($option['style']) ? $option['style'] : 'normal';
        $content = isset($option['content']) ? $option['content'] : (isset($option['name']) ? $option['name'] : '');
        echo '<div class="option ' . (isset($option['labels']) ? $option['labels'] : '') . '" id="' . $option['id'] . '">';
        echo '<div class="vtpl-submessage vtpl-submessage-' . $this->encode($style) . '">';
        echo $content;
        echo '</div></div>';
    }

    /**
     * 渲染数字输入框
     * @param array $option
     * @return void
     */
    private function renderNumber($option)
    {
        $min = isset($option['min']) && is_numeric($option['min']) ? ' min="' . $option['min'] . '"' : '';
        $max = isset($option['max']) && is_numeric($option['max']) ? ' max="' . $option['max'] . '"' : '';
        $step = isset($option['step']) ? ' step="' . $option['step'] . '"' : ' step="any"';
        $unit = isset($option['unit']) && trim($option['unit']) !== '' ? '<span class="vtpl-input-unit">' . $this->encode(trim($option['unit'])) . '</span>' : '';
        $placeholder = isset($option['placeholder']) ? ' placeholder="' . $this->encode($option['placeholder']) . '"' : '';

        $tpl = '<div class="vtpl-number-wrap">
                    <input type="number" class="vtpl-number-input" name="{name}" value="{value}"' . $min . $max . $step . $placeholder . '>
                    ' . $unit . '
                </div>';
        $this->renderByTpl($option, $tpl, false);
    }

    /**
     * 渲染滑块控件
     * @param array $option
     * @return void
     */
    private function renderSlider($option)
    {
        $min = isset($option['min']) && is_numeric($option['min']) ? (float)$option['min'] : 0;
        $max = isset($option['max']) && is_numeric($option['max']) ? (float)$option['max'] : 100;
        $step = isset($option['step']) && is_numeric($option['step']) ? (float)$option['step'] : 1;
        $unit = isset($option['unit']) && trim($option['unit']) !== '' ? $this->encode(trim($option['unit'])) : '';

        $tpl = '<div class="vtpl-slider-wrap" data-min="' . $min . '" data-max="' . $max . '" data-step="' . $step . '">
                    <input type="range" class="vtpl-slider-range" min="' . $min . '" max="' . $max . '" step="' . $step . '" value="{value}">
                    <div class="vtpl-slider-input-group">
                        <input type="number" class="vtpl-slider-number" name="{name}" min="' . $min . '" max="' . $max . '" step="' . $step . '" value="{value}">
                        ' . ($unit !== '' ? '<span class="vtpl-input-unit">' . $unit . '</span>' : '') . '
                    </div>
                </div>';
        $this->renderByTpl($option, $tpl, false);
    }

    /**
     * 渲染日期选择器（参考写文章页面日期控件风格）
     * @param array $option
     * @return void
     */
    private function renderDate($option)
    {
        if (!empty($option['from_to'])) {
            $fromText = isset($option['text_from']) ? $option['text_from'] : '从';
            $toText = isset($option['text_to']) ? $option['text_to'] : '到';

            $value = is_array($option['value']) ? $option['value'] : array('from' => '', 'to' => '');
            $fromVal = isset($value['from']) ? $value['from'] : '';
            $toVal = isset($value['to']) ? $value['to'] : '';

            $desc = !empty($option['description']) ? '<div class="option-description">' . $option['description'] . '</div>' : '';
            $tip = (isset($option['new']) && trim($option['new'])) ? '<small class="new-tip">' . trim($option['new']) . '</small>' : '';

            echo '<div class="option ' . (isset($option['labels']) ? $option['labels'] : '') . '" id="' . $option['id'] . '">';
            echo '<div class="option-name" data-name="' . $this->encode($option['name']) . '" data-id="' . $option['id'] . '">', $this->encode($option['name']) . $tip, $desc, '</div>';
            echo '<div class="option-body depend-none">';
            echo '<div class="vtpl-date-range">';
            echo '<div class="vtpl-date-item"><span class="vtpl-date-label">' . $this->encode($fromText) . '</span><input type="text" class="vtpl-date-input datepicker" name="' . $option['id'] . '[from]" value="' . $this->encode($fromVal) . '" placeholder="YYYY-MM-DD" autocomplete="off"></div>';
            echo '<span class="vtpl-date-sep">至</span>';
            echo '<div class="vtpl-date-item"><span class="vtpl-date-label">' . $this->encode($toText) . '</span><input type="text" class="vtpl-date-input datepicker" name="' . $option['id'] . '[to]" value="' . $this->encode($toVal) . '" placeholder="YYYY-MM-DD" autocomplete="off"></div>';
            echo '</div>';
            echo '</div></div>';
        } else {
            $tpl = '<input type="text" class="vtpl-date-input datepicker" name="{name}" value="{value}" placeholder="YYYY-MM-DD" autocomplete="off">';
            $this->renderByTpl($option, $tpl, false);
        }
    }

    /**
     * 渲染链接字段
     * @param array $option
     * @return void
     */
    private function renderLink($option)
    {
        $val = is_array($option['value']) ? $option['value'] : array();
        $url = isset($val['url']) ? $val['url'] : '';
        $text = isset($val['text']) ? $val['text'] : '';
        $target = isset($val['target']) ? $val['target'] : '_self';
        $checked = ($target === '_blank') ? ' checked="checked"' : '';

        $desc = !empty($option['description']) ? '<div class="option-description">' . $option['description'] . '</div>' : '';
        $tip = (isset($option['new']) && trim($option['new'])) ? '<small class="new-tip">' . trim($option['new']) . '</small>' : '';

        echo '<div class="option ' . (isset($option['labels']) ? $option['labels'] : '') . '" id="' . $option['id'] . '">';
        echo '<div class="option-name" data-name="' . $this->encode($option['name']) . '" data-id="' . $option['id'] . '">', $this->encode($option['name']) . $tip, $desc, '</div>';
        echo '<div class="option-body depend-none">';
        echo '<div class="vtpl-link-card">';
        echo '<div class="vtpl-link-row">';
        echo '<div class="vtpl-link-field"><label>链接文字</label><input type="text" name="' . $option['id'] . '[text]" value="' . $this->encode($text) . '" placeholder="例如：首页导航"></div>';
        echo '<div class="vtpl-link-field flex-grow-1"><label>链接网址</label><input type="text" name="' . $option['id'] . '[url]" value="' . $this->encode($url) . '" placeholder="https://..."></div>';
        echo '</div>';
        echo '<div class="vtpl-link-target mt-2">';
        echo '<input type="hidden" name="' . $option['id'] . '[target]" value="_self">';
        echo '<label class="vtpl-check"><input type="checkbox" name="' . $option['id'] . '[target]" value="_blank"' . $checked . '> 在新标签页中打开链接</label>';
        echo '</div>';
        echo '</div>';
        echo '</div></div>';
    }

    /**
     * 渲染超链接颜色（常规、悬浮、激活等状态）
     * @param array $option
     * @return void
     */
    private function renderLinkColor($option)
    {
        $this->renderLink_color($option);
    }

    /**
     * 兼容下划线调用 renderLink_color
     * @param array $option
     * @return void
     */
    private function renderLink_color($option)
    {
        $val = is_array($option['value']) ? $option['value'] : array();
        $props = array(
            'color'   => '常规',
            'hover'   => '悬浮 (hover)',
            'active'  => '激活 (active)',
            'visited' => '访问 (visited)',
            'focus'   => '聚焦 (focus)',
        );

        $showColor = isset($option['color']) ? !empty($option['color']) : true;
        $showHover = isset($option['hover']) ? !empty($option['hover']) : true;
        $showActive = !empty($option['active']);
        $showVisited = !empty($option['visited']);
        $showFocus = !empty($option['focus']);

        $desc = !empty($option['description']) ? '<div class="option-description">' . $option['description'] . '</div>' : '';
        $tip = (isset($option['new']) && trim($option['new'])) ? '<small class="new-tip">' . trim($option['new']) . '</small>' : '';

        echo '<div class="option ' . (isset($option['labels']) ? $option['labels'] : '') . '" id="' . $option['id'] . '">';
        echo '<div class="option-name" data-name="' . $this->encode($option['name']) . '" data-id="' . $option['id'] . '">', $this->encode($option['name']) . $tip, $desc, '</div>';
        echo '<div class="option-body depend-none">';
        echo '<div class="vtpl-color-group">';

        $activeProps = array();
        if ($showColor) $activeProps['color'] = $props['color'];
        if ($showHover) $activeProps['hover'] = $props['hover'];
        if ($showActive) $activeProps['active'] = $props['active'];
        if ($showVisited) $activeProps['visited'] = $props['visited'];
        if ($showFocus) $activeProps['focus'] = $props['focus'];

        foreach ($activeProps as $key => $label) {
            $colorVal = isset($val[$key]) ? $val[$key] : '';
            $pickerVal = (!empty($colorVal) && preg_match('/^#[a-f0-9]{6}$/i', $colorVal)) ? $colorVal : '#000000';
            echo '<div class="vtpl-color-item">';
            echo '<span class="vtpl-color-title">' . $label . '</span>';
            echo '<div class="vtpl-color-picker-box">';
            echo '<input type="color" class="vtpl-color-swatch" value="' . $pickerVal . '">';
            echo '<input type="text" class="vtpl-color-text" name="' . $option['id'] . '[' . $key . ']" value="' . $this->encode($colorVal) . '" placeholder="#000000">';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div></div>';
    }

    /**
     * 渲染边框字段（宽度、线型、颜色）
     * @param array $option
     * @return void
     */
    private function renderBorder($option)
    {
        $val = is_array($option['value']) ? $option['value'] : array();
        $isAll = isset($option['all']) ? !empty($option['all']) : true;
        $unit = isset($option['unit']) ? $option['unit'] : 'px';

        $style = isset($val['style']) ? $val['style'] : 'solid';
        $color = isset($val['color']) ? $val['color'] : '#e2e8f0';
        $pickerVal = (!empty($color) && preg_match('/^#[a-f0-9]{6}$/i', $color)) ? $color : '#e2e8f0';

        $borderStyles = array(
            'solid'  => '实线 (solid)',
            'dashed' => '虚线 (dashed)',
            'dotted' => '点线 (dotted)',
            'double' => '双线 (double)',
            'inset'  => '3D内嵌 (inset)',
            'outset' => '3D突出 (outset)',
            'none'   => '无 (none)',
        );

        $desc = !empty($option['description']) ? '<div class="option-description">' . $option['description'] . '</div>' : '';
        $tip = (isset($option['new']) && trim($option['new'])) ? '<small class="new-tip">' . trim($option['new']) . '</small>' : '';

        echo '<div class="option ' . (isset($option['labels']) ? $option['labels'] : '') . '" id="' . $option['id'] . '">';
        echo '<div class="option-name" data-name="' . $this->encode($option['name']) . '" data-id="' . $option['id'] . '">', $this->encode($option['name']) . $tip, $desc, '</div>';
        echo '<div class="option-body depend-none">';
        echo '<div class="vtpl-border-wrap">';

        if ($isAll) {
            $widthVal = isset($val['all']) ? $val['all'] : '';
            echo '<div class="vtpl-border-width-item">';
            echo '<span class="vtpl-border-label">粗细</span>';
            echo '<div class="vtpl-number-wrap"><input type="number" class="vtpl-number-input" name="' . $option['id'] . '[all]" value="' . $this->encode($widthVal) . '" placeholder="1"><span class="vtpl-input-unit">' . $unit . '</span></div>';
            echo '</div>';
        } else {
            $sides = array(
                'top'    => '上',
                'right'  => '右',
                'bottom' => '下',
                'left'   => '左',
            );
            echo '<div class="vtpl-border-sides">';
            foreach ($sides as $sKey => $sLabel) {
                $sVal = isset($val[$sKey]) ? $val[$sKey] : '';
                echo '<div class="vtpl-border-width-item">';
                echo '<span class="vtpl-border-label">' . $sLabel . '</span>';
                echo '<div class="vtpl-number-wrap"><input type="number" class="vtpl-number-input" name="' . $option['id'] . '[' . $sKey . ']" value="' . $this->encode($sVal) . '" placeholder="0"><span class="vtpl-input-unit">' . $unit . '</span></div>';
                echo '</div>';
            }
            echo '</div>';
        }

        echo '<div class="vtpl-border-style-item">';
        echo '<span class="vtpl-border-label">样式</span>';
        echo '<select name="' . $option['id'] . '[style]" class="vtpl-select">';
        foreach ($borderStyles as $sValKey => $sValName) {
            $sel = ($style === $sValKey) ? ' selected="selected"' : '';
            echo '<option value="' . $sValKey . '"' . $sel . '>' . $sValName . '</option>';
        }
        echo '</select>';
        echo '</div>';

        echo '<div class="vtpl-border-color-item">';
        echo '<span class="vtpl-border-label">颜色</span>';
        echo '<div class="vtpl-color-picker-box">';
        echo '<input type="color" class="vtpl-color-swatch" value="' . $pickerVal . '">';
        echo '<input type="text" class="vtpl-color-text" name="' . $option['id'] . '[color]" value="' . $this->encode($color) . '" placeholder="#000000">';
        echo '</div>';
        echo '</div>';

        echo '</div>';
        echo '</div></div>';
    }

    /**
     * 渲染间距字段（外边距或内边距）
     * @param array $option
     * @return void
     */
    private function renderSpacing($option)
    {
        $val = is_array($option['value']) ? $option['value'] : array();
        $units = isset($option['units']) && is_array($option['units']) ? $option['units'] : array('px', '%', 'rem', 'em');
        $currentUnit = isset($val['unit']) ? $val['unit'] : (isset($units[0]) ? $units[0] : 'px');
        $isAll = !empty($option['all']);

        $desc = !empty($option['description']) ? '<div class="option-description">' . $option['description'] . '</div>' : '';
        $tip = (isset($option['new']) && trim($option['new'])) ? '<small class="new-tip">' . trim($option['new']) . '</small>' : '';

        echo '<div class="option ' . (isset($option['labels']) ? $option['labels'] : '') . '" id="' . $option['id'] . '">';
        echo '<div class="option-name" data-name="' . $this->encode($option['name']) . '" data-id="' . $option['id'] . '">', $this->encode($option['name']) . $tip, $desc, '</div>';
        echo '<div class="option-body depend-none">';
        echo '<div class="vtpl-spacing-wrap">';

        if ($isAll) {
            $allVal = isset($val['all']) ? $val['all'] : '';
            echo '<div class="vtpl-spacing-item">';
            echo '<span class="vtpl-spacing-label"><i class="ri-drag-move-fill"></i> 四边统一</span>';
            echo '<input type="number" class="vtpl-spacing-input" name="' . $option['id'] . '[all]" value="' . $this->encode($allVal) . '" placeholder="数值">';
            echo '</div>';
        } else {
            $sides = array(
                'top'    => array('label' => '顶部', 'icon' => 'ri-arrow-up-line'),
                'right'  => array('label' => '右侧', 'icon' => 'ri-arrow-right-line'),
                'bottom' => array('label' => '底部', 'icon' => 'ri-arrow-down-line'),
                'left'   => array('label' => '左侧', 'icon' => 'ri-arrow-left-line'),
            );
            foreach ($sides as $sideKey => $sideInfo) {
                $sideVal = isset($val[$sideKey]) ? $val[$sideKey] : '';
                echo '<div class="vtpl-spacing-item">';
                echo '<span class="vtpl-spacing-label"><i class="' . $sideInfo['icon'] . '"></i> ' . $sideInfo['label'] . '</span>';
                echo '<input type="number" class="vtpl-spacing-input" name="' . $option['id'] . '[' . $sideKey . ']" value="' . $this->encode($sideVal) . '" placeholder="数值">';
                echo '</div>';
            }
        }

        if (count($units) > 1) {
            echo '<div class="vtpl-spacing-unit">';
            echo '<select name="' . $option['id'] . '[unit]" class="vtpl-spacing-unit-select">';
            foreach ($units as $u) {
                $selected = ($u === $currentUnit) ? ' selected="selected"' : '';
                echo '<option value="' . $this->encode($u) . '"' . $selected . '>' . $this->encode($u) . '</option>';
            }
            echo '</select>';
            echo '</div>';
        } else {
            echo '<input type="hidden" name="' . $option['id'] . '[unit]" value="' . $this->encode($currentUnit) . '">';
        }

        echo '</div>';
        echo '</div></div>';
    }

    /**
     * 渲染背景设置字段（颜色、图片、重复、位置、大小、固定）
     * @param array $option
     * @return void
     */
    private function renderBackground($option)
    {
        $val = is_array($option['value']) ? $option['value'] : array();
        $bgColor = isset($val['background-color']) ? $val['background-color'] : '';
        $bgImg = isset($val['background-image']) ? $val['background-image'] : '';
        $bgRepeat = isset($val['background-repeat']) ? $val['background-repeat'] : 'no-repeat';
        $bgPos = isset($val['background-position']) ? $val['background-position'] : 'center center';
        $bgSize = isset($val['background-size']) ? $val['background-size'] : 'cover';
        $bgAttach = isset($val['background-attachment']) ? $val['background-attachment'] : 'scroll';

        $pickerVal = (!empty($bgColor) && preg_match('/^#[a-f0-9]{6}$/i', $bgColor)) ? $bgColor : '#ffffff';

        $repeatOpts = array(
            'no-repeat' => '不平铺 (no-repeat)',
            'repeat'    => '完全平铺 (repeat)',
            'repeat-x'  => '水平平铺 (repeat-x)',
            'repeat-y'  => '垂直平铺 (repeat-y)',
        );

        $posOpts = array(
            'left top'      => '左上 (left top)',
            'left center'   => '左中 (left center)',
            'left bottom'   => '左下 (left bottom)',
            'center top'    => '中上 (center top)',
            'center center' => '居中 (center center)',
            'center bottom' => '中下 (center bottom)',
            'right top'     => '右上 (right top)',
            'right center'  => '右中 (right center)',
            'right bottom'  => '右下 (right bottom)',
        );

        $sizeOpts = array(
            'cover'      => '全覆盖 (cover)',
            'contain'    => '保持比例包含 (contain)',
            'auto'       => '原始尺寸 (auto)',
            '100% 100%'  => '拉伸铺满 (100% 100%)',
        );

        $attachOpts = array(
            'scroll' => '随页面滚动 (scroll)',
            'fixed'  => '固定背景 (fixed)',
        );

        $desc = !empty($option['description']) ? '<div class="option-description">' . $option['description'] . '</div>' : '';
        $tip = (isset($option['new']) && trim($option['new'])) ? '<small class="new-tip">' . trim($option['new']) . '</small>' : '';

        echo '<div class="option ' . (isset($option['labels']) ? $option['labels'] : '') . '" id="' . $option['id'] . '">';
        echo '<div class="option-name" data-name="' . $this->encode($option['name']) . '" data-id="' . $option['id'] . '">', $this->encode($option['name']) . $tip, $desc, '</div>';
        echo '<div class="option-body depend-none">';
        echo '<div class="vtpl-bg-wrap">';

        // 背景颜色
        echo '<div class="vtpl-bg-field">';
        echo '<span class="vtpl-bg-label">背景颜色</span>';
        echo '<div class="vtpl-color-picker-box">';
        echo '<input type="color" class="vtpl-color-swatch" value="' . $pickerVal . '">';
        echo '<input type="text" class="vtpl-color-text" name="' . $option['id'] . '[background-color]" value="' . $this->encode($bgColor) . '" placeholder="例如：#f4f6f9">';
        echo '</div>';
        echo '</div>';

        // 背景图片（利用现有 upload/media 机制）
        echo '<div class="vtpl-bg-field vtpl-bg-field-image">';
        echo '<span class="vtpl-bg-label">背景图片</span>';
        echo '<div class="tpl-block-upload">';
        echo '<div class="tpl-image-preview"><img src="' . $this->encode($bgImg) . '"></div>';
        echo '<div class="tpl-block-upload-input">';
        echo '<input type="text" name="' . $option['id'] . '[background-image]" value="' . $this->encode($bgImg) . '" placeholder="图片URL或选择上传">';
        echo '<a class="btn btn-outline-primary tpl-select-media" href="#mediaModal" data-toggle="modal" data-target="#mediaModal" data-mode="custom" data-media-type="image" data-btn-text="' . _langPlu('select', 'tpl_options') . '" data-callback="tplOptionsUseMediaImage">' . _langPlu('select', 'tpl_options') . '</a>';
        echo '<label><a class="btn btn-primary">' . _langPlu('js_upload', 'tpl_options') . '</a><input class="d-none tpl-image" type="file" name="image" data-url="' . BLOG_URL . '" accept="image/svg+xml,image/webp,image/avif,image/jpeg,image/jpg,image/png,image/gif"></label>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        // 背景属性网格
        echo '<div class="vtpl-bg-grid">';

        echo '<div class="vtpl-bg-grid-item">';
        echo '<span class="vtpl-bg-sublabel">重复模式</span>';
        echo '<select name="' . $option['id'] . '[background-repeat]" class="vtpl-select">';
        foreach ($repeatOpts as $rk => $rv) {
            $sel = ($bgRepeat === $rk) ? ' selected="selected"' : '';
            echo '<option value="' . $rk . '"' . $sel . '>' . $rv . '</option>';
        }
        echo '</select></div>';

        echo '<div class="vtpl-bg-grid-item">';
        echo '<span class="vtpl-bg-sublabel">对齐位置</span>';
        echo '<select name="' . $option['id'] . '[background-position]" class="vtpl-select">';
        foreach ($posOpts as $pk => $pv) {
            $sel = ($bgPos === $pk) ? ' selected="selected"' : '';
            echo '<option value="' . $pk . '"' . $sel . '>' . $pv . '</option>';
        }
        echo '</select></div>';

        echo '<div class="vtpl-bg-grid-item">';
        echo '<span class="vtpl-bg-sublabel">尺寸大小</span>';
        echo '<select name="' . $option['id'] . '[background-size]" class="vtpl-select">';
        foreach ($sizeOpts as $sk => $sv) {
            $sel = ($bgSize === $sk) ? ' selected="selected"' : '';
            echo '<option value="' . $sk . '"' . $sel . '>' . $sv . '</option>';
        }
        echo '</select></div>';

        echo '<div class="vtpl-bg-grid-item">';
        echo '<span class="vtpl-bg-sublabel">附着方式</span>';
        echo '<select name="' . $option['id'] . '[background-attachment]" class="vtpl-select">';
        foreach ($attachOpts as $ak => $av) {
            $sel = ($bgAttach === $ak) ? ' selected="selected"' : '';
            echo '<option value="' . $ak . '"' . $sel . '>' . $av . '</option>';
        }
        echo '</select></div>';

        echo '</div>'; // vtpl-bg-grid
        echo '</div>'; // vtpl-bg-wrap
        echo '</div></div>';
    }

    /**
     * 转义字符串，防止悲剧
     * @param string $value
     * @return string
     */
    private function encode($value)
    {
        return htmlspecialchars($value);
    }

    /**
     * 获取单个模板的配置信息项
     * @param string $template 模板目录名
     * @return array|false
     */
    private function getTemplateItem($template)
    {
        if (!is_dir(TPLS_PATH . $template)) {
            return false;
        }
        $headerFile = TPLS_PATH . $template . '/header.php';
        if (!file_exists($headerFile)) {
            return false;
        }
        if ($this->getTemplateDefinedOptions($template) === false) {
            return false;
        }
        $tplData = @file_get_contents($headerFile);
        $templateItem = array();
        preg_match("/Template Name:([^\r\n]+)/i", (string)$tplData, $name);
        $templateItem['name'] = isset($name[1]) ? trim($name[1]) : $template;
        $templateItem['file'] = $template;
        $templateItem['preview'] = $this->getTemplatePreview($template);
        return $templateItem;
    }

    /**
     * 获取模板信息（仅加载指定或当前启用主题，避免全量包含未启用主题导致致命错误）
     * @param string|null $template 模板目录名，默认当前启用模板
     * @return array
     */
    private function getTemplates($template = null)
    {
        if ($template === null || $template === '') {
            $template = Option::get('nonce_templet');
        }
        $templates = array();
        if (!empty($template)) {
            $item = $this->getTemplateItem($template);
            if ($item !== false) {
                $templates[$template] = $item;
            }
        }
        return $templates;
    }

    /**
     * 获取模板缩略图url
     * @param string $template 模板
     * @return string
     */
    private function getTemplatePreview($template)
    {
        if (is_file(TPLS_PATH . $template . '/preview.jpg')) {
            return TPLS_URL . $template . '/preview.jpg';
        }
        return $this->_assets . 'preview.jpg';
    }

    /**
     * 获取模板参数配置
     * @param string $template 模板目录名
     * @return mixed 模板配置数组，false表示不支持本插件
     */
    private function getTemplateDefinedOptions($template)
    {
        if (isset($this->_definedOptionsCache[$template])) {
            return $this->_definedOptionsCache[$template];
        }

        $optionFile = TPLS_PATH . $template . '/options.php';
        if (!is_file($optionFile)) {
            $this->_definedOptionsCache[$template] = false;
            return false;
        }

        // 先静态检测是否声明支持tpl_options，避免直接执行无关或损坏文件
        $fileContent = @file_get_contents($optionFile);
        if ($fileContent === false || strpos($fileContent, '@support tpl_options') === false) {
            $this->_definedOptionsCache[$template] = false;
            return false;
        }

        $options = null;
        try {
            include $optionFile;
        } catch (\Throwable $t) {
            $options = null;
        } catch (\Exception $e) {
            $options = null;
        }

        if (!isset($options) || !is_array($options)) {
            $this->_definedOptionsCache[$template] = false;
            return false;
        }

        $this->_definedOptionsCache[$template] = $options;
        return $options;
    }

    private function buildImageUrl($path)
    {
        if (empty($path)) {
            return '';
        }
        if (is_array($path)) {
            return array_map(array(
                $this,
                'buildImageUrl'
            ), $path);
        }
        return preg_match('{(https?|ftp)://}i', $path) ? $path : BLOG_URL . $path;
    }

    /**
     * 获取模板文件
     * @param string $view 模板名字
     * @param string $ext 模板后缀，默认为.php
     * @return string 模板文件全路径
     */
    public function view($view, $ext = '.php')
    {
        return $this->_view . $view . $ext;
    }

    /**
     * 根据参数构造url
     * @param array $params
     * @return string
     */
    public function url($params = array())
    {
        $baseUrl = './plugin.php?plugin=' . self::ID;
        $url = http_build_query($params);
        if ($url === '') {
            return $baseUrl;
        } else {
            return $baseUrl . '&' . $url;
        }
    }

    /**
     * 以json输出数据并结束
     * @param mixed $data
     * @return void
     */
    public function jsonReturn($data)
    {
        ob_clean();
        echo json_encode($data);
        exit;
    }

    /**
     * 从数组里取出数据，支持key.subKey的方式
     * @param array $array
     * @param string $key
     * @param mixed $default 默认值
     * @return mixed
     */
    public function arrayGet($array, $key, $default = null)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }
            $array = $array[$segment];
        }
        return $array;
    }

    /**
     * 魔术方法，用以获取模板设置
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $object = new stdClass();
        $object->name = $name;
        $object->data = $this->arrayGet($this->getTemplateOptions(), $name);
        doAction('tpl_options_get', $object);
        return $object->data;
    }
}

function _g($name = null)
{
    if ($name === null) {
        return TplOptions::getInstance()->getTemplateOptions();
    } else {
        return TplOptions::getInstance()->$name;
    }
}

function _em($name = null)
{
    if ($name === null) {
        return TplOptions::getInstance()->getTemplateOptions();
    } else {
        return TplOptions::getInstance()->$name;
    }
}

function _getBlock($name = null, $type = 'content')
{
    $target = TplOptions::getInstance()->$name;
    $arr = [];
    if (!is_array($target))
        return $arr;
    if (empty($target[trim($type)]))
        return $arr;
    if (trim($type) != 'title' && trim($type) != 'content')
        return $arr;
    $result = array_filter($target, 'is_array');
    if (count($result) == count($target)) {
        foreach ($target[$type] as $val) {
            $arr[] = $val;
        }
    }
    return $arr;
}

TplOptions::getInstance()->init();
