<?php
/*
 * OPMS
 * function.load_project_member.php
 * Created on 2006/12/31 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_project_member.php $
 */

function smarty_function_load_project_member($params, $smarty)
{
  $project_member = new ProjectMember();
  $project_member->init();
  $smarty->assign($params['assign'], $project_member);
}

class ProjectMember
{
  public $mProjectID;
  public $mProjectMember;

  private $mC_Member;
  
  function __construct()
  {
  	$this->mC_Project = new C_Project();
  	
  	if (isset($_GET['active_project']))
  	  $this->mProjectID = (int)$_GET['active_project'];
  	else
  	  throw new ProjectIDException;
  }
  
  function init()
  {
    $this->mProjectMember = $this->mC_Project->GetProjectMember($this->mProjectID);
  }
}
?>
