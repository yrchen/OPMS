<?php
/*
 * OPMS
 * class-event-file.php
 * Created on 2006/12/11 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 * $HeadURL$
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class handler_File implements EventHandler
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
  	$pageTitle = set_title("檔案列表");
  	$pageContentBase = "standard/file.tpl";
  	$pageContentCell = "standard/blank.tpl";
	
	if (isset($_GET['action']))
    {
      try
      {
        if (check_user_permission() >= PROJECT_MEMBER_PERMISSION)
        {
          switch ($_GET['action'])
          {
      	    case 'Add':
     	      $pageTitle = set_title("新增檔案");
      	      $pageContentCell = "standard/file-add.tpl";      	    	
      	      break;

      	    case 'Del':
              check_request_file_id();
              $pageTitle = set_title("刪除檔案");
              $pageContentCell = "standard/file-del.tpl";
      	      break;

            case 'Edit':
              check_request_file_id();
              $pageTitle = set_title("編輯檔案");
              $pageContentCell = "standard/file-edit.tpl";
              break;

      	    case 'List':
      	      check_request_file_id();
      	      $pageTitle = set_title("檢視檔案");
      	      $pageContentCell = "standard/file-view.tpl";
      	      break;
          }
        }
        else
          throw new PermissionException;      	
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
      catch (FileIDException $e)
      {
      	$page->assign('message', $error_message['file_not_found']);
      	log_error('message_not_found');
      }
    }
    else
    {
      $pageTitle = set_title("檔案列表");
      $pageContentCell = "standard/file-list.tpl";
    }

  	$timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->assign('page_title', $pageTitle);
  	$page->assign('pageContentCell', $pageContentCell);
  	$page->display ($pageContentBase);
  }
}
?>
