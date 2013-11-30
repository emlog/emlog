<?php
/**
 * kl_comment_manage_ajax.php
 * design by KLLER
 */
require_once('../../../init.php');
!(ISLOGIN === true && ROLE == 'admin') && exit('access deined!');
kl_comment_manage_ajax(true);