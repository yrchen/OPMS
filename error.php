<?php
/*
 * OPMS
 * error.php
 * Created on 2006/10/20 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/error.php $
 */

/*
 * Original source from LifeType
 * http://www.lifetype.org/
 */

/**
 * Implements an error handler for 401, 403 and 404 errors so that
 * if the user types a user name after the url, and Apache complains,
 * thanks to the ErrorDocument directive this handler will receive the
 * request and we will be able to perform a redirectiom
 *
 * To get this to work, we need a provider which allows to use
 * .htaccess files in their accounts and at the same time, allows
 * to have ErrorDocument directives in the .htaccess file.
 *
 * This should be the content of the file:
 *
 * ErrorDocument 401 /opms/error.php
 * ErrorDocument 403 /opms/error.php
 * ErrorDocument 404 /opms/error.php
 *
 * If OPMS is running somewhere else other than /opms/, then that
 * should be changed since an absolute URL is required.
 */

// yrchen.061015: Set flag that this is a parent file.
define( '_OPMSEXEC', 1 );

if (isset($_GET['enum']))
{
  require_once('init.php');

  if (isset($error_message[$_GET['enum']]))
  {
    $page = new Page();
    $page->caching = true;

    if (!$page->is_cached('standard/error.tpl', $_GET['enum']))
      $page->assign('error_message', $error_message[$_GET['enum']]);
    
    $page->display('standard/error.tpl', $_GET['enum']);
  }
}
//yrchen.061212: Silence is golden.
?>
