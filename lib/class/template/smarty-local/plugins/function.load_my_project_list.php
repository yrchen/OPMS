<?php
/*
 * OPMS
 * function.load_my_project_list.php
 * Created on 2006/12/11 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_my_project_list.php $
 */

function smarty_function_load_my_project_list($params, $smarty)
{
  $project_list = new ProjectList();
  $project_list->init();
  $smarty->assign($params['assign'], $project_list);
}

class ProjectList
{
  public $mProjectList;
  private $mC_Project;
  
  function __construct()
  {
  	$this->mC_Project = new C_Project();
  }
  
  function init()
  {
    $this->mProjectList = $this->mC_Project->GetMyProjectList();
  }
}

?>
