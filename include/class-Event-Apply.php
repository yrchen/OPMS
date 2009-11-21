<?php
/*
 * OPMS
 * class-Event-Apply.php
 * Created on 2006/12/27 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Event-Apply.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class handler_Apply implements EventHandler
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
  	$page->assign('message', "");
  	$pageTitle = set_title("申請列表");
  	$pageContentBase = "standard/apply.tpl";
  	$pageContentCell = "standard/blank.tpl";

    if (isset($_GET['action']))
    {
      try
      {
        switch ($_GET['action'])
        {
      	  case 'List':
      	    $pageTitle = set_title("可申請事項清單");
      	    $pageContentCell = "standard/apply-list.tpl";
            break;

      	  case 'ListLiveProject':
      	    $pageTitle = set_title("可申請加入專案清單");
      	    $pageContentCell = "standard/apply-project-list.tpl";
            break;

      	  case 'JoinProject':
      	    $pageTitle = set_title("申請加入專案");
      	    $pageContentCell = "standard/apply-project-join.tpl";
      	    break;

      	  case 'LeaveProject':
      	    $pageTitle = set_title("取消申請加入專案");
      	    $pageContentCell = "standard/apply-project-leave.tpl";
      	    break;

      	  case 'My':
      	  default:
      	    $pageTitle = set_title("我目前的申請");
      	    $pageContentCell = "standard/apply-my.tpl";
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
      $pageTitle = set_title("我目前的申請");
      $pageContentCell = "standard/apply-my.tpl";
    }

  	$timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->assign('page_title', $pageTitle);
  	$page->assign('pageContentCell', $pageContentCell);
  	$page->display ($pageContentBase);
  }
}
?>
