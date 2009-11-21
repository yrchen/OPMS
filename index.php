<?php
/*
 * OPMS
 * index.php
 * Created on 2006/07/10 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/index.php $
 */

// yrchen.061015: Set flag that this is a parent file.
define( '_OPMSEXEC', 1 );

require_once('init.php');

$page = new Page();
$page->assign('user_logined', "");
try
{
  check_login();
  $page->assign('user_logined', "true");
}
catch (LoginException $e)
{  
}

$page->assign('page_redirect', "main.php");
$timer->stop();
$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
$page->display('standard/index.tpl');
?>
