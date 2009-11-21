<!-- Begin of task-add.tpl -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-task.tpl"}
{add_task assign="add_task"}
{load_tasklist_content assign="tasklist_content"}
{load_project_member assign="project_member"}

{if $add_task->mMessage}
    <div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong>{$add_task->mMessage}</strong></p>
        {if $add_task->mLeaveFlag}
        <p>點<a href="main.php?event=Task&action=ViewList&id={$tasklist_content->mTasklistContent.id}&active_project={$smarty.request.active_project}">這裡</a>回到工作清單 {$tasklist_content->mTasklistContent.name}</p>
        {/if}
  	  </blockquote>
    </div>
{/if}

    <div class="post" style="margin-right:225px;">
      <h3><strong>新增工作</strong></h3>
      <form action="main.php?event=Task&action=AddTask&tasklist_id={$smarty.request.tasklist_id}&active_project={$smarty.request.active_project}" method="post">
        <div>
          <label for="taskFormText">名稱：</label>
		  <textarea class="short" id="taskFormText" name="text" rows="10" cols="80"></textarea>
        </div>

        <div>
          <label for="taskListAddTaskAssignedTo">指定給成員：</label>
		  <select id="addTaskAssignTo" class="select_member" name="assigned_to">
            <option value="0">無</option>
            {section name=i loop=$project_member->mProjectMember}
            <option value="{$project_member->mProjectMember[i].id}">{$project_member->mProjectMember[i].realname}</option>
            {/section}
          </select>
        </div>

        <input type="submit" name="submit_add_task_{$smarty.request.tasklist_id}" class="button" value="新增工作">
        <input type="reset" name="submit_reset" class="button" value="重設">
        <input type="submit" name="submit_cancel_{$smarty.request.tasklist_id}" class="button" value="取消">
      </form>
    </div>
<!-- End of task-add.tpl -->