<?php
/*
 * OPMS
 * function.load_announce_content.php
 * Created on 2006/12/22 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_announce_content.php $
 */

function smarty_function_load_announce_content($params, $smarty)
{
  $announce_content = new AnnounceContent();
  $announce_content->init();
  $smarty->assign($params['assign'], $announce_content);
}

class AnnounceContent
{
  public $mAnnounceContent;
  public $mLeaveFlag;
  public $mReadFlag;
  public $mAnnounceID;
  public $mProjectID;
  public $mMessage;

  private $mC_Announce;
  private $mAction;
  
  function __construct()
  {
  	$this->mC_Announce = new C_Announce();
    $this->mAction = "";
    $this->mLeaveFlag = false;
    $this->mReadFlag = false;

    if(isset($_GET['id']))
      $this->mAnnounceID = (int)$_GET['id'];
    else
      throw new AnnounceIDException;

    if ($this->mC_Announce->CheckAnnounceRead($this->mAnnounceID))
      $this->mReadFlag = true;

    $this->mProjectID = $this->mC_Announce->GetAnnounceProjectID($this->mAnnounceID);

  	foreach ($_POST as $key => $value)
  	  if (substr($key, 0, 6) == "submit")
  	  {
  	  	$last_underscore = strrpos($key, "_");
  	  	$this->mAction = substr($key, strlen("submit_"), $last_underscore - strlen("submit_"));
  	  	$this->mAnnounceID = substr($key, $last_underscore + 1);

  	  	break;	//yrchen.061213: jump out foreach
  	  }
  }
  
  function init()
  {
    global $config, $message;

    $this->mAnnounceContent = $this->mC_Announce->GetAnnounceContent($this->mAnnounceID);
    
    try
    {
      switch ($this->mAction)
      {
      	case 'mark_read':
      	  $this->mC_Announce->MarkAnnounceUserRead($this->mAnnounceID);
      	  break;

      	case 'mark_unread':
      	  $this->mC_Announce->MarkAnnounceUserUnread($this->mAnnounceID);
      	  break;

  	    case 'cancel':
  	      if ($this->mProjectID > 0)
  	        header("Location: " . $config['site_url'] . "main.php?event=Announce&action=List&active_project=" . $this->mProjectID);
  	      else
  	        header("Location: " . $config['site_url'] . "main.php?event=Announce&action=ListAll");
  	      break;

  	    default:
  	      break;
      }
    }
    catch (AnnounceReadException $e)
    {
      $this->mMessage = $message['announce_read'];
      $this->mLeaveFlag = true;
    }
    catch (AnnounceUnreadException $e)
    {
      $this->mMessage = $message['announce_unread'];
      $this->mLeaveFlag = true;
    }
  }
}
?>
