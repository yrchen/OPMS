<?php
/*
 * OPMS
 * class-task.php
 * Created on 2006/12/10 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 * $HeadURL$
 */
 
// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class M_Task extends Base
{
  public function ProjectTaskList($project_id)
  {
  	$query_string = "SELECT * FROM project_tasks " .
                    "WHERE project_tasks.task_list_id IN " .
                    "(SELECT id FROM project_task_lists " .
                    " WHERE project_id = '$project_id')";
  	$result = $this->DB->DBGetAll($query_string);

  	return $result;
  }
  
  public function CheckTaskID($task_id)
  {
  	$query_string = "SELECT COUNT(*) FROM project_tasks WHERE id = '$task_id'";
  	$result = $this->DB->DBGetOne($query_string);

  	return $result;
  }

  public function CheckTaskListID($tasklist_id)
  {
  	$query_string = "SELECT COUNT(*) FROM project_task_lists WHERE id = '$tasklist_id'";
  	$result = $this->DB->DBGetOne($query_string);

  	return $result;
  }

  public function TaskProjectID($task_id)
  {
  	$query_string = "SELECT project_id FROM project_task_lists " .
                    "WHERE project_task_lists.id IN " .
                    "(SELECT task_list_id FROM project_tasks " .
                    " WHERE id = '$task_id')";
  	$result = $this->DB->DBGetOne($query_string);

  	return $result;
  }

  public function TasklistProjectID($tasklist_id)
  {
  	$query_string = "SELECT project_id FROM project_task_lists " .
                    "WHERE id = '$tasklist_id'";
  	$result = $this->DB->DBGetOne($query_string);

  	return $result;
  }
  
  public function TasklistMilestoneID($tasklist_id)
  {
  	$query_string = "SELECT milestone_id FROM project_task_lists " .
                    "WHERE id = '$tasklist_id'";
    $result = $this->DB->DBGetOne($query_string);
  	
  	return $result;
  }
  
  public function ProjectTasklistList($project_id)
  {
  	$query_string = "SELECT * FROM project_task_lists " .
                    "WHERE project_id = '$project_id'";
    $result = $this->DB->DBGetAll($query_string);
    
    return $result;
  }
  
  public function AddTasklist($milestone_id = 0, $project_id, $name, $description, $is_private, $created_by_id)
  {
  	$query_string = "INSERT INTO project_task_lists " .
                    "(milestone_id, project_id, name, " .
                    " description, is_private, created_on, " .
                    " created_by_id) VALUES " .
                    "('$milestone_id', '$project_id', '$name'," .
                    " '$description', '$is_private', NOW()," .
                    " '$created_by_id')";
  	$result = $this->DB->DBQuery($query_string);

  	return $result;
  }

  public function AddTask($tasklist_id = 0, $text, $assigned_to_user_id, $created_by_id)
  {
  	$query_string = "INSERT INTO project_tasks " .
                    "(task_list_id, text, assigned_to_user_id, " .
                    " created_on, created_by_id) VALUES " .
                    "('$tasklist_id', '$text', '$assigned_to_user_id'," .
                    " NOW(), '$created_by_id')";
  	$result = $this->DB->DBQuery($query_string);
  	
  	return $result;
  }
  
  public function UpdateTasklist($tasklist_id, $milestone_id, $name, $description, $is_private, $updated_by_id)
  {
    $name = $this->DB->DBEscapeSimple($name);
    $description = $this->DB->DBEscapeSimple($description);
  	$query_string = "UPDATE project_task_lists SET " .
                    "milestone_id = '$milestone_id', " .
                    "name = '$name', " .
                    "description = '$description', " .
                    "is_private = '$is_private', " .
                    "updated_on = NOW(), " .
                    "updated_by_id = '$updated_by_id'" .
                    "WHERE id = '$tasklist_id'";
  	$result = $this->DB->DBQuery($query_string);
  	
  	return $result;
  }
  
  public function TaskContent($task_id)
  {
  	$query_string = "SELECT * FROM project_tasks " .
                    "WHERE id = '$task_id'";
  	$result = $this->DB->DBGetRow($query_string);
  	
  	return $result;
  }

  public function TaskListContent($tasklist_id)
  {
  	$query_string = "SELECT * FROM project_task_lists " .
                    "WHERE id = '$tasklist_id'";
  	$result = $this->DB->DBGetRow($query_string);
  	
  	return $result;
  }
  
  public function TaskListTask($tasklist_id)
  {
  	$query_string = "SELECT * FROM project_tasks " .
                    "WHERE task_list_id = '$tasklist_id'";
  	$result = $this->DB->DBGetAll($query_string);
  	
  	return $result;
  }
  
  public function UpdateTask($task_id, $tasklist_id, $text, $assigned_to_user_id, $updated_by_id)
  {
  	$query_string = "UPDATE project_tasks SET " .
                    "task_list_id = '$tasklist_id', " .
                    "text = '$text', " .
                    "assigned_to_user_id = '$assigned_to_user_id', " .
                    "updated_on = NOW(), " .
                    "updated_by_id = '$updated_by_id' " .
                    "WHERE id = '$task_id'";
  	$result = $this->DB->DBQuery($query_string);
  	
  	return $result;
  }
  
  public function GetMilestoneTasklist($milestone_id)
  {
  	$query_string = "SELECT tasklists.*, users.realname FROM project_task_lists tasklists " .
                    "LEFT JOIN users ON tasklists.created_by_id = users.id " .
                    "WHERE milestone_id = '$milestone_id'";
    $result = $this->DB->DBGetAll($query_string);
    
    return $result;
  }
}

