<!-- Begin of announce-all-nonlogin.tpl -->
{load_announce_all_nonlogin assign="announce_list"}

<ol>
{section name=i loop=$announce_list->mSystemAnnounceList max=5}
<li><a href="main.php?event=Announce&action=View&id={$announce_list->mSystemAnnounceList[i].id}">{$announce_list->mSystemAnnounceList[i].title}</li>
{/section}
</ol>

<!-- End of announce-all-nonlogin.tpl -->
