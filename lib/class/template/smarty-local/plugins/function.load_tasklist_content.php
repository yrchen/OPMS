<?php
/*
 * OPMS
 * function.load_tasklist_content.php
 * Created on 2006/12/31 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_tasklist_content.php $
 */

function smarty_function_load_tasklist_content($params, $smarty)
{
  $tasklist_content = new TasklistContent();
  $tasklist_content->init();
  $smarty->assign($params['assign'], $tasklist_content);
}

class TasklistContent
{
  public $mTasklistID;
  public $mTasklistContent;
  public $mTasklistTask;

  private $mC_Tasklist;
  
  function __construct()
  {
  	$this->mC_Tasklist = new C_Task();
  	
  	if (isset($_GET['id']))
  	  $this->mTasklistID = (int)$_GET['id'];
  	else if (isset($_GET['tasklist_id']))
  	  $this->mTasklistID = (int)$_GET['tasklist_id'];
  	else
  	  throw new TasklistIDException;
  }
  
  function init()
  {
    $this->mTasklistContent = $this->mC_Tasklist->GetTaskListContent($this->mTasklistID);
    $this->mTasklistTask = $this->mC_Tasklist->GetTaskListTask($this->mTasklistID);
  }
}
?>
