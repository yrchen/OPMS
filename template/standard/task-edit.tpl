<!-- Begin of task-edit.tpl -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-task.tpl"}
{edit_task assign="edit_task"}
{load_project_tasklist assign="project_tasklist"}
{load_project_member assign="project_member"}

{if $edit_task->mMessage}
    <div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong>{$edit_task->mMessage}</strong></p>
        {if $edit_task->mLeaveFlag}
        <p>點<a href="main.php?event=Task&action=ViewTask&id={$edit_task->mTaskContent.id}&active_project={$smarty.request.active_project}">這裡</a>回到工作</p>
        {/if}
  	  </blockquote>
    </div>
{/if}

    <div class="post" style="margin-right:225px;">
      <h3><strong>編輯工作</strong></h3>
      <form action="main.php?event=Task&action=EditTask&id={$edit_task->mTaskContent.id}&active_project={$smarty.request.active_project}" method="post">
        <div>
          <label for="editTaskTaskList">屬於工作清單：</label>
          <select id="editTaskTaskList" class="select_task_list" name="tasklist_id">
            {section name=i loop=$project_tasklist->mProjectTaskList}
            <option {if $edit_task->mTaskContent.task_list_id == $project_tasklist->mProjectTaskList[i].id}selected="selected" {/if}value="{$project_tasklist->mProjectTaskList[i].id}">{$project_tasklist->mProjectTaskList[i].name}</option>
            {/section}
          </select>
        </div>

        <div>
          <label for="editTaskText">內容：</label>
          <textarea id="editTaskText" class="short" name="text" rows="10" cols="40">{$edit_task->mTaskContent.text}</textarea>
        </div>

        <div>
          <label>指派給：</label>
          <select name="assigned_to_user_id">
            <option value="0">任何人</option>
            {section name=j loop=$project_member->mProjectMember}
            <option {if $edit_task->mTaskContent.assigned_to_user_id == $project_member->mProjectMember[j].id}selected="selected" {/if}value="{$project_member->mProjectMember[j].id}">{$project_member->mProjectMember[j].realname}</option>
            {/section}
          </select>
        </div>

        <input type="submit" name="submit_edit_task_{$edit_task->mTaskContent.id}" class="button" value="編輯工作">
        <input type="reset" name="submit_reset" class="button" value="重設">
        <input type="submit" name="submit_cancel_{$edit_task->mTaskContent.id}" class="button" value="取消">
      </form>
    </div>
<!-- End of task-edit.tpl -->