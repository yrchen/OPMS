<?php
/*
 * OPMS
 * function.load_project_selector.php
 * Created on 2006/12/15 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 * $HeadURL$
 */

function smarty_function_load_project_selector($params, $smarty)
{
  $project_selector = new ProjectSelector();
  $project_selector->init();
  $smarty->assign($params['assign'], $project_selector);
}

class ProjectSelector
{
  public $mProjectShortName;
  public $mProjectContent;
  public $mProjectID;
  
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
  	$this->mProjectShortName = $this->mC_Project->GetProjectShortName($this->mProjectID);
  }
}
?>
