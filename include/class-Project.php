<?php
/*
 * OPMS - Open Project Management System
 * class-project.php
 * Created on 2006/10/28 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Project.php $
 */
 
// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class M_Project extends Base
{
  public function ProjectList()
  {
    $query_string = "SELECT project_id, project_name, project_start_date, project_status, project_description FROM project_list";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  public function MyProjectList($user_id)
  {
    $query_string = "SELECT * FROM project_list, project_users " .
                    "WHERE project_users.user_id = '$user_id' " .
                    "AND project_list.project_id = project_users.project_id";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  public function ProjectMember($project_id)
  {
    $query_string = "SELECT users.realname, users.id FROM project_users, users " .
                    "WHERE project_users.project_id = '$project_id' " .
                    "AND project_users.role_id < " . $this->permission['project_teacher'] . " " .
                    "AND users.id = project_users.user_id";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  public function ProjectName($project_id)
  {
    $query_string = "SELECT project_name FROM project_list " .
                    "WHERE project_id = '$project_id'";
    $result = $this->DB->DBGetOne($query_string);

    return $result;
  }

  public function ProjectTeacher($project_id)
  {
    $query_string = "SELECT users.realname FROM project_users, users " .
                    "WHERE project_users.project_id = '$project_id' " .
                    "AND project_users.role_id >= " . $this->permission['project_teacher'] . " " .
                    "AND users.id = project_users.user_id";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  public function ProjectContent($project_id)
  {
    $query_string = "SELECT * FROM project_list " .
                    "WHERE project_id = '$project_id'";
    $result = $this->DB->DBGetRow($query_string);

    return $result;
  }

  public function CheckUserPermission($project_id, $user_id)
  {
    $query_string = "SELECT role_id FROM project_users " .
                    "WHERE project_id = '$project_id' " .
                    "AND user_id = '$user_id'";
    $result = $this->DB->DBGetOne($query_string);

    return $result;
  }

  public function CheckProjectID($project_id)
  {
    $query_string = "SELECT COUNT(*) FROM project_list " .
                    "WHERE project_id = '$project_id'";
    $result = $this->DB->DBGetOne($query_string);

    return $result;
  }

  public function GetProjectShortName($project_id)
  {
    $query_string = "SELECT project_short_name FROM project_list " .
                    "WHERE project_id = '$project_id'";
    $result = $this->DB->DBGetOne($query_string);

    return $result;
  }

  public function UpdateProjectContent($project_id, $name, $demo_url, $description, $licence)
  {
    $name = $this->DB->DBEscapeSimple($name);
    $demo_url = $this->DB->DBEscapeSimple($demo_url);
    $description = $this->DB->DBEscapeSimple($description);
    $query_string = "UPDATE project_list SET " .
                    "project_name = '$name', " .
                    "project_demo_url = '$demo_url', " .
                    "project_description = '$description', " .
                    "project_licence = '$licence' " .
                    "WHERE project_list.project_id ='$project_id'";
    $result = $this->DB->DBQuery($query_string);

    return $result; 
  }

  public function AddProjectMember($project_id, $user_id, $role_id)
  {
    $query_string = "INSERT INTO project_users " .
                    "(project_id, user_id, role_id) VALUES " .
                    "('$project_id', '$user_id', '$role_id')";
    $result = $this->DB->DBQuery($query_string);
    
    return $result;
  }

  public function DelProjectMember($project_id, $user_id, $role_id)
  {
    $query_string = "DELETE FROM project_users " .
                    "WHERE project_id = '$project_id' " .
                    "AND user_id = '$user_id' " .
                    "AND role_id = '$role_id'";
    $result = $this->DB->DBQuery($query_string);

    return $result;
  }
}

class C_Project
{
  private $mProject;

  function __construct()
  {
    $this->mProject = new M_Project();
  }

  public function GetProjectList()
  {
    $result = $this->mProject->ProjectList();

    return $result;
  }

  public function GetMyProjectList()
  {
    $user_id = get_current_user_id();
    $result = $this->mProject->MyProjectList($user_id);

    return $result;
  }

  public function GetProjectMember($project_id)
  {
    $result = $this->mProject->ProjectMember($project_id);

    return $result;
  }

  public function GetProjectName($project_id)
  {
    $result = $this->mProject->ProjectName($project_id);

    return $result;
  }

  public function GetProjectTeacher($project_id)
  {
    $result = $this->mProject->ProjectTeacher($project_id);

    return $result;
  }

  public function GetProjectContent($project_id)
  {
    $result = $this->mProject->ProjectContent($project_id);

    return $result;
  }

  public function CheckUserPermission($project_id)
  {
    $user_id = get_current_user_id();
    $result = $this->mProject->CheckUserPermission($project_id, $user_id);

    if ($result)
      return $result;
    else
      return 0;
  }

  public function CheckUserPermission2($project_id, $user_id)
  {
    $result = $this->mProject->CheckUserPermission($project_id, $user_id);

    if ($result)
      return $result;
    else
      return 0;
  }

  public function CheckProjectID($project_id)
  {
    $result = $this->mProject->CheckProjectID($project_id);

    return $result;
  }

  public function GetProjectShortName($project_id)
  {
    $result = $this->mProject->GetProjectShortName($project_id);

    return $result;
  }

  public function DoUpdateProjectContent($project_id, $name, $demo_url, $description, $licence)
  {
    if (check_user_permission() >= PROJECT_LEADER_PERMISSION)
    {
      $result = $this->mProject->UpdateProjectContent($project_id, $name, $demo_url, $description, $licence);  	

    if ($result)
      throw new ProjectUpdateException;
    }
    else
      throw new PermissionException;
  }
  
  public function AddProjectMember($project_id, $user_id)
  {
    if (check_user_permission() >= PROJECT_LEADER_PERMISSION)
    {
      $result = $this->mProject->CheckUserPermission($project_id, $user_id);
      
      if (!$result)
      {
        $result = $this->mProject->AddProjectMember($project_id, $user_id, PROJECT_MEMBER_PERMISSION);

        if ($result)
          throw new ProjectMemberModifyExceptoin;
      }
    }
    else
      throw new PermissionException;
  }

  public function DelProjectMember($project_id, $user_id)
  {
    if (check_user_permission() >= PROJECT_LEADER_PERMISSION)
    {
      $result = $this->mProject->CheckUserPermission($project_id, $user_id);

      if (($result >= PROJECT_MEMBER_PERMISSION) && ($result < PROJECT_TEACHER_PERMISSION))
      {
        $result = $this->mProject->DelProjectMember($project_id, $user_id, PROJECT_MEMBER_PERMISSION);

        if ($result)
          throw new ProjectMemberModifyExceptoin;
      }
      else if ($result >= PROJECT_TEACHER_PERMISSION)
      {
        $result = $this->mProject->DelProjectMember($project_id, $user_id, PROJECT_TEACHER_PERMISSION);

        if ($result)
          throw new ProjectTeacherModifyException;
      }
    }
    else
      throw new PermissionException;
  }
}
?>
