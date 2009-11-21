<!-- Begin of project-list-nonlogin.tpl -->
{load_project_list assign="project_list"}
<ol>
{section name=i loop=$project_list->mProjectList max=5}
<li><a href="main.php?event=Project&action=View&active_project={$project_list->mProjectList[i].project_id}">{$project_list->mProjectList[i].project_name}</a></li>
{/section}
</ol>
<!-- End of project-list-nonlogin.tpl -->
