<?php
/*
 * OPMS
 * class-event-main.php
 * Created on 2006/12/16 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 * $HeadURL$
 */

defined('_OPMSEXEC') or die('Restricted access');

class handler_Main implements EventHandler
{
  private $handle;
  
  function __construct($event_handle)
  {
  	$this->handle = $event_handle;
  }
  
  function handled_event()
  {
  	global $timer;
  	$page = new Page();
  	$page->assign('message', "");
  	$pageTitle = set_title("Dashboard");
  	$pageContentBase = "standard/main.tpl";
  	$pageContentCell = "standard/blank.tpl";

    $timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->assign('page_title', $pageTitle);
  	$page->assign('pageContentCell', $pageContentCell);
  	$page->display($pageContentBase);
  }
}
?>
