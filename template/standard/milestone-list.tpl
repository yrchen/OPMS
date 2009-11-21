<!-- Begin of milestone-list.tpl  -->
{include file="standard/selector-project.tpl"}
{include file="standard/selector-milestone.tpl"}
{load_project_milestone assign="project_milestone"}

    <h3><strong>目標</strong></h3>
    <div class="post" style="margin-right:225px;">
      <blockquote style="margin:0;">
        {if $project_milestone->mProjectMilestone}
        <ol>
          {section name=i loop=$project_milestone->mProjectMilestone}
          <li><a href="main.php?event=Milestone&action=View&id={$project_milestone->mProjectMilestone[i].id}&active_project={$smarty.request.active_project}">{$project_milestone->mProjectMilestone[i].name}</a></li>
          {/section}
        </ol>
        {else}
        目前尚未設定目標，是否<a href="main.php?event=Milestone&action=Add&active_project={$smarty.get.active_project}">新增</a>？
        {/if}
  	  </blockquote>
    </div>
<!-- End of milestone-list.tpl  -->
