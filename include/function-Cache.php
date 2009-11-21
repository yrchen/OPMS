<?php
/*
 * OPMS
 * function-Cache.php
 * Created on 2006/12/28 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-Cache.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

function opms_cache_get($request, $project_id = 0)
{
  return apc_fetch('option_' . $request . "_" . $project_id);
}

function opms_cache_add($setting, $value, $project_id = 0)
{
  return apc_store('option_' . $setting . "_" . $project_id, $value);
}

function opms_cache_del($setting, $project_id = 0)
{
  return apc_delete('option_' . $setting . "_" . $project_id);
}

function opms_cache_flush($request)
{
  return apc_clear_cache();
}
?>
