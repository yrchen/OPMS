<?php
/*
 * OPMS - Open Project Management System
 * init.php
 * Created on 2006/10/13 by Chen YuRen (yrchen@ATCity.org)
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/init.php $
 */

// no direct access
defined('_OPMSEXEC') or die('Restricted access');

if (!extension_loaded('apc'))
{
  die('Your PHP installation appears to be missing the APC which is required for OPMS.');
}
else
{
  if(!$setting = apc_fetch('setting'))
  {
    $setting = array(
    'path' => dirname(__FILE__) . '/',
    'inc'  => 'include/',
    'lib'  => 'lib/',
    'cla'  => 'lib/class/',
    'tpl'  => 'template/'
    );

    apc_store('setting', $setting);
  }

  if (!file_exists($setting['path'] . $setting['inc'] . 'config.php'))
  {
    die("There doesn't seem to be a <code>config.php</code> file. I need this before we can get started.");
  }
  else
  {
    if(!$config = apc_fetch('config'))
    {
      require ($setting['path'] . $setting['inc'] . 'config.php');
      apc_store('config', $config);
    }
  }
}

if (!extension_loaded('mysqli'))
  die('Your PHP installation appears to be missing the mysqli which is required for OPMS.');

ini_set('include_path', '.:' . $setting['path'] . $setting['lib'] . 'pear');
require_once('Benchmark/Timer.php');
$timer = new Benchmark_Timer();
$timer->start();

if (defined('DEBUG_MODE'))
  require_once($setting['path'] . $setting['inc'] . 'debug.php');

if (defined('MAINTAIN_MODE'))
  require_once($setting['path'] . $setting['inc'] . 'maintain.php');

require_once($setting['path'] . $setting['inc'] . 'var.php');
require_once($setting['path'] . $setting['inc'] . 'interface.php');
require_once($setting['path'] . $setting['inc'] . 'class.php');
require_once($setting['path'] . $setting['inc'] . 'function.php');
require_once($setting['path'] . $setting['inc'] . 'template-loader.php');
require_once($setting['path'] . $setting['inc'] . 'session.php');
?>
