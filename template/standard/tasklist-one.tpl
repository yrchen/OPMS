<!-- Begin of tasklist-one.tpl -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-tasklist.tpl"}
{load_tasklist_content assign="tasklist_content"}

    <div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        <h3><strong>{$tasklist_content->mTasklistContent.name}</strong></h3>
        <div>
          <p>{$tasklist_content->mTasklistContent.description}</p>
        </div>

        <div>
          <ol>
            {if $tasklist_content->mTasklistTask}
            {section name=i loop=$tasklist_content->mTasklistTask}
            <li><a href="main.php?event=Task&action=ViewTask&id={$tasklist_content->mTasklistTask[i].id}&active_project={$smarty.request.active_project}">{$tasklist_content->mTasklistTask[i].text}</a></li>
            {/section}
            {else}
            目前尚未設定工作，是否<a href="main.php?event=Task&action=AddTask&tasklist_id={$tasklist_content->mTasklistContent.id}&active_project={$smarty.get.active_project}">新增</a>？
            {/if}
          </ol>
        </div>

        <div>
          <a href="main.php?event=Task&action=AddTask&tasklist_id={$tasklist_content->mTasklistContent.id}&active_project={$smarty.get.active_project}">新增工作</a> | <a href="main.php?event=Task&action=EditList&id={$tasklist_content->mTasklistContent.id}&active_project={$smarty.get.active_project}">編輯</a> | <a href="main.php?event=Task&action=DelList&id={$tasklist_content->mTasklistContent.id}&active_project={$smarty.get.active_project}">刪除</a>
        </div>
      </blockquote>
    </div>
<!-- Begin of tasklist-one.tpl -->
