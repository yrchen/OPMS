<?php
/*
 * OPMS
 * var.php
 * Created on 2006/12/12 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/var.php $
 */

// no direct access
defined('_OPMSEXEC') or die('Restricted access');

if(!$error_message = apc_fetch('error_message'))
{
  $error_message = array(
    'event_not_found'       => '不存在的事件',
    'event_handler_error'   => '事件處理錯誤，可能缺乏必要的參數',
    'access_deniend'        => '拒絕存取',
    'permission_not_enough' => '權限不足',
    'project_not_found'     => '不存在的專案',
    'task_not_found'        => '不存在的工作',
    'tasklist_not_found'    => '不存在的工作清單',
    'milestone_not_found'   => '不存在的目標',
    'message_not_found'     => '不存在的訊息',
    'announce_not_found'    => '不存在的公告',
    'post_data_error'       => '輸入內容錯誤'
  );

  apc_store('error_message', $error_message);
}

if (!$message = apc_fetch('message'))
{
  $message = array(
    'project_update'        => '專案設定已更新',
    'project_member_modify' => '專案成員異動完成',
    'project_teacher_modify'=> '專案指導老師異動完成',
    'task_add'              => '工作已新增',
    'task_del'              => '工作已刪除',
    'task_update'           => '工作已更新',
    'tasklist_add'          => '工作清單已新增',
    'tasklist_del'          => '工作清單已刪除',
    'tasklist_update'       => '工作清單已更新',
    'milestone_add'         => '目標已新增',
    'milestone_del'         => '目標已刪除',
    'milestone_update'      => '目標已更新',
    'message_add'           => '訊息已新增',
    'message_del'           => '訊息已刪除',
    'message_update'        => '訊息已更新',
    'announce_add'          => '公告已新增',
    'announce_del'          => '公告已刪除',
    'announce_update'       => '公告已更新',
    'announce_read'         => '公告標示為已閱讀',
    'announce_unread'       => '公告標示為未閱讀',
    'apply_project_join'    => '申請加入專案成功',
    'apply_project_leave'   => '取消申請加入專案成功'
  );

  apc_store('message', $message);
}

if (!strstr($_SERVER['PHP_SELF'], 'install.php'))
{
  // Used to guarantee unique hash cookies
  $cookiehash = md5($config['site_url']);
  define('COOKIEHASH', $cookiehash);
}

if (!defined('USER_COOKIE'))
  define('USER_COOKIE', 'opmsuser_'. COOKIEHASH);
if (!defined('PASS_COOKIE'))
  define('PASS_COOKIE', 'opmspass_'. COOKIEHASH);
if (!defined('COOKIEPATH'))
  define('COOKIEPATH', preg_replace('|https?://[^/]+|i', '', $config['site_url'] . '/' ) );
if (!defined('SITECOOKIEPATH'))
  define('SITECOOKIEPATH', preg_replace('|https?://[^/]+|i', '', $config['site_url'] . '/' ) );
if (!defined('COOKIE_DOMAIN'))
  define('COOKIE_DOMAIN', false);

if (!apc_load_constants('constants_permission'))
{
  $constants_permissoin = array(
    'PROJECT_MEMBER_PERMISSION'		=> 10,
    'PROJECT_LEADER_PERMISSION'		=> 30,
    'PROJECT_TEACHER_PERMISSION'	=> 40,
    'SYSTEM_ADMIN_PERMISSION'		=> 50
  );

  apc_define_constants('constants_permission', $constants_permissoin);
  apc_load_constants('constants_permission');
}

if (!$permission = apc_fetch('permission'))
{
  $permission = array(
    'project_member'     => PROJECT_MEMBER_PERMISSION,
    'project_leader'     => PROJECT_LEADER_PERMISSION,
    'project_teacher'    => PROJECT_TEACHER_PERMISSION,
    'system_admin'       => SYSTEM_ADMIN_PERMISSION
  );

  apc_store('permission', $permission);
}

if (!defined('DEBUG_INFO'))
  define('DEBUG_INFO', 100);
if (!defined('DEBUG_SQL'))
  define('DEBUG_SQL', 75);
if (!defined('DEBUG_WARNING'))
  define('DEBUG_WARNING', 50);
if (!defined('DEBUG_ERROR'))
  define('DEBUG_ERROR', 25);
if (!defined('DEBUG_CRITICAL'))
  define('DEBUG_CRITICAL', 10);

if (!defined('LOGGER_DEBUG'))
  define('LOGGER_DEBUG', 100);
if (!defined('LOGGER_INFO'))
  define('LOGGER_INFO', 75);
if (!defined('LOGGER_NOTICE'))
  define('LOGGER_NOTICE', 50);
if (!defined('LOGGER_WARNING'))
  define('LOGGER_WARNING', 25);
if (!defined('LOGGER_ERROR'))
  define('LOGGER_ERROR', 10);
if (!defined('LOGGER_CRITICAL'))
  define('LOGGER_CRITICAL', 5);

if (!$config2 = apc_fetch('config2'))
{
  $config2 = array(
    'debug_level'        => DEBUG_INFO,
    'logger_level'       => LOGGER_INFO
  );

  apc_store('config2', $config2);
}
?>
