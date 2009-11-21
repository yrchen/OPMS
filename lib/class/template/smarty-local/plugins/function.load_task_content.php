<?php
/*
 * OPMS
 * function.load_task_content.php
 * Created on 2007/1/1 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_task_content.php $
 */

function smarty_function_load_task_content($params, $smarty)
{
  $task_content = new TaskContent();
  $task_content->init();
  $smarty->assign($params['assign'], $task_content);
}

class TaskContent
{
  public $mTaskID;
  public $mTaskContent;
  public $mTaskTask;

  private $mC_Task;
  
  function __construct()
  {
  	$this->mC_Task = new C_Task();
  	
  	if (isset($_GET['id']))
  	  $this->mTaskID = (int)$_GET['id'];
  	else if (isset($_GET['task_id']))
  	  $this->mTaskID = (int)$_GET['task_id'];
  	else
  	  throw new TaskIDException;
  }
  
  function init()
  {
    $this->mTaskContent = $this->mC_Task->GetTaskContent($this->mTaskID);
  }
}
?>
