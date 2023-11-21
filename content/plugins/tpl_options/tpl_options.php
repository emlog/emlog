<?php
/*
Plugin Name: 模版设置
Version: 4.2.3
Plugin URL: https://www.emlog.net/docs/#/template
Description: 为模版增加丰富的设置功能，详见官网文档-模板开发。
Author: emlog
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
    const VERSION = '4.2.3';

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
    private function __construct()
    {
    }

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
            'radio' => array(
                'name' => '单选按钮',
                'allowMulti' => false,
            ),
            'color' => array(
                'name' => '颜色控件',
                'allowMulti' => false,
            ),
            'checkon' => array(
                'name' => '开关',
                'allowMulti' => false,
            ),
            'checkbox' => array(
                'name' => '复选按钮',
                'allowMulti' => true,
            ),
            'text' => array(
                'name' => '文本',
                'allowMulti' => true,
                'allowRich' => true,
            ),
            'image' => array(
                'name' => '图片',
                'allowMulti' => false,
            ),
            'page' => array(
                'name' => '页面',
                'allowMulti' => true,
            ),
            'sort' => array(
                'name' => '分类',
                'allowMulti' => true,
                'allowDepend' => true,
            ),
            'tag' => array(
                'name' => '标签',
                'allowMulti' => true,
            ),
            'select' => array(
                'name' => '选择',
                'allowMulti' => true,
            ),
            'block' => array(
                'name' => '组合块',
                'allowMulti' => true,
            ),
        );
        $this->_arrayTypes = array(
            'checkbox',
            'tag',
            'select',
            'block',
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
            'prefix' => str_replace('_', '-', $this->_prefix),
            'baseUrl' => $this->url(),
            'uploadUrl' => $this->url(array(
                "do" => "upload"
            )),
        );
        echo sprintf('<script>var tplOptions = %s;</script>', json_encode($data));
    }

    /**
     * 头部，如css文件
     * @return void
     */
    public function hookAdminHead()
    {
        echo sprintf('<link rel="stylesheet" href="%s">', $this->_assets . 'main.min.css?ver=' . urlencode(self::VERSION));
        echo sprintf('<script src="%s"></script>', $this->_assets . 'message.min.js?ver=' . urlencode(self::VERSION));
        echo sprintf('<script src="%s"></script>', $this->_assets . 'main.min.js?ver=' . urlencode(self::VERSION));
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
            $template = Option::get('nonce_templet');
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
            if (!is_array($option) || !isset($option['name']) || !isset($option['type']) || !isset($this->_types[$option['type']])) {
                unset($options[$name]);
                continue;
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
                'name' => $name,
                'depend' => $option['depend'],
                'data' => serialize($option['data']),
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
                'sid' => -1,
                'sortname' => '未分类',
                'lognum' => 0,
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
                } else {
                    $value = mysql_escape_string($value);
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
            } else {
                $val = mysql_escape_string($val);
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
        $allTemplate = $this->getTemplates();
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
            emDirect('./template.php');
        } elseif ($template !== null) {
            if (!is_dir(TPLS_PATH . $template)) {
                $this->jsonReturn(array(
                    'code' => 1,
                    'msg' => '该模板不存在',
                ));
            }
            $options = $this->getTemplateDefinedOptions($template);
            if ($options === false) {
                $this->jsonReturn(array(
                    'code' => 1,
                    'msg' => '该模板不支持本插件设置',
                ));
            }
            $this->_currentTemplate = $template;
            $storedOptions = $this->getTemplateOptions($template);
            foreach ($options as $name => & $option) {
                if (!is_array($option) || !isset($option['name']) || !isset($option['type']) || !isset($this->_types[$option['type']])) {
                    unset($options[$name]);
                    continue;
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
                        'data' => $data,
                    );
                }
                $result = $this->setTemplateOptions($template, $newOptions);
                $code = $result ? 0 : 1;
                $data = array(
                    'template' => $template,
                    'code' => $result ? 0 : 1,
                    'msg' => '保存模板设置' . ($result ? '成功' : '失败'),
                );
                $this->jsonReturn($data);
            }
            ob_clean();
            include $this->view('setting');
            exit;
        } else {
            emDirect('./template.php');
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
            'msg' => '',
            'name' => $file['name'],
            'size' => $file['size'],
            'path' => '',
        );
        if ($file['error'] == 1) {
            $result['code'] = 100;
            $result['msg'] = '文件大小超过系统限制';
            return $result;
        }

        if ($file['error'] > 1) {
            $result['code'] = 101;
            $result['msg'] = '上传文件失败';
            return $result;
        }
        $extension = getFileSuffix($file['name']);
        if (!in_array($extension, $this->_imageTypes)) {
            $result['code'] = 102;
            $result['msg'] = '错误的文件类型';
            return $result;
        }
        $maxSize = Option::getAttMaxSize();

        if ($file['size'] > $maxSize) {
            $result['code'] = 103;
            $result['msg'] = '文件大小超出emlog的限制';
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
                $result['msg'] = '创建文件上传目录失败';
                return $result;
            }
        }
        if (@is_uploaded_file($file['tmp_name'])) {
            if (@!move_uploaded_file($file['tmp_name'], $attachpath)) {
                $result['code'] = 105;
                $result['msg'] = '上传失败。文件上传目录(content/uploadfile)不可写';
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
                'tag'
            ))) {
            $default = $option['default'];
        } else {
            switch ($option['type']) {
                case 'radio':
                    if (!isset($option['values']) || !is_array($option['values'])) {
                        $option['values'] = array(
                            0 => '否',
                            1 => '是',
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
                    $default = array();
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
            $method = 'render' . ucfirst($option['type']);
            $this->$method($option);
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
        if (!empty($option['description'])) {
            $desc = '<div class="option-description">' . $option['description'] . '</div>';
        }
        if (isset($option['new']) && trim($option['new'])) {
            $tip = '<small class="new-tip">' . trim($option['new']) . '</small>';
        }
        echo '<div class="option ' . @$option['labels'] . '" id="' . $option['id'] . '">';
        echo '<div class="option-ico upico"></div>';
        echo '<div class="option-name" title="单击展开收缩设置内容" data-name="' . $this->encode($option['name']) . '" data-id="' . $option['id'] . '">', $this->encode($option['name']) . $tip, $desc, '</div>';
        $depend = isset($option['depend']) ? $option['depend'] : 'none';
        echo sprintf('<div class="option-body depend-%s">', $depend);
        switch ($depend) {
            case 'sort':
                $unsorted = isset($option['unsorted']) ? $option['unsorted'] : true;
                $sorts = $this->getSorts($unsorted);
                if (!is_array($option['value'])) {
                    $option['value'] = array();
                }
                echo '<div class="option-sort" data-option-name="', $option['name'], '">';
                echo '<div class="option-sort-left">';
                if (count($sorts) < 1) {
                    foreach ($sorts as $sort) {
                        echo '<div class="option-sort-name">';
                        echo $sort['sortname'];
                        echo '</div>';
                    }
                } else {
                    echo '<select class="option-sort-select">';
                    foreach ($sorts as $sort) {
                        echo sprintf('<option value="%s">%s</option>', $sort['sortname'], $sort['sortname']);
                    }
                    echo '</select>';
                }
                echo '</div>';
                echo '<div class="option-sort-right">';
                foreach ($sorts as $sort) {
                    $sid = $sort['sid'];
                    echo '<div class="option-sort-option">';
                    if (!isset($option['value'][$sid])) {
                        $option['value'][$sid] = $this->getOptionDefaultValue($option, $this->_currentTemplate);
                    }
                    if ($loopValues) {
                        if ($placeholder) {
                            echo sprintf('<input type="hidden" name="%s" value="">', $option['id'] . "[{$sid}]");
                        }
                        foreach ($option['values'] as $value => $label) {
                            echo strtr($tpl, array(
                                '{name}' => $option['id'] . "[{$sid}]",
                                '{value}' => $this->encode($value),
                                '{label}' => $label,
                                '{checked}' => $this->getCheckedString($value, $option['value'][$sid]),
                            ));
                        }
                    } else {
                        echo strtr($tpl, array(
                            '{name}' => $option['id'] . "[{$sid}]",
                            '{value}' => $this->encode($option['value'][$sid]),
                            '{label}' => '',
                            '{path}' => $this->getImagePath($option['value'][$sid]),
                            '{rich}' => $this->getRichString($option),
                        ));
                    }
                    echo '</div>';
                }
                echo '</div>';
                echo '<div class="clearfix"></div>';
                echo '</div>';
                break;
            case 'select':
                $type = '';
                if ($option['pattern'] == 'post') {
                    $type = '文章';
                    $data = $this->getPosts();
                }
                if ($option['pattern'] == 'cate') {
                    $type = '分类';
                    $data = $this->getSorts(false, true);
                }
                if ($option['pattern'] == 'page') {
                    $type = '页面';
                    $data = $this->getPages();
                }

                echo sprintf('<div class="chosen-container chosen-container-multi %s">', $option['pattern']);
                echo '<ul class="chosen-choices">';
                echo sprintf('<input type="hidden" name="%s" value="">', $option['id']);
                foreach ($option['value'] as $id) {
                    echo strtr($tpl, array(
                        '{title}' => $data[$id],
                        '{name}' => $option['id'],
                        '{value}' => $this->encode($id),
                    ));
                }
                echo '<li class="search-field ">';
                echo sprintf('<input class="chosen-search-input" data-opt="%s" data-s-name="%s" data-url="%s" type="text" autocomplete="off" placeholder="输入%s标题关键词以搜索%s">', $option['pattern'], $option['id'], BLOG_URL, $type, $type);
                echo '</li>';
                echo '</ul>';
                echo '<div class="chosen-drop">';
                echo sprintf('<ul class="chosen-results"><li class="no-results">请输入%s标题</li></ul>', $type);
                echo '</div>';
                echo '</div>';
                break;
            case 'block':
                $this_data_type = isset($option['pattern']) && $option['pattern'] === 'image' ? 'image' : 'text';
                echo sprintf('<input type="hidden" name="%s" value="">', $option['id']);
                echo '<div class="tpl-sortable-block">';

                $html = '<div class="tpl-block-item">';
                $html .= '<div class="tpl-block-head">
                            <i class="tpl-block-clone icofont-ui-copy"></i>
                            <i class="tpl-block-remove icofont-close icofont-md"></i>
                          </div>';

                $data = $this->getBlockData($option['id']);
                $tmp_len = count($data);
                if ($tmp_len !== 0 && is_array($data)) {
                    $data_len = count($data['title']);
                    for ($i = 0; $i < $data_len; $i++) {
                        $block_title = $this->encode($data['title'][$i]);
                        echo $html;
                        echo sprintf('<h4 class="tpl-block-title"><span class="tpl-block-title-icon icofont-rounded-right"></span><item class="block-title-text">%s</item></h4>', $block_title);
                        echo '<div class="tpl-block-content d-none">';
                        echo strtr($tpl, array(
                            '{title}' => $option['id'] . '[title][]',
                            '{tvalue}' => $block_title,
                            '{name}' => $option['id'] . '[content][]',
                            '{value}' => $this->encode($data['content'][$i]),
                        ));
                        echo '</div>';
                        echo '</div>';
                    }
                }

                echo sprintf('<a class="badge badge-success tpl-add-block" data-b-name="%s" data-type="%s" data-url="%s"><i class="ri-add-line"></i> 添加</a>', $option['id'], $this_data_type, BLOG_URL);
                echo '</div>';
                echo '<script>
                          $(".tpl-sortable-block").sortable({
                              stop: function (e, ui) {
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
                            '{name}' => $option['id'],
                            '{value}' => $this->encode($value),
                            '{label}' => $label,
                            '{checked}' => $this->getCheckedString($value, $option['value']),
                        ));
                    }
                } else {
                    echo strtr($tpl, array(
                        '{name}' => $option['id'],
                        '{value}' => $this->encode($option['value']),
                        '{label}' => '',
                        '{path}' => $this->getImagePath($option['value']),
                        '{rich}' => $this->getRichString($option),
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
        if ($this->isMulti($option)) {
            $tpl = '<textarea name="{name}" rows="8" class="option-textarea{rich}">{value}</textarea>';
        } else {
            $tpl = '<input type="text" name="{name}" value="{value}">';
        }
        if (isset($option['pattern']) && trim($option['pattern']) === 'num') {
            $max = '';
            $min = '';
            $unit_html = isset($option['unit']) && trim($option['unit']) !== '' ? '<span class="tpl-number-input-unit">' . trim($option['unit']) . '</span>' : '';
            if (isset($option['max']) && trim($option['max']) !== '') {
                $max = trim($option['max']);
            }
            if (isset($option['min']) && trim($option['min']) !== '') {
                $min = trim($option['min']);
            }
            $limit_html = !empty($max) && !empty($min) ? 'oninput="if(value>' . $max . ')value=' . $max . ';if(value<' . $min . ')value=' . $min . '"' : '';

            $tpl = '<div class="tpl-number-input-item">
                        <input type="number" class="tpl-number-input" placeholder="填入数字" name="{name}" value="{value}" ' . $limit_html . '>
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
                    <span class="image-tip">友情提示：选择文件后将会立刻上传覆盖原图</span>
                    <div class="tpl-image-preview">
                        <img src="{value}">
                    </div>
                    <div class="tpl-block-upload-input">
                        <input type="text" name="{name}" value="{value}">
                        <label>
                            <a class="btn btn-primary"><i class="icofont-plus"></i>上传</a>
                            <input class="d-none tpl-image" type="file" name="image" data-url="' . BLOG_URL . '" accept="image/gif,image/jpeg,image/jpg,image/png">
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
                        <span>填写块标题：</span>
                        <input class="block-title-input" type="text" name="{title}" value="{tvalue}">
                         <div class="tpl-image-preview">
                            <img src="{value}">
                         </div>
                         <div class="tpl-block-upload-input">
                             <input type="text" name="{name}" value="{value}">
                             <label>
                                <a class="btn btn-primary"><i class="icofont-plus"></i>上传</a>
                                <input class="d-none tpl-image" type="file" name="image" data-url="' . BLOG_URL . '" accept="image/gif,image/jpeg,image/jpg,image/png">
                             </label>
                         </div>
                     </div>';
        } else {
            $tpl = '<span>填写块标题：</span>';
            $tpl .= '<input class="block-title-input" type="text" name="{title}" value="{tvalue}">';
            $tpl .= '<span>填写块内容：</span>';
            $tpl .= '<textarea rows="8" name="{name}">{value}</textarea>';
        }
        $option['depend'] = 'block';
        $this->renderByTpl($option, $tpl, false);
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
        if (isset($option['pattern'])) {
            $this_opt_data = null;
            switch (trim($option['pattern'])) {
                case 'post':
                {
                    $this_opt_data = $this->getPosts();
                }
                case 'cate':
                {
                    $this_opt_data = $this->getSorts();
                }
                case 'page':
                {
                    $this_opt_data = $this->getPages();
                }
            }
            $values = array();
            foreach ($this_opt_data as $id) {
                $values[] = $id;
            }
            $option['values'] = $values;
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
            $values[$tag['tagname']] = "${tag['tagname']} (${tag['usenum']})";
        }
        $option['values'] = $values;
        $this->renderCheckbox($option);
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
     * 获取支持的模板
     * @return array
     */
    private function getTemplates()
    {
        $handle = @opendir(TPLS_PATH);
        if ($handle === false) {
            return array();
        }
        $templates = array();
        while ($file = @readdir($handle)) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (@file_exists($headerFile = TPLS_PATH . $file . '/header.php')) {
                if ($this->getTemplateDefinedOptions($file) === false) {
                    continue;
                }
                $tplData = file_get_contents($headerFile);
                $template = array();
                preg_match("/Template Name:([^\r\n]+)/i", $tplData, $name);
                $template['name'] = isset($name[1]) ? trim($name[1]) : $file;
                $template['file'] = $file;
                $template['preview'] = $this->getTemplatePreview($file);
                $templates[$file] = $template;
            }
        }
        closedir($handle);
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
     * @param string $optionFile
     * @return mixed false表示不支持本插件
     */
    private function getTemplateDefinedOptions($template)
    {
        if (!is_file($optionFile = TPLS_PATH . $template . '/options.php')) {
            return false;
        }
        include $optionFile;
        if (!isset($options) || !is_array($options)) {
            return false;
        }
        if (strpos(file_get_contents($optionFile), '@support tpl_options') !== false) {
            return $options;
        }
        return false;
    }

    private function buildImageUrl($path)
    {
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

function _getBlock($name = null, $type = '')
{
    $offset = '';
    $target = TplOptions::getInstance()->$name;
    if (!is_array($target) || empty($type) || trim($type) === '') {
        return [];
    }
    if (trim($type) === 'title') {
        $offset = 'title';
    }
    if (trim($type) === 'content') {
        $offset = 'content';
    }
    if (trim($offset) === '') {
        return [];
    }
    $result = array_filter($target, 'is_array');
    $data_length = count($target);
    if (count($result) == $data_length) {
        $type_arr = [];
        for ($i = 0; $i < $data_length; $i++) {
            $type_arr[] = $target[$offset][$i];
        }
        return $type_arr;
    }
    return [];
}

TplOptions::getInstance()->init();