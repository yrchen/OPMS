<?php
/*
 * OPMS
 * search.php
 * Created on 2006/10/19 by Chen YuRen (yrchen@ATCity.org)
 *
 * 搜尋
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/search.php $
 */

// yrchen.061015: Set flag that this is a parent file.
define( '_OPMSEXEC', 1 );

require_once('init.php');

$page->assign('page_title', set_title("搜尋"));
$opms_tpl->display ('standard/search.tpl');
?>
