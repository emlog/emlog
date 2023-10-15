<?php
/**
 * plugin model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Plugin_Model {

    /**
     * start plug-in
     */
    public function activePlugin($plugin) {
        $active_plugins = Option::get('active_plugins');

        $ret = false;

        if (in_array($plugin, $active_plugins)) {
            $ret = true;
        } elseif (true === checkPlugin($plugin)) {
            $active_plugins[] = $plugin;
            $active_plugins = serialize($active_plugins);
            Option::updateOption('active_plugins', $active_plugins);
            $ret = true;
        }

        //run init callback functions
        $r = explode('/', $plugin, 2);
        $plugin = $r[0];
        $callback_file = "../content/plugins/$plugin/{$plugin}_callback.php";
        if (true === $ret && file_exists($callback_file)) {
            require_once $callback_file;
            if (function_exists('callback_init')) {
                callback_init();
            }
        }
        return $ret;
    }

    /**
     * stop plug-in
     */
    public function inactivePlugin($plugin) {
        $active_plugins = Option::get('active_plugins');
        if (in_array($plugin, $active_plugins)) {
            $key = array_search($plugin, $active_plugins);
            unset($active_plugins[$key]);
        } else {
            return;
        }
        $active_plugins = serialize($active_plugins);
        Option::updateOption('active_plugins', $active_plugins);
    }

    public function rmCallback($plugin) {
        $r = explode('/', $plugin, 2);
        $plugin = $r[0];
        $callback_file = "../content/plugins/$plugin/{$plugin}_callback.php";
        if (file_exists($callback_file)) {
            require_once $callback_file;
            if (function_exists('callback_rm')) {
                callback_rm();
            }
        }
    }

    // upgrade callback
    public function upCallback($plugin_alias) {
        $callback_file = "../content/plugins/$plugin_alias/{$plugin_alias}_callback.php";
        if (file_exists($callback_file)) {
            require_once $callback_file;
            if (function_exists('callback_up')) {
                callback_up();
            }
        }
    }

    function getPlugins($filter = '') {
        global $emPlugins;
        if (isset($emPlugins)) {
            return $emPlugins;
        }
        $emPlugins = [];
        $pluginFiles = [];
        $pluginPath = EMLOG_ROOT . '/content/plugins';
        $pluginDir = @dir($pluginPath);
        if (!$pluginDir) {
            return $emPlugins;
        }

        while (($file = $pluginDir->read()) !== false) {
            if (preg_match('|^\.+$|', $file)) {
                continue;
            }
            if (is_dir($pluginPath . '/' . $file)) {
                $pluginsSubDir = @dir($pluginPath . '/' . $file);
                if ($pluginsSubDir) {
                    while (($subFile = $pluginsSubDir->read()) !== false) {
                        if (preg_match('|^\.+$|', $subFile)) {
                            continue;
                        }
                        if ($subFile == $file . '.php') {
                            $filePath = $pluginPath . '/' . $file . '/' . $subFile;
                            $fileLastModified = filemtime($filePath);
                            $pluginFiles[$file] = [
                                'file'          => "$file/$subFile",
                                'last_modified' => $fileLastModified
                            ];
                        }
                    }
                }
            }
        }
        if (!$pluginFiles) {
            return $emPlugins;
        }

        // Sort plugins by last modified time
        usort($pluginFiles, function ($a, $b) {
            return $a['last_modified'] - $b['last_modified'];
        });

        $active_plugins = Option::get('active_plugins');
        foreach ($pluginFiles as $plugin) {
            $active = in_array($plugin['file'], $active_plugins) ? 1 : 0;
            if ($filter == 'on' && !$active) {
                continue;
            }
            if ($filter == 'off' && $active) {
                continue;
            }
            $pluginData = $this->getPluginData($plugin['file']);
            if (empty($pluginData['Name'])) {
                continue;
            }
            $pluginData['active'] = $active;
            $emPlugins[$plugin['file']] = $pluginData;
        }
        return $emPlugins;
    }


    function getPluginData($pluginFile) {
        $pluginPath = EMLOG_ROOT . '/content/plugins/';
        $content = file($pluginPath . $pluginFile);
        if (!$content) {
            return [];
        }
        $pluginData = implode('', $content);
        preg_match("/Plugin Name:(.*)/i", $pluginData, $plugin_name);
        preg_match("/Version:(.*)/i", $pluginData, $version);
        preg_match("/Plugin URL:(.*)/i", $pluginData, $plugin_url);
        preg_match("/Description:(.*)/i", $pluginData, $description);
        preg_match("/ForEmlog:(.*)/i", $pluginData, $emlog_version);
        preg_match("/Author:(.*)/i", $pluginData, $author_name);
        preg_match("/Author URL:(.*)/i", $pluginData, $author_url);

        $active_plugins = Option::get('active_plugins');
        $ret = explode('/', $pluginFile);
        $plugin = $ret[0];
        $have_setting = file_exists($pluginPath . $plugin . '/' . $plugin . '_setting.php') && in_array($pluginFile, $active_plugins);

        $plugin_name = isset($plugin_name[1]) ? strip_tags(trim($plugin_name[1])) : '';
        $version = isset($version[1]) ? strip_tags(trim($version[1])) : '';
        $description = isset($description[1]) ? strip_tags(trim($description[1])) : '';
        $plugin_url = isset($plugin_url[1]) ? strip_tags(trim($plugin_url[1])) : '';
        $author = isset($author_name[1]) ? strip_tags(trim($author_name[1])) : '';
        $emlog_version = isset($emlog_version[1]) ? strip_tags(trim($emlog_version[1])) : '';
        $author_url = isset($author_url[1]) ? strip_tags(trim($author_url[1])) : '';

        return [
            'Name'        => $plugin_name,
            'Version'     => $version,
            'Description' => $description,
            'Url'         => $plugin_url,
            'Author'      => $author,
            'ForEmlog'    => $emlog_version,
            'AuthorUrl'   => $author_url,
            'Setting'     => $have_setting,
            'Plugin'      => $plugin,
        ];
    }
}
