<!-- Begin of announce-system-unread.tpl -->
{load_unread_system_announce_list assign="unread_system_announce_list"}

    <div class="post">
      <div class="content content-title"><strong>系統公告</strong>
        <div class="post-body">
          <div class="content">
            {if $unread_system_announce_list->mAnnounceList}
            <ol class="list">
            {section name=i loop=$unread_system_announce_list->mAnnounceList max=5}
              <li><img src="images/new.gif" border="0" class="absmiddle" alt="未讀" /><a href="main.php?event=Announce&action=View&id={$unread_system_announce_list->mAnnounceList[i].id}">{$unread_system_announce_list->mAnnounceList[i].title}</a> - 由 {$unread_system_announce_list->mAnnounceList[i].realname} 於 {$unread_system_announce_list->mAnnounceList[i].start_date} 發布</li>
            {/section}
            </ol>
            {else}
            目前沒有新公告
            {/if}
          </div>
        </div>
      </div>
	</div>
<!-- End of announce-system-unread.tpl -->
