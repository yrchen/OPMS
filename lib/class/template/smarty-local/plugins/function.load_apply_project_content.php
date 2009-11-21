<?php
/*
 * OPMS
 * function.load_apply_project_content.php
 * Created on 2006/12/29 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.load_apply_project_content.php $
 */

function smarty_function_load_apply_project_content($params, $smarty)
{
  $apply_project_content = new ApplyProjectContent();
  $apply_project_content->init();
  $smarty->assign($params['assign'], $apply_project_content);
}

class ApplyProjectContent
{
  public $mApplyProjectContent;
  public $mApplyProjectTeacher;
  public $mApplyProjectUser;
  public $mApplyExistFlag;
  public $mLeaveFlag;
  public $mMessage;

  private $mC_ApplyProject;
  private $mProjectID;
  
  function __construct()
  {
  	$this->mC_ApplyProject = new C_ApplyProject();
  	$this->mApplyExistFlag = false;
    $this->mAction = "";
    $this->mLeaveFlag = false;
  	
    if(isset($_GET['id']))
      $this->mProjectID = (int)$_GET['id'];
    else
      throw new ApplyProjectIDException;
      
    $this->mC_ApplyProject->CheckApplyProjectID($this->mProjectID);
    
    if ($this->mC_ApplyProject->CheckApplyProjectExist($this->mProjectID, get_current_user_id()))
      $this->mApplyExistFlag = true;
    
  	foreach ($_POST as $key => $value)
  	  if (substr($key, 0, 6) == "submit")
  	  {
  	  	$last_underscore = strrpos($key, "_");
  	  	$this->mAction = substr($key, strlen("submit_"), $last_underscore - strlen("submit_"));
  	  	$this->mProjectID = substr($key, $last_underscore + 1);

  	  	break;	//yrchen.061213: jump out foreach
  	  }
  }
  
  function init()
  {
    global $config, $message, $error_message;

    try
    {
      switch ($this->mAction)
  	  {
  	    case 'join_project':
  	      if (!$this->mApplyExistFlag)
  	      {
  	        $this->mApplyProjectContent = $this->mC_ApplyProject->GetProjectContent($this->mProjectID);
            $this->mApplyProjectUser = $this->mC_ApplyProject->GetApplyProjectUser($this->mProjectID);
  	      }
  	      else
  	        throw new ApplyProjectJoinException;
  	      break;

  	    case 'join_project_confirm':
  	      if (!$this->mApplyExistFlag)
  	      {
  	        $this->mApplyProjectContent = $this->mC_ApplyProject->GetProjectContent($this->mProjectID);
            $this->mApplyProjectUser = $this->mC_ApplyProject->GetApplyProjectUser($this->mProjectID);
            $this->mC_ApplyProject->JoinProject($this->mProjectID);
  	      }
  	      else
  	        throw new ApplyProjectJoinException;
  	      break;

  	    case 'leave_project':
  	      if ($this->mApplyExistFlag)
  	      {
  	        $this->mApplyProjectContent = $this->mC_ApplyProject->GetProjectContent($this->mProjectID);
            $this->mApplyProjectUser = $this->mC_ApplyProject->GetApplyProjectUser($this->mProjectID);
  	      }
  	      else
  	        throw new ApplyProjectLeaveException;
  	      break;

  	    case 'leave_project_confirm':
  	      if ($this->mApplyExistFlag)
  	      {  	      
  	        $this->mApplyProjectContent = $this->mC_ApplyProject->GetProjectContent($this->mProjectID);
            $this->mApplyProjectUser = $this->mC_ApplyProject->GetApplyProjectUser($this->mProjectID);
            $this->mC_ApplyProject->LeaveProject($this->mProjectID, get_current_user_id());
  	      }
  	      else
  	        throw new ApplyProjectLeaveException;
  	      break;

  	    case 'cancel':
  	      header("Location: " . $config['site_url'] . "main.php?event=Apply&action=ListLiveProject");
  	      break;

  	    default:
  	      break;
  	  }
    }
    catch (PostDataErrorException $e)
    {
      $this->mMessage = $error_message['post_data_error'];
    }
    catch (ApplyProjectJoinException $e)
    {
      $this->mMessage = $message['apply_project_join'];
      $this->mApplyExistFlag = true;
      $this->mLeaveFlag = true;
    }
    catch (ApplyProjectLeaveException $e)
    {
      $this->mMessage = $message['apply_project_leave'];
      $this->mApplyExistFlag = false;
      $this->mLeaveFlag = true;
    }
  }
}
?>
