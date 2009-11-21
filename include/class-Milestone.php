<?php
/*
 * OPMS
 * class-milestone.php
 * Created on 2006/12/10 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Milestone.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class M_Milestone extends Base
{
  public function MilestoneContent($milestone_id)
  {
  	$query_string = "SELECT * FROM project_milestones " .
  			        "WHERE id = '$milestone_id'";
  	$result = $this->DB->DBGetRow($query_string);

  	return $result;
  }
  public function ProjectMilestoneList($project_id)
  {
  	$query_string = "SELECT * FROM project_milestones " .
  			        "WHERE project_id = '$project_id'";
  	$result = $this->DB->DBGetAll($query_string);

  	return $result;
  }
  
  public function AddMilestone($project_id, $name, $description, $due_date, $assigned_to_user_id, $is_private, $created_by_id)
  {
  	$query_string = "INSERT INTO project_milestones " .
  			        "(id, project_id, name," .
  			        " description, due_date, assigned_to_user_id," .
  			        " is_private, completed_on, completed_by_id," .
  			        " created_on, created_by_id, updated_on, updated_by_id) VALUES" .
  			        "(NULL , '$project_id', '$name'," .
  			        " '$description', '$due_date', '$assigned_to_user_id'," .
  			        " '$is_private', '0000-00-00 00:00:00', NULL," .
  			        " NOW(), '$created_by_id', NOW()," .
  			        " NULL)";
  	$result = $this->DB->DBQuery($query_string);

  	return $result;
  }
  
  public function UpdateMilestone($id, $name, $description, $due_date, $assigned_to_user_id, $is_private, $update_by_id)
  {
  	$name = $this->DB->DBEscapeSimple($name);
  	$description = $this->DB->DBEscapeSimple($description);
  	$query_string = "UPDATE project_milestones " .
  			        "SET name = '$name', " .
  			        "description = '$description', " .
  			        "due_date = '$due_date', " .
  			        "assigned_to_user_id = '$assigned_to_user_id', " .
  			        "is_private = '$is_private', " .
  			        "updated_on = NOW() , " .
  			        "updated_by_id = '$update_by_id' " .
  			        "WHERE project_milestones.id ='$id'";
  	$result = $this->DB->DBQuery($query_string);
  	
  	return $result;
  }

  public function CheckMilestoneID($milestone_id)
  {
  	$query_string = "SELECT COUNT(*) FROM project_milestones " .
  			        "WHERE id = '$milestone_id'";
  	$result = $this->DB->DBGetOne($query_string);
  	
  	return $result;
  }
  
  public function MilestoneProjectID($milestone_id)
  {
  	$query_string = "SELECT project_id FROM project_milestones " .
  			        "WHERE id = '$milestone_id'";
  	$result = $this->DB->DBGetOne($query_string);

  	return $result;
  }
}

class C_Milestone
{
  private $mMilestone;

  function __construct()
  {
    $this->mMilestone = new M_Milestone();
  }
  
  public function GetMilestoneContent($milestone_id)
  {
  	$result = $this->mMilestone->MilestoneContent($milestone_id);
  	return $result;
  }

  public function GetProjectMilestoneList($project_id)
  {
  	$result = $this->mMilestone->ProjectMilestoneList($project_id);
  	return $result;
  }
  
  public function AddProjectMilestone($project_id, $name, $description, $due_date, $assigned_to_user_id, $is_private)
  {
    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
    {
  	  $created_by_id = get_current_user_id();
  	  $result = $this->mMilestone->AddMilestone($project_id, $name, $description, $due_date, $assigned_to_user_id, $is_private, $created_by_id);
  	  
  	  if ($result)
  	    throw new MilestoneAddException;
    }
    else
      throw new PermisssionException;
  }
  
  public function UpdateProjectMilestone($id, $name, $description, $due_date, $assigned_to_user_id, $is_private)
  {
    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
    {
      $update_by_id = get_current_user_id();
  	  $result = $this->mMilestone->UpdateMilestone($id, $name, $description, $due_date, $assigned_to_user_id, $is_private, $update_by_id);
  	  
  	  if ($result)
  	    throw new MilestonUpdateException;
    }
  	else
  	  throw new PermissionException;
  }
  
  public function CheckMilestoneID($milestone_id)
  {
  	$result = $this->mMilestone->CheckMilestoneID($milestone_id);
  	return $result;
  }

  public function GetMilestoneProjectID($milestone_id)
  {
  	$result = $this->mMilestone->MilestoneProjectID($milestone_id);
  	return $result;
  } 
}
?>
