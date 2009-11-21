<!-- Begin of message-one.tpl -->
﻿{include file="standard/selector-project.tpl"}
{include file="standard/selector-message.tpl"}
{load_message_content assign="message_content"}
    <div class="post" style="margin-right:225px;">
      <h3><strong>檢視訊息：{$message_content->mMessageContent.title}</strong></h3>
      <blockquote style="margin:0;">
        <div>
          <p>{$message_content->mMessageContent.created_on} | {$message_content->mMessageContent.realname} {if $message_content->mMessageContent.milestone_id != 0}| 目標：<a href="main.php?event=Milestone&action=View&id={$message_content->mMessageContent.milestone_id}&active_project={$smarty.request.active_project}">{$message_content->mMessageContent.name}</a>{/if}</p>
        </div>
      
        <div>
          <p>{$message_content->mMessageContent.text}</p>
        </div>
      
        <div>
          <p>{$message_content->mMessageContent.additional_text}</p>
        </div>

        <div>
          <p><a href="main.php?event=Message&action=Edit&id={$message_content->mMessageContent.id}&active_project={$smarty.request.active_project}">編輯</a>|<a href="main.php?event=Message&action=Delete&id={$message_content->mMessageContent.id}&active_project={$smarty.request.active_project}">刪除</a></p>
        </div>
  	  </blockquote>
    </div>
<!-- End of message-one.tpl -->
