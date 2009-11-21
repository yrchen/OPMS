<?php
/*
 * OPMS
 * function.load_apply_project_list.php
 * Created on 2006/12/28 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_apply_project_list.php $
 */

function smarty_function_load_apply_project_list($params, $smarty)
{
  $apply_project_list = new ApplyProjectList();
  $apply_project_list->init();
  $smarty->assign($params['assign'], $apply_project_list);
}

class ApplyProjectList
{
  public $mApplyProjectList;
  public $mApplyProjectUser;
  public $mApplyProjectExist;

  private $mC_ApplyProject;
  
  function __construct()
  {
  	$this->mC_ApplyProject = new C_ApplyProject();
  }
  
  function init()
  {
    $this->mApplyProjectList = $this->mC_ApplyProject->GetAllProjectList();
    
    for ($i = 0; $i < count($this->mApplyProjectList); $i++)
    {
      $project_id = $this->mApplyProjectList[$i]['id'];
      $this->mApplyProjectUser[$i] = $this->mC_ApplyProject->GetApplyProjectUser($project_id);
      $this->mApplyProjectExist[$i] = $this->mC_ApplyProject->CheckApplyProjectExist($project_id, get_current_user_id());
    }
  }
}
?>
