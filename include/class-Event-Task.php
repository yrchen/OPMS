<?php
/*
 * OPMS
 * class-event-task.php
 * Created on 2006/12/11 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 * $HeadURL$
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class handler_Task implements EventHandler
{
  private $handle;
  
  function __construct($event_handle)
  {
  	$this->handle = $event_handle;
  }
  
  function handled_event()
  {
    global $timer, $message, $error_message;
  	$page = new Page();
  	$page->assign('error_message', "");
  	$pageTitle = set_title("工作列表");
  	$pageContentBase = "standard/task.tpl";
  	$pageContentCell = "standard/blank.tpl";

    if (isset($_GET['action']))
    {
      try
      {
        switch ($_GET['action'])
        {
      	  case 'AddList':
      	    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
      	    {
      	      $pageTitle = set_title("新增工作清單");
      	      $pageContentCell = "standard/tasklist-add.tpl";
      	    }
      	    else
      	      throw new PermissionException;
            break;
      	  
      	  case 'AddTask':
      	    if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
      	    {
      	      check_request_tasklist_id();
      	      $pageTitle = set_title("新增工作");
      	      $pageContentCell = "standard/task-add.tpl";
      	    }
      	    else
      	      throw new PermissionException;
            break;

      	  case 'DelList':
      	    check_request_tasklist_id();
      	    $pageTitle = set_title("刪除工作清單");
            $pageContentCell = "standard/tasklist-del.tpl";
            break;

      	  case 'ListDelList':
      	    $pageTitle = set_title("刪除工作清單");
            $pageContentCell = "standard/tasklist-del-list.tpl";
            break;

          case 'DelTask':
            check_request_task_id();
            $pageTitle = set_title("刪除工作");
      	    $pageContentCell = "standard/task-del.tpl";
      	    break;

          case 'ListDelTask':
            $pageTitle = set_title("刪除工作");
      	    $pageContentCell = "standard/task-del-list.tpl";
      	    break;

          case 'EditList':
      	    check_request_tasklist_id();
      	    $pageTitle = set_title("編輯工作清單");
            $pageContentCell = "standard/tasklist-edit.tpl";
            break;
          
          case 'ListEditList':
      	    $pageTitle = set_title("編輯工作清單");
            $pageContentCell = "standard/tasklist-edit-list.tpl";
            break;            

          case 'EditTask':
      	    check_request_task_id();
            $pageTitle = set_title("編輯工作");
            $pageContentCell = "standard/task-edit.tpl";
      	    break;

          case 'ListEditTask':
            $pageTitle = set_title("編輯工作");
            $pageContentCell = "standard/task-edit-list.tpl";
      	    break;

      	  case 'ViewList':
      	    check_request_tasklist_id();
      	    $pageTitle = set_title("檢視工作清單");
      	    $pageContentCell = "standard/tasklist-one.tpl";
            break;

      	  case 'ViewTask':
     	    check_request_task_id();
            $pageTitle = set_title("檢視工作");
      	    $pageContentCell = "standard/task-one.tpl";
      	    break;

          case 'ListAll':
            $pageTitle = set_title("檢視所有工作");
            $pageContentCell = "standard/task-list.tpl";
            break;

          case 'ListAllNew':
      	    $pageTitle = set_title("檢視所有工作");
      	    $pageContentCell = "standard/task-list-allnew.tpl";
      	    break;

          case 'List':
      	  default:
   	        if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
      	    {
              $pageTitle = set_title("工作清單");
    	      $pageContentCell = "standard/tasklist-list.tpl";
      	    }
      	    else
      	      throw new PermissionException;
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
      catch (TaskIDException $e)
      {
      	$page->assign('message', $error_message['task_not_found']);
      	log_error('task_not_found');
      }
      catch (TaskListIDException $e)
      {
      	$page->assign('message', $error_message['tasklist_not_found']);
      	log_error('tasklist_not_found');
      }
    }
    else
    {
      $pageTitle = set_title("工作清單");
      $pageContentCell = "standard/task-list.tpl";
    }

  	$timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->assign('page_title', $pageTitle);
  	$page->assign('pageContentCell', $pageContentCell);
  	$page->display ($pageContentBase);
  }
}
?>
