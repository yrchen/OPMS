<!-- Begin of tasklist-one.tpl -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-task.tpl"}
{load_task_content assign="task_content"}

    <div class="post" style="margin-right:225px;">
        <h3><strong>工作內容</strong></h3>
        <div>
          <p>{$task_content->mTaskContent.text}</p>
        </div>

        <div>
          <a href="main.php?event=Task&action=ViewList&id={$task_content->mTaskContent.task_list_id}&active_project={$smarty.get.active_project}">回到工作清單</a> | <a href="main.php?event=Task&action=EditTask&id={$task_content->mTaskContent.id}&active_project={$smarty.request.active_project}">編輯</a> | <a href="main.php?event=Task&action=DelTask&id={$task_content->mTaskContent.id}&active_project={$smarty.get.active_project}">刪除</a>
        </div>
    </div>
<!-- Begin of task-one.tpl -->
