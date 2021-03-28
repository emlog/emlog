<?php
/**
 * plugin model
 * @package EMLOG (www.emlog.net)
 */

class Plugin_Model {

	private $db;
	private $plugin;

	function __construct() {
		$this->db = Database::getInstance();
	}

	/**
	 * 开启插件
	 */
	function activePlugin($plugin) {
		$active_plugins = Option::get('active_plugins');

		$ret = false;

		if (in_array($plugin, $active_plugins)) {
			$ret = true;
		} elseif (true === checkPlugin($plugin)) {
			$active_plugins[] = $plugin;
			$active_plugins = serialize($active_plugins);
			Option::updateOption('active_plugins', $active_plugins);
			$ret = true;
		} else {
			$ret = false;
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
	 * 禁用插件
	 */
	function inactivePlugin($plugin) {
		$active_plugins = Option::get('active_plugins');
		if (in_array($plugin, $active_plugins)) {
			$key = array_search($plugin, $active_plugins);
			unset($active_plugins[$key]);
		} else {
			return;
		}
		$active_plugins = serialize($active_plugins);
		Option::updateOption('active_plugins', $active_plugins);

		//run remove callback functions
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

	/**
	 * 获取所有插件列表，未定义插件名称的插件将不予获取
	 * 插件目录：content\plugins
	 * 仅识别 插件目录/插件/插件.php 目录结构的插件
	 * @return array
	 */
	function getPlugins() {
		global $emPlugins;
		if (isset($emPlugins)) {
			return $emPlugins;
		}
		$emPlugins = array();
		$pluginFiles = array();
		$pluginPath = EMLOG_ROOT . '/content/plugins';
		$pluginDir = @ dir($pluginPath);
		if ($pluginDir) {
			while (($file = $pluginDir->read()) !== false) {
				if (preg_match('|^\.+$|', $file)) {
					continue;
				}
				if (is_dir($pluginPath . '/' . $file)) {
					$pluginsSubDir = @ dir($pluginPath . '/' . $file);
					if ($pluginsSubDir) {
						while (($subFile = $pluginsSubDir->read()) !== false) {
							if (preg_match('|^\.+$|', $subFile)) {
								continue;
							}
							if ($subFile == $file . '.php') {
								$pluginFiles[] = "$file/$subFile";
							}
						}
					}
				}
			}
		}
		if (!$pluginDir || !$pluginFiles) {
			return $emPlugins;
		}
		sort($pluginFiles);
		foreach ($pluginFiles as $pluginFile) {
			$pluginData = $this->getPluginData($pluginFile);
			if (empty($pluginData['Name'])) {
				continue;
			}
			$emPlugins[$pluginFile] = $pluginData;
		}
		return $emPlugins;
	}

	/**
	 * 获取插件信息
	 *
	 * @param string $pluginFile
	 * @return array
	 */
	function getPluginData($pluginFile) {
		$pluginPath = EMLOG_ROOT . '/content/plugins/';
		$pluginData = implode('', file($pluginPath . $pluginFile));
		preg_match("/Plugin Name:(.*)/i", $pluginData, $plugin_name);
		preg_match("/Version:(.*)/i", $pluginData, $version);
		preg_match("/Plugin URL:(.*)/i", $pluginData, $plugin_url);
		preg_match("/Description:(.*)/i", $pluginData, $description);
		preg_match("/ForEmlog:(.*)/i", $pluginData, $foremlog);
		preg_match("/Author:(.*)/i", $pluginData, $author_name);
		preg_match("/Author URL:(.*)/i", $pluginData, $author_url);

		$active_plugins = Option::get('active_plugins');
		$ret = explode('/', $pluginFile);
		$plugin = $ret[0];
		$setting = (file_exists($pluginPath . $plugin . '/' . $plugin . '_setting.php') && in_array($pluginFile, $active_plugins)) ? true : false;

		$plugin_name = isset($plugin_name[1]) ? strip_tags(trim($plugin_name[1])) : '';
		$version = isset($version[1]) ? strip_tags(trim($version[1])) : '';
		$description = isset($description[1]) ? strip_tags(trim($description[1])) : '';
		$plugin_url = isset($plugin_url[1]) ? strip_tags(trim($plugin_url[1])) : '';
		$author = isset($author_name[1]) ? strip_tags(trim($author_name[1])) : '';
		$foremlog = isset($foremlog[1]) ? strip_tags(trim($foremlog[1])) : '';
		$author_url = isset($author_url[1]) ? strip_tags(trim($author_url[1])) : '';

		return array(
			'Name'        => $plugin_name,
			'Version'     => $version,
			'Description' => $description,
			'Url'         => $plugin_url,
			'Author'      => $author,
			'ForEmlog'    => $foremlog,
			'AuthorUrl'   => $author_url,
			'Setting'     => $setting,
			'Plugin'      => $plugin,
		);
	}
}
