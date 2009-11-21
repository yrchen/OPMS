<!-- Begin of tasklist-add.tpl -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-tasklist.tpl"}
{add_tasklist assign="add_tasklist"}
{load_project_milestone assign="project_milestone"}

{if $add_tasklist->mMessage}
    <div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong>{$add_tasklist->mMessage}</strong></p>
        {if $add_tasklist->mLeaveFlag}
        <p>點<a href="main.php?event=Task&action=List&active_project={$smarty.request.active_project}">這裡</a>回到工作清單</p>
        {/if}
  	  </blockquote>
    </div>
{/if}

    <div class="post" style="margin-right:225px;">
      <h3><strong>新增工作清單</strong></h3>
      <form action="main.php?event=Task&action=AddList&active_project={$smarty.request.active_project}" method="post">
        <div>
          <label for="taskListFormName">名稱：</label>
		  <input class="long" id="taskListFormName" type="text" name="name" value="" />
        </div>

        <div>
          <label for="taskListFormDescription">描述：</label>
		  <textarea class="short" id="taskListFormDescription" name="description" rows="10" cols="80"></textarea>
        </div>

        <div>
          <label for="taskListFormMilestone">目標：</label>
		  <select id="taskListFormMilestone" class="select_milestone" name="milestone_id">
            <option value="0">無</option>
            {section name=i loop=$project_milestone->mProjectMilestone}
            <option {if $add_tasklist->mMilestoneID && ($project_milestone->mProjectMilestone[i].id == $add_tasklist->mMilestoneID)}selected="selected" {/if}value="{$project_milestone->mProjectMilestone[i].id}">{$smarty.section.i.iteration}. {$project_milestone->mProjectMilestone[i].name}</option>
            {/section}
          </select>
        </div>

        <div>
          <label>私人工作清單？</label>
          <input id="taskListFormIsPrivateYes" class="yes_no" value="1" type="radio" name="is_private" />
          <label class="yes_no" for="taskListFormIsPrivateYes">是</label>
	      <input id="taskListFormIsPrivateNo" class="yes_no" value="0" type="radio" checked="checked" name="is_private" />
	      <label class="yes_no" for="taskListFormIsPrivateNo">不是</label>
        </div>

        <input type="submit" name="submit_add_tasklist_{$smarty.request.active_project}" class="button" value="新增工作清單">
        <input type="reset" name="submit_reset" class="button" value="重設">
        <input type="submit" name="submit_cancel_{$smarty.request.active_project}" class="button" value="取消">
      </form>
    </div>
<!-- End of tasklist-add.tpl -->