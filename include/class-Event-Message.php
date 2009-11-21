<?php
/*
 * OPMS
 * class-event-message.php
 * Created on 2006/12/11 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 * $HeadURL$
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class handler_Message implements EventHandler
{
  private $handle;
  
  function __construct($event_handle)
  {
  	$this->handle = $event_handle;
  }
  
  function handled_event()
  {
    global $timer, $error_message, $message;
  	$page = new Page();
  	$page->assign('message', "");
  	$pageTitle = set_title("訊息列表");
  	$pageContentBase = "standard/message.tpl";
  	$pageContentCell = "standard/blank.tpl";

    if (isset($_GET['action']))
    {
      try
      {
        switch ($_GET['action'])
        {
   	      case 'Add':
   	        if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
            {
     	      $pageTitle = set_title("新增訊息");
      	      $pageContentCell = "standard/message-add.tpl";
            }
            else
              throw new PermissionException;      	    	
      	    break;

      	  case 'Del':
            check_request_message_id();
            $pageTitle = set_title("刪除訊息");
            $pageContentCell = "standard/message-del.tpl";
      	    break;

          case 'Edit':
            check_request_message_id();
            $pageTitle = set_title("編輯訊息");
            $pageContentCell = "standard/message-edit.tpl";
            break;

      	  case 'View':
      	    check_request_message_id();
      	    $pageTitle = set_title("檢視訊息");
      	    $pageContentCell = "standard/message-one.tpl";
      	    break;

      	  case 'ListAllNew':
      	    $pageTitle = set_title("檢視所有訊息");
      	    $pageContentCell = "standard/message-list-allnew.tpl";
      	    break;

      	  case 'List':
      	  default:
      	    $pageTitle = set_title("訊息清單");
      	    $pageContentCell = "standard/message-list.tpl";
      	    break;
        }
      }
      catch (ProjectIDException $e)
      {
      	$page->assign('message', $error_message['project_not_found']);
      	log_error('project_not_found');
      }
      catch (PermissionException $e)
      {
      	$page->assign('message', $error_message['permission_not_enough']);
      	log_error('permission_not_enough');
      }
      catch (MessageIDException $e)
      {
      	$page->assign('message', $error_message['message_not_found']);
      	log_error('message_not_found');
      }
      catch (MilestoneIDException $e)
      {
      	$page->assign('message', $error_message['milestone_not_found']);
      	log_error('milestone_not_found');
      }
    }
    else
    {
      $pageTitle = set_title("訊息列表");
      $pageContentCell = "standard/message-list.tpl";
    }

  	$timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->assign('page_title', $pageTitle);
  	$page->assign('pageContentCell', $pageContentCell);
  	$page->display ($pageContentBase);
  }
}
?>
