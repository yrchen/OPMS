<?php
/*
 * OPMS
 * function-error-handler.php
 * Created on 2006/11/24 by Chen YuRen (yrchen@ATCity.org)
 *
 * 控制錯誤訊息的輸出
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-ErrorHandler.php $
 */

// yrchen.061203: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

define("IS_WARNING_FATAL", "true");
define("DEBUGGING", "true");

define("SEND_ERROR_MAIL", "false");
define("ADMIN_ERROR_MAIL", "opms.bug@project.cis.au.edu.tw");
define("SENDMAIL_FROM", "opms@project.cis.au.edu.tw");
ini_set("sendmail_from", "SENDMAIL_FROM");

define("LOG_ERRORS", "false");
define("LOG_ERRORS_FILE", "log");

define("SITE_GENERIC_ERROR_MESSAGE", "<h2>OPMS Error!</h2>");

function dbg_get_backtrace($irrelevantFirstEntries)
{
  $s = '';
  $MAXSTRLEN = 64;
  $traceArr = debug_backtrace();
  
  for($i = 0; $i < $irrelevantFirstEntries; $i++)
    array_shift($traceArr);
    
  $tabs = sizeof($traceArr) - 1;
  
  foreach($traceArr as $arr)
  {
  	$tabs -= 1;
  	
  	if (isset($arr['class']))
  	  $s .= $arr['class'] . '.';
  	  
  	$args = array();
  	
  	if (!empty($arr['args']))
  	  foreach($arr['args'] as $v)
  	  {
  	  	if (is_null($v))
  	  	  $args[] = 'null';
  	  	else if (is_array($v))
  	  	  $args[] = 'Array[' . sizeof($v) . ']';
  	  	else if (is_object($v))
  	  	  $args[] = 'Object:' . get_class($v);
  	  	else if (is_bool($v))
  	  	  $args[] = $v ? 'true' : 'false';
  	  	else
  	  	{
  	  	  $v = (string)@$v;
  	  	  $str = htmlspecialchars(substr($v, 0, $MAXSTRLEN));

  	  	  if (strlen($v) > $MAXSTRLEN)
  	  	    $str .= '...';
  	  	    
  	  	  $args[] = "\"" . $str . "\"";
  	  	}
  	  }
  	  
  	  $s .= $arr['function'] . '(' . implode(', ', $args) . ')';
  	  $Line = (isset($arr['line']) ? $arr['line'] : "unknown");
  	  $File = (isset($arr['file']) ? $arr['file'] : "unknoen");
  	  $s .= sprintf(" # line %4d, file: %s,", $Line, $File, $File);
  	  $s .= "\n";
  }
  
  return $s;
}
 
function error_handler($errNo, $errStr, $errFile, $errLine)
{
  $backtrace = dbg_get_backtrace(2);
  $error_message = "\nERRNO: " . $errNo . "\nTEXT:" . $errStr . " \n" . "LOCATION: " . $errFile . ", line " . $errLine . ", at " . date("F j, Y, g:i a") . "\nShow backtrace:\n" . $backtrace . "\n\n";
  
  if(SEND_ERROR_MAIL == true)
    error_log($error_message, 1, ADMIN_ERROR_MAIL, "From: " . SENDMAIL_FROM. "\r\nTo: " . ADMIN_ERROR_MAIL);
    
  if(LOG_ERRORS == true)
    error_log($error_message, 3, LOG_ERRORS_FILE);
    
  if(($errNo == E_WARNING && IS_WARNING_FATAL == false) || ($errNo == E_NOTICE || $errNo == E_USER_NOTICE))
  {
  	if (DEBUGGING == true)
  	  echo "<pre>" . $error_message . "</pre>";
  }
  else
  {
  	if (DEBUGGING == true)
  	  echo "<pre>" . $error_message . "</pre>";
  	else
  	  echo SITE_GENERIC_ERROR_MESSAGE;
  	
  	exit;
  }
}

function log_error($error)
{
  global $config, $error_message;
}
?>