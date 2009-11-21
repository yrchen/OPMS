<?php
/*
 * OPMS
 * function.load_project_content.php
 * Created on 2006/12/11 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_project_content.php $
 */

function smarty_function_load_project_content($params, $smarty)
{
  $project_content = new ProjectContent();
  $project_content->init();
  $smarty->assign($params['assign'], $project_content);
}

class ProjectContent
{
  public $mProjectID;
  public $mProjectContent;
  public $mProjectMember;
  public $mProjectTeacher;
  private $mC_Project;
  
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
    $this->mProjectContent = $this->mC_Project->GetProjectContent($this->mProjectID);
    $this->mProjectMember = $this->mC_Project->GetProjectMember($this->mProjectID);
    $this->mProjectTeacher = $this->mC_Project->GetProjectTeacher($this->mProjectID);
  }
}
?>
