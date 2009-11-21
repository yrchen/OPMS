<?php
/*
 * OPMS
 * logout.php
 * Created on 2006/10/22 by Chen YuRen (yrchen@ATCity.org)
 *
 * 登出
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/logout.php $
 */

// yrchen.061015: Set flag that this is a parent file.
define( '_OPMSEXEC', 1 );

require_once('init.php');

$old_user = $_SESSION['valid_user'];

if (!empty($old_user))
{
  try
  {
  	unset($_SESSION['valid_user']);
    $result_dest = session_destroy();

    header("Location: " . $config['site_url'] . "index.php");
  }
  catch (Exception $e)
  {
  	// yrchen.061022: 已經登入，但無法登出
  	header("Location: " . $config['site_url'] . "error.php");
  }
}
else
{
  // yrchen.061022: 尚未登入，但是不知道為啥跑來這
  header("Location: " . $config['site_url'] . "login.php");
}
?>