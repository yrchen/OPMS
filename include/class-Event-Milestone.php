<?php
/*
 * OPMS
 * class-event-milestone.php
 * Created on 2006/12/11 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Event-Milestone.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class handler_Milestone implements EventHandler
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
  	$pageTitle = set_title("目標列表");
  	$pageContentBase = "standard/milestone.tpl";
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
              $pageTitle = set_title("新增目標");
      	      $pageContentCell = "standard/milestone-add.tpl";
            }
            else
      	      throw new PermissionException;      	    	
      	    break;

      	  case 'Del':
            check_request_milestone_id();
            $pageTitle = set_title("刪除目標");
            $pageContentCell = "standard/milestone-del.tpl";
      	    break;

          case 'Edit':
            check_request_milestone_id();
            $pageTitle = set_title("編輯目標");
            $pageContentCell = "standard/milestone-edit.tpl";
            break;

      	  case 'View':
      	    check_request_milestone_id();
      	    $pageTitle = set_title("檢視目標");
      	    $pageContentCell = "standard/milestone-one.tpl";
      	    break;

          case 'ListAllNew':
      	    $pageTitle = set_title("檢視所有目標");
      	    $pageContentCell = "standard/milestone-list-allnew.tpl";
      	    break;

      	  case 'List':
      	  default:
            if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
            {
      	      $pageTitle = set_title("目標清單");
      	      $pageContentCell = "standard/milestone-list.tpl";
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
      catch (MilestoneIDException $e)
      {
      	$page->assign('message', $error_message['milestone_not_found']);
      	log_error('milestone_not_found');
      }
    }
    else
    {
      $pageTitle = set_title("目標清單");
      $pageContentCell = "standard/milestone-list.tpl";
    }

  	$timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->assign('page_title', $pageTitle);
  	$page->assign('pageContentCell', $pageContentCell);
  	$page->display ($pageContentBase);
  }
}
?>
