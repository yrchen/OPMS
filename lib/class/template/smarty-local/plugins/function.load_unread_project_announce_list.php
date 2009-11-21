<?php
/*
 * OPMS
 * function.load_unread_project_announce_list.php
 * Created on 2006/12/6 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_unread_project_announce_list.php $
 */

function smarty_function_load_unread_project_announce_list($params, $smarty)
{
  $unread_announce_list = new UnreadProjectAnnounceList();
  $unread_announce_list->init();
  $smarty->assign($params['assign'], $unread_announce_list);
}

class UnreadProjectAnnounceList
{
  public $mAnnounceList;
  public $mProjeceID;
  private $mC_Announce;
  
  function __construct()
  {
  	$this->mC_Announce = new C_Announce();

  	if (isset($_GET['active_project']))
  	  $this->mProjectID = (int)$_GET['active_project'];
  	else
  	  throw new ProjectIDException;
  }
  
  function init()
  {
    $this->mAnnounceList = $this->mC_Announce->CheckProjectNew($this->mProjectID);
  }
}
?>
