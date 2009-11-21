<?php
/*
 * OPMS - Open Project Management System
 * function.php
 * Created on 2006/10/24 by Chen YuRen (yrchen@ATCity.org)
 *
 * 所有函式列表
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function.php $
 */
 
// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

require_once('function-DB.php');
require_once('function-ErrorHandler.php');
require_once('function-Auth.php');
require_once('function-Announce.php');
require_once('function-Milestone.php');
require_once('function-Misc.php');
require_once('function-Message.php');
require_once('function-Project.php');
require_once('function-Task.php');

set_error_handler("error_handler", E_ALL);
?>
