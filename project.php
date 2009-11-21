<?php
/*
 * OPMS
 * project.php
 * Created on 2006/10/16 by Chen YuRen (yrchen@ATCity.org)
 *
 * �M�׺޲專案相關功能
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/project.php $
 */

// yrchen.061015: Set flag that this is a parent file.
define( '_OPMSEXEC', 1 );

require_once('init.php');

$page = new Page();
$pageTitle = set_title("專案列表");
$pageContentCell = "standard/project.tpl";

if (isset($_GET['Project_ID']))
{
  $pageContentCell = "standard/project-one.tpl";
  $pageTitle = set_title(get_project_name($_GET['Project_ID']));
}

$timer->stop();
$page->assign('total_time', $timer->timeElapsed());
$page->assign ('page_title', $pageTitle);
$page->display ($pageContentCell);

opms_end();
?>