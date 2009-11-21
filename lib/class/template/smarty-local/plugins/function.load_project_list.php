<?php
/*
 * OPMS
 * function.load_project_list.php
 * Created on 2006/12/3 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_project_list.php $
 */

function smarty_function_load_project_list($params, $smarty)
{
  $project_list = new ProjectList();
  $project_list->init();
  $smarty->assign($params['assign'], $project_list);
}

class ProjectList
{
  public $mProjectList;
  public $mProjectMember;
  public $mProjectTeacher;

  private $mC_Project;
  
  function __construct()
  {
  	$this->mC_Project = new C_Project();
  }
  
  function init()
  {
    $this->mProjectList = $this->mC_Project->GetProjectList();
    
    for ($i = 0; $i < count($this->mProjectList); $i++)
    {
      $project_id = $this->mProjectList[$i]['project_id'];
      $this->mProjectMember[$i] = $this->mC_Project->GetProjectMember($project_id);
      $this->mProjectTeacher[$i] = $this->mC_Project->GetProjectTeacher($project_id);
    }
  }
}
?>