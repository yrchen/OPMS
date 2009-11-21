<!-- Begin of message-list.tpl  -->
﻿{include file="standard/selector-project.tpl"}
{include file="standard/selector-message.tpl"}
{load_project_message assign="project_message"}

    <div class="post" style="margin-right:225px;">
      <h3><strong>訊息</strong></h3>
      <blockquote style="margin:0;">
        {if $project_message->mProjectMessage}
        <ol>
          {section name=i loop=$project_message->mProjectMessage}
          <li><a href="main.php?event=Message&action=View&id={$project_message->mProjectMessage[i].id}&active_project={$smarty.request.active_project}">{$project_message->mProjectMessage[i].title}</a></li>
          {/section}
        </ol>
        {else}
        目前尚未設定訊息，是否<a href="main.php?event=Message&action=Add&active_project={$smarty.get.active_project}">新增</a>？
        {/if}
  	  </blockquote>
    </div>
<!-- Begin of message-list.tpl  -->
