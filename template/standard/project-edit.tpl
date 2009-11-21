{include file="standard/selector-project.tpl"}
{edit_project assign="edit_project"}

{if $edit_project->mMessage}
    <div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong>{$edit_project->mMessage}</strong></p>
        {if $edit_project->mLeaveFlag}
        <p>點<a href="main.php?event=Project&action=View&active_project={$smarty.request.active_project}">這裡</a>回到專案 {$edit_project->mProjectContent.project_name}</p>
        {/if}
  	  </blockquote>
    </div>
{/if}

{if !$edit_project->mLeaveFlag}
<div class="post" style="margin-right:225px;">
  <h3><strong>編輯專案</strong></h3>
	<form name="project_edit" action="main.php?event=Project&action=Edit&active_project={$smarty.request.active_project}" method="post">
      <div>
			<h3>名稱：<input type="text" name="project_name" value="{$edit_project->mProjectContent.project_name}" size="40" /></h3>
      </div>
	  <div>
			<h3>網址：<input type="text" name="project_demo_url" value="{$edit_project->mProjectContent.project_demo_url}" size="20" /></h3>
      </div>
	  <div>
			<h3>描述：<input type="text" name="project_description" value="{$edit_project->mProjectContent.project_description}" size="80" maxlength="500"></h3>
	  </div>
	  <div> 	
			<h3>授權：<input type="text" name="project_licence" value="{$edit_project->mProjectContent.project_licence}" size="2" maxlength="1"/></h3>
      </div>
	  <input type="submit" name="submit_edit_content_{$edit_project->mProjectContent.project_id}" class="button" value="變更">
      <input type="reset" name="submit_reset" class="button" value="重設">
      <input type="submit" name="submit_cancel_{$edit_project->mProjectContent.project_id}" class="button" value="取消">
	</form>		
</div>
{/if}
