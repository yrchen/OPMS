<?php
/*
 * OPMS
 * function-Apply.php
 * Created on 2006/12/29 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-Apply.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

function check_request_apply_id()
{
  $apply = new C_Apply;

  if (isset($_GET['id']))
    $apply_id = (int)$_GET['id'];
  else
    throw new ApplyIDException;

  $result = $apply->CheckApplyID($apply_id);
  
  if (!$result)
    throw new ApplyIDException;
}
?>
