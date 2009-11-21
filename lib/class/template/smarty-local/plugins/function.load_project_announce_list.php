<?php
/*
 * OPMS
 * function.load_project_announce_list.php
 * Created on 2006/12/22 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_project_announce_list.php $
 */

function smarty_function_load_project_announce_list($params, $smarty)
{
  $projec_announce_list = new ProjectAnnounceList();
  $projec_announce_list->init();
  $smarty->assign($params['assign'], $projec_announce_list);
}

class ProjectAnnounceList
{
  public $mAnnounceList;
  public $mAnnounceRead;

  private $mC_Announce;
  private $mProjectID;
  
  function __construct()
  {
  	$this->mC_Announce = new C_Announce();
    
    if (isset($_GET['active_project']))
      $this->mProjectID = (int)$_GET['active_project'];  	
  }
  
  function init()
  {
    $this->mAnnounceList = $this->mC_Announce->GetProjectAnnounceList($this->mProjectID);
    
    for ($i = 0; $i < count($this->mAnnounceList); $i++)
    {
      $announce_id = $this->mAnnounceList[$i]['id'];
      $this->mAnnounceRead[$i] = $this->mC_Announce->CheckAnnounceRead($announce_id);
    }
  }
}

?>
