<?php
/*
 * OPMS
 * function.load_project_task.php
 * Created on 2006/12/11 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_project_task.php $
 */

function smarty_function_load_project_task($params, $smarty)
{
  $project_task = new ProjectTask();
  $project_task->init();
  $smarty->assign($params['assign'], $project_task);
}

class ProjectTask
{
  public $mProjectID;
  public $mProjectTask;
  private $mC_Task;
  
  function __construct()
  {
  	$this->mC_Task = new C_Task();
  	
  	if (isset($_GET['active_project']))
  	  $this->mProjectID = (int)$_GET['active_project'];
  	else
  	  throw new ProjectIDException;
  }
  
  function init()
  {
    $this->mProjectTask = $this->mC_Task->GetProjectTaskList($this->mProjectID);
  }
}
?>
