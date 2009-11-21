<!-- Begin of message-add.tpl -->
﻿{include file="standard/selector-project.tpl"}
﻿{include file="standard/selector-message.tpl"}
{add_message assign="add_message"}
{load_project_milestone assign="project_milestone"}

{if $add_message->mMessage}
    <div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong>{$add_message->mMessage}</strong></p>
        {if $add_message->mLeaveFlag}
        <p>點<a href="main.php?event=Message&action=List&active_project={$smarty.request.active_project}">這裡</a>回到訊息清單</p>
        {/if}
  	  </blockquote>
    </div>
{/if}

    <div class="post" style="margin-right:225px;">
      <h3><strong>新增訊息</strong></h3>
      <form name="milestone_add" action="main.php?event=Message&action=Add&active_project={$smarty.request.active_project}" method="post" >
	    <div>
	      <label for="messageFormTitle">訊息標題：</label>
	      <input id="messageFormTitle" class="title" type="text" name="title" value="" />
	    </div>
	   
	    <div>
          <label for="messageFormText">內容：</label>
          <textarea id="messageFormText" class="editor" name="text" rows="5" cols="40"></textarea>
        </div>

        <div>
          <label for="messageFormAdditionalText">延伸訊息：</label>
          <textarea id="messageFormAdditionalText" class="editor" name="additional_text" rows="10" cols="40"></textarea>
        </div>

        <fieldset>
          <label for="messageFormMilestone">目標：</label>
		  <select id="messageFormMilestone" class="select_milestone" name="milestone_id">
            <option value="0">無</option>
            {section name=i loop=$project_milestone->mProjectMilestone}
            <option {if $add_message->mMilestoneID && ($project_milestone->mProjectMilestone[i].id == $add_message->mMilestoneID)}selected="selected" {/if}value="{$project_milestone->mProjectMilestone[i].id}">{$smarty.section.i.iteration}. {$project_milestone->mProjectMilestone[i].name}</option>
            {/section}
          </select>
        </fieldset>

        <fieldset>
          <legend>選項：</legend>
          <div class="objectOption">
            <div class="optionLabel">
              <label>私人訊息：</label>
            </div>

            <div class="optionControl">
              <input id="messageFormIsPrivateYes" class="yes_no" value="1" type="radio" name="is_private" />
              <label class="yes_no" for="messageFormIsPrivateYes">Yes</label>
              <input id="messageFormIsPrivateNo" class="yes_no" value="0" type="radio" checked="checked" name="is_private" />
              <label class="yes_no" for="messageFormIsPrivateNo">No</label>
            </div>

            <div class="optionDesc">Private messages are visible only to owner company members. Members of client companies will not be able see them.</div>
          </div>
    
          <div class="objectOption">
            <div class="optionLabel">
              <label>Important message:</label>
            </div>

            <div class="optionControl">
              <input id="messageFormIsImportantYes" class="yes_no" value="1" type="radio" name="is_important" />
              <label class="yes_no" for="messageFormIsImportantYes">Yes</label>
              <input id="messageFormIsImportantNo" class="yes_no" value="0" type="radio" checked="checked" name="is_important" />
              <label class="yes_no" for="messageFormIsImportantNo">No</label>
            </div>

            <div class="optionDesc">Important messages are listed in "Important messages" sidebar block on project messages page</div>
          </div>
    
          <div class="objectOption">
            <div class="optionLabel">
              <label>Enable comments:</label>
            </div>

            <div class="optionControl">
              <input id="fileFormEnableCommentsYes" class="yes_no" value="1" type="radio" checked="checked" name="comments_enabled" />
              <label class="yes_no" for="fileFormEnableCommentsYes">Yes</label>
              <input id="fileFormEnableCommentsNo" class="yes_no" value="0" type="radio" name="comments_enabled" />
              <label class="yes_no" for="fileFormEnableCommentsNo">No</label>
            </div>

            <div class="optionDesc">Users that can view this object can post comments on it. Select "No" to lock comments</div>
          </div>
  
          <div class="objectOption">
            <div class="optionLabel">
              <label>Anonymous comments:</label>
            </div>

            <div class="optionControl">
              <input id="fileFormEnableAnonymousCommentsYes" class="yes_no" value="1" type="radio" name="anonymous_comments_enabled" />
              <label class="yes_no" for="fileFormEnableAnonymousCommentsYes">Yes</label>
              <input id="fileFormEnableAnonymousCommentsNo" class="yes_no" value="0" type="radio" checked="checked" name="anonymous_comments_enabled" />
              <label class="yes_no" for="fileFormEnableAnonymousCommentsNo">No</label>
            </div>

            <div class="optionDesc">Let anononymous comments to be posteed for this object. Anonymous comments can be posted through API or any other external source if enabled. Author will need to provide his name, valid email address and his IP address will be logged.</div>
          </div>
        </fieldset>

        <div>
	      <input type="submit" name="submit_add_message_{$smarty.request.active_project}" class="button" value="新增" />
	      <input type="reset" name="reset" class="button" value="重設" />
	      <input type="submit" name="submit_cancel_{$smarty.request.active_project}" class="button" value="取消">
	    </div>
      </form>
<!-- End of message-add.tpl --> 