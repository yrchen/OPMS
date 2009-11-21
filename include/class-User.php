<?php
/*
 * OPMS
 * class-user.php
 * Created on 2006/12/4 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate:2006-12-06 02:21:49 +0000 (Wed, 06 Dec 2006) $
 * $LastChangedRevision:617 $
 * $LastChangedBy:yrchen $
 * $HeadURL:http://project.cis.au.edu.tw/svn/opms/trunk/include/class-user.php $
 */
 
// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class M_User extends Base
{
  public function UserList()
  {
  	$query_string = "SELECT username, email FROM users";
  	$result = $this->DB->DBGetAll($query_string);
  	return $result;
  }
  
  public function UserRealName($userid)
  {
  	$query_string = "SELECT realname FROM users WHERE userid = '$userid'";
  	$result = $this->DB->DBQuery($query_string);
  	return $result;
  }
}

class C_User
{
  private $mUser;
  
  function __construct()
  {
    $this->mUser = new M_User();
  }
  
  public function GetUserList()
  {
  	$result = $this->mUser->UserList();
  	return $result;
  }
  
  public function GetUserRealName($userid)
  {
  	$result = $this->mUser->UserRealName($userid);
  	return $result;
  }
}
?>
