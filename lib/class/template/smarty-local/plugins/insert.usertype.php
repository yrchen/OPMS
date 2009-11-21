<?php
/*
 * OPMS
 * insert.usertype.php
 * Created on 2006/12/12 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/insert.usertype.php $
 */

function smarty_insert_usertype($params, $smarty)
{
  return isset($params['output']) ? $params['output'] : get_current_user_role_name();
}
?>
