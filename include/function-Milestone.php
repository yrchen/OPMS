<?php
/*
 * OPMS
 * function-Milestone.php
 * Created on 2006/12/22 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-Milestone.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

function check_request_milestone_id()
{
  $milestone = new C_Milestone;

  if (isset($_GET['id']))
    $milestone_id = (int)$_GET['id'];
  else
    throw new MilestoneIDException;

  $result = $milestone->CheckMilestoneID($milestone_id);
  
  if ($result > 0)
  {
  	$result = $milestone->GetMilestoneProjectID($milestone_id);
  	$user_id = get_current_user_id();

    if (check_user_permission2($result, $user_id) < PROJECT_MEMBER_PERMISSION)
      throw new PermissionException;
  }
  else
    throw new MilestoneIDException;
}
?>
