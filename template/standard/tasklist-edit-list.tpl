<!-- Begin of tasklist-edit-list.tpl -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-tasklist.tpl"}
{load_project_tasklist assign="project_tasklist"}

    <div class="post" style="margin-right:225px;">
      <h3><strong>請選擇要編輯的工作清單</strong></h3>
      <blockquote style="margin:0;">
        {if $project_tasklist->mProjectTaskList}
        <ol>
          {section name=i loop=$project_tasklist->mProjectTaskList}
          <li><a href="main.php?event=Task&action=EditList&id={$project_tasklist->mProjectTaskList[i].id}&active_project={$smarty.get.active_project}">{$project_tasklist->mProjectTaskList[i].name}</a></li>
          {/section}
        </ol>
        {else}
        目前尚未設定工作清單，是否<a href="main.php?event=Task&action=AddList&active_project={$smarty.get.active_project}">新增</a>？
        {/if}
  	  </blockquote>
    </div>
<!-- End of tasklist-edit-list.tpl -->