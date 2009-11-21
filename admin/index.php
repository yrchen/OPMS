<?php
// yrchen.061015: Set flag that this is a parent file.
define( '_OPMSEXEC', 1 );

require_once('admin.php');

try
{
  check_admin_login();
  $user = $_SESSION['valid_user'];
}
catch (Exception $e)
{
  try
  {
    check_login();
    header("Location: " . $config['site_url'] . "main.php");
  }
  catch (Exception $e)
  {
    header("Location: " . $config['site_url'] . "login.php");
  }
}

$opms_tpl->assign('page_title', set_title("Admin > Dashboard"));
$opms_tpl->assign('page_style', '../style/');
$opms_tpl->assign('user_name', $user);
$opms_tpl->assign('user_type', "管理者");
$opms_tpl->assign('time', date("Y-m-d H:i"));

$opms_tpl->display ($setting['path'] . $setting['tpl'] . 'admin/admin.tpl');
?>
