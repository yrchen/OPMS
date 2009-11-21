<?php
/*
 * OPMS - Open Project Management System
 * function-misc.php
 * Created on 2006/10/24 by Chen YuRen (yrchen@ATCity.org)
 *
 * 其他函式
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-Misc.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

function js_alert($msg)
{
	if ($msg == "") return;
	
	echo "<script language='JavaScript'>";
	echo "alert(\"$msg\");";
	echo "</script>";

}


function js_alert2($msg)
{
	if ($msg == "") return;
	
	echo "<script language='JavaScript'>";
	echo "alert(\"$msg\");";
	echo "</script>";
	echo "<body onload = \"history.back();\">";

}

//
// check_session
// Action: Check if a session already exists, if not redirect to login.php
// Call: check_session ()
//
function check_session ()
{
   session_start ();
   session_fixid ();
   if (!session_is_registered ("sessid"))
   {
      header ("Location: " . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/login.php");
      exit;
   }
   $SESSID_USERNAME = $_SESSION['sessid']['username'];
   return $SESSID_USERNAME;
}

function check_user_session ()
{
   session_start ();
   session_fixid ();
   if (!session_is_registered ("userid"))
   {
      header ("Location: " . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/login.php");
      exit;
   }
   $USERID_USERNAME = $_SESSION['userid']['username'];
   return $USERID_USERNAME;
}

//
// session_fixid
// Action: should avoid 'session fixation'
// Call: session_fixid ()
//
function session_fixid ()
{
    if (!isset($_SESSION['exist']))
    {
        if ( !session_regenerate_id() ) die("Couldn't regenerate your session id.");
        $_SESSION['exist'] = true;
    }
}

//
// escape_string
// Action: Escape a string
// Call: escape_string (string string)
//
(ini_get('magic_quotes_gpc') ? ini_set('magic_quotes_runtime', '0') : '1');
(ini_get('magic_quotes_gpc') ? ini_set('magic_quotes_sybase', '0') : '1');
function escape_string ($string)
{
   if (get_magic_quotes_gpc ())
   {
      $string = stripslashes($string);
   }
   if (!is_numeric($string))
   {
     $link = db_connect();
     $escaped_string = mysql_real_escape_string($string, $link);
   }
   else
   {
     $escaped_string = $string;
   }
   
   return $escaped_string;
}

function set_title($title)
{
  global $config;
  
  if (isset($_GET['active_project']))
  {
    $project_name = get_project_name($_GET['active_project']);
    return $config['site_name'] . " > " . $project_name . " > " . $title;
  }
  else
    return $config['site_name'] . " > " . $title;
}

function opms_start()
{
  if (isset($_GET['event']))
    $event = $_GET['event'];
  else
    $event = "Main";

  try
  {
    $opms_dispatcher = new Dispatcher($event);
    $opms_dispatcher->handle_the_event();
  }
  catch(HandlerException $e)
  {
    global $timer, $error_message;
    $page = new Page();

  	$page->assign('page_title', set_title("Dashboard"));
  	$page->assign('message', $error_message['event_not_found']);
  	$timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->display('standard/default.tpl');  	
  }
  catch(HandlerErrorException $e)
  {
    global $timer, $error_message;
    $page = new Page();

  	$page->assign('page_title', set_title("Dashboard"));
  	$page->assign('message', $error_message['event_handler_error']);
  	$timer->stop();
  	$page->assign('total_time', sprintf("%2.3f", $timer->timeElapsed()));
  	$page->display('standard/default.tpl');  	
  }
}

function opms_end()
{
  global $opms_db;
  $opms_db->DBDisconnect();
}

function get_config($config_name)
{
  global $config;

  if (isset($config['$config_name']))
    return $config['$config_name'];
}

function get_option($setting, $project_id = 0)
{
  global $opms_db;
  $query_string = "SELECT option_value FROM options " .
                  "WHERE option_name = '$setting' " .
                  "AND project_id = '$project_id' LIMIT 1";
  $result = $opms_db->DBGetOne($query_string);
  
  if ($result)
    return $result;
  else
    return false;
}
?>
