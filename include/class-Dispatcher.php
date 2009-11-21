<?php
/*
 * OPMS
 * class-dispatcher.php
 * Created on 2006/12/10 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 * $HeadURL$
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class Dispatcher
{
  private $handle;
  
  function __construct($event_handle)
  {
  	$this->handle = $event_handle;
  }
  
  function handle_the_event()
  {
    global $config;
  	$name = "handler_{$this->handle}";
  	
  	if (class_exists("$name"))
  	{
  	  $handler_obj = new $name($this->handle);
  	  $response = $handler_obj->handled_event();
  	  return $response;
  	}
  	else
      throw new HandlerException;
  }
}
?>
