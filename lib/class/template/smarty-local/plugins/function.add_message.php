<?php
/*
 * OPMS
 * function.add_message.php
 * Created on 2006/12/18 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.add_message.php $
 */

function smarty_function_add_message($params, $smarty)
{
  $add_message = new AddMessage();
  $add_message->init();
  $smarty->assign($params['assign'], $add_message);
}

class AddMessage
{
  public $mMessage;
  public $mLeaveFlag;
  public $mMilestoneID;
  
  private $mC_Message;
  private $mProjectID;
  private $mMessageID;
  private $mAction;
  
  function __construct()
  {
  	$this->mC_Message = new C_Message();
    $this->mProjectID = (int)$_GET['active_project'];
    $this->mAction = "";
    $this->mMilestoneID = 0;
    $this->mLeaveFlag = false;

  	foreach ($_POST as $key => $value)
  	  if (substr($key, 0, 6) == "submit")
  	  {
  	  	$last_underscore = strrpos($key, "_");
  	  	$this->mAction = substr($key, strlen("submit_"), $last_underscore - strlen("submit_"));
  	  	$this->mProjectID = substr($key, $last_underscore + 1);

  	  	break;	//yrchen.061213: jump out foreach
  	  }
  	  
  	if (isset($_GET['milestone_id']))
  	  $this->mMilestoneID = $_GET['milestone_id'];
  }
  
  function init()
  {
  	global $config, $message, $error_message;

    try
    {
      switch ($this->mAction)
  	  {
  	    case 'add_message':
          if (isset($_POST['milestone_id'])     && isset($_POST['title']) &&
              isset($_POST['text'])             && isset($_POST['additional_text']) && 
              isset($_POST['is_important'])     && isset($_POST['is_private']) && 
              isset($_POST['comments_enabled']) && isset($_POST['anonymous_comments_enabled']))
          {
            $this->mC_Message->DoAddMessage($_POST['milestone_id'], $this->mProjectID, $_POST['title'], 
                                            $_POST['text'], $_POST['additional_text'], $_POST['is_important'], 
                                            $_POST['is_private'], $_POST['comments_enabled'], $_POST['anonymous_comments_enabled']);
          }
          else
            throw new PostDataErrorException;
  	      break;
  	  
  	    case 'cancel':
  	      header("Location: " . $config['site_url'] . "main.php?event=Task&action=ViewList&id=" . $this->mMessageID . "&active_project=" . $this->mProjectID);
  	      break;

  	    default:
  	      break;
  	  }
    }
    catch (PostDataErrorException $e)
    {
      $this->mMessage = $error_message['post_data_error'];
    }
    catch (MessageAddException $e)
    {
      $this->mMessage = $message['message_add'];
      $this->mLeaveFlag = true;
    }
  }
}

?>
