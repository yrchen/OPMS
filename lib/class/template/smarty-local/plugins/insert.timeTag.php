<?php
/*
 * OPMS
 * insert.timeTag.php
 * Created on 2006/12/12 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/insert.timeTag.php $
 */

function smarty_insert_timeTag($params, $smarty)
{
  return isset($params['output']) ? $params['output'] : date ('Y-m-d H:i:s');
}
?>
