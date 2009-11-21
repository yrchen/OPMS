<?php
/*
 * OPMS
 * function.load_milestone_message.php
 * Created on 2007/1/2 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_milestone_message.php $
 */

function smarty_function_load_milestone_message($params, $smarty)
{
  $milestone_message = new MilestoneMessage();
  $milestone_message->init();
  $smarty->assign($params['assign'], $milestone_message);
}

class MilestoneMessage
{
  public $mMilestoneID;
  public $mMilestoneMessage;

  private $mC_Milestone;
  
  function __construct()
  {
  	$this->mC_Message = new C_Message();
  	
  	if (isset($_GET['id']))
  	  $this->mMilestoneID = (int)$_GET['id'];
  	else if (isset($_GET['milestone_id']))
  	  $this->mMilestoneID = (int)$_GET['milestone_id'];
  	else
  	  throw new MilestoneIDException;
  }
  
  function init()
  {
    $this->mMilestoneMessage = $this->mC_Message->GetMilestoneMessage($this->mMilestoneID);
  }
}
?>
