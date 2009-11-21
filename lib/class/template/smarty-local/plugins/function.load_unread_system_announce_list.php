<?php
/*
 * OPMS
 * function.load_unread_system_announce_list.php
 * Created on 2006/12/5 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_unread_system_announce_list.php $
 */

function smarty_function_load_unread_system_announce_list($params, $smarty)
{
  $unread_announce_list = new UnreadSystemAnnounceList();
  $unread_announce_list->init();
  $smarty->assign($params['assign'], $unread_announce_list);
}

class UnreadSystemAnnounceList
{
  public $mAnnounceList;
  private $mC_Announce;
  
  function __construct()
  {
  	$this->mC_Announce = new C_Announce();
  }
  
  function init()
  {
    $this->mAnnounceList = $this->mC_Announce->GetSystemNewList();
  }
}
?>
