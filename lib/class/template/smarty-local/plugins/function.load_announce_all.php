<?php
/*
 * OPMS
 * function.load_announce_all.php
 * Created on 2006/12/24 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_announce_all.php $
 */

function smarty_function_load_announce_all($params, $smarty)
{
  $announce_all = new AnnounceAll();
  $announce_all->init();
  $smarty->assign($params['assign'], $announce_all);
}

class AnnounceAll
{
  public $mSystemAnnounceList;
  public $mProjectAnnounceList;
  public $mSystemAnnounceRead;
  public $mProjectAnnounceRead;

  private $mC_Announce;
  
  function __construct()
  {
  	$this->mC_Announce = new C_Announce();
  }
  
  function init()
  {
    $this->mSystemAnnounceList = $this->mC_Announce->GetSystemAnnounceList();
    for ($i = 0; $i < count($this->mSystemAnnounceList); $i++)
    {
      $announce_id = $this->mSystemAnnounceList[$i]['id'];
      $this->mSystemAnnounceRead[$i] = $this->mC_Announce->CheckAnnounceRead($announce_id);
    }

    $this->mProjectAnnounceList = $this->mC_Announce->GetProjectAllAnnounceList();
    for ($i = 0; $i < count($this->mProjectAnnounceList); $i++)
    {
      $announce_id = $this->mProjectAnnounceList[$i]['id'];
      $this->mProjectAnnounceRead[$i] = $this->mC_Announce->CheckAnnounceRead($announce_id);
    }
  }
}
?>
