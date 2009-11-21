<!-- Begin of announce-system.tpl -->
{load_announce_all assign="announce_list"}
    <div class="post">
      <div class="content content-title"><strong>系統公告</strong>
        <div class="post-body">
          <div class="content">
            {if $announce_list->mSystemAnnounceList}
            <ol class="list">
            {section name=i loop=$announce_list->mSystemAnnounceList max=5}
              <li>{if !$announce_list->mSystemAnnounceRead[i]}<img src="images/new.gif" border="0" class="absmiddle" alt="未讀" />{/if}<a href="main.php?event=Announce&action=View&id={$announce_list->mSystemAnnounceList[i].id}">{$announce_list->mSystemAnnounceList[i].title}</a> - 由 {$announce_list->mSystemAnnounceList[i].realname} 於 {$announce_list->mSystemAnnounceList[i].start_date} 發布</li>
            {/section}
            </ol>
            {else}
            目前沒有新公告
            {/if}
          </div>
        </div>
      </div>
	</div>
<!-- End of announce-system.tpl -->
