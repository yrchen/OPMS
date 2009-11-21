<!-- Begin of announce-project.tpl -->
{load_announce_all assign="announce_list"}
    <div class="post">
      <div class="content content-title"><strong>專案公告</strong>
        <div class="post-body">
          <div class="content">
            {if $announce_list->mProjectAnnounceList}
            <ol class="list">
            {section name=i loop=$announce_list->mProjectAnnounceList max=5}
              <li>{if !$announce_list->mProjectAnnounceRead[i]}<img src="images/new.gif" border="0" class="absmiddle" alt="未讀" />{/if}<a href="main.php?event=Announce&action=View&id={$announce_list->mProjectAnnounceList[i].id}">{$announce_list->mProjectAnnounceList[i].title}</a> - 由 {$announce_list->mProjectAnnounceList[i].realname} 於專案 {$announce_list->mProjectAnnounceList[i].project_name} 發布</li>
            {/section}
            </ol>
            {else}
            目前沒有新公告
            {/if}
          </div>
        </div>
      </div>
	</div>
<!-- End of announce-project.tpl -->
