<?php
/**
 * Model: Plug-in
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

class emPlugin {

	var $db;
	var $plugin;

	function emPlugin($dbhandle, $plugin='')
	{
		$this->db = $dbhandle;
		$this->plugin = $plugin;
	}

	/**
	 * Activate the plug-in
	 *
	 * @param array $active_plugins All the currently active plug-ins
	 */
	function active_plugin($active_plugins)
	{
		if (in_array($this->plugin, $active_plugins))
		{
			return ;
		} else {
			$active_plugins[] = $this->plugin;
		}
		$active_plugins = serialize($active_plugins);
		$this->db->query("update ".DB_PREFIX."options set option_value='$active_plugins' where option_name='active_plugins'");
	}
	
	/**
	 * Disable plug-in
	 *
	 * @param string $active_plugins All the currently active plug-ins
	 */
	function inactive_plugin($active_plugins)
	{
		if (in_array($this->plugin, $active_plugins))
		{
			$key = array_search($this->plugin, $active_plugins);
			unset($active_plugins[$key]);
		} else {
			return;
		}
		$active_plugins = serialize($active_plugins);
		$this->db->query("update ".DB_PREFIX."options set option_value='$active_plugins' where option_name='active_plugins'");
	}
	
	/**
	 * Get a list of all plug-ins, plug-ins without a defined plug-in name will not be obtained
	 * Plug-in directory: content/plugins
	 * Only recognize plug-ins with plug-in directory structure: /plug-in/plug-in.php
	 * @return array
	 */
	function getPlugins()
	{
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
	 * Get plug-in information
	 *
	 * @param string $pluginFile
	 * @return array
	 */
	function getPluginData($pluginFile)
	{
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

?>
