<?php
/*
 * OPMS
 * function.load_message_content.php
 * Created on 2007/1/1 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_message_content.php $
 */

function smarty_function_load_message_content($params, $smarty)
{
  $message_content = new MessageContent();
  $message_content->init();
  $smarty->assign($params['assign'], $message_content);
}

class MessageContent
{
  public $mMessageID;
  public $mMessageContent;

  private $mC_Message;
  
  function __construct()
  {
  	$this->mC_Message = new C_Message();
  	
  	if (isset($_GET['id']))
  	  $this->mMessageID = (int)$_GET['id'];
  	else
  	  throw new MessageIDException;
  }
  
  function init()
  {
    $this->mMessageContent = $this->mC_Message->GetMessageContent($this->mMessageID);
  }
}

?>
