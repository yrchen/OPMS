<?php
/*
 * OPMS
 * login.php
 * Created on 2006/10/23 by Chen YuRen (yrchen@ATCity.org)
 *
 * 登入
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/login.php $
 */

// yrchen.061015: Set flag that this is a parent file.
define( '_OPMSEXEC', 1 );

require_once('init.php');

$page = new Page();

$page->assign('page_title', set_title("登入"));
$page->assign('page_style', "style/WordPress/wp-admin.css");

if (isset($_REQUEST['redirect']))
  $page->assign('page_redirect', $_REQUEST['redirect']);
else
  $page->assign('page_redirect', "main.php");

$timer->stop();
$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
$page->display('standard/login.tpl');
?>