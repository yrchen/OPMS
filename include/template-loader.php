<?php
/*
 * OPMS
 * template-loader.php
 * Created on 2006/10/20 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/template-loader.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

require_once ($setting['path'] . $setting['cla'] . 'template/smarty/Smarty.class.php');

class Page extends Smarty
{
  function __construct()
  {
    global $setting, $config;
    $this->Smarty();
    
    $this->caching = false;
    $this->template_dir = $setting['path'] . $setting['tpl'];
    $this->compile_dir = $setting['path'] . 'template_c';
    $this->cache_dir = $setting['path'] . 'cache';
    $this->plugins_dir[0] = $setting['path'] . $setting['cla'] . 'template/smarty/plugins';
    $this->plugins_dir[1] = $setting['path'] . $setting['cla'] . 'template/smarty-local/plugins';
    $this->assign('time', date("Y-m-d H:i"));
    $this->assign('create_time', date("Y-m-d H:i:s"));
    $this->assign('page_title', $config['site_name']);
    $this->assign('page_style', 'style/style.css');  	
  }
}
?>