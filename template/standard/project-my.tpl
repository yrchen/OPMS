<!-- Begin of project-my.tpl -->
{load_my_project_list assign="project_list"}
    <div class="post" style="margin-right:225px;">
      <h2><strong>你目前所參與的專案</strong></h2>
      {section name=i loop=$project_list->mProjectList}
      <blockquote style="margin:0;">
        <p style="margin-bottom:10px;"><strong><a href="main.php?event=Project&action=View&active_project={$project_list->mProjectList[i].project_id}">{$project_list->mProjectList[i].project_name}</a></strong></p>
  	  </blockquote>
    {/section}
    </div>
<!-- End of project-my.tpl -->
