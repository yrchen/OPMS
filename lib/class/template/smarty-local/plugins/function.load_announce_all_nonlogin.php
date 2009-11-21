<?php
/*
 * OPMS
 * function.load_announce_all_nonlogin.php
 * Created on 2006/12/26 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_announce_all_nonlogin.php $
 */

function smarty_function_load_announce_all_nonlogin($params, $smarty)
{
  $announce_all = new AnnounceAll();
  $announce_all->init();
  $smarty->assign($params['assign'], $announce_all);
}

class AnnounceAll
{
  public $mSystemAnnounceList;

  private $mC_Announce;
  
  function __construct()
  {
  	$this->mC_Announce = new C_Announce();
  }
  
  function init()
  {
    $this->mSystemAnnounceList = $this->mC_Announce->GetSystemAnnounceList();
  }
}

?>