class C_Task
{
  private $mM_Task;

  function __construct()
  {
    $this->mM_Task = new M_Task();
  }
  
  public function GetProjectTaskList($project_id)
  {
  	$result = $this->mM_Task->ProjectTaskList($project_id);

  	return $result;
  }
  
  public function CheckTaskID($task_id)
  {
  	$result = $this->mM_Task->CheckTaskID($task_id);

  	return $result;
  }

  public function CheckTaskListID($tasklist_id)
  {
  	$result = $this->mM_Task->CheckTasklistID($tasklist_id);
  	
    return $result;
  }

  public function GetTaskProjectID($task_id)
  {
  	$result = $this->mM_Task->TaskProjectID($task_id);

  	return $result;
  } 

  public function GetTasklistProjectID($tasklist_id)
  {
  	$result = $this->mM_Task->TasklistProjectID($tasklist_id);

  	return $result;
  }
  
  public function GetTasklistMilestoneID($tasklist_id)
  {
  	$result = $this->mM_Task->TasklistMilestoneID($tasklist_id);
  	
  	return $result;
  }
  
  public function GetProjectTasklistList($project_id)
  {
  	$result = $this->mM_Task->ProjectTasklistList($project_id);
  	
  	return $result;
  }
  
  public function AddTasklist($milestone_id = 0, $project_id, $name, $description, $is_private)
  {
    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
    {
  	  $result = $this->mM_Task->AddTasklist($milestone_id, $project_id, $name, $description, $is_private, get_current_user_id());
  	
  	  if ($result)
  	    throw new TasklistAddException;
    }
    else
      throw new PermissionException;
  }

  public function AddTask($tasklist_id = 0, $text, $assigned_to_user_id)
  {
    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
    {
  	  $result = $this->mM_Task->AddTask($tasklist_id, $text, $assigned_to_user_id, get_current_user_id());
  	
  	  if ($result)
  	    throw new TaskAddException;
    }
    else
      throw new PermissionException;
  }

  public function DoUpdateTasklist($tasklist_id, $milestone_id, $name, $description, $is_private)
  {
    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
    {
  	  $updated_by_id = get_current_user_id();
  	  $result = $this->mM_Task->UpdateTasklist($tasklist_id, $milestone_id, $name, $description, $is_private, $updated_by_id);
  	
  	  if ($result)
  	    throw new TasklistUpdateException;
    }
    else
      throw new PermissionException;
  }

  public function GetTaskContent($task_id)
  {
  	$result =$this->mM_Task->TaskContent($task_id);
  	
  	return $result;
  }
  
  public function GetTaskListContent($tasklist_id)
  {
  	$result = $this->mM_Task->TaskListContent($tasklist_id);
  	
  	return $result;
  }
  
  public function GetTaskListTask($tasklist_id)
  {
  	$result = $this->mM_Task->TaskListTask($tasklist_id);
  	
  	return $result;
  }
  
  public function DoUpdateTask($task_id, $tasklist_id, $text, $assigned_to_user_id)
  {
    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
    {
  	  $result = $this->mM_Task->UpdateTask($task_id, $tasklist_id, $text, $assigned_to_user_id, get_current_user_id());
  	
  	  if ($result)
  	    throw new TaskUpdateException;
    }
    else
      throw new PermissoinException;
  }
  
  public function GetMilestoneTasklist($milestone_id)
  {
  	$result = $this->mM_Task->GetMilestoneTasklist($milestone_id);
  	
  	return $result;
  }
}
?>
