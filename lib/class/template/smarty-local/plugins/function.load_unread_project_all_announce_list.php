<?php
/*
 * OPMS
 * function.load_unread_project_all_announce_list.php
 * Created on 2006/12/26 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_unread_project_all_announce_list.php $
 */

function smarty_function_load_unread_project_all_announce_list($params, $smarty)
{
  $project_announce_list = new ProjectAnnounceList();
  $project_announce_list->init();
  $smarty->assign($params['assign'], $project_announce_list);
}

class ProjectAnnounceList
{
  public $mProjectList;
  public $mProjectAnnounceList;

  private $mC_Project;
  private $mC_Announce;
  
  function __construct()
  {
  	$this->mC_Project = new C_Project();
    $this->mC_Announce = new C_Announce();
  }

  function init()
  {
    $this->mProjectList = $this->mC_Project->GetMyProjectList();

    for ($i = 0; $i < count($this->mProjectList); $i++)
    {
      $project_id = $this->mProjectList[$i]['project_id'];
      $this->mProjectAnnounceList[$i] = $this->mC_Announce->CheckProjectNew($project_id);
    }
  }
}
?>
