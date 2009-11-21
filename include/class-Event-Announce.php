<?php
/*
 * OPMS
 * class-event-announce.php
 * Created on 2006/12/11 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Event-Announce.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class handler_Announce implements EventHandler
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
  	$pageTitle = set_title("公告列表");
  	$pageContentBase = "standard/announce.tpl";
  	$pageContentCell = "standard/blank.tpl";

    if (isset($_GET['action']))
    {
      try
      {
        switch ($_GET['action'])
        {
      	  case 'AddSystem':
      	    if (check_user_permission() >= SYSTEM_ADMIN_PERMISSION)
      	    {
              $pageTitle = set_title("新增系統公告");
              $pageContentCell = "standard/announce-system-add.tpl";      	    	
      	    }
      	    else
      	      throw new PermissionException;
      	    break;

      	  case 'Add':
      	    if (check_user_permission() >= PROJECT_LEADER_PERMISSION)
      	    {
              $pageTitle = set_title("新增公告");
              $pageContentCell = "standard/announce-project-add.tpl";
      	    }
      	    else
      	      throw new PermissionException;
      	    break;

      	  case 'DelSystem':
      	    if (check_user_permission() >= SYSTEM_ADMIN_PERMISSION)
      	    {
              check_request_announce_id();
              $pageTitle = set_title("刪除系統公告");
              $pageContentCell = "standard/announce-system-del.tpl";      	      	
      	    }
      	    else
      	      throw new PermissionException;
      	    break;

     	  case 'Del':
      	    if (check_user_permission() >= PROJECT_LEADER_PERMISSION)
      	    {
              check_request_announce_id();
              $pageTitle = set_title("刪除公告");
              $pageContentCell = "standard/announce-project-del.tpl";
      	    }
      	    else
      	      throw new PermissionException;
      	    break;

          case 'EditSystem':
      	    if (check_user_permission() >= SYSTEM_ADMIN_PERMISSION)
      	    {
              check_request_announce_id();
              $pageTitle = set_title("編輯系統公告");
              $pageContentCell = "standard/announce-system-edit.tpl";
      	    }
      	    else
      	      throw new PermissionException;
             break;

          case 'Edit':
      	    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
      	    {
              check_request_announce_id();
              $pageTitle = set_title("編輯公告");
              $pageContentCell = "standard/announce-project-edit.tpl";
      	    }
      	    else
      	      throw new PermissionException;
            break;

           case 'View':
             check_request_announce_id();
      	     $pageTitle = set_title("檢視公告");
      	     $pageContentCell = "standard/announce-one.tpl";
      	     break;

      	  case 'ListSystem':
      	    if (check_user_permission() >= SYSTEM_ADMIN_PERMISSION)
      	    {
      	      $pageTitle = set_title("系統公告清單");
      	      $pageContentCell = "standard/announce-system-list.tpl";
      	    }
      	    else
      	      throw new PermissionException;
      	    break;
      	    
      	  case 'List':
      	    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
      	    {
      	      $pageTitle = set_title("公告清單");
      	      $pageContentCell = "standard/announce-project-list.tpl";
      	    }
      	    else
      	      throw new PermissionException;
      	    break;
      	    
      	  case 'ListNew':
      	    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
      	    {
      	      $pageTitle = set_title("專案未讀公告清單");
      	      $pageContentCell = "standard/announce-project-new-list.tpl";
      	    }
      	    else
      	      throw new PermissionException;
      	    break;

      	  case 'ListAll':
      	    $pageTitle = set_title("所有公告清單");
      	    $pageContentCell = "standard/announce-all-list.tpl";
      	    break;

      	  case 'ListAllNew':
      	    $pageTitle = set_title("所有未讀公告清單");
      	    $pageContentCell = "standard/announce-allnew-list.tpl";
      	    break;

      	  default:
      	    throw new HandlerErrorException;
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
      catch (AnnounceIDException $e)
      {
      	$page->assign('message', $error_message['announce_not_found']);
      	log_error('announce_not_found');
      }
    }
    else
      throw new HandlerErrorException;

  	$timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->assign('page_title', $pageTitle);
  	$page->assign('pageContentCell', $pageContentCell);
  	$page->display ($pageContentBase);
  }
}
?>
