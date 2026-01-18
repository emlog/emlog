<?php

/**
 * RSS
 * @package EMLOG
 * 
 */

require_once './init.php';

header('Content-type: application/xml');

$rss = new Rss();
$rss->generate();
