<?php
/*
 * OPMS
 * function.add_task.php
 * Created on 2006/12/31 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.add_task.php $
 */

function smarty_function_add_task($params, $smarty)
{
  $add_task = new AddTask();
  $add_task->init();
  $smarty->assign($params['assign'], $add_task);
}

class AddTask
{
  public $mMessage;
  public $mLeaveFlag;
  
  private $mC_Task;
  private $Project_ID;
  private $mAction;
  
  function __construct()
  {
  	$this->mC_Task = new C_Task();
    $this->mProjectID = (int)$_GET['active_project'];
    $this->mAction = "";
    $this->mLeaveFlag = false;

  	foreach ($_POST as $key => $value)
  	  if (substr($key, 0, 6) == "submit")
  	  {
  	  	$last_underscore = strrpos($key, "_");
  	  	$this->mAction = substr($key, strlen("submit_"), $last_underscore - strlen("submit_"));
  	  	$this->mProjectID = substr($key, $last_underscore + 1);

  	  	break;	//yrchen.061213: jump out foreach
  	  }
  	
  	if (isset($_GET['tasklist_id']))
  	  $this->mTasklistID = $_GET['tasklist_id'];
  	else
  	  throw new TasklistIDException;
  }
  
  function init()
  {
  	global $config, $message, $error_message;

    try
    {
      switch ($this->mAction)
  	  {
  	    case 'add_task':
  	      if (isset($_POST['text']) && isset($_POST['assigned_to']))
          {
            $this->mC_Task->AddTask($this->mTasklistID, $_POST['text'], $_POST['assigned_to']);
          }
          else
            throw new PostDataErrorException;
  	      break;
  	  
  	    case 'cancel':
  	      header("Location: " . $config['site_url'] . "main.php?event=Task&action=List&active_project=" . $this->mProjectID);
  	      break;

  	    default:
  	      break;
  	  }
    }
    catch (PostDataErrorException $e)
    {
      $this->mMessage = $error_message['post_data_error'];
    }
    catch (TaskAddException $e)
    {
      $this->mMessage = $message['task_add'];
      $this->mLeaveFlag = true;
    }
  }
}

?>
