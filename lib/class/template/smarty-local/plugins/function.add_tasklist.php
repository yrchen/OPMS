<?php
/*
 * OPMS
 * function.add_tasklist.php
 * Created on 2006/12/31 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.add_tasklist.php $
 */

function smarty_function_add_tasklist($params, $smarty)
{
  $add_tasklist = new AddTasklist();
  $add_tasklist->init();
  $smarty->assign($params['assign'], $add_tasklist);
}

class AddTasklist
{
  public $mMessage;
  public $mLeaveFlag;
  public $mMilestoneID;
  
  private $mC_Tasklist;
  private $mProjectID;
  private $mTasklistID;
  private $mAction;
  
  function __construct()
  {
  	$this->mC_Tasklist = new C_Task();
    $this->mProjectID = (int)$_GET['active_project'];
    $this->mAction = "";
    $this->mMilestoneID = "";
    $this->mLeaveFlag = false;

  	foreach ($_POST as $key => $value)
  	  if (substr($key, 0, 6) == "submit")
  	  {
  	  	$last_underscore = strrpos($key, "_");
  	  	$this->mAction = substr($key, strlen("submit_"), $last_underscore - strlen("submit_"));
  	  	$this->mProjectID = substr($key, $last_underscore + 1);

  	  	break;	//yrchen.061213: jump out foreach
  	  }
  	  
  	if (isset($_GET['milestone_id']))
  	  $this->mMilestoneID = (int)$_GET['milestone_id'];
  }
  
  function init()
  {
  	global $config, $message, $error_message;

    try
    {
      switch ($this->mAction)
  	  {
  	    case 'add_tasklist':
  	      if ((isset($_POST['milestone_id'])) && isset($_POST['name']) &&
              isset($_POST['description']) && isset($_POST['is_private']))
          {
            $this->mC_Tasklist->AddTasklist($_POST['milestone_id'], $this->mProjectID, $_POST['name'], $_POST['description'], $_POST['is_private']);
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
    catch (TasklistAddException $e)
    {
      $this->mMessage = $message['tasklist_add'];
      $this->mLeaveFlag = true;
    }
  }
}

?>
