<?php
/*
 * OPMS
 * admin-function-auth.php
 * Created on 2006/10/26 by Chen YuRen (yrchen@ATCity.org)
 *
 * 管理者認證用函式
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/admin/admin-function-auth.php $
 */

defined('_OPMSEXEC') or die('Restricted access');

function check_admin_login()
{
  if (isset($_SESSION['valid_user']))
  {
  	if (get_user_role() == 1)
      return true;
    else
      throw new Exception ('User not Admin!');
  }
  else
    throw new Exception ('User not loging!');
}
?>
