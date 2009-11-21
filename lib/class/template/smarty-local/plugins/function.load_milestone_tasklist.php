<?php
/*
 * OPMS
 * function.load_milestone_tasklist.php
 * Created on 2007/1/2 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_milestone_tasklist.php $
 */

function smarty_function_load_milestone_tasklist($params, $smarty)
{
  $milestone_tasklist = new MilestoneTasklist();
  $milestone_tasklist->init();
  $smarty->assign($params['assign'], $milestone_tasklist);
}

class MilestoneTasklist
{
  public $mMilestoneID;
  public $mMilestoneTasklist;

  private $mC_Milestone;
  
  function __construct()
  {
  	$this->mC_Tasklist = new C_Task();
  	
  	if (isset($_GET['id']))
  	  $this->mMilestoneID = (int)$_GET['id'];
  	else if (isset($_GET['milestone_id']))
  	  $this->mMilestoneID = (int)$_GET['milestone_id'];
  	else
  	  throw new MilestoneIDException;
  }
  
  function init()
  {
    $this->mMilestoneTasklist = $this->mC_Tasklist->GetMilestoneTasklist($this->mMilestoneID);
  }
}

?>
