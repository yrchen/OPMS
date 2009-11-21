<?php
/*
 * OPMS
 * function.add_milestone.php
 * Created on 2006/12/17 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.add_milestone.php $
 */

function smarty_function_add_milestone($params, $smarty)
{
  $add_milestone = new AddMilestone();
  $add_milestone->init();
  $smarty->assign($params['assign'], $add_milestone);
}

class AddMilestone
{
  public $mMessage;
  public $mLeaveFlag;
  
  private $mC_Milestone;
  private $Project_ID;
  private $mAction;
  
  function __construct()
  {
  	$this->mC_Milestone = new C_Milestone();
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
  }
  
  function init()
  {
  	global $config, $message, $error_message;

    try
    {
      switch ($this->mAction)
  	  {
  	    case 'add_milestone':
  	      if (isset($_POST['milestone_name']) &&
              isset($_POST['milestone_description']) && isset($_POST['milestone_due_date']) &&
              isset($_POST['milestone_assigned_to_user_id']) && isset($_POST['is_private']))
          {
            $this->mC_Project->DoUpdateProjectContent($this->mProjectID, $_POST['milestone_name'], $_POST['milestone_description'], $_POST['milestone_due_date'], $_POST['milestone_assigned_to_user_id'], $_POST['is_private']);
          }
          else
            throw new PostDataErrorException;
  	      break;
  	  
  	    case 'cancel':
  	      header("Location: " . $config['site_url'] . "main.php?event=Milestone&action=List&active_project=" . $this->mProjectID);
  	      break;

  	    default:
  	      break;
  	  }
    }
    catch (PostDataErrorException $e)
    {
      $this->mMessage = $error_message['post_data_error'];
    }
    catch (MilestoneAddException $e)
    {
      $this->mMessage = $message['milestone_add'];
      $this->mLeaveFlag = true;
    }
  }
}
?>
