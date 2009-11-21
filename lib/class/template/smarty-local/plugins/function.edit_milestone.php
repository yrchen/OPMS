<?php
/*
 * OPMS
 * function.edit_milestone.php
 * Created on 2006/12/18 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.edit_milestone.php $
 */

function smarty_function_edit_milestone($params, $smarty)
{
  $edit_milestone = new EditMilestone();
  $edit_milestone->init();
  $smarty->assign($params['assign'], $edit_milestone);
}

class EditMilestone
{
  public $mMilestoneID;
  public $mMessage;
  public $mMilestoneContent;
  public $mLeaveFlag;
  
  private $mC_Milestone;
  private $mAction;
  private $mProjectID;
  
  function __construct()
  {
  	$this->mC_Milestone = new C_Milestone();
    $this->mMilestoneID = 0;
    $this->mProjectID = (int)$_GET['active_project'];
    $this->mAction = "";
    $this->mLeaveFlag = false;

  	if (isset($_GET['id']))
  	  $this->mMilestoneID = (int)$_GET['id'];
  	else if (isset($_GET['milestone_id']))
  	  $this->mMilestoneID = (int)$_GET['milestone_id'];
  	
  	foreach ($_POST as $key => $value)
  	  if (substr($key, 0, 6) == "submit")
  	  {
  	  	$last_underscore = strrpos($key, "_");
  	  	$this->mAction = substr($key, strlen("submit_"), $last_underscore - strlen("submit_"));
  	  	$this->mMilestoneID = substr($key, $last_underscore + 1);

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
  	    case 'edit_milestone':
  	      if (isset($_POST['name']) &&
              isset($_POST['description']) && isset($_POST['due_date']) &&
              isset($_POST['assigned_to_user_id']) && isset($_POST['is_private']))
          {
            $this->mC_Project->UpdateMilestoneContent($this->mMilestoneID, $_POST['name'], $_POST['description'], $_POST['due_date'], $_POST['assigned_to_user_id'], $_POST['is_private']);
          }
          else
            throw new PostDataErrorException;
  	      break;
  	  
  	    case 'cancel':
  	      header("Location: " . $config['site_url'] . "main.php?event=Milestone&action=View&id=" . $this->mMilestoneID . "&active_project=" . $this->mProjectID);
  	      break;

  	    default:
  	      break;
  	  }
    }
    catch (PostDataErrorException $e)
    {
      $this->mMessage = $error_message['post_data_error'];
    }
    catch (MilestoneUpdateException $e)
    {
      $this->mMessage = $message['update'];
      $this->mLeaveFlag = true;
    }

  	$this->mMilestoneContent = $this->mC_Milestone->GetMilestoneContent($this->mMilestoneID);
  }
}
?>
