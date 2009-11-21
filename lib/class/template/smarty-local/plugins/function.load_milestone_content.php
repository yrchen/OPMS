<?php
/*
 * OPMS
 * function.load_milestone_content.php
 * Created on 2006/12/18 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_milestone_content.php $
 */

function smarty_function_load_milestone_content($params, $smarty)
{
  $milestone_content = new MilestoneContent();
  $milestone_content->init();
  $smarty->assign($params['assign'], $milestone_content);
}

class MilestoneContent
{
  public $mMilestoneID;
  public $mMilestoneContent;

  private $mC_Milestone;
  
  function __construct()
  {
  	$this->mC_Milestone = new C_Milestone();
  	
  	if (isset($_GET['id']))
  	  $this->mMilestoneID = (int)$_GET['id'];
  	else
  	  throw new MilestoneIDException;
  }
  
  function init()
  {
    $this->mMilestoneContent = $this->mC_Milestone->GetMilestoneContent($this->mMilestoneID);
  }
}
?>
