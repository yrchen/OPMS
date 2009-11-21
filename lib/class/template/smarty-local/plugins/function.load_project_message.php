<?php
/*
 * OPMS
 * function.load_project_message.php
 * Created on 2006/12/30 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_project_message.php $
 */

function smarty_function_load_project_message($params, $smarty)
{
  $project_message = new ProjectMessage();
  $project_message->init();
  $smarty->assign($params['assign'], $project_message);
}

class ProjectMessage
{
  public $mProjectID;
  public $mProjectMessage;

  private $mC_Message;
  
  function __construct()
  {
  	$this->mC_Message = new C_Message();
  	
  	if (isset($_GET['active_project']))
  	  $this->mProjectID = (int)$_GET['active_project'];
  	else
  	  throw new ProjectIDException;
  }
  
  function init()
  {
    $this->mProjectMessage = $this->mC_Message->GetProjectMessageList($this->mProjectID);
  }
}
?>
