<?php
/*
 * OPMS
 * function-Announce.php
 * Created on 2006/12/23 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-Announce.php $
 */

function check_request_announce_id()
{
  $annoounce = new C_Announce;

  if (isset($_GET['id']))
    $annoounce_id = (int)$_GET['id'];
  else
    throw new AnnounceIDException;
    
  $result = $annoounce->CheckAnnounceID($annoounce_id);
  
  if ($result > 0)
  {
  	$result = $annoounce->GetAnnounceProjectID($annoounce_id);

  	if ($result != 0)
  	{
      $user_id = get_current_user_id();

      if (check_user_permission2($result, $user_id) < PROJECT_MEMBER_PERMISSION)
        throw new PermissionException;
  	}
  	else
  	  return 0;
  }
  else
    throw new AnnounceIDException;
}
?>
