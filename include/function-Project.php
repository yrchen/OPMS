<?php
/*
 * OPMS
 * function-project.php
 * Created on 2006/12/10 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-Project.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

function get_project_name($project_id)
{
  $project = new C_Project;
  $result = $project->GetProjectName($project_id);

  return $result;
}

function get_project_user_belong_list()
{
  global $opms_db;
  
  $user_id = get_current_user_id();
  $query_string = "SELECT project_id FROM project_users WHERE user_id = '$user_id'"; 
  $result = $opms_db->DBGetAll($query_string);

  return $result;
}

function check_request_project_id()
{
  $project = new C_Project;

  if (isset($_GET['active_project']))
    $project_id = (int)$_GET['active_project'];
  else
    throw new ProjectIDException;

  $result = $project->CheckProjectID($project_id);
  
  if ($result > 0)
    return 0;
  else
    throw new ProjectIDException;
}

?>
