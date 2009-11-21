<?php
/*
 * OPMS
 * class-Apply.php
 * Created on 2006/12/27 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Apply.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class M_Apply extends Base
{
  function ApplyList()
  {
  	$query_string = "SELECT * FROM apply_lists";
  	$result = $this->DB->DBGetAll($query_string);
  	
  	return $result;
  }
  
  function ShowDetail($apply_id)
  {
  	$query_string = "SELECT * FROM apply_lists " .
  			        "WHERE id = '$apply_id'";
  	$result = $this->DB->DBGetRow($query_string);
  	
  	return $result;
  }
  
  function CheckApplyID($apply_id)
  {
  	$query_string = "SELECT COUNT(*) FROM apply_lists " .
                    "WHERE id = '$apply_id'";
    $result = $this->DB->DBGetOne($query_string);
    
    return $result;
  }
}

class C_Apply
{
  private $mApply;
  
  public function __construct()
  {
  	$this->mApply = new M_Apply;
  }

  function GetApplyList()
  {
  	$result = $this->mApply->ApplyList();
  	
  	return $result;
  }
  
  function ShowDetail($apply_id)
  {
  	$result = $this->mApply->ShowDetail($apply_id);
  	
  	return $result;
  }
  
  function CheckApplyID($apply_id)
  {
  	$result = $this->mApply->CheckApplyID($apply_id);
  	
  	return $result;
  }
}

class M_ApplyProject extends Base
{
  function ListAllProject()
  {
  	$query_string = "SELECT apply.*, users.realname FROM apply_projects apply " .
                    "LEFT JOIN users ON apply.teacher = users.id";
    $result = $this->DB->DBGetAll($query_string);
    
    return $result;
  }

  function ListAllLiveProject()
  {
  	$query_string = "SELECT apply.*, users.realname FROM apply_projects apply " .
                    "LEFT JOIN users ON apply.teacher = users.id " .
                    "WHERE apply.status = 'open'";
    $result = $this->DB->DBGetAll($query_string);
    
    return $result;
  }
 
  function JoinProject($project_id, $user_id)
  {
  	$query_string = "INSERT INTO apply_project_users " .
                    "(project_id, user_id) " .
                    "VALUES " .
                    "('$project_id', '$user_id')";
    $result = $this->DB->DBQuery($query_string);
    
    return $result;
  }
  
  function LeaveProject($project_id, $user_id)
  {
  	$query_string = "DELETE FROM apply_project_users " .
                    "WHERE project_id = '$project_id' " .
                    "AND user_id = '$user_id'";
    $result = $this->DB->DBQuery($query_string);
    
    return $result;
  }
  
  function ListProjectApply($project_id)
  {
  	$query_string = "SELECT apply.*, users.realname FROM apply_project_users apply" .
  	                "LEFT JOIN users ON apply.user_id = users.id " .
                    "WHERE apply.project_id = '$project_id'";
  	$result = $this->DB->DBQuery($query_string);
  	
  	return $result;
  }
  
  function ApplyProjectUser($project_id)
  {
  	$query_string = "SELECT COUNT(*) FROM apply_project_users " .
                    "WHERE project_id = '$project_id'";
    $result = $this->DB->DBGetOne($query_string);
    
    return $result;
  }
  
  function ProjectContent($project_id)
  {
  	$query_string = "SELECT apply.*, users.realname FROM apply_projects apply " .
                    "LEFT JOIN users ON apply.teacher = users.id " .
                    "WHERE apply.id = '$project_id'";
    $result = $this->DB->DBGetRow($query_string);
    
    return $result;
  }

  function CheckApplyProjectID($project_id)
  {
  	$query_string = "SELECT COUNT(*) FROM apply_projects " .
                    "WHERE id = '$project_id'";
    $result = $this->DB->DBGetOne($query_string);
    
    return $result;
  }
  
  function CheckApplyProjectExist($project_id, $user_id)
  {
  	$query_string = "SELECT COUNT(*) FROM apply_project_users " .
                    "WHERE project_id = '$project_id' " .
                    "AND user_id = '$user_id'";
    $result = $this->DB->DBGetOne($query_string);
    
    return $result;
  }
}

class C_ApplyProject
{
  public function __construct()
  {
  	$this->mApplyProject = new M_ApplyProject;
  }
  
  public function GetAllProjectList()
  {
  	$result = $this->mApplyProject->ListAllProject();
  	
  	return $result;
  }

  public function GetAllLiveProjectList()
  {
  	$result = $this->mApplyProject->ListAllLiveProject();
  	
  	return $result;
  }
  
  public function JoinProject($project_id)
  {
  	$user_id = get_current_user_id();
  	$result = $this->mApplyProject->JoinProject($project_id, $user_id);
  	
  	if ($result)
  	  throw new ApplyProjectJoinException;
  }
  
  public function LeaveProject($project_id, $user_id)
  {
  	$result = $this->mApplyProject->LeaveProject($project_id, $user_id);
  	
  	if ($result)
  	  throw new ApplyProjectLeaveException;
  }
  
  public function ListProjectApply($project_id)
  {
  	$result = $this->mApplyProject->ListProjectApply($project_id);
  	
  	return $result;
  }
  
  public function GetApplyProjectUser($project_id)
  {
  	$result = $this->mApplyProject->ApplyProjectUser($project_id);
  	
  	return $result;
  }
  
  public function GetProjectContent($project_id)
  {
  	$result = $this->mApplyProject->ProjectContent($project_id);
  	
  	return $result;
  }

  function CheckApplyProjectID($project_id)
  {
  	$result = $this->mApplyProject->CheckApplyProjectID($project_id);
  	
  	return $result;
  }
  
  function CheckApplyProjectExist($project_id, $user_id)
  {
  	$result = $this->mApplyProject->CheckApplyProjectExist($project_id, $user_id);

    if ($result > 0)
      return true;
    else
      return false;
  }
}
?>
