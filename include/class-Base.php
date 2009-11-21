<?php
/*
 * OPMS - Open Project Management System
 * class-base.php
 * Created on 2006/12/5 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate:2006-12-06 02:21:49 +0000 (Wed, 06 Dec 2006) $
 * $LastChangedRevision:617 $
 * $LastChangedBy:yrchen $
 * $HeadURL:http://project.cis.au.edu.tw/svn/opms/trunk/include/class-base.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class Base
{
  public $DB;
  var $permission;

  function __construct()
  {
  	global $opms_db, $permission;

  	$this->DB = $opms_db;
  	$this->permission = $permission;
  }
}
?>
