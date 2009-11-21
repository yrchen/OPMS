<?php 
/*
 * OPMS
 * check-login.php
 * Created on 2006/10/21 by Chen YuRen (yrchen@ATCity.org)
 *
 * 認證導引網頁
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/check-login.php $
 */

// yrchen.061015: Set flag that this is a parent file.
define( '_OPMSEXEC', 1 );

require_once('init.php');

if ($_POST)
{
  $username = $_POST['username'];
  $password = $_POST['passwd'];
  $redirect = $_POST['redirect'];

  try
  {
    login($username, $password);
    $_SESSION['valid_user'] = $username;

    if($redirect)
      header("Location: " . $config['site_url'] . $redirect);
    else
      header("Location: " . $config['site_url'] . "main.php");
  }
  catch (LoginException $e)
  {
    // yrchen.061021: 登入失敗
    header("Location: " . $config['site_url'] . "login.php");
  }
}
else
  header("Location: " . $config['site_url'] . "login.php");
?> 