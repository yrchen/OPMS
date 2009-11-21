<!-- Begin of announce-one.tpl  -->
{include file="standard/selector-announce-one.tpl"}
{load_announce_content assign="announce_content"}
{if $announce_content->mMessage}
    <div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong>{$announce_content->mMessage}</strong></p>
        {if $announce_content->mLeaveFlag}
        <p>點{if $announce_content->mProjectID > 0}<a href="main.php?event=Announce&action=List&active_project={$announce_content->mProjectID}">{else}<a href="main.php?event=Announce&action=ListAll">{/if}這裡</a>回到公告清單</p>
        <p>點<a href="main.php?event=Announce&action=ListAllNew">這裡</a>回到所有未讀公告清單</p>
        {/if}
  	  </blockquote>
    </div>
{/if}

{if !$announce_content->mLeaveFlag}
    <div class="post" style="margin-right:225px;">
      <h3><strong>公告: {$announce_content->mAnnounceContent.title}</strong></h3>
      <blockquote style="margin:0;">
        <p>由 {$announce_content->mAnnounceContent.realname} 於 {$announce_content->mAnnounceContent.start_date} 發布，本訊息將於 {$announce_content->mAnnounceContent.expire_date} 過期</p>
        <p>{$announce_content->mAnnounceContent.content}</p>
    	<form name="announce_one" action="main.php?event=Announce&action=View&id={$announce_content->mAnnounceID}" method="post">
          {if $announce_content->mReadFlag}
          <input type="submit" name="submit_mark_unread_{$announce_content->mAnnounceID}" class="button" value="標記為未閱讀">
          {else}
          <input type="submit" name="submit_mark_read_{$announce_content->mAnnounceID}" class="button" value="標記為已閱讀">
          {/if}
          <input type="submit" name="submit_cancel_{$announce_content->mProjectID}" class="button" value="回到公告清單">
        </form>
  	  </blockquote>
    </div>
{/if}
<!-- End of announce-one.tpl  -->
