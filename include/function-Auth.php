<?php
/*
 * OPMS
 * function-auth.php
 * Created on 2006/10/21 by Chen YuRen (yrchen@ATCity.org)
 *
 * 與認證相關的函式
 * 
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-Auth.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

function login($username, $password)
{
  global $opms_db;
  $query_string = "SELECT * FROM users WHERE username='$username' AND password = MD5('$password')";

  $result = $opms_db->DBGetRow($query_string);

  if ($result)
    return true;
  else
    throw new LoginException ('Could not log you in!');
}

function check_login()
{
  if (isset($_SESSION['valid_user']))
  	return true;
  else
    throw new LoginException ('User not loging!');
}

function check_admin()
{
  if (isset($_SESSION['admin']))
  	return true;
  else
    return false;
}

function get_cookie_login()
{
  if (empty($_COOKIE[USER_COOKIE]) || empty($_COOKIE[PASS_COOKIE]))
    return false;

  return array('login' => $_COOKIE[USER_COOKIE], 'password' => $_COOKIE[PASS_COOKIE]);
}

function opms_setcookie($username, $password, $already_md5 = false, $home = '', $siteurl = '', $remember = false)
{
  if (!$already_md5 )
    $password = md5( md5($password) ); // Double hash the password in the cookie.

  if (empty($home))
    $cookiepath = COOKIEPATH;
  else
    $cookiepath = preg_replace('|https?://[^/]+|i', '', $home . '/' );

  if (empty($siteurl))
  {
    $sitecookiepath = SITECOOKIEPATH;
    $cookiehash = COOKIEHASH;
  }
  else
  {
    $sitecookiepath = preg_replace('|https?://[^/]+|i', '', $siteurl . '/' );
    $cookiehash = md5($siteurl);
  }

  if ($remember)
    $expire = time() + 31536000;
  else
    $expire = 0;

  setcookie(USER_COOKIE, $username, $expire, $cookiepath, COOKIE_DOMAIN);
  setcookie(PASS_COOKIE, $password, $expire, $cookiepath, COOKIE_DOMAIN);

  if ($cookiepath != $sitecookiepath)
  {
    setcookie(USER_COOKIE, $username, $expire, $sitecookiepath, COOKIE_DOMAIN);
    setcookie(PASS_COOKIE, $password, $expire, $sitecookiepath, COOKIE_DOMAIN);
  }
}

function opms_clearcookie()
{
  setcookie(USER_COOKIE, ' ', time() - 31536000, COOKIEPATH, COOKIE_DOMAIN);
  setcookie(PASS_COOKIE, ' ', time() - 31536000, COOKIEPATH, COOKIE_DOMAIN);
  setcookie(USER_COOKIE, ' ', time() - 31536000, SITECOOKIEPATH, COOKIE_DOMAIN);
  setcookie(PASS_COOKIE, ' ', time() - 31536000, SITECOOKIEPATH, COOKIE_DOMAIN);
}

function get_current_user_name()
{
  if (isset($_SESSION['valid_user']))
    $user = $_SESSION['valid_user'];
  else
    $user = "Guest";
    
  return $user;
}

function get_current_user_id()
{
  global $opms_db;
  $username = get_current_user_name();
  $query_string = "SELECT id FROM users WHERE username = '$username'";
  
  $result = $opms_db->DBGetOne($query_string);
  
  if ($result)
  	return $result;
  else
    throw new Exception ("Can't get user id!");  
}

function get_current_user_role()
{
  global $opms_db;
  
  if (isset($_SESSION['valid_user']))
    $username = $_SESSION['valid_user'];
  else
    return 0;	//yrchen.061206: 0 就代表是 guest，也不用去資料庫查了

  $query_string = "SELECT user_roles.role_id FROM users, user_roles WHERE users.username='$username' AND users.id = user_roles.user_id";
  $result = $opms_db->DBGetOne($query_string);

  if ($result)
  	return $result;
  else
    throw new Exception ("Can't get user role!");
}

function get_current_user_role_name()
{
  global $opms_db;

  $username = get_current_user_name();
  if ($username == "Guest")
    return "Guest";	//yrchen.061206: 同 get_user_role()，是 guest 就直接傳回 Guest 就好
  
  $query_string = "SELECT roles.role_name FROM roles, users, user_roles WHERE users.username ='$username' AND users.id = user_roles.user_id AND roles.role_id = user_roles.role_id";
  $result = $opms_db->DBGetOne($query_string);

  if ($result)
  	return $result;
  else
    throw new Exception ("Can't get user role name!");
}

function check_user_permission()
{
  check_request_project_id();

  if (check_admin())
  {
    return SYSTEM_ADMIN_PERMISSION;  	
  }
  else
  {
    $project = new C_Project;
    $project_id = (int)$_GET['active_project'];

    $result = $project->CheckUserPermission($project_id);
  
    if ($result)
      return $result;
    else
      return 0;
  }
}

function check_user_permission2($project_id, $user_id)
{
  $project = new C_Project;
  $result = $project->CheckUserPermission2($project_id, $user_id);
  
  if ($result)
    return $result;
  else
    return 0;
}
?>