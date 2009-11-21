<?php
/*
 * OPMS
 * function-CacheWP.php
 * Created on 2006/12/28 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/function-CacheWP.php $
 */

//yrchen.061228: 從 WordPress trunk 修訂版 4667 引進 cache 機制

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

function opms_cache_add($key, $data, $flag = '', $expire = 0) {
	global $opms_object_cache;

	return $opms_object_cache->add($key, $data, $flag, $expire);
}

function opms_cache_close() {
	global $opms_object_cache;

	return $opms_object_cache->save();
}

function opms_cache_delete($id, $flag = '') {
	global $opms_object_cache;

	return $opms_object_cache->delete($id, $flag);
}

function opms_cache_flush() {
	global $opms_object_cache;

	return $opms_object_cache->flush();
}

function opms_cache_get($id, $flag = '') {
	global $opms_object_cache;

	return $opms_object_cache->get($id, $flag);
}

function opms_cache_init() {
	$GLOBALS['opms_object_cache'] =& new WP_Object_Cache();
}

function opms_cache_replace($key, $data, $flag = '', $expire = 0) {
	global $opms_object_cache;

	return $opms_object_cache->replace($key, $data, $flag, $expire);
}

function opms_cache_set($key, $data, $flag = '', $expire = 0) {
	global $opms_object_cache;

	return $opms_object_cache->set($key, $data, $flag, $expire);
}
?>
