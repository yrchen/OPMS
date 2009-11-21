<?php
/*
 * OPMS
 * class-event-page.php
 * Created on 2006/12/13 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 * $HeadURL$
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class handler_Page implements EventHandler
{
  private $handle;
  
  function __construct($event_handle)
  {
  	$this->handle = $event_handle;
  }
  
  function handled_event()
  {
    global $setting, $timer;
  	$page = new Page();
    $pageTitle = set_title("頁面檢視");
  	$pageContentBase = "standard/blank.tpl";

    if (isset($_GET['action']))
    {
      switch ($_GET['action'])
      {
      	case 'View':
      	  if (isset($_GET['file']) && file_exists($setting['path'] . $setting['tpl'] . $_GET['file']))
      	  	$pageContentBase = $_GET['file'];
      	  break;

      	default:
      	  break;
      }
    }

  	$timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->assign('page_title', $pageTitle);
  	$page->display($pageContentBase);
  }
}
?>
