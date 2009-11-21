<?php
/*
 * OPMS
 * class-event-project.php
 * Created on 2006/12/11 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 * $HeadURL$
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class handler_Project implements EventHandler
{
  private $handle;
  
  function __construct($event_handle)
  {
  	$this->handle = $event_handle;
  }
  
  function handled_event()
  {
  	global $timer, $error_message;
  	$page = new Page();
  	$page->assign('message', "");
  	$pageTitle = set_title("專案列表");
  	$pageContentBase = "standard/project.tpl";
  	$pageContentCell = "standard/blank.tpl";

    if (isset($_GET['action']))
    {
      try
      {
        switch ($_GET['action'])
        {
          case 'Add':
        	$pageTitle = set_title("新增專案");
        	$pageContentCell = "standard/project-add.tpl";
      	    break;

          case 'Del':
            $pageTitle = set_title("刪除專案");
            $pageContentCell = "standard/project-del.tpl";
            break;

          case 'Edit':
            if (check_user_permission() >= PROJECT_LEADER_PERMISSION)
            {
              $pageTitle = set_title("編輯專案");
              $pageContentCell = "standard/project-edit.tpl";
      	    }
      	    else
      	      throw new PermissionException;
            
            break;

          case 'Member':
            $pageTitle = set_title("檢視專案成員");
            $pageContentCell = "standard/project-member.tpl";
            break;

      	  case 'My':
      	    $pageTitle = set_title("我所參與的專案");
      	    $pageContentCell = "standard/project-my.tpl";
      	    break;

      	  case 'View':
            if (check_user_permission() >= 1)
            {
              $pageTitle = set_title("檢視專案");
              $pageContentCell = "standard/project-one.tpl";
      	    }
      	    else
      	      throw new PermissionException;

      	    break;

          case 'List':
      	  default:
      	    $pageTitle = set_title("專案清單");
      	    $pageContentCell = "standard/project-list.tpl";
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
    }
    else
    {
      $pageTitle = set_title("專案清單");
      $pageContentCell = "standard/project-list.tpl";
    }

    $timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->assign('page_title', $pageTitle);
  	$page->assign('pageContentCell', $pageContentCell);
  	$page->display($pageContentBase);
  }
}
?>
