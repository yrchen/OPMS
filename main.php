<?php
/*
 * OPMS
 * main.php
 * Created on 2006/07/10 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/main.php $
 */

// yrchen.061015: Set flag that this is a parent file.
define( '_OPMSEXEC', 1 );

require_once('init.php');

try
{
  check_login();
  opms_start();
  opms_end();
}
catch (LoginException $e)
{
  header("Location: " . $config['site_url'] . "login.php?redirect=" . $_SERVER['REQUEST_URI']);
}
?>