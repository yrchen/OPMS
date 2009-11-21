<?php
/*
 * OPMS
 * function.load_project_milestone.php
 * Created on 2006/12/11 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_project_milestone.php $
 */

function smarty_function_load_project_milestone($params, $smarty)
{
  $project_milestone = new ProjectMilestone();
  $project_milestone->init();
  $smarty->assign($params['assign'], $project_milestone);
}

class ProjectMilestone
{
  public $mProjectID;
  public $mProjectMilestone;

  private $mC_Milestone;
  
  function __construct()
  {
  	$this->mC_Milestone = new C_Milestone();
  	
  	if (isset($_GET['active_project']))
  	  $this->mProjectID = (int)$_GET['active_project'];
  	else
  	  throw new ProjectIDException;
  }
  
  function init()
  {
    $this->mProjectMilestone = $this->mC_Milestone->GetProjectMilestoneList($this->mProjectID);
  }
}
?>
