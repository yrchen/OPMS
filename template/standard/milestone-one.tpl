<!-- Begin of milestone-one.tpl  -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-milestone.tpl"}
{load_milestone_content assign="milestone_content"}
{load_milestone_message assign="milestone_message"}
{load_milestone_tasklist assign="milestone_tasklist"}

    <div class="post" style="margin-right:225px;">
      <h3><strong>目標：{$milestone_content->mMilestoneContent.name}</strong></h3>
      <blockquote style="margin:0;">
      <div>
        <p>結束日期: {$milestone_content->mMilestoneContent.due_date}</p>
      </div>
      
      <div>
      {if $milestone_content->mMilestoneContent.description}
        <p>{$milestone_content->mMilestoneContent.description}</p>
      {else}
        <p>這個目標沒有說明</p>
      {/if}
      </div>
      
      <div>
        <p>訊息：</p>
        {if $milestone_message->mMilestoneMessage}
        <ol>
          {section name=i loop=$milestone_message->mMilestoneMessage}
          <li><a href="main.php?event=Message&action=View&id={$milestone_message->mMilestoneMessage[i].id}&active_project={$smarty.request.active_project}">{$milestone_message->mMilestoneMessage[i].title}</a> - ({$milestone_message->mMilestoneMessage[i].created_on} | {$milestone_message->mMilestoneMessage[i].realname})<a href="main.php?event=Message&action=Edit&id={$milestone_message->mMilestoneMessage[i].id}&active_project={$smarty.request.active_project}"><img src="images/edit.gif" alt="編輯"/></a><a href="main.php?event=Message&action=Del&id={$milestone_message->mMilestoneMessage[i].id}&active_project={$smarty.request.active_project}"><img src="images/cancel_gray.gif" alt="刪除" /></a></li>
          {/section}
        </ol>
        <p>新增<a href="main.php?event=Message&action=Add&milestone_id={$milestone_content->mMilestoneContent.id}&active_project={$smarty.request.active_project}">訊息</a>給此目標</p>
        {else}
        <p>這個目標沒有訊息，你可以在任何時候新增<a href="main.php?event=Message&action=Add&milestone_id={$milestone_content->mMilestoneContent.id}&active_project={$smarty.request.active_project}">訊息</a>給此目標</p>
        {/if}
      </div>
      
      <div>
        <p>工作清單：</p>
        {if $milestone_tasklist->mMilestoneTasklist}
        <ol>
          {section name=j loop=$milestone_tasklist->mMilestoneTasklist}
          <li><a href="main.php?event=Task&action=ViewList&id={$milestone_tasklist->mMilestoneTasklist[j].id}&active_project={$smarty.request.active_project}">{$milestone_tasklist->mMilestoneTasklist[j].name}</a> - ({$milestone_tasklist->mMilestoneTasklist[j].created_on} | {$milestone_tasklist->mMilestoneTasklist[j].realname})<a href="main.php?event=Task&action=Edit&id={$milestone_tasklist->mMilestoneTasklist[j].id}&active_project={$smarty.request.active_project}"><img src="images/edit.gif" alt="編輯"/></a><a href="main.php?event=Task&action=Del&id={$milestone_tasklist->mMilestoneTasklist[j].id}&active_project={$smarty.request.active_project}"><img src="images/cancel_gray.gif" alt="刪除" /></a></li>
          {/section}
        </ol>
        <p>新增<a href="main.php?event=Task&action=AddList&milestone_id={$milestone_content->mMilestoneContent.id}&active_project={$smarty.request.active_project}">工作清單</a>給此目標</p>
        {else}
        <p>這個目標沒有工作清單，你可以在任何時候新增<a href="main.php?event=Task&action=AddList&milestone_id={$milestone_content->mMilestoneContent.id}&active_project={$smarty.request.active_project}">工作清單</a>給此目標</p>
        {/if}
      </div>

      <div>
        <p><a href="main.php?event=Milestone&action=Edit&id={$milestone_content->mMilestoneContent.id}&active_project={$smarty.request.active_project}">編輯</a>|<a href="main.php?event=Milestone&action=Delete&id={$milestone_content->mMilestoneContent.id}&active_project={$smarty.request.active_project}">刪除</a></p>
      </div>
  	  </blockquote>
    </div>

<!-- End of milestone-one.tpl  -->
