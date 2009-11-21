<!-- Begin of task-edit-list.tpl -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-task.tpl"}
{load_project_task assign="project_task"}

    <div class="post" style="margin-right:225px;">
      <h3><strong>請選擇要編輯的工作</strong></h3>
      <blockquote style="margin:0;">
        {if $project_task->mProjectTask}
        <ol>
          {section name=i loop=$project_task->mProjectTask}
          <li><a href="main.php?event=Task&action=EditTask&id={$project_task->mProjectTask[i].id}&active_project={$smarty.request.active_project}">{$project_task->mProjectTask[i].text}</a></li>
          {/section}
        </ol>
        {else}
        目前尚未設定工作，是否<a href="main.php?event=Task&action=ViewList&active_project={$smarty.get.active_project}">選擇工作清單</a>新增？
        {/if}
  	  </blockquote>
    </div>

<!-- End of task-edit-list.tpl -->
