<?php
/*
 * OPMS
 * class-exception.php
 * Created on 2006/12/13 by Chen YuRen (yrchen@ATCity.org)
 *
 * $LastChangedDate: 2007-01-21T12:44:58.332782Z $
 * $LastChangedRevision: 7011 $
 * $LastChangedBy: yrchen $
 * $HeadURL: /local/opms/trunk/include/class-Exception.php $
 */

// yrchen.061015: Set flag that this is a parent file.
defined('_OPMSEXEC') or die('Restricted access');

class HandlerException extends Exception
{
}

class HandlerErrorException extends Exception
{
}

class DefaultHandlerException extends Exception
{
}

class LoginException extends Exception
{
}

class PermissionException extends Exception
{
}

class ProjectIDException extends Exception
{
}

class TaskIDException extends Exception
{
}

class TaskAddException extends Exception
{
}

class TaskDelException extends Exception
{
}

class TaskUpdateException extends Exception
{
}

class TaskListIDException extends Exception
{
}

class TaskListAddException extends Exception
{
}

class TaskListDelException extends Exception
{
}

class TaskListUpdateException extends Exception
{
}

class PostDataErrorException extends Exception
{
}

class ProjectUpdateException extends Exception
{
}

class ProjectMemberModifyException extends Exception
{
}

class ProjectTeacherModifyException extends Exception
{
}

class MilestoneIDException extends Exception
{
}

class MilestoneAddException extends Exception
{
}

class MilestoneDelException extends Exception
{
}

class MilestoneUpdateException extends Exception
{
}

class MessageIDException extends Exception
{
}

class MessageAddException extends Exception
{
}

class MessageDelException extends Exception
{
}

class MessageUpdateException extends Exception
{
}

class AnnounceIDException extends Exception
{
}

class AnnounceAddException extends Exception
{
}

class AnnounceDelException extends Exception
{
}

class AnnounceUpdateException extends Exception
{
}

class AnnounceReadException extends Exception
{
}

class AnnounceUnreadException extends Exception
{
}

class ApplyIDException extends Exception
{
}

class ApplyProjectIDException extends Exception
{
}

class ApplyProjectJoinException extends Exception
{
}

class ApplyProjectLeaveException extends Exception
{
}
?>
