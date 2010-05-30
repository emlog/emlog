<?php
/**
 * 插件
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.5.1
 * $Id$
 */

class emPlugin {

	private $db;
	private $plugin;

	function __construct($plugin = '') {
		$this->db = MySql::getInstance();
		$this->plugin = $plugin;
	}

	/**
	 * 激活插件
	 *
	 * @param array $active_plugins 当前已激活的全部插件
	 */
	function active_plugin($active_plugins) {
		if (in_array($this->plugin, $active_plugins)){
			return true;
		} elseif(true === checkPlugin($this->plugin)) {
			$active_plugins[] = $this->plugin;
		    $active_plugins = serialize($active_plugins);
		    updateOption('active_plugins', $active_plugins);
		    return true;
		} else {
		    return false;
		}
	}

	/**
	 * 禁用插件
	 *
	 * @param string $active_plugins 当前已激活的全部插件
	 */
	function inactive_plugin($active_plugins) {
		if (in_array($this->plugin, $active_plugins))
		{
			$key = array_search($this->plugin, $active_plugins);
			unset($active_plugins[$key]);
		} else {
			return;
		}
		$active_plugins = serialize($active_plugins);
		updateOption('active_plugins', $active_plugins);
	}

	/**
	 * 获取所有插件列表，未定义插件名称的插件将不予获取
	 * 插件目录：content\plugins
	 * 仅识别 插件目录/插件/插件.php 目录结构的插件
	 * @return array
	 */
	function getPlugins() {
		global $emPlugins;
		if (isset($emPlugins))
		{
			return $emPlugins;
		}
		$emPlugins = array();
		$pluginFiles = array();
		$pluginPath = EMLOG_ROOT . '/content/plugins';
		$pluginDir = @ dir($pluginPath);
		if ($pluginDir)
		{
			while(($file = $pluginDir->read()) !== false)
			{
				if (preg_match('|^\.+$|', $file))
				{
					continue;
				}
				if (is_dir($pluginPath . '/' . $file))
				{
					$pluginsSubDir = @ dir($pluginPath . '/' . $file);
					if ($pluginsSubDir)
					{
						while(($subFile = $pluginsSubDir->read()) !== false)
						{
							if (preg_match('|^\.+$|', $subFile))
							{
								continue;
							}
							if ($subFile == $file.'.php')
							{
								$pluginFiles[] = "$file/$subFile";
							}
						}
					}
				}
			}
		}
		if (!$pluginDir || !$pluginFiles)
		{
			return $emPlugins;
		}
		sort($pluginFiles);
		foreach($pluginFiles as $pluginFile)
		{
			$pluginData = $this->getPluginData("$pluginPath/$pluginFile");
			if (empty($pluginData['Name']))
			{
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
		$pluginData = implode('', file($pluginFile));
		preg_match("/Plugin Name:(.*)/i", $pluginData, $plugin_name);
		preg_match("/Version:(.*)/i", $pluginData, $version);
		preg_match("/Plugin URL:(.*)/i", $pluginData, $plugin_url);
		preg_match("/Description:(.*)/i", $pluginData, $description);
		preg_match("/Author:(.*)/i", $pluginData, $author_name);
		preg_match("/Author Email:(.*)/i", $pluginData, $author_email);
		preg_match("/Author URL:(.*)/i", $pluginData, $author_url);

		$plugin_name = isset($plugin_name[1]) ? trim($plugin_name[1]) : '';
		$version = isset($version[1]) ? $version[1] : '';
		$description = isset($description[1]) ? $description[1] : '';
		$plugin_url = isset($plugin_url[1]) ? trim($plugin_url[1]) : '';
		$author = isset($author_name[1]) ? trim($author_name[1]) : '';
		$author_email = isset($author_email[1]) ? trim($author_email[1]) : '';
		$author_url = isset($author_url[1]) ? trim($author_url[1]) : '';

		return array(
		'Name' => $plugin_name,
		'Version' => $version,
		'Description' => $description,
		'Url' => $plugin_url,
		'Author' => $author,
		'Email' => $author_email,
		'AuthorUrl' => $author_url,
		);
	}
}
