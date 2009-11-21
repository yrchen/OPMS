<!-- Begin of announce-project-list.tpl -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-announce-project.tpl"}
{load_project_announce_list assign="project_announce_list"}
{include file="standard/announce-project-unread.tpl"}

    <div class="post">
      <div class="content content-title"><strong>專案公告</strong>
        <div class="post-body">
          <div class="content">
            {if $project_announce_list->mAnnounceList}
            <ol class="list">
            {section name=i loop=$project_announce_list->mAnnounceList max=10}
              <li>{if !$project_announce_list->mAnnounceRead[i]}<img src="images/new.gif" border="0" class="absmiddle" alt="未讀" />{/if}<a href="main.php?event=Announce&action=View&id={$project_announce_list->mAnnounceList[i].id}">{$project_announce_list->mAnnounceList[i].title}</a> - 由 {$project_announce_list->mAnnounceList[i].realname} 於 {$project_announce_list->mAnnounceList[i].start_date} 發布</li>
            {/section}
            </ol>
            {else}
            目前沒有新公告
            {/if}
          </div>
        </div>
      </div>
	</div>

<!-- End of announce-project-list.tpl -->
