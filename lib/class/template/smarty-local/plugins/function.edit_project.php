<?php
/*
 * OPMS - Open Project Management System
 * function.edit_project.php
 * Created on 13-Dec-06 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/lib/class/template/smarty-local/plugins/function.edit_project.php $
 */

function smarty_function_edit_project($params, $smarty)
{
  $edit_project = new EditProject();
  $edit_project->init();
  $smarty->assign($params['assign'], $edit_project);
}

class EditProject
{
  public $mMessage;
  public $mProjectContent;
  public $mLeaveFlag;
  public $mUserLevel;
  
  private $mPojectID;
  private $mC_Project;
  private $mAction;
  
  function __construct()
  {
  	$this->mC_Project = new C_Project();
    $this->mProjectID = (int)$_GET['active_project'];
    $this->mAction = "";
    $this->mLeaveFlag = false;
    $this->mUserLevel = check_user_permission();

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
  	    case 'edit_content':
  	      if (isset($_POST['project_name']) && isset($_POST['project_demo_url']) &&
              isset($_POST['project_description']) && isset($_POST['project_licence']))
          {
            $this->mC_Project->DoUpdateProjectContent($this->mProjectID, $_POST['project_name'], $_POST['project_demo_url'], $_POST['project_description'], $_POST['project_licence']);
          }
          else
            throw new PostDataErrorException;
  	      break;

        case 'add_member':
          if ($this->mUserLevel >= PROJECT_LEADER_PERMISSION)
          {
            $this->mC_Project->AddProjectMember($this->mProjectID, (int)$_POST['project_new_member']);
          }
          else
            throw new PermissionException;
          break;

        case 'del_member':
          if ($this->mUserLevel >= PROJECT_LEADER_PERMISSION)
          {
            $this->mC_Project->DelProjectMember($this->mProjectID, (int)$_POST['project_new_member']);
          }
          else
            throw new PermissionException;
          break;

  	    case 'cancel':
  	      header("Location: " . $config['site_url'] . "main.php?event=Project&action=View&active_project=" . $this->mProjectID);
  	      break;

  	    default:
  	      break;
  	  }
    }
    catch (PostDataErrorException $e)
    {
      $this->mMessage = $error_message['post_data_error'];
    }
    catch (ProjectUpdateException $e)
    {
      $this->mMessage = $message['project_update'];
      $this->mLeaveFlag = true;
    }
    catch (ProjectMemberModifyException $e)
    {
      $this->mMessage = $message['project_member_modify'];
      $this->mLeaveFlag = true; 
    }
    catch (ProjectTeacherModifyException $e)
    {
      $this->mMessage = $message['project_teacher_modify'];
      $this->mLeaveFlag = true;
    }
 	
  	$this->mProjectContent = $this->mC_Project->GetProjectContent($this->mProjectID);
  }
}
?>
