<!-- Begin of apply-project-join.tpl -->
{load_apply_project_content assign="apply_project_content"}

{if $apply_project_content->mMessage}
    <div class="post">
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong>{$apply_project_content->mMessage}</strong></p>
        {if $apply_project_content->mLeaveFlag}
        <p>點<a href="main.php?event=Apply&action=ListLiveProject">這裡</a>回到可申請加入專案清單</p>
        {/if}
  	  </blockquote>
    </div>
{/if}

{if $apply_project_content->mApplyProjectContent}
    <div class="post">
      <blockquote>
        <h2><strong>{$apply_project_content->mApplyProjectContent.title}</strong></h2><br/>
        <p>{$apply_project_content->mApplyProjectContent.description}</p><br/>
        <p>指導老師：{$apply_project_content->mApplyProjectContent.realname}</p>
        <p>人數上限：{$apply_project_content->mApplyProjectContent.member_limit}　已報名：{$apply_project_content->mApplyProjectUser}</p>
        <p>參考資料：{$apply_project_content->mApplyProjectContent.reference}</p>
  	  </blockquote>

      <blockquote>
      {if $apply_project_content->mApplyExistFlag}
        <h3><strong>已經報名過囉！</strong></h3>
      {else}
        <h3><strong>確定報名？</strong></h3>
        <form name="project_edit" action="main.php?event=Apply&action=JoinProject&id={$apply_project_content->mApplyProjectContent.id}" method="post">
          <input type="submit" name="submit_join_project_confirm_{$apply_project_content->mApplyProjectContent.id}" class="button" value="確定報名">
          <input type="submit" name="submit_cancel_{$apply_project_content->mApplyProjectContent.id}" class="button" value="取消">
        </form>
      {/if}
      </blockquote>
    </div>
{/if}
<!-- End of apply-project-join.tpl -->