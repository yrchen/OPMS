<!-- Begin of announce-project-all-unread.tpl -->
{load_unread_project_all_announce_list assign="unread_project_all_announce_list"}

    <div class="post">
    {section name=i loop=$unread_project_all_announce_list->mProjectList}
      <div class="content content-title"><strong>{$unread_project_all_announce_list->mProjectList[i].project_name}</strong>
        <div class="post-body">
          <div class="content">
            {if $unread_project_all_announce_list->mProjectAnnounceList[i]}
            <ol class="list">
            {section name=k loop=$unread_project_all_announce_list->mProjectAnnounceList[i] max=5}
              <li><img src="images/new.gif" border="0" class="absmiddle" alt="未讀" /><a href="main.php?event=Announce&action=View&id={$unread_project_all_announce_list->mProjectAnnounceList[i][k].id}">{$unread_project_all_announce_list->mProjectAnnounceList[i][k].title}</a> - 由 {$unread_project_all_announce_list->mProjectAnnounceList[i][k].realname} 於 {$unread_project_all_announce_list->mProjectAnnounceList[i][k].start_date} 發布</li>
            {/section}
            </ol>
            {else}
            目前沒有新公告
            {/if}
          </div>
        </div>
      </div>
    {/section}
	</div>
<!-- End of announce-project-all-unread.tpl -->
