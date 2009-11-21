<?php
/*
 * OPMS
 * function.edit_tasklist.php
 * Created on 2006/12/31 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.edit_tasklist.php $
 */

function smarty_function_edit_tasklist($params, $smarty)
{
  $edit_tasklist = new EditTasklist();
  $edit_tasklist->init();
  $smarty->assign($params['assign'], $edit_tasklist);
}

class EditTasklist
{
  public $mTasklistID;
  public $mMilestoneID;
  public $mProjectID;
  public $mMessage;
  public $mTaskContent;
  public $mLeaveFlag;
  
  private $mC_Tasklist;
  private $mAction;
  
  function __construct()
  {
  	$this->mC_Tasklist = new C_Task();
    $this->mTasklistID = (int)$_GET['id'];
    $this->mAction = "";
    $this->mLeaveFlag = false;

  	foreach ($_POST as $key => $value)
  	  if (substr($key, 0, 6) == "submit")
  	  {
  	  	$last_underscore = strrpos($key, "_");
  	  	$this->mAction = substr($key, strlen("submit_"), $last_underscore - strlen("submit_"));
  	  	$this->mTasklistID = substr($key, $last_underscore + 1);

  	  	break;	//yrchen.061213: jump out foreach
  	  }
  	
  	$this->mProjectID = $this->mC_Tasklist->GetTasklistProjectID($this->mTasklistID);
  	$this->mMilestoneID = $this->mC_Tasklist->GetTasklistMilestoneID($this->mTasklistID);
  }
  
  function init()
  {
  	global $config, $message, $error_message;

    try
    {
      switch ($this->mAction)
  	  {
  	    case 'edit_tasklist':
  	      if (isset($_POST['milestone_id']) && isset($_POST['name']) &&
              isset($_POST['description']) && isset($_POST['is_private']))
          {
            $this->mC_Tasklist->DoUpdateTasklist($this->mTasklistID, $_POST['milestone_id'], $_POST['name'], $_POST['description'], $_POST['is_private']);
          }
          else
            throw new PostDataErrorException;
  	      break;
  	  
  	    case 'cancel':
  	      header("Location: " . $config['site_url'] . "main.php?event=Task&action=ViewList&id=" . $this->mTasklistID . "&active_project=" . $this->mProjectID);
  	      break;

  	    default:
  	      break;
  	  }
    }
    catch (PostDataErrorException $e)
    {
      $this->mMessage = $error_message['post_data_error'];
    }
    catch (TasklistUpdateException $e)
    {
      $this->mMessage = $message['tasklist_update'];
      $this->mLeaveFlag = true;
    }

  	$this->mTasklistContent = $this->mC_Tasklist->GetTasklistContent($this->mTasklistID);
  }
}

?>
