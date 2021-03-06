<?php
/*
 * OPMS
 * function.load_apply_list.php
 * Created on 2006/12/30 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_apply_list.php $
 */

function smarty_function_load_apply_list($params, $smarty)
{
  $apply_list = new ApplyList();
  $apply_list->init();
  $smarty->assign($params['assign'], $apply_list);
}

class ApplyList
{
  public $mApplyList;

  private $mC_Apply;
  
  function __construct()
  {
  	$this->mC_Apply = new C_Apply();
  }
  
  function init()
  {
    $this->mApplyList = $this->mC_Apply->GetApplyList();    
  }
}

?>
