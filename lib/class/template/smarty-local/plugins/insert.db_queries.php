<?php
/*
 * OPMS - Open Project Management System
 * insert.db_queries.php
 * Created on 22-Dec-06 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/insert.db_queries.php $
 */

function smarty_insert_db_queries($params, $smarty)
{
  return isset($params['output']) ? $params['output'] : get_num_queries();
}
?>
