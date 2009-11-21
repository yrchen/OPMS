<?php
/*
 * OPMS
 * class-Message.php
 * Created on 2006/12/18 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Message.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class M_Message extends Base
{
  public function GetProjectMessageList($project_id)
  {
  	$query_string = "SELECT * FROM project_messages " .
                    "WHERE project_id = '$project_id'";
    $result = $this->DB->DBGetAll($query_string);
    
    return $result;
  }

  public function CheckMessageID($message_id)
  {
    $query_string = "SELECT COUNT(*) FROM project_messages " .
                    "WHERE id = '$message_id'";
    $result = $this->DB->DBGetOne($query_string);

    return $result;
  }

  public function GetMessageProjectID($message_id)
  {
    $query_string = "SELECT project_id FROM project_messages " .
                    "WHERE id = '$message_id'";
    $result = $this->DB->DBGetOne($query_string);

    return $result;
  }

  public function MessageContent($message_id)
  {
    $query_string = "SELECT messages.*, milestones.name, users.realname FROM project_messages messages " .
                    "LEFT JOIN project_milestones milestones ON messages.milestone_id = milestones.id " .
                    "LEFT JOIN users ON messages.created_by_id = users.id " .
                    "WHERE messages.id = '$message_id'";
    $result = $this->DB->DBGetRow($query_string);

    return $result;
  }
  
  public function AddMessage($milestone_id, $project_id, $title, $text, $additional_text, $is_important, $is_private, $comments_enabled, $anonymous_comments_enabled, $created_by_id)
  {
  	$query_string = "INSERT INTO project_messages " .
                    "(milestone_id, project_id, title, " .
                    " text, additional_text, is_important, " .
                    " is_private, comments_enabled, anonymous_comments_enabled, " .
                    " created_on, created_by_id) VALUES " .
                    "('$milestone_id', '$project_id', '$title', " .
                    " '$text', '$additional_text', '$is_important', " .
                    " '$is_private', '$comments_enabled', '$anonymous_comments_enabled', " .
                    " NOW(), $created_by_id)";
    $result = $this->DB->DBQuery($query_string);
    
    return $result;
  }
  
  public function MilestoneMessage($milestone_id)
  {
  	$query_string = "SELECT messages.*, users.realname FROM project_messages messages " .
                    "LEFT JOIN users ON messages.created_by_id = users.id " .
                    "WHERE messages.milestone_id = '$milestone_id'";
    $result = $this->DB->DBGetAll($query_string);
    
    return $result;
  }
}

class C_Message
{
  private $mM_Message;
  
  public function __construct()
  {
  	$this->mM_Message = new M_Message;
  }

  public function GetProjectMessageList($project_id)
  {
  	$result = $this->mM_Message->GetProjectMessageList($project_id);
  	
  	return $result;
  }

  public function CheckMessageID($message_id)
  {
    $result = $this->mM_Message->CheckMessageID($message_id);

    return $result;
  }
  
  public function GetMessageProjectID($message_id)
  {
    $result = $this->mM_Message->GetMessageProjectID($message_id);

    return $result;
  }

  public function GetMessageContent($message_id)
  {
    $result = $this->mM_Message->MessageContent($message_id);

    return $result;
  }
  
  public function DoAddMessage($milestone_id, $project_id, $title, $text, $additional_text, $is_important, $is_private, $comments_enabled, $anonymous_comments_enabled)
  {
  	$result = $this->mM_Message->AddMessage($milestone_id, $project_id, $title, $text, $additional_text, $is_important, $is_private, $comments_enabled, $anonymous_comments_enabled, get_current_user_id());
  	
  	if ($result)
  	  throw new MessageAddException;
  }
  
  public function GetMilestoneMessage($milestone_id)
  {
  	$result = $this->mM_Message->MilestoneMessage($milestone_id);
  	
  	return $result;
  }
}
?>
