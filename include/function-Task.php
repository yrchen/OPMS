<?php
/*
 * OPMS
 * function-Task.php
 * Created on 2006/12/22 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-Task.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

function check_request_task_id()
{
  $task = new C_Task;

  if (isset($_GET['id']))
    $task_id = (int)$_GET['id'];
  else if (isset($_GET['task_id']))
    $task_id = (int)$_GET['task_id'];
  else
    throw new TaskIDException;
    
  $result = $task->CheckTaskID($task_id);
  
  if ($result > 0)
  {
  	$result = $task->GetTaskProjectID($task_id);
  	$user_id = get_current_user_id();

    if (check_user_permission2($result, $user_id) < PROJECT_MEMBER_PERMISSION)
       throw new PermissionException;
  }
  else
    throw new TaskIDException;
}

function check_request_tasklist_id()
{
  $tasklist = new C_Task;

  if (isset($_GET['id']))
    $tasklist_id = (int)$_GET['id'];
  else if (isset($_GET['tasklist_id']))
    $tasklist_id = (int)$_GET['tasklist_id'];
  else
    throw new TaskListIDException;

  $result = $tasklist->CheckTasklistID($tasklist_id);
  
  if ($result > 0)
  {
  	$result = $tasklist->GetTasklistProjectID($tasklist_id);
  	$user_id = get_current_user_id();

    if (check_user_permission2($result, $user_id) < PROJECT_MEMBER_PERMISSION)
      throw new PermissionException;
  }
  else
    throw new TaskListIDException;
}

?>
