<?php
/*
 * OPMS
 * class-Announce.php
 * Created on 2006/12/4 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Announce.php $
 */
 
// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class M_Announce extends Base
{
  function SystemAnnounceList()
  {
    $query_string = "SELECT announce.*, CONCAT(LEFT(announce.title, 30), '..') AS title, users.realname FROM announce " .
                    "LEFT JOIN users ON announce.owner = users.id " .
                    "WHERE project_id = 0 " .
                    "ORDER BY announce.id DESC";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  function ProjectAnnounceList($project_id)
  {
    $query_string = "SELECT announce.*, users.realname FROM announce " .
                    "LEFT JOIN users ON announce.owner = users.id " .
                    "WHERE project_id = '$project_id' " .
                    "ORDER BY announce.id DESC";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  function ProjectAllAnnounceList($user_id)
  {
    $query_string = "SELECT announce.*, users.realname, project_list.project_name FROM announce " .
                    "LEFT JOIN users ON announce.owner = users.id " .
                    "LEFT JOIN project_list ON announce.project_id = project_list.project_id " .
                    "WHERE (announce.project_id) IN " .
                    "(SELECT project_list.project_id FROM project_list, project_users " .
                    "WHERE project_users.user_id = '$user_id' " .
                    "AND project_list.project_id = project_users.project_id) " .
                    "ORDER BY announce.id DESC";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  function UserRead($user_id, $announce_id)
  {
    $query_string= "SELECT * FROM announce_read " .
                   "WHERE user_id ='$user_id' " .
                   "AND announce_id = '$announce_id'";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  function SystemNew($user_id)
  {
    $query_string = "SELECT announce.*, users.realname FROM announce " .
                    "LEFT JOIN users ON announce.owner = users.id " .
                    "WHERE (announce.id) NOT IN " .
                    "(SELECT announce_read.announce_id FROM announce_read " .
                    "WHERE announce_read.user_id = '$user_id') " .
                    "AND announce.project_id = 0 " .
                    "ORDER BY announce.id DESC";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  function ProjectNew($project_id, $user_id)
  {
    $query_string = "SELECT announce.*, users.realname FROM announce " .
                    "LEFT JOIN users ON announce.owner = users.id " .
                    "WHERE (announce.id) NOT IN " .
                    "(SELECT announce_read.announce_id FROM announce_read " .
                    "WHERE announce_read.user_id = '$user_id') " .
                    "AND announce.project_id = '$project_id' " .
                    "ORDER BY announce.id DESC";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  function ProjectAllNew($user_id)
  {
    $query_string = "SELECT announce.*, users.realname FROM announce " .
                    "LEFT JOIN users ON announce.owner = users.id " .
                    "WHERE (announce.project_id) IN " .
                    "(SELECT project_list.project_id FROM project_list, project_users " .
                    "WHERE project_users.user_id = '$user_id' " .
                    "AND project_list.project_id = project_users.project_id) " .
                    "AND (announce.id) NOT IN " .
                    "(SELECT announce_id FROM announce_read WHERE user_id = '$user_id') " .
                    "ORDER BY announce.id DESC";
    $result = $this->DB->DBGetAll($query_string);

    return $result;
  }

  function AnnounceContent($announce_id)
  {
    $query_string = "SELECT announce.*, users.realname FROM announce " .
                    "LEFT JOIN users ON announce.owner = users.id " .
                    "WHERE announce.id = '$announce_id' " .
                    "ORDER BY announce.id DESC";
    $result = $this->DB->DBGetRow($query_string);

    return $result;
  }

  function CheckAnnounceID($announce_id)
  {
    $query_string = "SELECT COUNT(*) FROM announce WHERE id = '$announce_id'";
    $result = $this->DB->DBGetOne($query_string);

    return $result;
  }

  function GetAnnounceProjectID($announce_id)
  {
    $query_string = "SELECT project_id FROM announce WHERE id = '$announce_id'";
    $result = $this->DB->DBGetOne($query_string);

    return $result;
  }

  function AnnounceUserRead($announce_id, $user_id)
  {
    $query_string = "INSERT INTO announce_read (announce_id, user_id) ".
                    "VALUES ('$announce_id', '$user_id')";
    $result = $this->DB->DBQuery($query_string);

    return $result;
  }

  function AnnounceUserUnread($announce_id, $user_id)
  {
  	$query_string = "DELETE FROM announce_read " .
                    "WHERE announce_id = '$announce_id' AND user_id = '$user_id'";
    $result = $this->DB->DBQuery($query_string);
    
    return $result;
  }

  function CheckAnnounceRead($announce_id, $user_id)
  {
    $query_string = "SELECT COUNT(*) FROM announce_read " .
                    "WHERE announce_id = '$announce_id' " .
                    "AND user_id = '$user_id'";
    $result = $this->DB->DBGetOne($query_string);

    return $result;
  }
}

class C_Announce
{
  private $mAnnounce;

  function __construct()
  {
    $this->mAnnounce = new M_Announce();
  }

  function GetSystemAnnounceList()
  {
    $result = $this->mAnnounce->SystemAnnounceList();
    return $result;
  }

  function GetProjectAnnounceList($project_id)
  {
    $result = $this->mAnnounce->ProjectAnnounceList($project_id);
    return $result;
  }

  function GetProjectAllAnnounceList()
  {
  	$user_id = get_current_user_id();
  	$result = $this->mAnnounce->ProjectAllAnnounceList($user_id);
  	
  	return $result;
  }

  function CheckUserRead($user_id, $announce_id)
  {
    $result = $this->mAnnounce->UserRead($user_id, $announce_id);
    return $result;
  }

  function GetSystemNewList()
  {
    $user_id = get_current_user_id();
    $result = $this->mAnnounce->SystemNew($user_id);
    return $result;
  }

  function CheckProjectNew($project_id)
  {
    $user_id = get_current_user_id();
    $result = $this->mAnnounce->ProjectNew($project_id, $user_id);
    return $result;
  }

  function GetProjectAllNewList()
  {
    $user_id = get_current_user_id();
    $result = $this->mAnnounce->ProjectAllNew($user_id);
    return $result;
  }

  function GetAnnounceContent($announce_id)
  {
    $result = $this->mAnnounce->AnnounceContent($announce_id);
    return $result;
  }

  function CheckAnnounceID($announce_id)
  {
    $result = $this->mAnnounce->CheckAnnounceID($announce_id);
    return $result;
  }

  function GetAnnounceProjectID($announce_id)
  {
    $result = $this->mAnnounce->GetAnnounceProjectID($announce_id);
    return $result;
  }

  function MarkAnnounceUserRead($announce_id)
  {
    if (!$this->CheckAnnounceRead($announce_id))
    {
      $user_id = get_current_user_id();
      $result = $this->mAnnounce->AnnounceUserRead($announce_id, $user_id);

      if ($result)
        throw new AnnounceReadException;
    }
    else
      throw new AnnounceReadException;
  }

  function MarkAnnounceUserUnread($announce_id)
  {
    if ($this->CheckAnnounceRead($announce_id))
    {
      $user_id = get_current_user_id();
      $result = $this->mAnnounce->AnnounceUserUnread($announce_id, $user_id);

      if ($result)
        throw new AnnounceUnreadException;
    }
    else
      throw new AnnounceUnreadException;
  }

  function CheckAnnounceRead($announce_id)
  {
    $user_id = get_current_user_id();
    $result = $this->mAnnounce->CheckAnnounceRead($announce_id, $user_id);

    if ($result > 0)
      return 1;
    else
      return 0;
  }
}
?>
