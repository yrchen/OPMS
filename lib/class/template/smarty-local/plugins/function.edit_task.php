<?php
/*
 * OPMS
 * function.edit_task.php
 * Created on 2007/1/1 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.edit_task.php $
 */

function smarty_function_edit_task($params, $smarty)
{
  $edit_task = new EditTask();
  $edit_task->init();
  $smarty->assign($params['assign'], $edit_task);
}

class EditTask
{
  public $mTaskID;
  public $mProjectID;
  public $mMessage;
  public $mTaskContent;
  public $mLeaveFlag;
  
  private $mC_Task;
  private $mAction;
  
  function __construct()
  {
  	$this->mC_Task = new C_Task();
    $this->mTaskID = (int)$_GET['id'];
    $this->mAction = "";
    $this->mLeaveFlag = false;

  	foreach ($_POST as $key => $value)
  	  if (substr($key, 0, 6) == "submit")
  	  {
  	  	$last_underscore = strrpos($key, "_");
  	  	$this->mAction = substr($key, strlen("submit_"), $last_underscore - strlen("submit_"));
  	  	$this->mTaskID = substr($key, $last_underscore + 1);

  	  	break;	//yrchen.061213: jump out foreach
  	  }
  	
  	$this->mProjectID = $this->mC_Task->GetTaskProjectID($this->mTaskID);
  }
  
  function init()
  {
  	global $config, $message, $error_message;

    try
    {
      switch ($this->mAction)
  	  {
  	    case 'edit_task':
  	      if (isset($_POST['tasklist_id']) && isset($_POST['text']) && isset($_POST['assigned_to_user_id']))
          {
            $this->mC_Task->DoUpdateTask($this->mTaskID, $_POST['tasklist_id'], $_POST['text'], $_POST['assigned_to_user_id']);
          }
          else
            throw new PostDataErrorException;
  	      break;
  	  
  	    case 'cancel':
  	      header("Location: " . $config['site_url'] . "main.php?event=Task&action=ViewTask&id=" . $this->mTaskID . "&active_project=" . $this->mProjectID);
  	      break;

  	    default:
  	      break;
  	  }
    }
    catch (PostDataErrorException $e)
    {
      $this->mMessage = $error_message['post_data_error'];
    }
    catch (TaskUpdateException $e)
    {
      $this->mMessage = $message['task_update'];
      $this->mLeaveFlag = true;
    }

  	$this->mTaskContent = $this->mC_Task->GetTaskContent($this->mTaskID);
  }
}

?>
