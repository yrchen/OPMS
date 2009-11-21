<?php
/*
 * OPMS
 * function.load_project_tasklist.php
 * Created on 2006/12/30 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_project_tasklist.php $
 */

function smarty_function_load_project_tasklist($params, $smarty)
{
  $project_tasklist = new ProjectTaskList();
  $project_tasklist->init();
  $smarty->assign($params['assign'], $project_tasklist);
}

class ProjectTaskList
{
  public $mProjectID;
  public $mProjectTaskList;

  private $mC_TaskList;
  
  function __construct()
  {
  	$this->mC_TaskList = new C_Task();
  	
  	if (isset($_GET['active_project']))
  	  $this->mProjectID = (int)$_GET['active_project'];
  	else
  	  throw new ProjectIDException;
  }
  
  function init()
  {
    $this->mProjectTaskList = $this->mC_TaskList->GetProjectTasklistList($this->mProjectID);
  }
}

?>
