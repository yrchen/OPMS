<?php
/*
 * OPMS
 * debug.php
 * Created on 2006/12/29 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/debug.php $
 */

// no direct access
defined('_OPMSEXEC') or die('Restricted access');

if (defined('DEBUG_MODE'))
{
  require_once('class-Debugger.php');

  apc_clear_cache();
}
?>
