<?php
/*
 * OPMS
 * class-event-auth.php
 * Created on 2006/12/13 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 * $HeadURL$
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class handler_Auth implements EventHandler
{
  private $handle;
  
  function __construct($event_handle)
  {
  	$this->handle = $event_handle;
  }
  
  function handled_event()
  {
    global $config, $timer;
  	$page = new Page();
    $pageTitle = set_title("認證");
  	$pageContentBase = "standard/blank.tpl";

    if (isset($_GET['action']))
    {
      switch ($_GET['action'])
      {
      	case 'Login':
          if (!isset($_SESSION['valid_user']))
          {
            $page->assign('page_title', set_title("登入"));
            $page->assign('page_style', "style/WordPress/wp-admin.css");
            $page->assign('page_redirect', "main.php");
            $pageContentBase = "standard/login.tpl";
          }
          break;

        case 'Logout':
          if (isset($_SESSION['valid_user']))
          {
            try
            {
  	          unset($_SESSION['valid_user']);
              session_destroy();

              header("Location: " . $config['site_url'] . "index.php");
            }
            catch (Exception $e)
            {
              // yrchen.061022: 已經登入，但無法登出
              header("Location: " . $config['site_url'] . "error.php");
            }
          }
          else
          {
            // yrchen.061022: 尚未登入，但是不知道為啥跑來這
            header("Location: " . $config['site_url'] . "login.php");
          }
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
